import {
	BlockControls,
	InnerBlocks,
	useBlockProps,
} from '@wordpress/block-editor';
import { getBlockContent } from '@wordpress/blocks';
import { Button, ToolbarGroup, ToolbarButton } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import { edit } from '@wordpress/icons';

/**
 * This block is used as the hero carousel wrapper so the only child block needed is the hero carousel item.
 */
const ALLOWED_BLOCKS = [ 'wst-blocks/hero-carousel-item' ];

/**
 * Automatically add one item when you create a new block.
 */
const TEMPLATE = [ [ 'wst-blocks/hero-carousel-item' ] ];

export default function ( {
	attributes,
	clientId,
	isSelected,
	setAttributes,
} ) {
	const { className } = attributes;

	const [ initialCreation, setInitialCreation ] = useState( true );
	const [ isEditing, toggleEditing ] = useState( false );

	const classNames = [
		className || 'js-hero-carousel',
		'alignfull',
		isEditing ? 'is-editing' : null,
	];

	const blockProps = useBlockProps( {
		className: classNames.filter( Boolean ).join( ' ' ),
	} );

	const heroCarouselItems = useSelect(
		( select ) => select( 'core/block-editor' ).getBlocks( clientId ),
		[ clientId ]
	);

	// Store the number of slides.
	useEffect( () => {
		setAttributes( {
			slideCount: heroCarouselItems.length,
		} );
	}, [ heroCarouselItems, setAttributes ] );

	// Retrieve the HTML markup from an hero carousel item.
	const getItemMarkup = ( blocks ) =>
		blocks.reduce( ( prev, curr ) => {
			return prev + getBlockContent( curr );
		}, '' );

	// Enable the edit mode on block creation.
	useEffect( () => {
		if ( initialCreation && isSelected ) {
			toggleEditing( true );
			setInitialCreation( false );
		}
	}, [ initialCreation, isSelected, toggleEditing, setInitialCreation ] );

	return (
		<>
			<div { ...blockProps }>
				<BlockControls>
					<ToolbarGroup label="Options">
						<ToolbarButton
							icon={ edit }
							label={
								isEditing
									? 'Preview Hero Carousel'
									: 'Edit Hero Carousel'
							}
							className={ isEditing ? 'is-pressed' : '' }
							onClick={ () => toggleEditing( ! isEditing ) }
						/>
					</ToolbarGroup>
				</BlockControls>
				{ isEditing ? (
					<>
						<InnerBlocks
							allowedBlocks={ ALLOWED_BLOCKS }
							template={ TEMPLATE }
							renderAppender={ InnerBlocks.ButtonBlockAppender }
						/>
						<Button
							icon={ edit }
							label={ 'Preview Hero Carousel' }
							className={ 'preview-mode' }
							onClick={ () => toggleEditing( ! isEditing ) }
						/>
					</>
				) : (
					heroCarouselItems.map( ( item ) => (
						<div
							className="wp-block-wst-hero-carousel-item glide-slide"
							key={ item.clientId }
							dangerouslySetInnerHTML={ {
								__html: getItemMarkup( item.innerBlocks ),
							} }
						></div>
					) )
				) }
			</div>
		</>
	);
}
