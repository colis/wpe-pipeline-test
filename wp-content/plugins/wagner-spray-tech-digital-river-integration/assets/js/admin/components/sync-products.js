document.addEventListener( 'DOMContentLoaded', () => {
	'use strict';

	const formElement = document.querySelector(
		'.digital_river_sync_manual_sync'
	);

	if ( ! formElement ) {
		return;
	}

	/**
	 * Abstract post data via fetch function.
	 *
	 * @param {FormData} data
	 */
	const postData = ( data ) => {
		return fetch( ajaxurl, {
			method: 'POST',
			credentials: 'same-origin',
			body: data,
		} );
	};

	/**
	 * Update Digital River data and report sync progress.
	 *
	 * @param {object} data
	 */
	const updateProgress = ( data = {} ) => {
		if ( ! data ) {
			return;
		}

		const { total_pages = '', task = '', page = '' } = data;
		const textLabel =
			formElement.querySelector( `p` ) || document.createElement( 'p' );
		const progressElement =
			formElement.querySelector( `progress` ) ||
			document.createElement( 'progress' );

		if ( ! formElement.querySelector( `progress` ) ) {
			formElement.innerHTML = '';
			formElement.appendChild( textLabel );
			formElement.appendChild( progressElement );

			progressElement.setAttribute(
				'max',
				total_pages || progressElement.getAttribute( 'max' )
			);
		}

		textLabel.innerText = task ?? textLabel.innerText;
		progressElement.setAttribute( 'value', page ?? progressElement.value );

		if ( page === 'complete' ) {
			setTimeout( () => {
				location.reload();
			}, 100 );
		}
	};

	/**
	 * Create an array of promises based on the amount of pages reported available from digital river.
	 * This will allow us to download and update products in batches.
	 *
	 * @param {FormData} data
	 * @param {*} totalPages
	 * @param {*} task
	 */
	const getPromises = ( data, totalPages, task ) => {
		let rtn = [];
		let page = data.page || 1;

		data.set( 'task', task );

		do {
			data.append( 'page', page.toString() );
			rtn.push(
				postData( data )
					.then( ( response ) => response.json() )
					.then( ( responseJson ) => {
						updateProgress( responseJson );
						return responseJson;
					} )
			);
			page++;
		} while ( page <= totalPages );

		return rtn;
	};

	formElement.addEventListener( 'submit', function ( event ) {
		event.preventDefault();

		const data = new FormData( formElement );
		let totalPages = 0;
		data.append( 'ajaxrequest', true );

		formElement.innerHTML = '<p>Starting sync...</p>';

		postData( data )
			.then( ( response ) => response.json() )
			.then( ( responseJson ) => {
				updateProgress( responseJson );
				totalPages = responseJson?.total_pages;

				Promise.all( [
					...getPromises( data, totalPages, 'download' ),
					...getPromises( data, totalPages, 'update' ),
				] ).then( ( response ) => {
					data.set( 'task', 'complete' );
					postData( data )
						.then( ( response ) => response.json() )
						.then( ( responseJson ) => {
							updateProgress( responseJson );
						} );
				} );
			} );
	} );
} );
