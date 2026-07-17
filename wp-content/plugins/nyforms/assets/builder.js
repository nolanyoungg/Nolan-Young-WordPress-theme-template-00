( function( apiFetch, i18n ) {
	var root = document.getElementById( 'nyforms-builder' );
	if ( ! root ) { return; }
	var record = JSON.parse( root.dataset.form );
	var form = record.definition;
	var types = [ 'text', 'textarea', 'email', 'phone', 'number', 'name', 'address', 'url', 'date', 'time', 'select', 'radio', 'checkbox', 'consent', 'hidden', 'html', 'section', 'page', 'file', 'product', 'option', 'quantity', 'total', 'calculation' ];
	function key( type ) { return type + '_' + Math.random().toString( 36 ).slice( 2, 8 ); }
	function render() {
		root.innerHTML = '<div class="nyforms-builder"><aside><h2>Fields</h2>' + types.map( function( type ) { return '<button type="button" class="button nyforms-add" data-type="' + type + '">+' + type + '</button>'; } ).join( '' ) + '</aside><main><p><label>Form title <input id="nyforms-title" value="' + escapeHtml( form.title ) + '"></label></p><ol id="nyforms-fields">' + form.fields.map( fieldRow ).join( '' ) + '</ol><p><button class="button button-primary" id="nyforms-save">Save form</button> <span id="nyforms-notice"></span></p></main></div>';
		root.querySelectorAll( '.nyforms-add' ).forEach( function( button ) { button.addEventListener( 'click', function() { form.fields.push( { key: key( button.dataset.type ), type: button.dataset.type, label: button.dataset.type, description: '', placeholder: '', help: '', default: '', css_class: '', required: false, choices: [] } ); render(); } ); } );
		root.querySelectorAll( '.nyforms-remove' ).forEach( function( button ) { button.addEventListener( 'click', function() { form.fields.splice( Number( button.dataset.index ), 1 ); render(); } ); } );
		root.querySelectorAll( '.nyforms-label,.nyforms-required' ).forEach( function( input ) { input.addEventListener( 'change', function() { var field = form.fields[ Number( input.dataset.index ) ]; field[ input.dataset.prop ] = 'checkbox' === input.type ? input.checked : input.value; } ); } );
		root.querySelector( '#nyforms-save' ).addEventListener( 'click', save );
	}
	function fieldRow( field, index ) { return '<li draggable="true"><strong>' + escapeHtml( field.type ) + '</strong> <input class="nyforms-label" data-index="' + index + '" data-prop="label" value="' + escapeHtml( field.label || '' ) + '"> <label><input type="checkbox" class="nyforms-required" data-index="' + index + '" data-prop="required"' + ( field.required ? ' checked' : '' ) + '> Required</label> <button class="button-link-delete nyforms-remove" data-index="' + index + '">Remove</button></li>'; }
	function save() { form.title = root.querySelector( '#nyforms-title' ).value; apiFetch( { path: 'nyforms/v1/forms/' + record.id, method: 'PUT', headers: { 'X-WP-Nonce': window.nyformsBuilder.nonce }, data: form } ).then( function( updated ) { record = updated; form = updated.definition; root.querySelector( '#nyforms-notice' ).textContent = i18n.__( 'Saved.', 'nyforms' ); } ).catch( function( error ) { root.querySelector( '#nyforms-notice' ).textContent = error.message; } ); }
	function escapeHtml( string ) { return String( string || '' ).replace( /[&<>'"]/g, function( char ) { return { '&':'&amp;', '<':'&lt;', '>':'&gt;', "'":'&#39;', '"':'&quot;' }[ char ]; } ); }
	render();
}( window.wp.apiFetch, window.wp.i18n ) );
