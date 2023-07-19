import {
	InspectorControls,
	// eslint-disable-next-line
	__experimentalLinkControl as LinkControl,
} from '@wordpress/block-editor';
import { SelectControl, Panel, PanelBody } from '@wordpress/components';
import { store as coreDataStore } from '@wordpress/core-data';
import { useEffect } from 'react';
import PostSearch from '../utils/Components/PostSearch';
import { useSelect } from '@wordpress/data';

export default function ( { setAttributes, attributes } ) {
	const { post, selectedPostType } = attributes;

	// Get all post types.
	const { postTypes } = useSelect( ( select ) => {
		return {
			postTypes: select( coreDataStore ).getPostTypes( {
				per_page: 100,
			} ),
			hasResolved:
				select( coreDataStore ).hasFinishedResolution( 'getPostTypes' ),
		};
	}, [] );

	// Set the post type so the dropdown is pre-selected.
	useEffect( () => {
		if ( ! post?.type ) {
			return;
		}

		setAttributes( {
			selectedPostType: post?.type,
		} );
	}, [ post, setAttributes ] );

	// Set result as post attribute
	const handleResultSelect = ( result ) => {
		// No post selected
		if ( typeof result?.id === 'undefined' ) {
			return;
		}

		// Post didn't change.
		if ( result?.id === post?.id ) {
			return;
		}

		// Post was removed
		if ( result?.id === 0 ) {
			return;
		}

		setAttributes( { post: result } );
	};

	return (
		<InspectorControls>
			<Panel>
				<PanelBody title="Content Card Settings">
					{ postTypes && (
						<SelectControl
							label="Filter by content type"
							value={ attributes?.selectedPostType }
							options={ [
								...[
									{
										label: 'Select a content type',
										value: '',
										disabled: true,
									},
								],
								...postTypes.map( ( postType ) => ( {
									label: postType.labels.name,
									value: postType.slug,
								} ) ),
							] }
							onChange={ ( newContentType ) =>
								setAttributes( {
									selectedPostType: newContentType,
								} )
							}
							__nextHasNoMarginBottom
						/>
					) }

					<PostSearch
						postType={ selectedPostType }
						handleResultSelect={ handleResultSelect }
						initialResult={ post }
					/>
				</PanelBody>
			</Panel>
		</InspectorControls>
	);
}
