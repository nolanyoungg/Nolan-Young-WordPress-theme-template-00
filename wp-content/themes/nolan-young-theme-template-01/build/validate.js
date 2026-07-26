'use strict';

const fs = require( 'node:fs' );
const path = require( 'node:path' );

const root = path.resolve( __dirname, '..' );
const repositoryRoot = path.resolve( root, '../../..' );
const workspacePath = 'wp-content/themes/nolan-young-theme-template-01';

const requiredFiles = [
	'style.css',
	'functions.php',
	'theme.json',
	'screenshot.png',
	'index.php',
	'header.php',
	'footer.php',
	'front-page.php',
	'home.php',
	'404.php',
	'README.md',
	'CHANGELOG.md',
	'webpack.config.js',
	'package.json',
	'phpunit.xml.dist',
	'build/clean.js',
	'build/dev.js',
	'build/generate-file-manifest.js',
	'build/package-theme.js',
	'build/validate-scss-architecture.js',
	'build/validate.js',
	'assets/css/bundle.css',
	'assets/css/bundle-rtl.css',
	'assets/css/bundle.asset.php',
	'assets/css/editor.css',
	'assets/css/editor-rtl.css',
	'assets/css/editor.asset.php',
	'assets/js/bundle.js',
	'assets/js/bundle.asset.php',
	'inc/setup.php',
	'inc/navigation.php',
	'inc/enqueue.php',
	'template-parts/header/mega-menu-featured.php',
	'template-parts/header/mega-menu-blog.php',
	'template-parts/header/mobile-navigation.php',
	'template-parts/content/content-front-page.php',
	'src/js/components/mega-menu.js',
	'src/scss/components/_mega-menu.scss',
	'languages/nolan-young-theme-template-01.pot',
];

const requiredRepositoryFiles = [ '.nvmrc', 'package.json', 'package-lock.json' ];

const missingFiles = requiredFiles.filter(
	( relativePath ) => ! fs.existsSync( path.join( root, relativePath ) )
);
const missingRepositoryFiles = requiredRepositoryFiles.filter(
	( relativePath ) => ! fs.existsSync( path.join( repositoryRoot, relativePath ) )
);

if ( missingFiles.length ) {
	throw new Error( `Missing required theme files:\n${ missingFiles.join( '\n' ) }` );
}

if ( missingRepositoryFiles.length ) {
	throw new Error(
		`Missing required repository files:\n${ missingRepositoryFiles.join( '\n' ) }`
	);
}

if ( fs.existsSync( path.join( root, 'package-lock.json' ) ) ) {
	throw new Error(
		'The authoritative package-lock.json must be at the repository root.'
	);
}

const nonEmptyFiles = [
	'assets/css/bundle.css',
	'assets/css/bundle-rtl.css',
	'assets/css/editor.css',
	'assets/css/editor-rtl.css',
	'assets/js/bundle.js',
	'README.md',
];

for ( const relativePath of nonEmptyFiles ) {
	const filePath = path.join( root, relativePath );

	if ( fs.statSync( filePath ).size === 0 ) {
		throw new Error( `Required file is empty: ${ relativePath }` );
	}
}

const packageJson = JSON.parse(
	fs.readFileSync( path.join( root, 'package.json' ), 'utf8' )
);
const repositoryPackageJson = JSON.parse(
	fs.readFileSync( path.join( repositoryRoot, 'package.json' ), 'utf8' )
);
const packageLock = JSON.parse(
	fs.readFileSync( path.join( repositoryRoot, 'package-lock.json' ), 'utf8' )
);
const themeJson = JSON.parse(
	fs.readFileSync( path.join( root, 'theme.json' ), 'utf8' )
);

const requiredThemeScripts = {
	start: 'wp-scripts start',
	dev: 'npm run clean && npm run lint && node build/dev.js',
	'dev:fast': 'npm run start',
	clean: 'node build/clean.js',
	'build:assets': 'wp-scripts build',
	build: 'npm run clean && npm run lint && npm run build:assets && npm run validate',
	check: 'npm run lint && npm run validate',
	'lint:node': 'node --check build/clean.js && node --check build/dev.js && node --check build/generate-file-manifest.js && node --check build/package-theme.js && node --check build/validate-scss-architecture.js && node --check build/validate.js',
	validate: 'node build/generate-file-manifest.js --check && node build/validate.js',
	package: 'npm run build && node build/package-theme.js',
};

for ( const [ scriptName, expectedCommand ] of Object.entries(
	requiredThemeScripts
) ) {
	if ( packageJson.scripts?.[ scriptName ] !== expectedCommand ) {
		throw new Error(
			`Theme package.json script ${ scriptName } must equal: ${ expectedCommand }`
		);
	}
}

const requiredRepositoryScripts = [
	'start',
	'dev',
	'dev:fast',
	'check',
	'lint',
	'build',
	'package',
];

for ( const scriptName of requiredRepositoryScripts ) {
	const expectedCommand = `npm run ${ scriptName } --workspace=${ packageJson.name }`;

	if ( repositoryPackageJson.scripts?.[ scriptName ] !== expectedCommand ) {
		throw new Error(
			`Root package.json script ${ scriptName } must equal: ${ expectedCommand }`
		);
	}
}

if ( packageJson.scripts?.test || repositoryPackageJson.scripts?.test ) {
	throw new Error( 'A test package script is not supported.' );
}

if ( repositoryPackageJson.private !== true ) {
	throw new Error( 'The root npm workspace package must be private.' );
}

if (
	! Array.isArray( repositoryPackageJson.workspaces ) ||
	! repositoryPackageJson.workspaces.includes( workspacePath )
) {
	throw new Error(
		`The root npm workspace must include ${ workspacePath }.`
	);
}

if ( repositoryPackageJson.engines?.node !== '20.x' ) {
	throw new Error( 'The root npm workspace must require Node 20.x.' );
}

if (
	fs.readFileSync( path.join( repositoryRoot, '.nvmrc' ), 'utf8' ).trim() !==
	'20'
) {
	throw new Error( '.nvmrc must pin Node 20.' );
}

if (
	packageLock.packages?.[ '' ]?.name !== repositoryPackageJson.name ||
	packageLock.packages?.[ '' ]?.version !== repositoryPackageJson.version ||
	packageLock.packages?.[ workspacePath ]?.version !== packageJson.version ||
	packageLock.packages?.[ `node_modules/${ packageJson.name }` ]?.resolved !==
		workspacePath
) {
	throw new Error(
		'The root package-lock.json must describe the repository and theme workspace.'
	);
}

if ( ! packageJson.devDependencies?.webpack ) {
	throw new Error( 'webpack must be declared directly in devDependencies.' );
}

if ( themeJson.version !== 3 ) {
	throw new Error( 'theme.json must use version 3.' );
}

if ( themeJson.$schema !== 'https://schemas.wp.org/wp/7.0/theme.json' ) {
	throw new Error( 'theme.json must use the WordPress 7.0 schema.' );
}

const styleHeader = fs.readFileSync( path.join( root, 'style.css' ), 'utf8' );
const expectedHeaderFields = [
	'Theme Name: Nolan Young Theme Template 01',
	`Version: ${ packageJson.version }`,
	'Requires at least: 7.0',
	'Tested up to: 7.0',
	'Requires PHP: 7.4',
	'Text Domain: nolan-young-theme-template-01',
];

for ( const field of expectedHeaderFields ) {
	if ( ! styleHeader.includes( field ) ) {
		throw new Error( `style.css is missing or mismatches: ${ field }` );
	}
}

const screenshot = fs.readFileSync( path.join( root, 'screenshot.png' ) );
const pngSignature = '89504e470d0a1a0a';

if ( screenshot.subarray( 0, 8 ).toString( 'hex' ) !== pngSignature ) {
	throw new Error( 'screenshot.png is not a valid PNG file.' );
}

const screenshotWidth = screenshot.readUInt32BE( 16 );
const screenshotHeight = screenshot.readUInt32BE( 20 );

if ( screenshotWidth !== 1200 || screenshotHeight !== 900 ) {
	throw new Error(
		`screenshot.png must be exactly 1200x900; found ${ screenshotWidth }x${ screenshotHeight }.`
	);
}

const phpFiles = [];

function collectPhpFiles( directory ) {
	for ( const entry of fs.readdirSync( directory, { withFileTypes: true } ) ) {
		const absolutePath = path.join( directory, entry.name );

		if ( entry.isDirectory() ) {
			if ( [ 'node_modules', 'vendor', 'dist' ].includes( entry.name ) ) {
				continue;
			}
			collectPhpFiles( absolutePath );
		} else if ( entry.name.endsWith( '.php' ) ) {
			phpFiles.push( absolutePath );
		}
	}
}

collectPhpFiles( root );

for ( const phpFile of phpFiles ) {
	const contents = fs.readFileSync( phpFile, 'utf8' );
	const relativePath = path.relative( root, phpFile );

	if ( /register_post_type\s*\(/.test( contents ) ) {
		throw new Error(
			`Theme architecture violation: register_post_type() found in ${ relativePath }.`
		);
	}

	if ( /register_taxonomy\s*\(/.test( contents ) ) {
		throw new Error(
			`Theme architecture violation: register_taxonomy() found in ${ relativePath }.`
		);
	}
}

if ( fs.existsSync( path.join( root, '403.php' ) ) ) {
	throw new Error( 'Unsupported root-level 403.php must not exist.' );
}

for ( const metadataPath of [
	'assets/css/bundle.asset.php',
	'assets/css/editor.asset.php',
	'assets/js/bundle.asset.php',
] ) {
	const metadata = fs.readFileSync( path.join( root, metadataPath ), 'utf8' );

	if ( ! metadata.includes( "'dependencies'" ) || ! metadata.includes( "'version'" ) ) {
		throw new Error( `Invalid webpack asset metadata: ${ metadataPath }` );
	}
}

console.log(
	`Validated the root npm workspace, ${ requiredFiles.length } required theme files, ${ phpFiles.length } PHP files, theme.json, style.css metadata, asset metadata, architecture boundaries, and the 1200x900 screenshot.`
);
