// Retrieve the link and target attributes from the Button block.
export const getAttributesFromButton = (block) => ({
	linkRel: block?.rel || '',
	linkTarget: block?.linkTarget || '_self',
	linkText: block?.text || '',
	linkUrl: block?.url
		? block.url.replace(
				`${window.location.origin}/`,
				mecumBlocks.headlessFrontendUrl // eslint-disable-line
		  )
		: '',
});
