<?php
	// get our functions so we can use them!
	require_once( 'functions.php' );

	// validate and get date
	$date = getStoreDate();

	// get the items sorted
	$storeData = getStoreSortedData( $date );
?>
<!DOCTYPE html>
<html>
<head>
		<title>Item Shop || Fortnite Haven</title>
	</head>
	<body>
		<h1>Item Shop resets at 8 PM EST</h1>
	</body>
</html>
