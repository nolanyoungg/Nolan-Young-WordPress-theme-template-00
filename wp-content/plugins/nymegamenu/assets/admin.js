(() => {
	const customCss = document.getElementById( 'nymega-custom-css' );
	if ( customCss && window.wp?.codeEditor && window.nymegaCustomEditor ) {
		const editor = window.wp.codeEditor.initialize( customCss, window.nymegaCustomEditor );
		customCss.closest( 'form' )?.addEventListener( 'submit', () => editor.codemirror.save() );
	}
	const open = ( editor ) => { editor.hidden = false; const dialog = editor.querySelector( '.nymega-item-editor__dialog' ); if ( dialog ) dialog.querySelector( 'select, input, textarea, button' )?.focus(); };
	const close = ( editor ) => { editor.hidden = true; };
	document.addEventListener( 'click', ( event ) => { const trigger = event.target.closest( '.nymega-item-editor-trigger' ); if ( trigger ) { event.preventDefault(); open( document.getElementById( trigger.dataset.nymegaEditor ) ); return; } const closer = event.target.closest( '[data-nymega-close]' ); if ( closer ) { close( closer.closest( '.nymega-item-editor' ) ); return; } if ( event.target.classList.contains( 'nymega-item-editor' ) ) close( event.target ); } );
	document.addEventListener( 'keydown', ( event ) => { if ( 'Escape' === event.key ) document.querySelectorAll( '.nymega-item-editor:not([hidden])' ).forEach( close ); } );
	document.addEventListener( 'submit', ( event ) => { const form = event.target.closest( '.nymega-theme-editor-form' ); if ( ! form || ! form.querySelector( '[name="nymegamenu_open_preview"]' )?.checked ) return; window.open( form.dataset.previewUrl, '_blank', 'noopener' ); } );
	const hex = ( value ) => /^#[0-9a-f]{6}$/i.test( value ) ? value : '#ffffff';
	const closeColor = () => document.querySelectorAll( '.nymega-color-popover' ).forEach( ( popover ) => popover.remove() );
	document.addEventListener( 'click', ( event ) => { const swatch = event.target.closest( '[data-nymega-color]' ); if ( ! swatch ) { if ( ! event.target.closest( '.nymega-color-popover' ) ) closeColor(); return; } event.preventDefault(); closeColor(); const control = swatch.closest( '.nymega-color-control' ); const text = control.querySelector( 'input[type="text"]' ); const popover = document.createElement( 'div' ); popover.className = 'nymega-color-popover'; popover.setAttribute( 'role', 'dialog' ); popover.innerHTML = '<strong>Choose color</strong><input type="color" value="' + hex( text.value ) + '"><button type="button">Transparent</button>'; control.append( popover ); const picker = popover.querySelector( 'input' ); const sync = ( value ) => { text.value = value; control.querySelector( 'i' ).style.background = value; text.dispatchEvent( new Event( 'change', { bubbles: true } ) ); }; picker.addEventListener( 'input', () => sync( picker.value ) ); popover.querySelector( 'button' ).addEventListener( 'click', () => { sync( 'transparent' ); closeColor(); } ); picker.focus(); } );
	document.addEventListener( 'input', ( event ) => { const text = event.target.closest( '.nymega-color-control input[type="text"]' ); if ( text ) { text.closest( '.nymega-color-control' ).querySelector( 'i' ).style.background = text.value; } } );
	const locationModal = ( modal, open ) => {
		if ( ! modal ) return;
		modal.hidden = ! open;
		if ( open ) modal.querySelector( '[data-nymega-location-close]' )?.focus();
	};
	document.addEventListener( 'click', ( event ) => {
		const card = event.target.closest( '[data-nymega-location-open]' );
		if ( card && ! event.target.closest( '.nymega-switch' ) ) { locationModal( document.getElementById( 'nymega-location-modal-' + card.dataset.nymegaLocationOpen ), true ); return; }
		const closeLocation = event.target.closest( '[data-nymega-location-close]' );
		if ( closeLocation ) { locationModal( closeLocation.closest( '.nymega-location-modal' ), false ); return; }
		const tab = event.target.closest( '[data-nymega-location-tab]' );
		if ( tab ) { const modal = tab.closest( '.nymega-location-modal' ); modal.querySelectorAll( '[data-nymega-location-tab]' ).forEach( ( item ) => item.classList.toggle( 'is-active', item === tab ) ); modal.querySelectorAll( '[data-nymega-location-panel]' ).forEach( ( panel ) => { const active = panel.dataset.nymegaLocationPanel === tab.dataset.nymegaLocationTab; panel.hidden = ! active; panel.classList.toggle( 'is-active', active ); } ); return; }
		const saveLocation = event.target.closest( '[data-nymega-location-save]' );
		if ( saveLocation ) { saveLocation.closest( 'form' )?.requestSubmit(); }
		if ( event.target.classList.contains( 'nymega-location-modal' ) ) locationModal( event.target, false );
	} );
	document.addEventListener( 'keydown', ( event ) => {
		if ( 'Escape' === event.key ) document.querySelectorAll( '.nymega-location-modal:not([hidden])' ).forEach( ( modal ) => locationModal( modal, false ) );
		if ( ( 'Enter' === event.key || ' ' === event.key ) && event.target.matches( '[data-nymega-location-open]' ) ) { event.preventDefault(); locationModal( document.getElementById( 'nymega-location-modal-' + event.target.dataset.nymegaLocationOpen ), true ); }
	} );
})();
