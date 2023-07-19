import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { addFilter } from '@wordpress/hooks';
import { assign } from 'lodash';

/**
 * Filter block registration to add visibility attribute to the group block.
 *
 * @param {Object} settings Block settings config.
 * @param {string} name     Block name.
 *
 * @return {Object} Block settings config.
 */
function addVisibilityAttr( settings, name ) {
	if ( name !== 'core/group' ) {
		return settings;
	}

	return assign( {}, settings, {
		attributes: assign( {}, settings.attributes, {
			deviceType: {
				type: 'string',
				default: 'all',
			},
		} ),
	} );
}

addFilter(
	'blocks.registerBlockType',
	'ae/filterBlockGroupAttrs',
	addVisibilityAttr
);

/**
 * Filter block list block function to extend Group block class names.
 */
function saveGroupClassNames( extraProps, blockType, attributes ) {
	if ( 'core/group' !== blockType.name ) {
		return extraProps;
	}

	const { deviceType } = attributes;

	const deviceClassName =
		deviceType && deviceType !== 'all' ? `is-${ deviceType }-only` : '';

	extraProps.className = `${ extraProps.className } ${ deviceClassName }`;

	return extraProps;
}

addFilter(
	'blocks.getSaveContent.extraProps',
	'ae/filterBlockGroupClassNames',
	saveGroupClassNames
);

/**
 * Filter block edit function to add settings to the group blocks.
 */
const extendCoreGroupSettings = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( 'core/group' !== props.name ) {
			return <BlockEdit { ...props } />;
		}

		const { setAttributes } = props;
		const { deviceType } = props.attributes;

		return (
			<Fragment>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody title="Visibility Settings">
						<SelectControl
							value={ deviceType }
							options={ [
								{ label: 'All Devices', value: 'all' },
								{
									label: 'Mobile devices only',
									value: 'mobile',
								},
								{
									label: 'Desktop devices only',
									value: 'desktop',
								},
							] }
							onChange={ ( newDeviceType ) =>
								setAttributes( {
									deviceType: newDeviceType,
								} )
							}
							__nextHasNoMarginBottom
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'extendCoreGroupSettings' );

addFilter(
	'editor.BlockEdit',
	'ae/filterBlockGroupEditAttrs',
	extendCoreGroupSettings
);

/**
 * Filter block list block function to extend group block class names.
 */
const extendGroupClassNames = createHigherOrderComponent(
	( BlockListBlock ) => {
		return ( props ) => {
			if ( props.name !== 'core/group' ) {
				return <BlockListBlock { ...props } />;
			}

			const { attributes } = props;
			const { deviceType, visibility } = attributes;

			const classNames = [
				deviceType && deviceType !== 'all'
					? `is-${ deviceType }-only`
					: '',
				visibility && visibility !== 'all'
					? `has-visibility-${ visibility }`
					: '',
			];

			return (
				<BlockListBlock
					{ ...props }
					className={ classNames.filter( Boolean ).join( ' ' ) }
				/>
			);
		};
	},
	'extendGroupClassNames'
);

addFilter(
	'editor.BlockListBlock',
	'ae/filterBlockGroupClassNames',
	extendGroupClassNames
);
