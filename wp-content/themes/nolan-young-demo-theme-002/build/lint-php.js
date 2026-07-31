const { execFileSync } = require( 'node:child_process' );
const { readdirSync } = require( 'node:fs' );
const { join } = require( 'node:path' );
const root = join( __dirname, '..' );
const files = []; const walk = (dir) => readdirSync(dir,{withFileTypes:true}).forEach(e=>e.isDirectory() ? ( e.name !== 'node_modules' && e.name !== 'vendor' && walk(join(dir,e.name)) ) : e.name.endsWith('.php')&&files.push(join(dir,e.name)));
walk(root); files.forEach(file => execFileSync('php',['-l',file],{stdio:'inherit'}));
