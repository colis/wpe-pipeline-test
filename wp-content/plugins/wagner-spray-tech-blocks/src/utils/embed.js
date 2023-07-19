// Create URL embed for YouTube or Vimeo videos.
const getVideoUrl = ( url ) => {
	if ( ! url ) {
		return false;
	}

	let videoId;

	videoId = url.indexOf( 'v=' ) !== -1 ? url.split( 'v=' ) : url.split( '/' );
	videoId = videoId[ videoId.length - 1 ];

	return url.includes( 'vimeo' )
		? `//player.vimeo.com/video/${ videoId }`
		: `//youtube.com/embed/${ videoId }`;
};

export const getVideoEmbedMarkup = ( url, width, height ) =>
	`<iframe width="${ width }" height="${ height }" src=${ getVideoUrl(
		url
	) } frameBorder="0"></iframe>`;

export const getEmbedMarkup = ( url, width, height ) =>
	`<iframe frameBorder="no" height="${ height }" src="${ url }" title="Embedded map grom Google Maps" width="${ width }"></iframe>`;
