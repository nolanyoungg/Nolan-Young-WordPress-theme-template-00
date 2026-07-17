( function( blocks, element, components, blockEditor, i18n ) {
	var el = element.createElement;
	blocks.registerBlockType( 'nyforms/form', { edit: function( props ) { return el( 'div', { className: 'nyforms-block-placeholder' }, el( components.TextControl, { label: i18n.__( 'Form ID', 'nyforms' ), type: 'number', value: props.attributes.formId, onChange: function( value ) { props.setAttributes( { formId: parseInt( value, 10 ) || 0 } ); } } ), el( 'p', {}, i18n.__( 'Choose the ID of an NYforms form.', 'nyforms' ) ) ); }, save: function() { return null; } } );
}( window.wp.blocks, window.wp.element, window.wp.components, window.wp.blockEditor, window.wp.i18n ) );
