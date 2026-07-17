( function() {
	document.addEventListener( 'DOMContentLoaded', function() {
		document.querySelectorAll( '.nyforms-select-all' ).forEach( function( master ) {
			master.addEventListener( 'change', function() {
				document.querySelectorAll( 'input[name="form_ids[]"]' ).forEach( function( checkbox ) {
					checkbox.checked = master.checked;
				} );
			} );
		} );
	} );
}() );
