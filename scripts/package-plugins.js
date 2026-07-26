#!/usr/bin/env node

const fs = require( 'node:fs' );
const path = require( 'node:path' );
const { ZipArchive } = require( 'archiver' );

const root = path.resolve( __dirname, '..' );
const outputDirectory = path.join( root, 'dist', 'plugins' );
const plugins = [
  {
    slug: 'nyforms',
    main: 'nyforms.php',
    entries: [
      'assets',
      'blocks',
      'includes',
      'languages/nyforms.pot',
      'nyforms.php',
      'readme.txt',
      'uninstall.php',
    ],
  },
  {
    slug: 'nymegamenu',
    main: 'nymegamenu.php',
    entries: [
      'assets',
      'blocks',
      'includes',
      'languages/nymegamenu.pot',
      'nymegamenu.php',
      'readme.txt',
      'uninstall.php',
    ],
  },
];

function readVersion( plugin ) {
  const directory = path.join( root, 'wp-content', 'plugins', plugin.slug );
  const mainFile = fs.readFileSync( path.join( directory, plugin.main ), 'utf8' );
  const readme = fs.readFileSync( path.join( directory, 'readme.txt' ), 'utf8' );
  const version = mainFile.match( /^\s*\*\s*Version:\s*([0-9.]+)\s*$/m )?.[ 1 ];
  const stableTag = readme.match( /^Stable tag:\s*([0-9.]+)\s*$/im )?.[ 1 ];

  if ( ! version || version !== stableTag ) {
    throw new Error(
      `${ plugin.slug }: main plugin Version and readme Stable tag must match.`
    );
  }

  if ( ! /^Tested up to:\s*[0-9]+(?:\.[0-9]+)?\s*$/im.test( readme ) ) {
    throw new Error( `${ plugin.slug }: readme Tested up to value is invalid.` );
  }

  return version;
}

function assertReleaseFiles( plugin ) {
  const directory = path.join( root, 'wp-content', 'plugins', plugin.slug );
  const missing = plugin.entries.filter(
    ( entry ) => ! fs.existsSync( path.join( directory, entry ) )
  );

  if ( missing.length ) {
    throw new Error(
      `${ plugin.slug }: missing release entries: ${ missing.join( ', ' ) }`
    );
  }

  const forbidden = [
    'composer.json',
    'composer.lock',
    'phpcs.xml.dist',
    'phpunit.xml.dist',
    'tests',
    'vendor',
  ];
  const includedForbidden = plugin.entries.filter( ( entry ) =>
    forbidden.includes( entry )
  );

  if ( includedForbidden.length ) {
    throw new Error(
      `${ plugin.slug }: development entries cannot ship: ${ includedForbidden.join(
        ', '
      ) }`
    );
  }
}

function createArchive( plugin, version ) {
  const directory = path.join( root, 'wp-content', 'plugins', plugin.slug );
  const destination = path.join(
    outputDirectory,
    `${ plugin.slug }-${ version }.zip`
  );

  return new Promise( ( resolve, reject ) => {
    const output = fs.createWriteStream( destination );
    const archive = new ZipArchive( { zlib: { level: 9 } } );

    output.on( 'close', () => resolve( destination ) );
    archive.on( 'warning', ( error ) => {
      if ( error.code === 'ENOENT' ) {
        reject( error );
        return;
      }
      throw error;
    } );
    archive.on( 'error', reject );
    archive.pipe( output );

    plugin.entries.forEach( ( entry ) => {
      const source = path.join( directory, entry );
      const destinationPath = `${ plugin.slug }/${ entry }`;

      if ( fs.statSync( source ).isDirectory() ) {
        archive.directory( source, destinationPath );
      } else {
        archive.file( source, { name: destinationPath } );
      }
    } );

    archive.finalize();
  } );
}

async function main() {
  fs.rmSync( outputDirectory, { recursive: true, force: true } );
  fs.mkdirSync( outputDirectory, { recursive: true } );

  for ( const plugin of plugins ) {
    assertReleaseFiles( plugin );
    const version = readVersion( plugin );
    const destination = await createArchive( plugin, version );
    const size = fs.statSync( destination ).size;

    if ( size >= 10 * 1024 * 1024 ) {
      throw new Error( `${ plugin.slug }: archive exceeds the 10 MB limit.` );
    }

    process.stdout.write(
      `Packaged ${ path.relative( root, destination ) } (${ size } bytes)\n`
    );
  }
}

main().catch( ( error ) => {
  process.stderr.write( `${ error.message }\n` );
  process.exitCode = 1;
} );
