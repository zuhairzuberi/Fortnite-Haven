<?php
	// Get our API Key
	require_once( 'config.php');

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

	
?>
