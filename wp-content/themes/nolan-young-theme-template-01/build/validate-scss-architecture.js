'use strict';

const fs = require( 'node:fs' );
const path = require( 'node:path' );

const root = path.resolve( __dirname, '..' );
const scssRoot = path.join( root, 'src/scss' );
const main = fs.readFileSync( path.join( scssRoot, 'main.scss' ), 'utf8' );

function collectScssFiles( directory ) {
	return fs.readdirSync( directory, { withFileTypes: true } ).flatMap( ( entry ) => {
		const absolutePath = path.join( directory, entry.name );

		return entry.isDirectory()
			? collectScssFiles( absolutePath )
			: entry.name.endsWith( '.scss' )
				? [ absolutePath ]
				: [];
	} );
}

const files = collectScssFiles( scssRoot );
const source = files
	.map( ( file ) => fs.readFileSync( file, 'utf8' ) )
	.join( '\n' );

if ( /\.ny(?:forms|megamenu|mega)(?:[-_]|[a-z])/i.test( source ) ) {
	throw new Error( 'Plugin-owned NY Forms or NY Mega Menu selectors must not appear in theme SCSS.' );
}

for ( const file of files ) {
	const relativePath = path.relative( scssRoot, file ).replaceAll( path.sep, '/' );

	if ( [ 'main.scss', 'editor.scss' ].includes( relativePath ) ) {
		continue;
	}

	const importPath = relativePath
		.replace( /(^|\/)_/, '$1' )
		.replace( /\.scss$/, '' );
	const escapedPath = importPath.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' );
	const occurrences = (
		main.match( new RegExp( `@use\\s+["']${ escapedPath }["']`, 'g' ) ) || []
	).length;

	if ( 1 !== occurrences ) {
		throw new Error( `${ relativePath } must be imported exactly once by main.scss; found ${ occurrences }.` );
	}
}

for ( const file of files.filter( ( candidate ) => candidate.includes( `${ path.sep }abstracts${ path.sep }` ) ) ) {
	const withoutComments = fs
		.readFileSync( file, 'utf8' )
		.replace( /\/\*[\s\S]*?\*\//g, '' )
		.trim();

	if ( /(^|})\s*[^@$][^{;]*\{/.test( withoutComments ) ) {
		throw new Error( `${ path.relative( root, file ) } emits a selector from the abstracts layer.` );
	}
}

const pageScopes = {
	'_about-us.scss': '.nytt01-page-about',
	'_blog.scss': '.nytt01-page-blog',
	'_contact.scss': '.nytt01-page-contact',
	'_error.scss': '.nytt01-error-page',
	'_homepage.scss': '.nytt01-hero',
	'_policy.scss': '.nytt01-policy',
	'_search.scss': '.search-results',
	'_service-detail.scss': '.nytt01-page-service-detail',
	'_services.scss': '.nytt01-page-services',
	'_work.scss': '.nytt01-page-work',
};

for ( const [ filename, scope ] of Object.entries( pageScopes ) ) {
	const contents = fs.readFileSync( path.join( scssRoot, 'pages', filename ), 'utf8' );

	if ( ! contents.includes( scope ) ) {
		throw new Error( `pages/${ filename } must remain owned by ${ scope }.` );
	}
}

const homepage = fs.readFileSync( path.join( scssRoot, 'pages/_homepage.scss' ), 'utf8' );
for ( const sharedSelector of [
	'.nytt01-brand-statement',
	'.nytt01-process-list',
	'.nytt01-cta-banner',
	'.nytt01-newsletter',
] ) {
	if ( homepage.includes( sharedSelector ) ) {
		throw new Error( `${ sharedSelector } is shared and cannot be owned by pages/_homepage.scss.` );
	}
}

const editor = fs.readFileSync( path.join( scssRoot, 'editor.scss' ), 'utf8' );
if ( /@use\s+["'](?:base|layout|components|pages)\//.test( editor ) ) {
	throw new Error( 'editor.scss must not import selector-emitting frontend layers.' );
}

console.log( `Validated SCSS ownership for ${ files.length } source files.` );
