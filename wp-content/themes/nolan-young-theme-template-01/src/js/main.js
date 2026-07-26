import { ready } from './utilities/dom.js';
import { initializeNavigation } from './components/navigation.js';
import { initializeMegaMenus } from './components/mega-menu.js';

ready( () => {
	document.documentElement.classList.add( 'nytt01-js' );
	initializeNavigation();
	initializeMegaMenus();
} );
