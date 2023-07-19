import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, PanelRow, ToggleControl } from '@wordpress/components';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { addFilter } from '@wordpress/hooks';
import { assign } from 'lodash';

/**
 * Filter block registration to add autoplay attribute to the embed block.
 *
 * @param {Object} settings Block settings config.
 * @param {string} name     Block name.
 *
 * @return {Object} Block settings config.
 */
function addAutoplayAttr( settings, name ) {
	if ( name !== 'core/embed' ) {
		return settings;
	}

	return assign( {}, settings, {
		attributes: assign( {}, settings.attributes, {
			autoplay: {
				type: 'boolean',
				default: false,
			},
		} ),
	} );
}

addFilter(
	'blocks.registerBlockType',
	'ae/filterBlockEmbedAttrs',
	addAutoplayAttr
);

/**
 * Filter block edit function to add settings to the embed blocks.
 */
const extendCoreEmbedSettings = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if (
			props.name !== 'core/embed' ||
			( props.attributes.providerNameSlug !== 'youtube' &&
				props.attributes.providerNameSlug !== 'vimeo' )
		) {
			return <BlockEdit { ...props } />;
		}

		const { setAttributes } = props;
		const { autoplay } = props.attributes;

		return (
			<Fragment>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody title="Video Settings">
						<PanelRow>
							<ToggleControl
								label="Enable Autoplay"
								checked={ !! autoplay }
								onChange={ () =>
									setAttributes( {
										autoplay: ! autoplay,
									} )
								}
							/>
						</PanelRow>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'extendCoreEmbedSettings' );

addFilter(
	'editor.BlockEdit',
	'ae/filterBlockEmbedEditAttrs',
	extendCoreEmbedSettings
);
