(() => {
	const menus = document.querySelectorAll( '[data-nymega-menu]' );
	menus.forEach( ( menu ) => {
		let active = null;
		const close = ( item, focus = false ) => {
			if ( ! item ) return;
			const trigger = item.querySelector( ':scope > [data-nymega-trigger]' );
			const panel = item.querySelector( ':scope > .nymegamenu__panel, :scope > .nymegamenu__submenu' );
			item.classList.remove( 'is-open' );
			if ( trigger ) trigger.setAttribute( 'aria-expanded', 'false' );
			if ( panel ) panel.hidden = true;
			if ( focus && trigger ) trigger.focus();
			if ( active === item ) active = null;
		};
		const open = ( item ) => {
			if ( active && active !== item ) close( active );
			const trigger = item.querySelector( ':scope > [data-nymega-trigger]' );
			const panel = item.querySelector( ':scope > .nymegamenu__panel, :scope > .nymegamenu__submenu' );
			if ( ! trigger || ! panel ) return;
			panel.hidden = false; item.classList.add( 'is-open' ); trigger.setAttribute( 'aria-expanded', 'true' ); active = item;
		};
		menu.querySelectorAll( '[data-nymega-item]' ).forEach( ( item ) => {
			const trigger = item.querySelector( ':scope > [data-nymega-trigger]' );
			if ( ! trigger ) return;
			trigger.addEventListener( 'click', () => item.classList.contains( 'is-open' ) ? close( item ) : open( item ) );
			trigger.addEventListener( 'keydown', ( event ) => {
				if ( event.key === 'Escape' ) { event.preventDefault(); close( item, true ); }
				if ( event.key === 'ArrowDown' ) { event.preventDefault(); open( item ); const target = item.querySelector( '.nymegamenu__panel a, .nymegamenu__submenu a, .nymegamenu__panel button' ); if ( target ) target.focus(); }
			} );
			item.addEventListener( 'mouseenter', () => { if ( menu.dataset.nymegaTrigger === 'hover' || menu.dataset.nymegaTrigger === 'hover-intent' ) open( item ); } );
			item.addEventListener( 'mouseleave', () => { if ( menu.dataset.nymegaTrigger === 'hover' ) close( item ); } );
		} );
		document.addEventListener( 'click', ( event ) => { if ( active && ! menu.contains( event.target ) ) close( active ); } );
		document.addEventListener( 'keydown', ( event ) => { if ( event.key === 'Escape' && active ) { event.preventDefault(); close( active, true ); } } );
	} );
})();
