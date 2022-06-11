<?php
	// get our functions so we can use them!
	require_once( 'functions.php' );

	// validate and get the current date of the store
	$date = getStoreDate();

	// get the items sorted
	$storeData = StoreSortedData( $date );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Item Shop || Fortnite Haven</title>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	</head>
	<body>
		<h1>Item Shop resets at 8 PM EST on </h1>
	</body>
</html>