import { Spinner } from '@wordpress/components';
import Inspector from './inspector';
import ServerSideRender from '@wordpress/server-side-render';
import block from './block.json';
import { useBlockProps } from '@wordpress/block-editor';

export default function ( props ) {
	const { attributes } = props;
	const { post } = attributes;
	const blockProps = useBlockProps();

	return (
		<div { ...blockProps }>
			<Inspector { ...props } />
			{ ! post && <Spinner /> }

			<ServerSideRender
				block={ block.name }
				attributes={ {
					layout: attributes.layout,
					post: { id: post?.id },
				} }
			/>
		</div>
	);
}
