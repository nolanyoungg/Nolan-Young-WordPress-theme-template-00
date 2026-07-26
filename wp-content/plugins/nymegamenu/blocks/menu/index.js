( function( blocks, blockEditor, components, element, apiFetch, serverSideRender, i18n ) {
	'use strict';

	const el = element.createElement;
	const InspectorControls = blockEditor.InspectorControls;
	const PanelBody = components.PanelBody;
	const SelectControl = components.SelectControl;
	const Placeholder = components.Placeholder;
	const ServerSideRender = serverSideRender;
	const __ = i18n.__;

	blocks.registerBlockType( 'nymegamenu/menu', {
		edit: function( props ) {
			const state = element.useState( [] );
			const locations = state[ 0 ];
			const setLocations = state[ 1 ];

			element.useEffect( function() {
				apiFetch( { path: '/wp/v2/menu-locations' } )
					.then( function( response ) {
						const options = Object.keys( response || {} ).map( function( key ) {
							return { label: response[ key ].description || response[ key ].name || key, value: key };
						} );
						setLocations( options );
					} )
					.catch( function() {
						setLocations( [] );
					} );
			}, [] );

			const options = [ { label: __( 'Select a menu location', 'nymegamenu' ), value: '' } ].concat( locations );
			return el(
				element.Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Menu settings', 'nymegamenu' ) },
						el( SelectControl, {
							label: __( 'Menu location', 'nymegamenu' ),
							value: props.attributes.location || '',
							options: options,
							onChange: function( location ) {
								props.setAttributes( { location: location } );
							},
						} )
					)
				),
				props.attributes.location
					? el( ServerSideRender, { block: 'nymegamenu/menu', attributes: props.attributes } )
					: el( Placeholder, { icon: 'menu', label: 'NY Mega Menu' }, __( 'Choose an enabled menu location in the block settings.', 'nymegamenu' ) )
			);
		},
		save: function() {
			return null;
		},
	} );
} )(
	window.wp.blocks,
	window.wp.blockEditor,
	window.wp.components,
	window.wp.element,
	window.wp.apiFetch,
	window.wp.serverSideRender,
	window.wp.i18n
);
