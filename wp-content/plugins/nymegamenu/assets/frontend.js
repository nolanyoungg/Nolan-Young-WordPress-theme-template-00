(() => {
	const menus = () => Array.from( document.querySelectorAll( '[data-nymega-menu]' ) );
	const setCompact = () => menus().forEach( ( menu ) => menu.classList.toggle( 'is-compact', window.innerWidth <= Number( menu.dataset.nymegaBreakpoint || 900 ) ) );
	const panelFor = ( item ) => item.querySelector( ':scope > .nymegamenu__panel, :scope > .nymegamenu__submenu' );
	const close = ( item, focus = false ) => { if ( ! item ) return; const trigger = item.querySelector( ':scope > button[data-nymega-trigger]' ); const panel = panelFor( item ); item.classList.remove( 'is-open' ); if ( trigger ) { trigger.setAttribute( 'aria-expanded', 'false' ); trigger.setAttribute( 'aria-selected', 'false' ); if ( focus ) { trigger.focus(); } } if ( panel ) { panel.hidden = true; } };
	const open = ( item ) => { const menu = item.closest( '[data-nymega-menu]' ); if ( ! menu ) return; if ( 'multiple' !== menu.dataset.nymegaMobileBehavior || ! menu.classList.contains( 'is-compact' ) ) { menu.querySelectorAll( '.nymegamenu__item.is-open' ).forEach( ( other ) => { if ( other !== item ) close( other ); } ); } const trigger = item.querySelector( ':scope > button[data-nymega-trigger]' ); const panel = panelFor( item ); if ( ! trigger || ! panel ) return; panel.hidden = false; item.classList.add( 'is-open' ); trigger.setAttribute( 'aria-expanded', 'true' ); if ( item.hasAttribute( 'data-nymega-tabbed' ) ) trigger.setAttribute( 'aria-selected', 'true' ); };
	const setSticky = () => menus().forEach( ( menu ) => { if ( menu.classList.contains( 'nymegamenu--sticky' ) ) menu.classList.toggle( 'is-stuck', window.scrollY > 0 ); } );
	const initialize = () => {
		setCompact(); setSticky();
		menus().forEach( ( menu ) => {
			if ( menu.classList.contains( 'is-compact' ) && 'expanded' === menu.dataset.nymegaMobileDefault ) menu.querySelectorAll( '.nymegamenu__item' ).forEach( ( item ) => { if ( panelFor( item ) ) open( item ); } );
			if ( ! menu.classList.contains( 'is-compact' ) && /^(hover|hover-intent)$/.test( menu.dataset.nymegaTrigger || '' ) ) {
				let timer;
				menu.addEventListener( 'pointerover', ( event ) => { const item = event.target.closest( '[data-nymega-item]' ); if ( ! item || ! menu.contains( item ) ) return; clearTimeout( timer ); const reveal = () => open( item ); if ( 'hover-intent' === menu.dataset.nymegaTrigger ) timer = window.setTimeout( reveal, 140 ); else reveal(); } );
				menu.addEventListener( 'pointerout', ( event ) => { const item = event.target.closest( '[data-nymega-item]' ); if ( ! item || item.contains( event.relatedTarget ) ) return; clearTimeout( timer ); timer = window.setTimeout( () => close( item ), 'hover-intent' === menu.dataset.nymegaTrigger ? 180 : 60 ); } );
			}
		} );
		window.addEventListener( 'resize', setCompact, { passive: true } ); window.addEventListener( 'scroll', setSticky, { passive: true } );
	};
	document.addEventListener( 'click', ( event ) => { const toggle = event.target.closest( '[data-nymega-toggle]' ); if ( toggle ) { const menu = toggle.closest( '[data-nymega-menu]' ); if ( menu ) { const isOpen = menu.classList.toggle( 'is-drawer-open' ); toggle.setAttribute( 'aria-expanded', String( isOpen ) ); } return; } const trigger = event.target.closest( 'button[data-nymega-trigger]' ); if ( trigger ) { const item = trigger.closest( '[data-nymega-item]' ); if ( item ) { item.classList.contains( 'is-open' ) ? close( item ) : open( item ); } return; } menus().forEach( ( menu ) => { if ( ! menu.contains( event.target ) ) menu.querySelectorAll( '.nymegamenu__item.is-open' ).forEach( close ); } ); } );
	document.addEventListener( 'keydown', ( event ) => { const trigger = event.target.closest( 'button[data-nymega-trigger]' ); if ( trigger && 'ArrowDown' === event.key ) { event.preventDefault(); open( trigger.closest( '[data-nymega-item]' ) ); trigger.closest( '[data-nymega-item]' ).querySelector( '.nymegamenu__panel a, .nymegamenu__submenu a, .nymegamenu__panel button' )?.focus(); } if ( 'Escape' === event.key ) menus().forEach( ( menu ) => menu.querySelectorAll( '.nymegamenu__item.is-open' ).forEach( ( item ) => close( item, true ) ) ); } );
	if ( 'loading' === document.readyState ) document.addEventListener( 'DOMContentLoaded', initialize, { once: true } ); else initialize();
})();
