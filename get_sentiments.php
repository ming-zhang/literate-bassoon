<?php

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
        $this->_ENDPOINTS['sentiment_targeted']['text'] = '/text/TextGetTargetedSentiment';
    }

    /**
      *    Calculates the targeted sentiment for text, a URL or HTML.
      *    For an overview, please refer to: http://www.alchemyapi.com/products/features/sentiment-analysis/
      *    For the docs, please refer to: http://www.alchemyapi.com/api/sentiment-analysis/
      *    
      *    INPUT:
      *    flavor -> which version of the call, i.e. text, url or html.
      *    data -> the data to analyze, either the text, the url or html code.
      *    target -> the word or phrase to run sentiment analysis on.
      *    options -> various parameters that can be used to adjust how the API works, see below for more info on the available options.
      *    
      *    Available Options:
      *    showSourceText    -> 0: disabled, 1: enabled
      *
      *    OUTPUT:
      *    The response, already converted from JSON to a PHP object. 
    */
    public function sentiment_targeted($flavor, $data, $target, $options) {
        //Make sure this request supports the flavor
        if (!array_key_exists($flavor, $this->_ENDPOINTS['sentiment_targeted'])) {
            return array('status'=>'ERROR','statusInfo'=>'Targeted sentiment analysis for ' . $flavor . ' not available');
        }

        if (!$target) {
            return array('status'=>'ERROR','statusInfo'=>'targeted sentiment requires a non-null target');
        }

        //Add the URL encoded data to the options and analyze
        $options[$flavor] = $data;
        $options['target'] = $target;
        return $this->analyze($this->_ENDPOINTS['sentiment_targeted'][$flavor], $options);
    }

    /**
      *    HTTP Request wrapper that is called by the endpoint functions. This function is not intended to be called through an external interface. 
      *    It makes the call, then converts the returned JSON string into a PHP object. 
      *    
      *    INPUT:
      *    url -> the full URI encoded url
      *
      *    OUTPUT:
      *    The response, already converted from JSON to a PHP object. 
    */
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

$target='clinton';

$text='Wow, Hillary Clinton was SO INSULTING to my supporters, millions of amazing, hard working people. I think it will cost her at the Polls!';


echo 'Processing text: ', $text, PHP_EOL;
echo 'Target: ', $target, PHP_EOL;
echo PHP_EOL;

$response = $alchemyapi->sentiment_targeted('text', $text, $target, null);

if ($response['status'] == 'OK') {
    echo '## Response Object ##', PHP_EOL;
    echo print_r($response);

    echo PHP_EOL;
    echo '## Targeted Sentiment ##', PHP_EOL;
    echo 'sentiment: ', $response['docSentiment']['type'], PHP_EOL;
    if (array_key_exists('score', $response['docSentiment'])) {
        echo 'score: ', $response['docSentiment']['score'], PHP_EOL;
    }
} else {
    echo 'Error in the targeted sentiment analysis call: ', $response['statusInfo'];
}

?>