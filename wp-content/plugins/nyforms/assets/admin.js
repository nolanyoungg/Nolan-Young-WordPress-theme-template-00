( function() {
	document.addEventListener( 'DOMContentLoaded', function() {
		document.querySelectorAll( '.nyforms-select-all' ).forEach( function( master ) {
			master.addEventListener( 'change', function() {
				var scope = master.closest( 'form' ) || document;
				scope.querySelectorAll( 'input[name="form_ids[]"], input[name="entry_ids[]"]' ).forEach( function( checkbox ) {
					checkbox.checked = master.checked;
				} );
			} );
		} );
	} );
}() );
