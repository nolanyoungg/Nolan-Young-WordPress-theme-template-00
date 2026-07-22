(() => {
	'use strict';

	const menus = () => Array.from( document.querySelectorAll( '[data-nymega-menu][data-nymega-breakpoint]' ) );
	const drawerFor = ( menu ) => menu.querySelector( '[data-nymega-drawer]' );
	const overlayFor = ( menu ) => menu.querySelector( '[data-nymega-overlay]' );
	const panelFor = ( item ) => item.querySelector( ':scope > [data-nymega-panel], :scope > .nymegamenu__panel, :scope > .nymegamenu__submenu' );
	const triggerFor = ( item ) => item.querySelector( ':scope > button[data-nymega-trigger]' );
	const focusable = ( root ) => Array.from( root.querySelectorAll( 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])' ) ).filter( ( element ) => ! element.hidden && element.offsetParent !== null );

	const isCompact = ( menu ) => menu.classList.contains( 'is-compact' );
	const usesOffcanvas = ( menu ) => 'offcanvas' === menu.dataset.nymegaMobileType;
	const hasOpenPanel = ( menu ) => Boolean( menu.querySelector( '.nymegamenu__item.is-open' ) );

	const updateOverlay = ( menu ) => {
		const overlay = overlayFor( menu );
		if ( ! overlay ) {
			return;
		}

		const active = isCompact( menu )
			? menu.classList.contains( 'is-drawer-open' ) && '1' === menu.dataset.nymegaOverlayMobile
			: hasOpenPanel( menu ) && '1' === menu.dataset.nymegaOverlayDesktop;
		overlay.hidden = ! active;
		overlay.setAttribute( 'aria-hidden', String( ! active ) );
		overlay.tabIndex = active ? 0 : -1;
	};

	const updateMenuState = ( menu ) => {
		menu.classList.toggle( 'is-menu-open', hasOpenPanel( menu ) );
		updateOverlay( menu );
	};

	const updateDrawerState = () => {
		const openOffcanvas = Boolean( document.querySelector( '[data-nymega-menu].is-drawer-open[data-nymega-mobile-type="offcanvas"]' ) );
		document.body.classList.toggle( 'nymega-drawer-open', openOffcanvas );
	};

	const closeItem = ( item, returnFocus = false ) => {
		if ( ! item ) {
			return;
		}

		const trigger = triggerFor( item );
		const panel = panelFor( item );
		item.classList.remove( 'is-open' );
		if ( trigger ) {
			trigger.setAttribute( 'aria-expanded', 'false' );
			if ( returnFocus ) {
				trigger.focus();
			}
		}
		if ( panel ) {
			panel.classList.remove( 'is-open' );
			panel.hidden = true;
		}

		const menu = item.closest( '[data-nymega-menu][data-nymega-breakpoint]' );
		if ( menu ) {
			updateMenuState( menu );
		}
	};

	const openItem = ( item, preserveOpenItems = false ) => {
		const menu = item?.closest( '[data-nymega-menu][data-nymega-breakpoint]' );
		const trigger = triggerFor( item );
		const panel = panelFor( item );
		if ( ! menu || ! trigger || ! panel ) {
			return;
		}

		if ( ! preserveOpenItems && ( ! isCompact( menu ) || 'multiple' !== menu.dataset.nymegaMobileBehavior ) ) {
			menu.querySelectorAll( '.nymegamenu__item.is-open' ).forEach( ( other ) => {
				if ( other !== item ) {
					closeItem( other );
				}
			} );
		}

		panel.hidden = false;
		panel.classList.add( 'is-open' );
		item.classList.add( 'is-open' );
		trigger.setAttribute( 'aria-expanded', 'true' );
		updateMenuState( menu );
	};

	const closeDrawer = ( menu, returnFocus = false ) => {
		const toggle = menu.querySelector( '[data-nymega-toggle]' );
		const drawer = drawerFor( menu );
		menu.classList.remove( 'is-drawer-open' );
		menu.querySelectorAll( '.nymegamenu__item.is-open' ).forEach( ( item ) => closeItem( item ) );
		if ( drawer ) {
			drawer.setAttribute( 'aria-hidden', String( isCompact( menu ) ) );
		}
		if ( toggle ) {
			toggle.setAttribute( 'aria-expanded', 'false' );
			if ( returnFocus ) {
				toggle.focus();
			}
		}
		updateOverlay( menu );
		updateDrawerState();
	};

	const openDrawer = ( menu ) => {
		const toggle = menu.querySelector( '[data-nymega-toggle]' );
		const drawer = drawerFor( menu );
		menu.classList.add( 'is-drawer-open' );
		if ( drawer ) {
			drawer.setAttribute( 'aria-hidden', 'false' );
		}
		if ( toggle ) {
			toggle.setAttribute( 'aria-expanded', 'true' );
		}
		updateOverlay( menu );
		updateDrawerState();
		focusable( drawer )[ 0 ]?.focus();
	};

	const setCompact = () => {
		menus().forEach( ( menu ) => {
			const compact = window.innerWidth <= Number( menu.dataset.nymegaBreakpoint || 900 );
			const changed = compact !== isCompact( menu );
			const drawer = drawerFor( menu );
			menu.classList.toggle( 'is-compact', compact );

			if ( changed && ! compact ) {
				closeDrawer( menu );
				menu.querySelectorAll( '.nymegamenu__item.is-open' ).forEach( ( item ) => closeItem( item ) );
			}

			if ( ! compact && drawer ) {
				drawer.setAttribute( 'aria-hidden', 'false' );
			}

			if ( changed && compact ) {
				menu.querySelectorAll( '.nymegamenu__item.is-open' ).forEach( ( item ) => closeItem( item ) );
				if ( 'expanded' === menu.dataset.nymegaMobileDefault ) {
					menu.querySelectorAll( '.nymegamenu__item' ).forEach( ( item ) => {
						if ( panelFor( item ) ) {
							openItem( item, true );
						}
					} );
				}
			}

			if ( compact && drawer && ! menu.classList.contains( 'is-drawer-open' ) ) {
				drawer.setAttribute( 'aria-hidden', 'true' );
			}
			updateOverlay( menu );
		} );
	};

	const setSticky = () => {
		menus().forEach( ( menu ) => {
			if ( menu.classList.contains( 'nymegamenu--sticky' ) ) {
				menu.classList.toggle( 'is-stuck', window.scrollY > 0 );
			}
		} );
	};

	const installHoverBehavior = ( menu ) => {
		if ( ! /^(hover|hover-intent)$/.test( menu.dataset.nymegaTrigger || '' ) ) {
			return;
		}

		let timer;
		menu.addEventListener( 'pointerover', ( event ) => {
			if ( isCompact( menu ) ) {
				return;
			}
			const item = event.target.closest( '[data-nymega-item]' );
			if ( ! item || ! menu.contains( item ) ) {
				return;
			}
			window.clearTimeout( timer );
			const reveal = () => openItem( item );
			timer = 'hover-intent' === menu.dataset.nymegaTrigger ? window.setTimeout( reveal, 140 ) : reveal();
		} );
		menu.addEventListener( 'pointerout', ( event ) => {
			const item = event.target.closest( '[data-nymega-item]' );
			if ( ! item || item.contains( event.relatedTarget ) ) {
				return;
			}
			window.clearTimeout( timer );
			timer = window.setTimeout( () => closeItem( item ), 'hover-intent' === menu.dataset.nymegaTrigger ? 180 : 60 );
		} );
	};

	const initialize = () => {
		setCompact();
		setSticky();
		menus().forEach( ( menu ) => {
			installHoverBehavior( menu );
		} );
		window.addEventListener( 'resize', setCompact, { passive: true } );
		window.addEventListener( 'scroll', setSticky, { passive: true } );
	};

	document.addEventListener( 'click', ( event ) => {
		const overlay = event.target.closest( '[data-nymega-overlay]' );
		if ( overlay ) {
			const menu = overlay.closest( '[data-nymega-menu][data-nymega-breakpoint]' );
			if ( menu ) {
				if ( isCompact( menu ) ) {
					closeDrawer( menu, true );
				} else {
					menu.querySelectorAll( '.nymegamenu__item.is-open' ).forEach( ( item ) => closeItem( item, true ) );
				}
			}
			return;
		}

		const toggle = event.target.closest( '[data-nymega-toggle]' );
		if ( toggle ) {
			const menu = toggle.closest( '[data-nymega-menu][data-nymega-breakpoint]' );
			if ( menu ) {
				menu.classList.contains( 'is-drawer-open' ) ? closeDrawer( menu ) : openDrawer( menu );
			}
			return;
		}

		const trigger = event.target.closest( 'button[data-nymega-trigger]' );
		if ( trigger ) {
			const item = trigger.closest( '[data-nymega-item]' );
			item?.classList.contains( 'is-open' ) ? closeItem( item ) : openItem( item );
			return;
		}

		const link = event.target.closest( '.nymegamenu__link' );
		if ( link ) {
			const item = link.closest( '[data-nymega-item]' );
			const menu = item?.closest( '[data-nymega-menu][data-nymega-breakpoint]' );
			if ( item && menu && triggerFor( item ) && ! isCompact( menu ) ) {
				const behavior = menu.dataset.nymegaClickBehavior || 'toggle-follow';
				if ( 'toggle-close' === behavior || ( 'toggle-follow' === behavior && ! item.classList.contains( 'is-open' ) ) ) {
					event.preventDefault();
					item.classList.contains( 'is-open' ) ? closeItem( item ) : openItem( item );
				}
			}
			return;
		}

		menus().forEach( ( menu ) => {
			if ( ! menu.contains( event.target ) ) {
				menu.querySelectorAll( '.nymegamenu__item.is-open' ).forEach( closeItem );
				closeDrawer( menu );
			}
		} );
	} );

	document.addEventListener( 'keydown', ( event ) => {
		const activeMenu = event.target.closest( '[data-nymega-menu][data-nymega-breakpoint]' );
		if ( 'Escape' === event.key && activeMenu ) {
			event.preventDefault();
			if ( activeMenu.classList.contains( 'is-drawer-open' ) ) {
				closeDrawer( activeMenu, true );
			} else {
				activeMenu.querySelectorAll( '.nymegamenu__item.is-open' ).forEach( ( item ) => closeItem( item, true ) );
			}
			return;
		}

		const trigger = event.target.closest( 'button[data-nymega-trigger]' );
		if ( trigger && 'ArrowDown' === event.key ) {
			event.preventDefault();
			const item = trigger.closest( '[data-nymega-item]' );
			openItem( item );
			focusable( panelFor( item ) )[ 0 ]?.focus();
			return;
		}
		if ( trigger && 'ArrowUp' === event.key ) {
			event.preventDefault();
			closeItem( trigger.closest( '[data-nymega-item]' ), true );
			return;
		}

		const drawerMenu = event.target.closest( '[data-nymega-menu][data-nymega-breakpoint].is-drawer-open[data-nymega-mobile-type="offcanvas"]' );
		if ( drawerMenu && 'Tab' === event.key ) {
			const controls = focusable( drawerFor( drawerMenu ) );
			if ( ! controls.length ) {
				return;
			}
			const first = controls[ 0 ];
			const last = controls[ controls.length - 1 ];
			if ( event.shiftKey && event.target === first ) {
				event.preventDefault();
				last.focus();
			} else if ( ! event.shiftKey && event.target === last ) {
				event.preventDefault();
				first.focus();
			}
		}
	} );

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', initialize, { once: true } );
	} else {
		initialize();
	}
})();
