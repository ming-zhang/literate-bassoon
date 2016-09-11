<?php
require_once('twitter_proxy.php');
require_once('get_location.php');

// $tweetsArr = array(
// 'Alabama',
// 'Alaska',
// 'Arizona',
// 'Arkansas',
// 'California',
// 'Colorado',
// 'Connecticut',
// 'Delaware',
// 'Florida',
// 'Georgia',
// 'Hawaii',
// 'Idaho',
// 'Illinois',
// 'Indiana',
// 'Iowa',
// 'Kansas',
// 'Kentucky',
// 'Louisiana',
// 'Maine',
// 'Maryland',
// 'Massachusetts',
// 'Michigan',
// 'Minnesota',
// 'Mississippi',
// 'Missouri',
// 'Montana',
// 'Nebraska',
// 'Nevada',
// 'New Hampshire',
// 'New Jersey',
// 'New Mexico',
// 'New York',
// 'North Carolina',
// 'North Dakota',
// 'Ohio',
// 'Oklahoma',
// 'Oregon',
// 'Pennsylvania',
// 'Rhode Island',
// 'South Carolina',
// 'South Dakota',
// 'Tennessee',
// 'Texas',
// 'Utah',
// 'Vermont',
// 'Virginia',
// 'Washington',
// 'West Virginia',
// 'Wisconsin',
// 'Wyoming'
// );

$tweetsArr = array(
'Alabama',
'Pennsylvania',
'Texas',
'New York',
'Wyoming'
);

// Twitter OAuth Config options
$oauth_access_token = '261161981-PEoTMlyGLme0h3mYH5LRRlIAcaeUSiKQHIdkQOIk';
$oauth_access_token_secret = 'E6xJp9RVS4VvviKGSPheyHEksY2P6t3rQPHgVwGm6MLU0';
$consumer_key = 'bmuK144ogL41ekQdHPTRGjfIA';
$consumer_secret = 's1U0kav8D2DcNwMzChR3X3mcS3AfUKgRNDxFbIVBQyIoVNrXys';

//$twitter_url = 'search.json?q=trump%20place%3A96683cc9126741d1';
$twitter_url = 'search/tweets.json?q=';

$keyword = 'trump';


// Create a Twitter Proxy object from our twitter_proxy.php class
$twitter_proxy = new TwitterProxy(
	$oauth_access_token,			// 'Access token' on https://apps.twitter.com
	$oauth_access_token_secret,		// 'Access token secret' on https://apps.twitter.com
	$consumer_key,					// 'API key' on https://apps.twitter.com
	$consumer_secret			// 'API secret' on https://apps.twitter.com

);
// Invoke the get method to retrieve results via a cURL request
//$tweets = $twitter_proxy->get($twitter_url . $keyword . '&' . $language . '&' . $time . '&' . $count);

$allTweets = array();

foreach ($states as $state => $id) {

	$tweets = $twitter_proxy->get($twitter_url . $keyword . '%20place%3A' . $id);
	$t = json_decode($tweets);
	$tweetsArr2 = array();



	for ($x = 0; $x <= count($t->{'statuses'}); $x++) {

		array_push($tweetsArr2, $t->{'statuses'}[$x]->{'text'});
		$allTweets[$state] = $tweetsArr2;

	}
 
}


?>

