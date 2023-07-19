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
 * This block is used as the accordion wrapper so the only child block needed is the accordion item.
 */
const ALLOWED_BLOCKS = [ 'wst-blocks/accordion-item' ];

/**
 * Automatically add one item when you create a new block.
 */
const TEMPLATE = [ [ 'wst-blocks/accordion-item' ] ];

export default function ( { attributes, clientId, isSelected } ) {
	const { className } = attributes;

	const [ initialCreation, setInitialCreation ] = useState( true );
	const [ isEditing, toggleEditing ] = useState( false );

	const classNames = [ className || '', isEditing ? 'is-editing' : null ];

	const blockProps = useBlockProps( {
		className: classNames.filter( Boolean ).join( ' ' ),
	} );

	const accordionItems = useSelect(
		( select ) => select( 'core/block-editor' ).getBlocks( clientId ),
		[ clientId ]
	);

	// Retrieve the HTML markup from an accordion item.
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
	}, [ initialCreation, toggleEditing, setInitialCreation, isSelected ] );

	return (
		<>
			<div { ...blockProps }>
				<BlockControls>
					<ToolbarGroup label="Options">
						<ToolbarButton
							icon={ edit }
							label={
								isEditing
									? 'Preview Accordion'
									: 'Edit Accordion'
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
							label={ 'Preview Accordion' }
							className={ 'preview-mode' }
							onClick={ () => toggleEditing( ! isEditing ) }
						/>
					</>
				) : (
					accordionItems.map( ( item ) => (
						<div
							className="wp-block-wst-blocks-accordion-item"
							key={ item.clientId }
						>
							<h4 className="wp-block-wst-blocks-accordion-item__title js-wp-block-wst-blocks-accordion">
								<button
									type="button"
									aria-expanded={
										item.attributes.open ? 'true' : 'false'
									}
									className="wp-block-wst-blocks-accordion-item__trigger"
									aria-controls={ `${ item.attributes.key }-accordion` }
									id={ `${ item.attributes.key }-accordion-button` }
								>
									{ item.attributes.title }
									<span className="accordion-marker">
										<span className="svg-icon icon-plus-minus"></span>
									</span>
								</button>
							</h4>
							<div
								id={ `${ item.attributes.key }-accordion` }
								role="region"
								aria-labelledby={ `${ item.attributes.key }-accordion-button` }
								className="wp-block-wst-blocks-accordion-item__content"
								hidden={
									item.attributes.open ? 'false' : 'true'
								}
								dangerouslySetInnerHTML={ {
									__html: getItemMarkup( item.innerBlocks ),
								} }
							></div>
						</div>
					) )
				) }
			</div>
		</>
	);
}
