import {
	InnerBlocks,
	store as blockEditorStore,
	useBlockProps,
} from '@wordpress/block-editor';
import { createBlock } from '@wordpress/blocks';
import { Spinner } from '@wordpress/components';
import { store as coreDataStore } from '@wordpress/core-data';
import { useDispatch, useSelect } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import Inspector from './inspector';
import isEqual from 'lodash.isequal';

// Content Selector Block.
// N.B. Don't use post or updateInnerBlocks as dependancies for any useEffects.
export default function ( props ) {
	const { attributes, setAttributes, clientId } = props;
	const {
		author,
		contentTypes,
		isDynamic,
		layout,
		maxResults,
		taxonomyFilters,
		selectedPosts,
		selectedBlockType,
		gridColumns,
	} = attributes;

	const blockProps = useBlockProps();

	// Flag for filter changes.
	const [ hasFilterChanged, setHasFilterChanged ] = useState( false );
	// Flag for page load.
	const [ isPageLoad, setIsPageLoad ] = useState( true );
	// Posts are searched for once before we actually want to use them.
	const [ isInitialSearch, setIsInitialSearch ] = useState( true );
	// Determine state of template locking.
	// <false | 'all' | 'insert'>
	const [ templateLock, setTemplateLock ] = useState( false );
	// Used to store posts that come from filtered results.
	// Array<{id: number, name: string, type: string }>.
	const [ filteredPosts, setFilteredPosts ] = useState( [] );

	// Global state dispatchers.
	const { replaceInnerBlocks, selectBlock, updateBlockAttributes } =
		useDispatch( blockEditorStore );

	// Function for replacing the inner blocks with newly created blocks.
	// Array<{id: number, name: string, type: string }>.
	const updateInnerBlocks = ( p, replaceBlocks ) => {
		if ( ! replaceBlocks ) {
			// Update innerBlocks by replacing attributes only.
			// Maintains some gutenberg niceties like drag+drop animations.
			contentSelectorBlock.innerBlocks.forEach( ( block, index ) => {
				updateBlockAttributes( block.clientId, {
					post: p[ index ],
				} );
			} );

			return;
		}

		// If an innerBlock is selected, reselect the content selector block.
		// This stops selectedBlock data in core/block-editor from being null which causes errors.
		if ( hasSelectedInnerBlock ) {
			selectBlock( clientId );
		}

		// Otherwise, just replace the inner blocks.
		const innerBlocks = p
			?.filter( ( data ) => data )
			?.map( ( data ) => {
				return createBlock( selectedBlockType, {
					layout,
					post: data,
					contentSelectorId: clientId,
				} );
			} );

		replaceInnerBlocks( clientId, innerBlocks, false );
	};

	// Get the block on change and whether inner block is selected.
	const { hasSelectedInnerBlock, contentSelectorBlock } = useSelect(
		( select ) => {
			return {
				hasSelectedInnerBlock: select(
					blockEditorStore
				).hasSelectedInnerBlock( clientId, true ),
				contentSelectorBlock:
					select( blockEditorStore ).getBlock( clientId ),
			};
		},
		[ clientId ]
	);

	// Handle user change, addition, removal, reordering of posts.
	useEffect( () => {
		// Get the posts from the inner blocks.
		const innerBlockPosts = contentSelectorBlock.innerBlocks.map(
			( block ) => block.attributes.post
		);

		// If the posts are the same as the saved set, do nothing.
		if ( isEqual( innerBlockPosts, selectedPosts ) ) {
			return;
		}

		// Save the changed set.
		setFilteredPosts( innerBlockPosts, clientId );
	}, [ contentSelectorBlock ] );

	// Queries posts when filters etc change.
	// Also gets posts from the content-selector store.
	const { posts, hasResolved } = useSelect(
		( select ) => {
			const taxQueries = taxonomyFilters.map( ( filter ) => {
				// Handle WP categories and tags.
				if ( filter.termTaxonomy === 'category' ) {
					return { categories: filter.termId };
				}
				if ( filter.termTaxonomy === 'post_tag' ) {
					return { tags: filter.termId };
				}
				// Handle custom taxonomies.
				return { [ filter.termTaxonomy ]: filter.termId };
			} );

			const query = {
				per_page: maxResults,
				status: 'publish',
				context: 'view',
				_embed: true,
				...Object.assign( {}, ...taxQueries ),
			};

			if ( ! contentTypes[ 0 ] ) {
				return {
					posts: [],
					filteredPosts: [],
					hasResolved: true,
				};
			}

			const selectorArgs = [ 'postType', contentTypes[ 0 ], query ];

			const results = select( coreDataStore )
				.getEntityRecords( ...selectorArgs )
				?.sort( ( a, b ) => new Date( b.date ) - new Date( a.date ) )
				?.slice( 0, maxResults );

			return {
				posts: results
					? results.map( ( post ) => ( {
							id: post.id,
							name: post.title.rendered,
							type: post.type,
					  } ) )
					: [],
				hasResolved: select( coreDataStore ).hasFinishedResolution(
					'getEntityRecords',
					selectorArgs
				),
			};
		},
		[ author, contentTypes, maxResults, taxonomyFilters, clientId ]
	);

	// Initialise the content on page load.
	useEffect( () => {
		if ( ! isPageLoad ) {
			return;
		}

		if ( ! hasResolved ) {
			return;
		}

		setIsPageLoad( false );

		// Set the initial filtered posts to the saved set.
		setFilteredPosts( selectedPosts, clientId );

		// Render the saved posts.
		updateInnerBlocks( selectedPosts, true );
	}, [
		isPageLoad,
		isDynamic,
		hasResolved,
		selectedBlockType,
		clientId,
		selectedPosts,
		setFilteredPosts,
	] );

	// New posts have been queried from useSelect.
	useEffect( () => {
		if ( ! hasFilterChanged || ! hasResolved ) {
			return;
		}

		setHasFilterChanged( false );

		// Ignore the first set of posts, returned during initial render.
		if ( isInitialSearch ) {
			setIsInitialSearch( false );
			return;
		}

		setFilteredPosts( posts, clientId );
	}, [ hasFilterChanged, hasResolved, clientId, setFilteredPosts ] );

	// filteredPosts or selectedPosts have changed. Render the new posts.
	useEffect( () => {
		if ( isPageLoad ) {
			return;
		}

		const renderPosts = isDynamic ? posts : filteredPosts;

		// If the posts are the same as the saved set, do nothing.
		if ( isEqual( renderPosts, selectedPosts ) ) {
			return;
		}

		// If num of posts is different or dynamic mode active,
		// replace the inner blocks completely.
		const replaceBlocks =
			contentSelectorBlock.innerBlocks.length !== renderPosts.length ||
			isDynamic;

		// Render the posts.
		updateInnerBlocks( renderPosts, replaceBlocks );

		// Save the posts.
		setAttributes( { selectedPosts: renderPosts } );
	}, [ filteredPosts, isPageLoad, selectedPosts, setAttributes ] );

	// selectedBlockType has changed. Render the new card.
	useEffect( () => {
		if ( isPageLoad ) {
			return;
		}

		const renderPosts = isDynamic ? posts : filteredPosts;

		// Render the posts.
		updateInnerBlocks( renderPosts, true );
	}, [ selectedBlockType ] );

	// Filter changed
	useEffect( () => {
		if ( isPageLoad ) {
			return;
		}

		setHasFilterChanged( true );
	}, [
		selectedBlockType,
		author,
		contentTypes,
		isDynamic,
		maxResults,
		taxonomyFilters,
		isPageLoad,
	] );

	useEffect( () => {
		if ( isDynamic ) {
			setTemplateLock( 'all' );
			return;
		}

		if ( selectedPosts.length >= maxResults ) {
			setTemplateLock( 'insert' );
			return;
		}

		setTemplateLock( false );
	}, [ selectedPosts, maxResults, isDynamic, setTemplateLock ] );

	return (
		<>
			<Inspector { ...props } />
			<div { ...blockProps } key={ props.name }>
				{ ! hasResolved && <Spinner /> }
				<>
					<div
						className={ `wp-block-wst-content-selector ${
							isDynamic &&
							'wp-block-wst-content-selector--dynamic'
						}` }
					>
						<div
							className={ `wp-block-wst-content-selector__${ layout }` }
							data-layout={ layout }
							data-grid-columns={ gridColumns ? gridColumns : 4 }
						>
							{ hasResolved && (
								/* Render the innerBlocks */
								<InnerBlocks
									allowedBlocks={ [ selectedBlockType ] }
									orientation={
										layout === 'list'
											? 'vertical'
											: 'horizontal'
									}
									templateLock={ templateLock }
									renderAppender={
										! isDynamic &&
										!! selectedBlockType &&
										selectedPosts.length < maxResults &&
										InnerBlocks.ButtonBlockAppender
									}
								/>
							) }
						</div>
					</div>
				</>
				{ hasResolved && ! selectedPosts?.length && (
					<p className="no-selection">No posts found/selected.</p>
				) }
			</div>
		</>
	);
}
