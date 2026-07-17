( function() {
	window.nyformsRecaptchaComplete = function() { document.querySelectorAll( '.nyforms-form[data-nyforms-recaptcha-waiting="1"]' ).forEach( function( form ) { form.dataset.nyformsRecaptchaWaiting = '0'; form.submit(); } ); };
	function values( form ) {
		var output = {};
		form.querySelectorAll( '[name^="nyforms_values"]' ).forEach( function( input ) {
			var match = input.name.match( /nyforms_values\[([^\]]+)\]/ );
			if ( ! match || ( ( 'checkbox' === input.type || 'radio' === input.type ) && ! input.checked ) ) { return; }
			if ( ! output[ match[ 1 ] ] ) { output[ match[ 1 ] ] = []; }
			output[ match[ 1 ] ].push( input.value );
		} );
		return output;
	}
	function matches( logic, current ) {
		if ( ! logic || ! logic.rules || ! logic.rules.length ) { return true; }
		var results = logic.rules.map( function( rule ) {
			var chosen = current[ rule.field ] || [];
			if ( 'checked' === rule.operator ) { return chosen.length > 0; }
			if ( 'unchecked' === rule.operator ) { return chosen.length === 0; }
			return 'not_equals' === rule.operator ? chosen.indexOf( rule.value ) === -1 : chosen.indexOf( rule.value ) !== -1;
		} );
		return 'any' === logic.match ? results.some( Boolean ) : results.every( Boolean );
	}
	function update( form ) {
		var current = values( form );
		form.querySelectorAll( '[data-nyforms-visibility]' ).forEach( function( element ) {
			var logic = JSON.parse( element.dataset.nyformsVisibility || '{}' );
			var visible = matches( logic, current );
			element.hidden = ! visible;
			element.querySelectorAll( 'input,select,textarea' ).forEach( function( input ) { input.disabled = ! visible; } );
		} );
		var numbers = {};
		Object.keys( current ).forEach( function( key ) { numbers[ key ] = parseFloat( current[ key ][ 0 ] ) || 0; } );
		var total = 0;
		form.querySelectorAll( '[data-nyforms-price]' ).forEach( function( field ) { var price = parseFloat( field.dataset.nyformsPrice ) || 0; var input = field.querySelector( 'input,select' ); if ( input && ( input.type !== 'checkbox' || input.checked ) ) { total += price * ( numbers[ field.dataset.nyformsKey ] || 1 ); } } );
		form.querySelectorAll( '.nyforms-total [data-nyforms-result]' ).forEach( function( result ) { result.textContent = total.toFixed( 2 ); } );
		form.querySelectorAll( '.nyforms-calculation' ).forEach( function( field ) { var formula = field.dataset.nyformsFormula || ''; formula = formula.replace( /\{([a-z0-9_-]+)\}/gi, function( match, key ) { return String( numbers[ key ] || 0 ); } ); if ( /^[0-9+\-*/().\s]+$/.test( formula ) ) { try { field.querySelector( '[data-nyforms-result]' ).textContent = Function( 'return (' + formula + ')' )().toFixed( 2 ); } catch ( error ) {} } } );
	}
	function paginate( form ) {
		var pages = Array.prototype.slice.call( form.querySelectorAll( '.nyforms-page-panel' ) );
		var nav = form.querySelector( '.nyforms-navigation' );
		if ( pages.length < 2 || ! nav ) { return; }
		var current = 0; var previous = nav.querySelector( '.nyforms-previous' ); var next = nav.querySelector( '.nyforms-next' ); var submit = nav.querySelector( '.nyforms-submit-wrap' ); var progress = nav.querySelector( '.nyforms-progress' );
		function show( index ) { current = index; pages.forEach( function( page, position ) { page.hidden = position !== current; } ); previous.hidden = current === 0; next.hidden = current === pages.length - 1; submit.hidden = current !== pages.length - 1; if ( progress ) { progress.textContent = 'Step ' + ( current + 1 ) + ' of ' + pages.length; } window.scrollTo( { top: form.getBoundingClientRect().top + window.pageYOffset - 24, behavior: 'smooth' } ); }
		next.addEventListener( 'click', function() { var invalid = pages[ current ].querySelector( 'input:invalid,select:invalid,textarea:invalid' ); if ( invalid ) { invalid.reportValidity(); return; } show( Math.min( pages.length - 1, current + 1 ) ); } );
		previous.addEventListener( 'click', function() { show( Math.max( 0, current - 1 ) ); } ); show( 0 );
	}
	document.addEventListener( 'DOMContentLoaded', function() { document.querySelectorAll( '.nyforms-form' ).forEach( function( form ) { form.addEventListener( 'change', function() { update( form ); } ); var invisible = form.querySelector( '.nyforms-recaptcha--invisible' ); if ( invisible ) { form.addEventListener( 'submit', function( event ) { if ( '1' === form.dataset.nyformsRecaptchaWaiting || ! window.grecaptcha || ! window.grecaptcha.execute ) { return; } event.preventDefault(); form.dataset.nyformsRecaptchaWaiting = '1'; window.grecaptcha.execute(); } ); } update( form ); paginate( form ); } ); document.querySelectorAll( '.nyforms-privacy-request' ).forEach( function( form ) { form.addEventListener( 'submit', function( event ) { event.preventDefault(); var status = form.querySelector( '.nyforms-privacy-status' ); var token = form.querySelector( '[name="g-recaptcha-response"]' ); fetch( form.dataset.endpoint, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify( { email: form.elements.email.value, type: form.elements.type.value, 'g-recaptcha-response': token ? token.value : '' } ) } ).then( function() { status.textContent = 'If the request can be processed, you will receive a confirmation email.'; } ).catch( function() { status.textContent = 'If the request can be processed, you will receive a confirmation email.'; } ); } ); } ); } );
}() );
