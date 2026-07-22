(() => {
	'use strict';

	const opener = new WeakMap();
	const focusable = ( root ) => Array.from( root.querySelectorAll( 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])' ) ).filter( ( element ) => ! element.hidden && element.offsetParent !== null );
	const trapFocus = ( event, dialog ) => {
		if ( 'Tab' !== event.key ) {
			return;
		}
		const controls = focusable( dialog );
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
	};

	const openDialog = ( modal, trigger, selector ) => {
		if ( ! modal ) {
			return;
		}
		opener.set( modal, trigger || document.activeElement );
		modal.hidden = false;
		modal.querySelector( selector )?.focus();
	};
	const closeDialog = ( modal ) => {
		if ( ! modal ) {
			return;
		}
		modal.hidden = true;
		opener.get( modal )?.focus();
	};

	const activateLocationTab = ( tab, focus = false ) => {
		const modal = tab.closest( '.nymega-location-modal' );
		if ( ! modal ) {
			return;
		}
		modal.querySelectorAll( '[data-nymega-location-tab]' ).forEach( ( item ) => {
			const active = item === tab;
			item.classList.toggle( 'is-active', active );
			item.setAttribute( 'aria-selected', String( active ) );
			item.tabIndex = active ? 0 : -1;
		} );
		modal.querySelectorAll( '[data-nymega-location-panel]' ).forEach( ( panel ) => {
			const active = panel.dataset.nymegaLocationPanel === tab.dataset.nymegaLocationTab;
			panel.hidden = ! active;
			panel.classList.toggle( 'is-active', active );
		} );
		if ( focus ) {
			tab.focus();
		}
	};

	const customCss = document.getElementById( 'nymega-custom-css' );
	if ( customCss && window.wp?.codeEditor && window.nymegaCustomEditor ) {
		const editor = window.wp.codeEditor.initialize( customCss, window.nymegaCustomEditor );
		customCss.closest( 'form' )?.addEventListener( 'submit', () => editor.codemirror.save() );
	}

	const closeColor = () => document.querySelectorAll( '.nymega-color-popover' ).forEach( ( popover ) => popover.remove() );
	const hex = ( value ) => /^#[0-9a-f]{6}$/i.test( value ) ? value : '#ffffff';

	document.addEventListener( 'click', ( event ) => {
		const itemTrigger = event.target.closest( '.nymega-item-editor-trigger' );
		if ( itemTrigger ) {
			event.preventDefault();
			openDialog( document.getElementById( itemTrigger.dataset.nymegaEditor ), itemTrigger, '.nymega-item-editor__close' );
			return;
		}
		const itemClose = event.target.closest( '[data-nymega-close]' );
		if ( itemClose ) {
			closeDialog( itemClose.closest( '.nymega-item-editor' ) );
			return;
		}
		if ( event.target.classList.contains( 'nymega-item-editor' ) ) {
			closeDialog( event.target );
			return;
		}

		const locationTrigger = event.target.closest( '[data-nymega-location-open]' );
		if ( locationTrigger ) {
			openDialog( document.getElementById( 'nymega-location-modal-' + locationTrigger.dataset.nymegaLocationOpen ), locationTrigger, '[data-nymega-location-close]' );
			return;
		}
		const locationClose = event.target.closest( '[data-nymega-location-close]' );
		if ( locationClose ) {
			closeDialog( locationClose.closest( '.nymega-location-modal' ) );
			return;
		}
		const tab = event.target.closest( '[data-nymega-location-tab]' );
		if ( tab ) {
			activateLocationTab( tab );
			return;
		}
		const saveLocation = event.target.closest( '[data-nymega-location-save]' );
		if ( saveLocation ) {
			saveLocation.closest( 'form' )?.requestSubmit();
			return;
		}
		if ( event.target.classList.contains( 'nymega-location-modal' ) ) {
			closeDialog( event.target );
			return;
		}

		const swatch = event.target.closest( '[data-nymega-color]' );
		if ( ! swatch ) {
			if ( ! event.target.closest( '.nymega-color-popover' ) ) {
				closeColor();
			}
			return;
		}
		event.preventDefault();
		closeColor();
		const control = swatch.closest( '.nymega-color-control' );
		const text = control?.querySelector( 'input[type="text"]' );
		if ( ! control || ! text ) {
			return;
		}
		const popover = document.createElement( 'div' );
		popover.className = 'nymega-color-popover';
		popover.setAttribute( 'role', 'dialog' );
		popover.innerHTML = '<strong>Choose color</strong><input type="color" value="' + hex( text.value ) + '"><button type="button">Transparent</button>';
		control.append( popover );
		const picker = popover.querySelector( 'input' );
		const sync = ( value ) => {
			text.value = value;
			control.querySelector( 'i' ).style.background = value;
			text.dispatchEvent( new Event( 'change', { bubbles: true } ) );
		};
		picker.addEventListener( 'input', () => sync( picker.value ) );
		popover.querySelector( 'button' ).addEventListener( 'click', () => {
			sync( 'transparent' );
			closeColor();
		} );
		picker.focus();
	} );

	document.addEventListener( 'keydown', ( event ) => {
		const itemModal = event.target.closest( '.nymega-item-editor:not([hidden])' );
		const locationModal = event.target.closest( '.nymega-location-modal:not([hidden])' );
		const modal = itemModal || locationModal;
		if ( modal ) {
			if ( 'Escape' === event.key ) {
				event.preventDefault();
				closeDialog( modal );
				return;
			}
			trapFocus( event, modal.querySelector( '[role="dialog"]' ) || modal );
		}

		const tab = event.target.closest( '[data-nymega-location-tab]' );
		if ( ! tab || ! /^(ArrowLeft|ArrowRight|Home|End)$/.test( event.key ) ) {
			return;
		}
		const tabs = Array.from( tab.closest( '[role="tablist"]' ).querySelectorAll( '[data-nymega-location-tab]' ) );
		const index = tabs.indexOf( tab );
		let next = index;
		if ( 'ArrowLeft' === event.key ) next = ( index - 1 + tabs.length ) % tabs.length;
		if ( 'ArrowRight' === event.key ) next = ( index + 1 ) % tabs.length;
		if ( 'Home' === event.key ) next = 0;
		if ( 'End' === event.key ) next = tabs.length - 1;
		event.preventDefault();
		activateLocationTab( tabs[ next ], true );
	} );

	document.addEventListener( 'input', ( event ) => {
		const text = event.target.closest( '.nymega-color-control input[type="text"]' );
		if ( text ) {
			text.closest( '.nymega-color-control' ).querySelector( 'i' ).style.background = text.value;
		}
	} );

	document.addEventListener( 'submit', ( event ) => {
		const form = event.target.closest( '.nymega-theme-editor-form' );
		if ( form && form.querySelector( '[name="nymegamenu_open_preview"]' )?.checked ) {
			window.open( form.dataset.previewUrl, '_blank', 'noopener' );
		}
	} );
})();
