const { existsSync, readFileSync, readdirSync } = require( 'node:fs' );
const { join } = require( 'node:path' );

const root = join( __dirname, '..' );
const templatePartsDirectory = join( root, 'template-parts' );
const themeName = 'Nolan Young Demo Theme 002';
const themeSlug = 'nolan-young-demo-theme-002';
const requiredRuntimeFiles = [
  'style.css', 'functions.php', 'index.php', 'header.php', 'footer.php', 'README.md', 'readme.txt', 'screenshot.png',
  `languages/${ themeSlug }.pot`,
  'dist/css/bundle.css', 'dist/js/bundle.js',
];
const requiredIncludes = [
  'inc/setup.php', 'inc/helpers.php', 'inc/enqueue.php',
  'inc/template-tags.php', 'inc/customizer.php', 'inc/navigation.php',
];
const requiredTemplateParts = [
  'content-front-page-hero.php', 'content-front-page-services.php', 'content-front-page-work.php', 'content-front-page-process.php', 'content-front-page-cta.php',
  'content-services-hero.php', 'content-services-sect01.php', 'content-services-sect02.php', 'content-services-sect03.php', 'content-services-sect04.php', 'content-services-sect05.php', 'content-services-cta.php',
  'content-about-us-hero.php', 'content-about-us-sect01.php', 'content-about-us-sect02.php', 'content-about-us-sect03.php', 'content-about-us-sect04.php', 'content-about-us-sect05.php', 'content-about-us-cta.php',
  'content-work-hero.php', 'content-work-sect01.php', 'content-work-sect02.php', 'content-work-sect03.php', 'content-work-sect04.php', 'content-work-sect05.php', 'content-work-cta.php',
  'content-blog-hero.php', 'content-blog-page-grid.php', 'content-blog-cta-bottom.php', 'content-blog-single-hero.php', 'content-blog-single-page.php', 'content-blog-single-next-blog.php', 'content-blog-single-cta-bottom.php',
  'content-contact-us-hero.php', 'content-contact-us-sect01.php', 'content-contact-us-sect02.php', 'content-contact-us-sect03.php', 'content-contact-us-sect04.php', 'content-contact-us-sect05.php', 'content-contact-us-cta.php',
  'content-ppc-lp-2026-hero.php', 'content-ppc-lp-2026-sect01.php', 'content-ppc-lp-2026-sect02.php', 'content-ppc-lp-2026-sect03.php', 'content-ppc-lp-2026-sect04.php', 'content-ppc-lp-2026-sect05.php', 'content-ppc-lp-2026-cta.php',
  'content-404-hero.php', 'content-404-sect01.php', 'content-404-sect02.php', 'content-404-cta.php',
];

const missingRuntimeFiles = requiredRuntimeFiles.filter( ( file ) => !existsSync( join( root, file ) ) );
if ( missingRuntimeFiles.length ) {
  throw new Error( `Missing runtime files: ${ missingRuntimeFiles.join( ', ' ) }` );
}

const stylesheet = readFileSync( join( root, 'style.css' ), 'utf8' );
if ( !stylesheet.includes( `Theme Name: ${ themeName }` ) ) {
  throw new Error( `style.css must declare Theme Name: ${ themeName }.` );
}
if ( !stylesheet.includes( `Text Domain: ${ themeSlug }` ) ) {
  throw new Error( `style.css must declare Text Domain: ${ themeSlug }.` );
}

const packageManifest = JSON.parse( readFileSync( join( root, 'package.json' ), 'utf8' ) );
if ( packageManifest.name !== themeSlug ) {
  throw new Error( `package.json name must be ${ themeSlug }.` );
}

const bootstrap = readFileSync( join( root, 'functions.php' ), 'utf8' );
const missingIncludes = requiredIncludes.filter( ( file ) => !bootstrap.includes( `'/${ file }'` ) );
if ( missingIncludes.length ) {
  throw new Error( `functions.php must include each required module once: ${ missingIncludes.join( ', ' ) }` );
}

const rootContentFiles = readdirSync( root ).filter( ( file ) => /^content-.+\.php$/.test( file ) );
if ( rootContentFiles.length ) {
  throw new Error( `Template-part files must live in template-parts/: ${ rootContentFiles.join( ', ' ) }` );
}

const missingTemplateParts = requiredTemplateParts.filter( ( file ) => !existsSync( join( templatePartsDirectory, file ) ) );
if ( missingTemplateParts.length ) {
  throw new Error( `Missing required template parts: ${ missingTemplateParts.join( ', ' ) }` );
}

const templateParts = readdirSync( templatePartsDirectory ).filter( ( file ) => file.endsWith( '.php' ) );
const invalidPartNames = templateParts.filter( ( file ) => !/^content-[a-z0-9-]+\.php$/.test( file ) );
if ( invalidPartNames.length ) {
  throw new Error( `Template part naming violation: ${ invalidPartNames.join( ', ' ) }` );
}

const templates = readdirSync( join( root, 'page-templates' ) ).filter( ( file ) => file.endsWith( '.php' ) );
for ( const file of templates ) {
  const template = readFileSync( join( root, 'page-templates', file ), 'utf8' );
  if ( !template.includes( 'Template Name:' ) ) {
    throw new Error( `${ file } has no Template Name header.` );
  }
}

console.log( `Theme structure validated: ${ templateParts.length } template parts in template-parts/.` );
