<?php
	// Get our API Key
	require_once( 'API_Key.php');

	// Create a variable for date that will be used as the parameter for most of our store functions
	$date = date( 'Y-m-d' );

	// Set it to EST (Specifically Toronto cause im from there lol)
	date_default_timezone_set( 'America/Toronto' );

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

		// Create a file titled 'YYYY-MM-DD' and save the JSON response to the file before closing
		$storeFile = fopen( 'json_files/' . $date . '.json', 'w' );
		fwrite( $storeFile, $response );
		fclose( $storeFile );
	}

	/**
	 * Get data from either the json file or hit the api for data.
	 *
	 * @param void
	 *
	 * @return void
	 */
	function getStoreDataFromJSON( $date ) {
		// Check if we have Store Data saved in a JSON File
		if ( !file_exists( 'json_files/' . $date . '.json' ) ) { // if no json file found for the current date hit the api
			getStoreDataFromAPI( $date );
		}

		// Return the Store Data in the files Folder
		return json_decode( file_get_contents( 'json_files/' . $date . '.json' ), true );
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
		$items = getStoreDataFromJSON($date);

		// Create an array with 3 sections: Weekly, Daily, and Special
		$sortedItems = array(
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
		);

		foreach ( $items as $item ) { // Place the Items in their correct section (Weekly, Daily, or Special)
			// Create links to the fortnitetracker website with the necessary details
			$itemUrlName = strtolower( $item['name'] );
			$itemUrlName = str_replace( ' ', '-', $itemUrlName );
			$item['link_to_fn_item'] = 'https://fortnitetracker.com/locker/' . $item['manifestId'] . '/' . $itemUrlName;

			// Add item to sorted items
			$sortedItems[$item['storeCategory']]['items'][] = $item;
		}

		// Return our sorted items array
		return $sortedItems;
	}

	/**
	 * Get files in the json_files folder
	 *
	 * @param void
	 *
	 * @return Array $storeJsonFiles
	 */
	function getStoreJsonFiles() {
		// Get all the files from our JSON directory
		$allFiles = scandir( 'json_files' );

		// Sort by Date in Descending Order
		rsort( $allFiles );

		// Create our array of the dates
		$validFiles = array();

		foreach ( $allFiles as $file ) { // Loop over the files in the directory
			$namePieces = explode( '.', $file );
		}

		// Return the Valid Files
		return $validFiles;
	}

	/**
	 * Get store date and validate GET var
	 *
	 * @param void
	 *
	 * @return String $date
	 */
	function getStoreDate() {
		// Get Today and Tomorrows Date incase the store has already refreshed
		$date = date( 'Y-m-d' );
		$tomorrowsDate = date( 'Y-m-d', strtotime(' +1 day') );

		if ( date( 'G' ) >= 20 ) { // If it is past 8 PM EST then a new shop is ready and we need to create a new file
			$date = $tomorrowsDate;
		}

		// Return a valid date
		return $date;
	}	
?>
