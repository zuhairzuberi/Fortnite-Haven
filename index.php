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
		<title>Fortnite Item Shop</title>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<style>
			@font-face {
			  	font-family: 'Fortnite';
			  	src: url( 'BurbankBigCondensed-Bold.otf' );
			}

			.rarity-fine {
				background: #fb9625;
			}

			.rarity-quality {
				background: #7907a5;
			}

			.rarity-sturdy {
				background: #3dc7ff;
			}

			.rarity-handmade {
				background: #5bad03;
			}

			a {
				color: #e3e3e3;
			}
		</style>
	</head>
</html>
