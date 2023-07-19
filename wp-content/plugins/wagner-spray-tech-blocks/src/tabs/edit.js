import {
	BlockControls,
	InnerBlocks,
	useBlockProps,
} from '@wordpress/block-editor';
import { getBlockContent } from '@wordpress/blocks';
import { ToolbarGroup, ToolbarButton } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import { edit } from '@wordpress/icons';
import parse from 'html-react-parser';
import React from 'react';
import Inspector from './inspector';
import { getEmbedMarkup } from '../utils/embed';

/**
 * This block is used as the tabs wrapper so the only child block needed is the tab item.
 */
const ALLOWED_BLOCKS = [ 'wst-blocks/tab-item' ];

/**
 * Automatically add one item when you create a new block.
 */
const TEMPLATE = [ [ 'wst-blocks/tab-item' ] ];

export default function ( props ) {
	const { attributes, clientId, isSelected } = props;
	const { className } = attributes;

	const [ initialCreation, setInitialCreation ] = useState( true );
	const [ isEditing, toggleEditing ] = useState( false );
	const [ activeTabIndex, setActiveTabIndex ] = useState( 0 );

	const classNames = [ className || '', isEditing ? 'is-editing' : null ];

	const blockProps = useBlockProps( {
		className: classNames.filter( Boolean ).join( ' ' ),
	} );

	const tabItems = useSelect(
		( select ) => select( 'core/block-editor' ).getBlocks( clientId ),
		[ clientId ]
	);

	const embedHTML = {
		markup: '',
		hasEmbed: false,
	};

	// Retrieve the embed HTML markup recursively.
	const parseEmbedBlock = ( block ) => {
		block.innerBlocks?.forEach( ( innerBlock ) => {
			if ( innerBlock.name === 'core/embed' ) {
				embedHTML.hasEmbed = true;
				embedHTML.markup = getEmbedMarkup(
					innerBlock.attributes.url,
					600,
					450
				);
			} else {
				return parseEmbedBlock( innerBlock );
			}
		} );

		return embedHTML;
	};

	// Retrieve the HTML markup from the active tab.
	const activeTabMarkup = tabItems?.[ activeTabIndex ]?.innerBlocks.reduce(
		( prev, curr ) => {
			switch ( curr.name ) {
				default:
					const embed = parseEmbedBlock( curr );

					return [
						...prev,
						parse(
							embed.hasEmbed
								? embed.markup
								: getBlockContent( curr )
						),
					];
			}
		},
		[]
	);

	// Enable the edit mode on block creation.
	useEffect( () => {
		if ( initialCreation && isSelected ) {
			toggleEditing( true );
			setInitialCreation( false );
		}
	}, [ initialCreation, isSelected, toggleEditing, setInitialCreation ] );

	return (
		<>
			<Inspector { ...props } />
			<div { ...blockProps }>
				<BlockControls>
					<ToolbarGroup label="Options">
						<ToolbarButton
							icon={ edit }
							label={ isEditing ? 'Preview' : 'Edit' }
							className={ isEditing ? 'is-pressed' : '' }
							onClick={ () => toggleEditing( ! isEditing ) }
						/>
					</ToolbarGroup>
				</BlockControls>
				{ isEditing ? (
					<InnerBlocks
						allowedBlocks={ ALLOWED_BLOCKS }
						template={ TEMPLATE }
					/>
				) : (
					<>
						<div className="tabs">
							{ tabItems.map( ( item, index ) => (
								<button
									className={ `tab ${
										activeTabIndex === index ? 'active' : ''
									}` }
									key={ item.clientId }
									onClick={ () => setActiveTabIndex( index ) }
									dangerouslySetInnerHTML={ {
										__html: item.attributes.title,
									} }
								/>
							) ) }
						</div>
						<div className="tabs-content">
							{ React.Children.map(
								activeTabMarkup,
								( child ) => child
							) }
						</div>
					</>
				) }
			</div>
		</>
	);
}
