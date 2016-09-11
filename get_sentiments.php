<?php

require_once('get_tweets.php');

class AlchemyAPI {
    
    private $_api_key;
    private $_ENDPOINTS;
    private $_base_url;
    private $_BASE_HTTP_URL = 'http://access.alchemyapi.com/calls';
    private $_BASE_HTTPS_URL =  'https://access.alchemyapi.com/calls';

    /**
     * Constructor
     *
     * @param string
     * @param boolean
     * @return void
     */
    public function __construct($key, $use_https = false)  {
        $this->_api_key = $key;
        
        $this->_base_url = $use_https ? $this->_BASE_HTTPS_URL : $this->_BASE_HTTP_URL;
            
        //Initialize the API Endpoints
        $this->_ENDPOINTS['sentiment_targeted'] = '/text/TextGetTargetedSentiment';
        $this->_ENDPOINTS['emotion_targeted'] = '/text/TextGetTargetedEmotion';
    }

    public function sentiment_targeted($data, $target, $options) {

        if (!$target) {
            return array('status'=>'ERROR','statusInfo'=>'targeted sentiment requires a non-null target');
        }

        //Add the URL encoded data to the options and analyze
        $options['text'] = $data;
        $options['targets'] = $target;
        return $this->analyze($this->_ENDPOINTS['sentiment_targeted'], $options);
    }

    public function emotion_targeted($data, $target, $options) {

        if (!$target) {
            return array('status'=>'ERROR','statusInfo'=>'targeted emotion requires a non-null target');
        }

        //Add the URL encoded data to the options and analyze
        $options['text'] = $data;
        $options['targets'] = $target;
        return $this->analyze($this->_ENDPOINTS['emotion_targeted'], $options);
    }

    private function analyze($endpoint, $params) {
        //Insert the base URL
        $url = $this->_base_url . $endpoint;

        //Add the API Key and set the output mode to JSON
        $params['apikey'] = $this->_api_key;
        $params['outputMode'] = 'json';
        
        //Create the HTTP header
        $header = array('http' => array('method' => 'POST','header'=>'Content-Type: application/x-www-form-urlencode', 'content'=>http_build_query($params)));

        //Fire off the HTTP Request
        try {
            $fp = @fopen($url, 'rb',false, stream_context_create($header));
            $response = @stream_get_contents($fp);
            fclose($fp);
            return json_decode($response, true);
        } catch (Exception $e) {
            return array('status'=>'ERROR', 'statusInfo'=>'Network error');
        }
    }
    //Use to create request for image API
        private function analyzeImage($endpoint, $params, $imageData) {
        

        //Add the API Key and set the output mode to JSON
        $params['apikey'] = $this->_api_key;
        $params['outputMode'] = 'json';

        //Insert the base URL
        $url = $this->_base_url . $endpoint . '?' . http_build_query($params);
        
        //Create the HTTP header
        $header = array('http' => array('method' => 'POST','header'=>'Content-Type: application/x-www-form-urlencode', 'content'=>$imageData));

        //Fire off the HTTP Request
        try {
            $fp = @fopen($url, 'rb',false, stream_context_create($header));
            $response = @stream_get_contents($fp);
            fclose($fp);
            return json_decode($response, true);
        } catch (Exception $e) {
            return array('status'=>'ERROR', 'statusInfo'=>'Network error');
        }
    }
}

$alchemyapi = new AlchemyAPI("6be6a589965cd760bb387d2535704ac1f72ae540");

$target='trump';
// $text='Wow, Hillary Clinton was SO INSULTING to my supporters, millions of amazing, hard working people. I think it will cost her at the Polls!';

$input = $tweetsArr;

$output = array();

foreach ($input as $state => $tweets) {
    $text = implode(" ", $tweets);
    $feelings = array();

    $response = $alchemyapi->sentiment_targeted($text, $target, null);

    if ($response['status'] == 'OK') {
        $sentiment = $response['results'][0]['sentiment'];
        $feelings['sentiment'] = $sentiment['score'];
    } else {
        echo 'Error in the targeted sentiment analysis call: ', $response['statusInfo'];
    }

    $response = $alchemyapi->emotion_targeted($text, $target, null);

    if ($response['status'] == 'OK') {
        $emotions = $response['results'][0]['emotions'];
        foreach ($emotions as $emotion => $score) {
            $feelings[$emotion] = $score;
        }
    } else {
        echo 'Error in the targeted sentiment analysis call: ', $response['statusInfo'];
    }

    $output[$state] = $feelings

}

?>