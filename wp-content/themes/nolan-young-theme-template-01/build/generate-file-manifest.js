'use strict';

const fs = require( 'node:fs' );
const path = require( 'node:path' );

const root = path.resolve( __dirname, '..' );
const destination = path.join( root, 'FILE-MANIFEST.txt' );
const excludedDirectories = new Set( [ 'dist', 'node_modules', 'vendor' ] );
const excludedFiles = new Set( [ '.phpunit.result.cache' ] );
const files = [];

function collect( directory ) {
	for ( const entry of fs.readdirSync( directory, { withFileTypes: true } ) ) {
		if (
			excludedFiles.has( entry.name ) ||
			( entry.isDirectory() && excludedDirectories.has( entry.name ) )
		) {
			continue;
		}

		const absolutePath = path.join( directory, entry.name );
		if ( entry.isDirectory() ) {
			collect( absolutePath );
		} else {
			files.push( path.relative( root, absolutePath ).split( path.sep ).join( '/' ) );
		}
	}
}

collect( root );
files.sort( ( first, second ) => first.localeCompare( second, 'en' ) );
const manifest = `${ files.join( '\n' ) }\n`;

if ( process.argv.includes( '--check' ) ) {
	const current = fs.existsSync( destination )
		? fs.readFileSync( destination, 'utf8' )
		: '';

	if ( current !== manifest ) {
		throw new Error(
			'FILE-MANIFEST.txt is stale. Run npm run manifest from the theme workspace.'
		);
	}
} else {
	fs.writeFileSync( destination, manifest );
	console.log( `Recorded ${ files.length } theme files in FILE-MANIFEST.txt.` );
}
