'use strict';

const fs = require( 'node:fs' );
const path = require( 'node:path' );
const { ZipArchive } = require( 'archiver' );

const root = path.resolve( __dirname, '..' );
const slug = 'nolan-young-theme-template-01';
const distDirectory = path.join( root, 'dist' );
const now = new Date();
const pad = ( value ) => String( value ).padStart( 2, '0' );
const hour = now.getHours() % 12 || 12;
const meridiem = now.getHours() >= 12 ? 'PM' : 'AM';
const timestamp = `${ pad( now.getMonth() + 1 ) }-${ pad( now.getDate() ) }-${ now.getFullYear() }-T${ pad( hour ) }-${ pad( now.getMinutes() ) }${ meridiem }`;
const baseOutputPath = path.join( distDirectory, `${ slug }-${ timestamp }.zip` );
let outputPath = baseOutputPath;
let sequence = 2;

while ( fs.existsSync( outputPath ) ) {
	outputPath = path.join( distDirectory, `${ slug }-${ timestamp }-${ sequence }.zip` );
	sequence += 1;
}

const runtimeEntries = [
	'404.php',
	'CHANGELOG.md',
	'LICENSE.txt',
	'README.md',
	'archive.php',
	'assets',
	'comments.php',
	'footer.php',
	'front-page.php',
	'functions.php',
	'header.php',
	'home.php',
	'inc',
	'index.php',
	'languages',
	'page-templates',
	'page.php',
	'patterns',
	'privacy-policy.php',
	'screenshot.png',
	'search.php',
	'searchform.php',
	'single.php',
	'singular.php',
	'style.css',
	'template-parts',
	'theme.json',
];

fs.mkdirSync( distDirectory, { recursive: true } );

const output = fs.createWriteStream( outputPath );
const archive = new ZipArchive( { zlib: { level: 9 } } );

output.on( 'close', () => {
	console.log( `Created ${ path.relative( root, outputPath ) } (${ archive.pointer() } bytes).` );
} );

archive.on( 'warning', ( error ) => {
	if ( error.code !== 'ENOENT' ) {
		throw error;
	}
	console.warn( error.message );
} );

archive.on( 'error', ( error ) => {
	throw error;
} );

archive.pipe( output );

for ( const entry of runtimeEntries ) {
	const sourcePath = path.join( root, entry );

	if ( ! fs.existsSync( sourcePath ) ) {
		throw new Error( `Cannot package missing runtime entry: ${ entry }` );
	}

	const destination = path.posix.join( slug, entry.replaceAll( path.sep, '/' ) );
	const stat = fs.statSync( sourcePath );

	if ( stat.isDirectory() ) {
		archive.directory( sourcePath, destination );
	} else {
		archive.file( sourcePath, { name: destination } );
	}
}

archive.finalize();
