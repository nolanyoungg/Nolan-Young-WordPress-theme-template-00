'use strict';

const fs = require( 'node:fs' );
const path = require( 'node:path' );
const { ZipArchive } = require( 'archiver' );

const root = path.resolve( __dirname, '..' );
const slug = 'nolan-young-theme-template-99-master';
const packageDirectory = path.resolve( root, '..', '..', 'zipped-theme' );
const outputPath = path.join( packageDirectory, `${ slug }.zip` );
const isPreflight = process.argv.includes( '--preflight' );
const runtimeEntries = [
	'404.php', 'archive.php', 'comments.php', 'footer.php', 'front-page.php',
	'functions.php', 'header.php', 'home.php', 'inc', 'index.php', 'languages',
	'page-templates', 'page.php', 'readme.txt', 'screenshot.png',
	'search.php', 'searchform.php', 'sidebar.php', 'single.php', 'style.css',
	'template-parts', 'dist/css', 'dist/js', 'dist/images', 'dist/icons',
];

function verifyPackageDirectory() {
	if ( !fs.existsSync( packageDirectory ) ) {
		fs.mkdirSync( packageDirectory, { recursive: true } );
	}

	if ( !fs.statSync( packageDirectory ).isDirectory() ) {
		throw new Error( `Package destination is not a directory: ${ packageDirectory }` );
	}

	fs.accessSync( packageDirectory, fs.constants.W_OK );
}

function listArchiveFiles( archivePath ) {
	const archive = fs.readFileSync( archivePath );
	const endSignature = 0x06054b50;
	const centralSignature = 0x02014b50;
	const minimumEndSize = 22;
	const maximumCommentSize = 0xffff;
	const searchStart = Math.max( 0, archive.length - minimumEndSize - maximumCommentSize );
	let endOffset = -1;

	for ( let offset = archive.length - minimumEndSize; offset >= searchStart; offset-- ) {
		if (
			archive.readUInt32LE( offset ) === endSignature &&
			offset + minimumEndSize + archive.readUInt16LE( offset + 20 ) === archive.length
		) {
			endOffset = offset;
			break;
		}
	}

	if ( endOffset === -1 ) {
		throw new Error( 'Archive inventory validation failed: ZIP end record was not found.' );
	}

	const diskNumber = archive.readUInt16LE( endOffset + 4 );
	const centralDisk = archive.readUInt16LE( endOffset + 6 );
	const diskEntryCount = archive.readUInt16LE( endOffset + 8 );
	const entryCount = archive.readUInt16LE( endOffset + 10 );
	const centralSize = archive.readUInt32LE( endOffset + 12 );
	const centralOffset = archive.readUInt32LE( endOffset + 16 );

	if (
		diskNumber !== 0 ||
		centralDisk !== 0 ||
		diskEntryCount !== entryCount ||
		entryCount === 0xffff ||
		centralSize === 0xffffffff ||
		centralOffset === 0xffffffff
	) {
		throw new Error( 'Archive inventory validation failed: unsupported multi-disk or ZIP64 archive.' );
	}

	if ( centralOffset + centralSize > endOffset ) {
		throw new Error( 'Archive inventory validation failed: invalid central directory bounds.' );
	}

	const entries = [];
	let offset = centralOffset;

	for ( let index = 0; index < entryCount; index++ ) {
		if ( offset + 46 > archive.length || archive.readUInt32LE( offset ) !== centralSignature ) {
			throw new Error( 'Archive inventory validation failed: invalid central directory entry.' );
		}

		const nameLength = archive.readUInt16LE( offset + 28 );
		const extraLength = archive.readUInt16LE( offset + 30 );
		const commentLength = archive.readUInt16LE( offset + 32 );
		const entryEnd = offset + 46 + nameLength + extraLength + commentLength;

		if ( entryEnd > archive.length ) {
			throw new Error( 'Archive inventory validation failed: truncated central directory entry.' );
		}

		entries.push( archive.toString( 'utf8', offset + 46, offset + 46 + nameLength ) );
		offset = entryEnd;
	}

	if ( offset !== centralOffset + centralSize ) {
		throw new Error( 'Archive inventory validation failed: incomplete central directory.' );
	}

	return entries.filter( ( entry ) => !entry.endsWith( '/' ) ).sort();
}

function listSourceFiles( source, relativePath ) {
	if ( fs.statSync( source ).isFile() ) {
		return [ path.posix.join( slug, relativePath.split( path.sep ).join( '/' ) ) ];
	}

	return fs.readdirSync( source, { withFileTypes: true } ).flatMap( ( entry ) => {
		const entrySource = path.join( source, entry.name );
		const entryRelative = path.join( relativePath, entry.name );

		return listSourceFiles( entrySource, entryRelative );
	} );
}

function validateArchiveInventory( archivePath ) {
	const archiveEntries = listArchiveFiles( archivePath );
	const expectedEntries = runtimeEntries.flatMap( ( entry ) => listSourceFiles( path.join( root, entry ), entry ) ).sort();
	const invalidRoots = archiveEntries.filter( ( entry ) => !entry.startsWith( `${ slug }/` ) );
	const missingEntries = expectedEntries.filter( ( entry ) => !archiveEntries.includes( entry ) );
	const extraEntries = archiveEntries.filter( ( entry ) => !expectedEntries.includes( entry ) );

	if ( invalidRoots.length || missingEntries.length || extraEntries.length ) {
		throw new Error(
			`Archive inventory validation failed. Invalid root: ${ invalidRoots.join( ', ' ) || 'none' }; missing: ${ missingEntries.join( ', ' ) || 'none' }; extra: ${ extraEntries.join( ', ' ) || 'none' }`
		);
	}
}

verifyPackageDirectory();

if ( isPreflight ) {
	console.log( `Package destination ready: ${ packageDirectory }` );
	process.exit( 0 );
}

runtimeEntries.forEach( ( entry ) => {
	const source = path.join( root, entry );
	if ( !fs.existsSync( source ) ) {
		throw new Error( `Missing package entry: ${ entry }` );
	}
} );

verifyPackageDirectory();

const temporaryPath = `${ outputPath }.partial`;
const output = fs.createWriteStream( temporaryPath, { flags: 'w' } );
const archive = new ZipArchive( { zlib: { level: 9 } } );

const cleanup = ( error ) => {
	if ( fs.existsSync( temporaryPath ) ) {
		fs.unlinkSync( temporaryPath );
	}

	if ( error ) {
		throw error;
	}
};

output.on( 'close', () => {
	try {
		validateArchiveInventory( temporaryPath );
		verifyPackageDirectory();
		fs.renameSync( temporaryPath, outputPath );
		console.log( `Created and validated ${ outputPath } (${ archive.pointer() } bytes).` );
	} catch ( error ) {
		cleanup( error );
	}
} );
output.on( 'error', cleanup );
archive.on( 'error', cleanup );
archive.pipe( output );

runtimeEntries.forEach( ( entry ) => {
	const source = path.join( root, entry );
	const destination = path.posix.join( slug, entry );

	if ( fs.statSync( source ).isDirectory() ) {
		archive.directory( source, destination );
	} else {
		archive.file( source, { name: destination } );
	}
} );

archive.finalize();
