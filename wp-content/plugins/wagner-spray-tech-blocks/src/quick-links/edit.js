import { useBlockProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';

/**
 * Quick Links Block Edit
 *
 * @param {Object} props - Block properties.
 */
export default function ( props ) {
	const { attributes, clientId, setAttributes } = props;
	const { className, anchorCollection } = attributes;
	const classNames = [ className || '' ];
	const blockProps = useBlockProps( {
		className: classNames.join( ' ' ),
	} );

	const [ postBlocks, setPostBlocks ] = useState( '' );
	const [ anchors, setAnchors ] = useState( new Set() );
	const blocks = useSelect( ( select ) =>
		select( 'core/block-editor' ).getBlocks()
	);

	useEffect( () => {
		if ( blocks === postBlocks ) {
			return;
		}

		const newAnchors = new Set();

		blocks.forEach( ( block ) => {
			if ( block.clientId === clientId ) {
				return;
			}

			if ( ! block.attributes.anchor ) {
				return;
			}

			newAnchors.add( block.attributes.anchor );
		} );
		setPostBlocks( blocks );
		setAnchors( newAnchors );
	}, [ blocks, clientId, postBlocks ] );

	useEffect( () => {
		setAttributes( {
			anchorCollection: [ ...anchors ],
		} );
	}, [ anchors, setAttributes ] );

	return (
		<>
			<nav { ...blockProps } key={ 'block' }>
				<ul>
					{ Array.from( anchorCollection ).map( ( anchor, key ) => {
						return (
							<li key={ key }>
								<a href={ '#' + anchor }>
									{ anchor
										.replaceAll( '-', ' ' )
										.replaceAll( '_', ' ' ) }
								</a>
							</li>
						);
					} ) }
				</ul>
			</nav>
		</>
	);
}
