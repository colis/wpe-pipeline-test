import { InspectorControls } from '@wordpress/block-editor';
import {
	Panel,
	PanelBody,
	PanelRow,
	SelectControl,
	ToggleControl,
	// eslint-disable-next-line
	__experimentalNumberControl as NumberControl,
} from '@wordpress/components';
import TermFilter from './filters/term';
import { useSelect } from '@wordpress/data';
import { useState, useEffect } from 'react';
import { store as coreDataStore } from '@wordpress/core-data';
import allowedBlocks from './allowedBlocks';
import excludedPostTypes from './excludedPostTypes';

export default function ( props ) {
	const { attributes, setAttributes } = props;
	const {
		contentTypes,
		taxonomyFilters,
		isDynamic,
		layout,
		gridColumns,
		sliderColumns,
		maxResults,
		selectedBlockType,
	} = attributes;

	const parsedContentType = contentTypes.join( ',' );

	// Retrieve postTypes from the DB.
	const { postTypes } = useSelect( ( select ) => {
		return {
			postTypes: select( coreDataStore ).getPostTypes( {
				per_page: 100,
			} ),
			hasResolved:
				select( coreDataStore ).hasFinishedResolution( 'getPostTypes' ),
		};
	}, [] );

	const [ taxonomies, setTaxonomies ] = useState( [] );

	// Set the taxonomies when the user selects a content type.
	useEffect( () => {
		if ( ! postTypes ) {
			return;
		}

		setTaxonomies(
			postTypes.find(
				( postType ) => postType?.slug === contentTypes[ 0 ]
			)?.taxonomies
		);
	}, [ postTypes, contentTypes ] );

	// When the selectedBlockType changes,
	// update the selectedBlockType path (used for rendering the correct child block template).
	useEffect( () => {
		const renderPath = allowedBlocks.find(
			( block ) => block.name === selectedBlockType
		)?.render;

		setAttributes( {
			selectedBlockTypeRenderPath: renderPath,
		} );
	}, [ selectedBlockType ] );

	return (
		<InspectorControls>
			<Panel>
				<PanelBody title="Content Selector Settings">
					{ !! allowedBlocks.length && (
						<SelectControl
							label="Select a block type"
							value={ selectedBlockType }
							options={ [
								...[
									{
										label: 'Select a block type',
										value: '',
										disabled: true,
									},
								],
								...allowedBlocks.map( ( block ) => ( {
									label: block.label,
									value: block.name,
								} ) ),
							] }
							onChange={ ( newBlockType ) => {
								setAttributes( {
									selectedBlockType: newBlockType,
								} );
							} }
							__nextHasNoMarginBottom
						/>
					) }
					{ selectedBlockType && postTypes && (
						<SelectControl
							label="Filter by content type"
							value={ parsedContentType }
							options={ [
								...[
									{
										label: 'Select a content type',
										value: '',
										disabled: true,
									},
								],
								...postTypes
									.filter(
										( postType ) =>
											! excludedPostTypes.includes(
												postType.slug
											)
									)
									.map( ( postType ) => ( {
										label: postType.labels.name,
										value: postType.slug,
									} ) ),
							] }
							onChange={ ( newContentType ) =>
								setAttributes( {
									contentTypes: newContentType.split( ',' ),
								} )
							}
							__nextHasNoMarginBottom
						/>
					) }
					{ taxonomies && (
						<>
							{ taxonomies.map( ( taxonomy ) => {
								return (
									<PanelRow key={ taxonomy }>
										<TermFilter
											{ ...props }
											taxonomyFilters={ taxonomyFilters }
											taxonomyName={ taxonomy }
											taxonomyLabel={ taxonomy
												.replace( '_tax', '' )
												.replace( '_', ' ' ) }
										/>
									</PanelRow>
								);
							} ) }
						</>
					) }
					<PanelRow>
						<NumberControl
							label="Max results"
							value={ maxResults }
							min="1"
							max="50"
							onChange={ ( newMaxResults ) =>
								setAttributes( {
									maxResults: Number( newMaxResults ),
								} )
							}
						/>
					</PanelRow>
					{ selectedBlockType && (
						<PanelRow>
							<SelectControl
								label="Layout"
								value={ layout }
								options={
									allowedBlocks.find(
										( block ) =>
											block.name === selectedBlockType
									)?.layout
								}
								onChange={ ( newLayout ) =>
									setAttributes( { layout: newLayout } )
								}
								__nextHasNoMarginBottom
							/>
						</PanelRow>
					) }
					{ layout === 'grid' && (
						<PanelRow>
							<NumberControl
								label="Results per column"
								value={ gridColumns }
								min="1"
								max="10"
								onChange={ ( newGridColumns ) =>
									setAttributes( {
										gridColumns: Number( newGridColumns ),
									} )
								}
							/>
						</PanelRow>
					) }
					{ layout === 'carousel' && (
						<PanelRow>
							<NumberControl
								label="visible slides on desktop"
								value={ sliderColumns }
								min="1"
								max="10"
								onChange={ ( newSliderColumns ) =>
									setAttributes( {
										sliderColumns:
											Number( newSliderColumns ),
									} )
								}
							/>
						</PanelRow>
					) }
					<PanelRow>
						<ToggleControl
							label="Dynamic content"
							help="When enabled, the block will always use the latest available content. NB: all hand-picked content and custom ordering will be lost!"
							checked={ !! isDynamic }
							onChange={ () =>
								setAttributes( {
									isDynamic: ! isDynamic,
								} )
							}
						/>
					</PanelRow>
				</PanelBody>
			</Panel>
		</InspectorControls>
	);
}
