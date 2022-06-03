<?php
	// Get our API Key
	require_once( 'API_Key.php');

	// Set it to EST (Specifically Toronto cause im from there lol)
	date_default_timezone_set( 'America/Toronto' );

	// Create a variable for date that will be used as the parameter for most of our store functions
	$date = date( 'Y-m-d' );

	/**
	 * Get Store Data from Fortnite Tracker API
	 *
	 * @param String $date
	 *
	 * @return void
	 */
	function getStoreDataFromAPI( $date ) {
		// Store the API Endpoint, this is the Endpoint provided by fortnite tracker and it is self documenting (making our life easier)
		$apiUrlEndpointStore = 'https://api.fortnitetracker.com/v1/store';

		// Set up curl
		$ch = curl_init();

		// Specify the store endpoint
		curl_setopt( $ch, CURLOPT_URL, $apiUrlEndpointStore );

		// Pass our API Key as a header
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
		    'TRN-Api-Key:' . FN_API_KEY
		) );

		// Few other curl settings necessary for making process easier
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE ); 	// This sets the transfer as a string of the return value when curl_exec() is done
		curl_setopt( $ch, CURLOPT_HEADER, FALSE );			// Header will not be included in the output
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );	// No need to verify the certificate's status for the user so it is set to false

		// Response from the Endpoint
		$response = curl_exec( $ch );
	}

	/**
	 * Get data from either the json file or hit the api for data.
	 *
	 * @param void
	 *
	 * @return void
	 */
	function getStoreDataFromJSON( $date ) {
		// make sure we have a json file with store data
		if ( !file_exists( 'store_json_files/' . $date . '.json' ) ) { // if no json file found for the current date hit the api
			getStoreDataFromAPI( $date );
		}

		// return store data as a php array
		return json_decode( file_get_contents( 'store_json_files/' . $date . '.json' ), true );
	}

	/**
	 * Format The Store Data
	 *
	 * @param void
	 *
	 * @return Array $sortedItems
	 */
	function StoreSortedData( $date ) {
		// Get the items
		$items = getStoreDataFromAPI($date);

		// Create an array with 3 sections: Weekly, Daily, and Special
		$sortedArray = array{
			'BRWeeklyStorefront' => array(
				'info' => array(
					'title' => 'FEATURED ITEMS'
				),
				'items' => array()
			),
			'BRDailyStorefront' => array(
				'info' => array(
					'title' => 'DAILY ITEMS'
				),
				'items' => array()
			),
			'BRSpecialFeatured' => array(
				'info' => array(
					'title' => 'SPECIAL ITEMS'
				),
				'items' => array()
			)
		};

		foreach ( $items as $item ) { // Place the Items in their correct section (Weekly, Daily, or Special)
			// Create links to the fortnitetracker website with the necessary details
			$itemUrlName = strtolower( $item['name'] );
			$itemUrlName = str_replace( ' ', '-', $itemUrlName );
			$item['link_to_fn_item'] = 'https://fortnitetracker.com/locker/' . $item['manifestId'] . '/' . $itemUrlName;

			// add item to sorted items
			$sortedItems[$item['storeCategory']]['items'][] = $item;
		}

		// return our sorted items array
		return $sortedItems;
	}

		
?>
