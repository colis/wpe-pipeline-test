import { useBlockProps } from '@wordpress/block-editor';

export default function ( { attributes } ) {
	const { className, anchorCollection } = attributes;
	const classNames = [ className || '' ];
	const blockProps = useBlockProps.save( {
		className: classNames,
	} );

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
