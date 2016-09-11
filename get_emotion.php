<?php
	require('get_sentiments.php');

	$emo = $_POST['emo'];
	$state = $_POST['state'];


	echo $output[$state][$emo];

?>