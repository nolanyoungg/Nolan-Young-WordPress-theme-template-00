( function( blocks, element ) {
	blocks.registerBlockType( 'nyforms/privacy-request', { edit: function() { return element.createElement( 'p', {}, 'NYforms privacy request form' ); }, save: function() { return null; } } );
}( window.wp.blocks, window.wp.element ) );
