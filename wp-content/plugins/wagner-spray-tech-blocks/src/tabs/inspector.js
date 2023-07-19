import { InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	PanelRow,
	// eslint-disable-next-line
	__experimentalNumberControl as NumberControl,
} from '@wordpress/components';

export default function ( { attributes, setAttributes } ) {
	const { tabsPerView } = attributes;

	return (
		<InspectorControls>
			<PanelBody title="Tabs Settings">
				<PanelRow>
					<NumberControl
						label="Tabs per view"
						onChange={ ( newTabsPerView ) =>
							setAttributes( {
								tabsPerView: Number( newTabsPerView ),
							} )
						}
						value={ tabsPerView }
					/>
				</PanelRow>
			</PanelBody>
		</InspectorControls>
	);
}
