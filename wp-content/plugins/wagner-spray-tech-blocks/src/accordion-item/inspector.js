import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';

export default function ( { attributes, setAttributes } ) {
	const { open } = attributes;

	const getDisplayOpenHelp = ( checked ) =>
		checked
			? 'Accordion item is open by default.'
			: 'Toggle to set this accordion item to be open by default.';

	return (
		<InspectorControls>
			<PanelBody title="Accordion Item Settings">
				<ToggleControl
					label="Display Open"
					checked={ !! open }
					help={ getDisplayOpenHelp }
					onChange={ () => setAttributes( { open: ! open } ) }
				/>
			</PanelBody>
		</InspectorControls>
	);
}
