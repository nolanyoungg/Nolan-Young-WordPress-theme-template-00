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
		var copyButton = document.getElementById( 'nyforms-copy-system-report' );
		if ( copyButton ) {
			copyButton.addEventListener( 'click', function() {
				var report = document.getElementById( 'nyforms-system-report-data' );
				var status = document.querySelector( '.nyforms-copy-status' );
				if ( navigator.clipboard && window.isSecureContext ) { navigator.clipboard.writeText( report.value ).then( function() { status.textContent = 'Copied.'; } ); return; }
				report.focus(); report.select(); document.execCommand( 'copy' ); status.textContent = 'Copied.';
			} );
		}
	} );
}() );
