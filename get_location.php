<?php
require_once('twitter_proxy.php');


// $states = array(
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

$states = array(
'Alabama',
'Pennsylvania',
'Texas',
'New York',
'Wyoming'
);

// Twitter OAuth Config options
$oauth_access_token = '774736384104009731-1DrC9R819JL1YVo2SHhJRK5KZ98AvnN';
$oauth_access_token_secret = 'ZmSU1E18mFaZSPGax67zyIsvFCJ92DxhddBJwaX9XYkKQ';
$consumer_key = '6FRDQlSia5LEtCejHJchikN6S';
$consumer_secret = 'H9QdUfn8u5ZetSZvU08optZa8OHoNUyezA3rbtF5n3LSmHmiwK';


$twitter_url = 'geo/search.json?query=';

// Create a Twitter Proxy object from our twitter_proxy.php class
$twitter_proxy = new TwitterProxy(
	$oauth_access_token,			// 'Access token' on https://apps.twitter.com
	$oauth_access_token_secret,		// 'Access token secret' on https://apps.twitter.com
	$consumer_key,					// 'API key' on https://apps.twitter.com
	$consumer_secret			// 'API secret' on https://apps.twitter.com

);
// Invoke the get method to retrieve results via a cURL request
//$tweets = $twitter_proxy->get($twitter_url . $keyword . '&' . $language . '&' . $time . '&' . $count);

foreach ($states as $state) {
	$tweets = $twitter_proxy->get($twitter_url . $state);
	$t = json_decode($tweets);
	$id = $t->{'result'}->{'places'}[0]->{'id'};
	$states[$state] = $id;
}

echo var_dump($states);

