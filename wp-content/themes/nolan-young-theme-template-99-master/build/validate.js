const { existsSync, readdirSync } = require('node:fs'); const { join } = require('node:path');
const root=join(__dirname,'..'); const required=['style.css','functions.php','index.php','header.php','footer.php','dist/css/bundle.css','dist/js/bundle.js'];
const missing=required.filter(file=>!existsSync(join(root,file))); if(missing.length){throw new Error('Missing: '+missing.join(', '));}
const templates=readdirSync(join(root,'page-templates')).filter(file=>file.endsWith('.php')); for(const file of templates){const text=require('node:fs').readFileSync(join(root,'page-templates',file),'utf8'); if(!text.includes('Template Name:')) throw new Error(file+' has no Template Name');} console.log('Theme structure validated.');
