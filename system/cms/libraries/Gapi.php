<?php
/**
 * GAPI - Google Analytics PHP Interface
 * 
 * http://code.google.com/p/gapi-google-analytics-php-interface/
 * 
 * @copyright Stig Manning 2009
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Stig Manning <stig@sdm.co.nz>
 * @author Joel Kitching <jkitching@mailbolt.com>
 * @author Cliff Gordon <clifton.gordon@gmail.com>
 * @version 2.0
 * 
 */

class gapi {
  const account_data_url = 'https://www.googleapis.com/analytics/v3/management/accountSummaries';
  const report_data_url = 'https://www.googleapis.com/analytics/v3/data/ga';
  const interface_name = 'GAPI-2.0';
  const dev_mode = false;

  private $auth_method = null;
  private $account_entries = array();
  private $report_aggregate_metrics = array();
  private $report_root_parameters = array();
  private $results = array();

  /**
   * Constructor function for new gapi instances
   *
   * @param string $client_email Email of OAuth2 service account (XXXXX@developer.gserviceaccount.com)
   * @param string $key_file Location/filename of .p12 key file
   * @param string $delegate_email Optional email of account to impersonate
   * @return gapi
   */
  public function __construct($client_email, $key_file, $delegate_email = null) {
    if (version_compare(PHP_VERSION, '5.3.0') < 0) {
      throw new Exception('GAPI: PHP version ' . PHP_VERSION . ' is below minimum required 5.3.0.');
    }
    $this->auth_method = new gapiOAuth2();
    $this->auth_method->fetchToken($client_email, $key_file, $delegate_email);
  }

  /**
   * Return the auth token string retrieved by Google
   *
   * @return String
   */
  public function getToken() {
    return $this->auth_method->getToken();
  }

  /**
   * Return the auth token information from the Google service
   *
   * @return Array
   */
  public function getTokenInfo() {
    return $this->auth_method->getTokenInfo();
  }

  /**
   * Revoke the current auth token, rendering it invalid for future requests
   *
   * @return Boolean
   */
  public function revokeToken() {
    return $this->auth_method->revokeToken();
  }

  /**
   * Request account data from Google Analytics
   *
   * @param Int $start_index OPTIONAL: Start index of results
   * @param Int $max_results OPTIONAL: Max results returned
   */
  public function requestAccountData($start_index=1, $max_results=1000) {
    $get_variables = array(
      'start-index' => $start_index,
      'max-results' => $max_results,
      );
    $url = new gapiRequest(gapi::account_data_url);
    $response = $url->get($get_variables, $this->auth_method->generateAuthHeader());

    if (substr($response['code'], 0, 1) == '2') {
      return $this->accountObjectMapper($response['body']);
    } else {
      throw new Exception('GAPI: Failed to request account data. Error: "' . strip_tags($response['body']) . '"');
    }
  }

  /**
   * Request report data from Google Analytics
   *
   * $report_id is the Google report ID for the selected account
   * 
   * $parameters should be in key => value format
   * 
   * @param String $report_id
   * @param Array $dimensions Google Analytics dimensions e.g. array('browser')
   * @param Array $metrics Google Analytics metrics e.g. array('pageviews')
   * @param Array $sort_metric OPTIONAL: Dimension or dimensions to sort by e.g.('-visits')
   * @param String $filter OPTIONAL: Filter logic for filtering results
   * @param String $start_date OPTIONAL: Start of reporting period
   * @param String $end_date OPTIONAL: End of reporting period
   * @param Int $start_index OPTIONAL: Start index of results
   * @param Int $max_results OPTIONAL: Max results returned
   */
  public function requestReportData($report_id, $dimensions=null, $metrics, $sort_metric=null, $filter=null, $start_date=null, $end_date=null, $start_index=1, $max_results=10000) {
    $parameters = array('ids'=>'ga:' . $report_id);

    if (is_array($dimensions)) {
      $dimensions_string = '';
      foreach ($dimensions as $dimesion) {
        $dimensions_string .= ',ga:' . $dimesion;
      }
      $parameters['dimensions'] = substr($dimensions_string, 1);
    } elseif ($dimensions !== null) {
      $parameters['dimensions'] = 'ga:'.$dimensions;
    }

    if (is_array($metrics)) {
      $metrics_string = '';
      foreach ($metrics as $metric) {
        $metrics_string .= ',ga:' . $metric;
      }
      $parameters['metrics'] = substr($metrics_string, 1);
    } else {
      $parameters['metrics'] = 'ga:'.$metrics;
    }

    if ($sort_metric==null&&isset($parameters['metrics'])) {
      $parameters['sort'] = $parameters['metrics'];
    } elseif (is_array($sort_metric)) {
      $sort_metric_string = '';

      foreach ($sort_metric as $sort_metric_value) {
        //Reverse sort - Thanks Nick Sullivan
        if (substr($sort_metric_value, 0, 1) == "-") {
          $sort_metric_string .= ',-ga:' . substr($sort_metric_value, 1); // Descending
        }
        else {
          $sort_metric_string .= ',ga:' . $sort_metric_value; // Ascending
        }
      }

      $parameters['sort'] = substr($sort_metric_string, 1);
    } else {
      if (substr($sort_metric, 0, 1) == "-") {
        $parameters['sort'] = '-ga:' . substr($sort_metric, 1);
      } else {
        $parameters['sort'] = 'ga:' . $sort_metric;
      }
    }

    if ($filter!=null) {
      $filter = $this->processFilter($filter);
      if ($filter!==false) {
        $parameters['filters'] = $filter;
      }
    }

    if ($start_date==null) {
      // Use the day that Google Analytics was released (1 Jan 2005).
      $start_date = '2005-01-01';
    } elseif (is_int($start_date)) {
      // Perhaps we are receiving a Unix timestamp.
      $start_date = date('Y-m-d', $start_date);
    }

    $parameters['start-date'] = $start_date;

    if ($end_date==null) {
      $end_date = date('Y-m-d');
    } elseif (is_int($end_date)) {
      // Perhaps we are receiving a Unix timestamp.
      $end_date = date('Y-m-d', $end_date);
    }

    $parameters['end-date'] = $end_date;


    $parameters['start-index'] = $start_index;
    $parameters['max-results'] = $max_results;

    $parameters['prettyprint'] = gapi::dev_mode ? 'true' : 'false';
    
    $url = new gapiRequest(gapi::report_data_url);
    $response = $url->get($parameters, $this->auth_method->generateAuthHeader());

    //HTTP 2xx
    if (substr($response['code'], 0, 1) == '2') {
      return $this->reportObjectMapper($response['body']);
    } else {
      throw new Exception('GAPI: Failed to request report data. Error: "' . $this->cleanErrorResponse($response['body']) . '"');
    }
  }
  
  /**
   * Clean error message from Google API
   * 
   * @param String $error Error message HTML or JSON from Google API
   */
  private function cleanErrorResponse($error) {
    if (strpos($error, '<html') !== false) {
      $error = preg_replace('/<(style|title|script)[^>]*>[^<]*<\/(style|title|script)>/i', '', $error);
      return trim(preg_replace('/\s+/', ' ', strip_tags($error)));
    }
    else
    {
      $json = json_decode($error);
      return isset($json->error->message) ? strval($json->error->message) : $error;
    }
  }

  /**
   * Process filter string, clean parameters and convert to Google Analytics
   * compatible format
   * 
   * @param String $filter
   * @return String Compatible filter string
   */
  protected function processFilter($filter) {
    $valid_operators = '(!~|=~|==|!=|>|<|>=|<=|=@|!@)';

    $filter = preg_replace('/\s\s+/', ' ', trim($filter)); //Clean duplicate whitespace
    $filter = str_replace(array(',', ';'), array('\,', '\;'), $filter); //Escape Google Analytics reserved characters
    $filter = preg_replace('/(&&\s*|\|\|\s*|^)([a-z0-9]+)(\s*' . $valid_operators . ')/i','$1ga:$2$3',$filter); //Prefix ga: to metrics and dimensions
    $filter = preg_replace('/[\'\"]/i', '', $filter); //Clear invalid quote characters
    $filter = preg_replace(array('/\s*&&\s*/','/\s*\|\|\s*/','/\s*' . $valid_operators . '\s*/'), array(';', ',', '$1'), $filter); //Clean up operators

    if (strlen($filter) > 0) {
      return urlencode($filter);
    }
    else {
      return false;
    }
  }

  /**
   * Report Account Mapper to convert the JSON to array of useful PHP objects
   *
   * @param String $json_string
   * @return Array of gapiAccountEntry objects
   */
  protected function accountObjectMapper($json_string) {
    $json = json_decode($json_string, true);
    $results = array();

    foreach ($json['items'] as $item) {
      foreach ($item['webProperties'] as $property) {
        if (isset($property['profiles'][0]['id'])) {
          $property['ProfileId'] = $property['profiles'][0]['id'];
        }
        $results[] = new gapiAccountEntry($property);
      }
    }

    $this->account_entries = $results;

    return $results;
  }

  /**
   * Report Object Mapper to convert the JSON to array of useful PHP objects
   *
   * @param String $json_string
   * @return Array of gapiReportEntry objects
   */
  protected function reportObjectMapper($json_string) {
    $json = json_decode($json_string, true);

    $this->results = null;
    $results = array();

    $report_aggregate_metrics = array();

    //Load root parameters

    // Start with elements from the root level of the JSON that aren't themselves arrays.
    $report_root_parameters = array_filter($json, function($var){
      return !is_array($var);
    });

    // Get the items from the 'query' object, and rename them slightly.
    foreach($json['query'] as $index => $value) {
      $new_index = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $index))));
      $report_root_parameters[$new_index] = $value;
    }

    // Now merge in the profileInfo, as this is also mostly useful.
    array_merge($report_root_parameters, $json['profileInfo']);

    //Load result aggregate metrics

    foreach($json['totalsForAllResults'] as $index => $metric_value) {
      //Check for float, or value with scientific notation
      if (preg_match('/^(\d+\.\d+)|(\d+E\d+)|(\d+.\d+E\d+)$/', $metric_value)) {
        $report_aggregate_metrics[str_replace('ga:', '', $index)] = floatval($metric_value);
      } else {
        $report_aggregate_metrics[str_replace('ga:', '', $index)] = intval($metric_value);
      }
    }

    //Load result entries
    if(isset($json['rows'])){
      foreach($json['rows'] as $row) {
        $metrics = array();
        $dimensions = array();
        foreach($json['columnHeaders'] as $index => $header) {
          switch($header['columnType']) {
            case 'METRIC':
              $metric_value = $row[$index];

              //Check for float, or value with scientific notation
              if(preg_match('/^(\d+\.\d+)|(\d+E\d+)|(\d+.\d+E\d+)$/',$metric_value)) {
                $metrics[str_replace('ga:', '', $header['name'])] = floatval($metric_value);
              } else {
                $metrics[str_replace('ga:', '', $header['name'])] = intval($metric_value);
              }
              break;
            case 'DIMENSION':
              $dimensions[str_replace('ga:', '', $header['name'])] = strval($row[$index]);
              break;
            default:
              throw new Exception("GAPI: Unrecognized columnType '{$header['columnType']}' for columnHeader '{$header['name']}'");
          }
        }
        $results[] = new gapiReportEntry($metrics, $dimensions);
      }
    }

    $this->report_root_parameters = $report_root_parameters;
    $this->report_aggregate_metrics = $report_aggregate_metrics;
    $this->results = $results;

    return $results;
  }

  /**
   * Get current analytics results
   *
   * @return Array
   */
  public function getResults() {
    return is_array($this->results) ? $this->results : false;
  }

  /**
   * Get current account data
   *
   * @return Array
   */
  public function getAccounts() {
    return is_array($this->account_entries) ? $this->account_entries : false;
  }

  /**
   * Get an array of the metrics and the matching
   * aggregate values for the current result
   *
   * @return Array
   */
  public function getMetrics() {
    return $this->report_aggregate_metrics;
  }

  /**
   * Call method to find a matching root parameter or 
   * aggregate metric to return
   *
   * @param $name String name of function called
   * @return String
   * @throws Exception if not a valid parameter or aggregate 
   * metric, or not a 'get' function
   */
  public function __call($name, $parameters) {
    if (!preg_match('/^get/', $name)) {
      throw new Exception('No such function "' . $name . '"');
    }

    $name = preg_replace('/^get/', '', $name);

    $parameter_key = gapi::ArrayKeyExists($name, $this->report_root_parameters);

    if ($parameter_key) {
      return $this->report_root_parameters[$parameter_key];
    }

    $aggregate_metric_key = gapi::ArrayKeyExists($name, $this->report_aggregate_metrics);

    if ($aggregate_metric_key) {
      return $this->report_aggregate_metrics[$aggregate_metric_key];
    }

    throw new Exception('No valid root parameter or aggregate metric called "' . $name . '"');
  }
  
  /**
   * Case insensitive array_key_exists function, also returns
   * matching key.
   *
   * @param String $key
   * @param Array $search
   * @return String Matching array key
   */
  public static function ArrayKeyExists($key, $search) {
    if (array_key_exists($key, $search)) {
      return $key;
    }
    if (!(is_string($key) && is_array($search))) {
      return false;
    }
    $key = strtolower($key);
    foreach ($search as $k => $v) {
      if (strtolower($k) == $key) {
        return $k;
      }
    }
    return false;
  }
}

/**
 * Storage for individual gapi account entries
 *
 */
class gapiAccountEntry {
  private $properties = array();

  /**
   * Constructor function for all new gapiAccountEntry instances
   * 
   * @param Array $properties
   * @return gapiAccountEntry
   */
  public function __construct($properties) {
    $this->properties = $properties;
  }

  /**
   * toString function to return the name of the account
   *
   * @return String
   */
  public function __toString() {
    return isset($this->properties['name']) ?
      $this->properties['name']: '';
  }

  /**
   * Get an associative array of the properties
   * and the matching values for the current result
   *
   * @return Array
   */
  public function getProperties() {
    return $this->properties;
  }

  /**
   * Call method to find a matching parameter to return
   *
   * @param $name String name of function called
   * @return String
   * @throws Exception if not a valid parameter, or not a 'get' function
   */
  public function __call($name, $parameters) {
    if (!preg_match('/^get/', $name)) {
      throw new Exception('No such function "' . $name . '"');
    }

    $name = preg_replace('/^get/', '', $name);

    $property_key = gapi::ArrayKeyExists($name, $this->properties);

    if ($property_key) {
      return $this->properties[$property_key];
    }

    throw new Exception('No valid property called "' . $name . '"');
  }
}

/**
 * Storage for individual gapi report entries
 *
 */
class gapiReportEntry {
  private $metrics = array();
  private $dimensions = array();

  /**
   * Constructor function for all new gapiReportEntry instances
   * 
   * @param Array $metrics
   * @param Array $dimensions
   * @return gapiReportEntry
   */
  public function __construct($metrics, $dimensions) {
    $this->metrics = $metrics;
    $this->dimensions = $dimensions;
  }

  /**
   * toString function to return the name of the result
   * this is a concatented string of the dimensions chosen
   * 
   * For example:
   * 'Firefox 3.0.10' from browser and browserVersion
   *
   * @return String
   */
  public function __toString() {
    return is_array($this->dimensions) ? 
      implode(' ', $this->dimensions) : '';
  }

  /**
   * Get an associative array of the dimensions
   * and the matching values for the current result
   *
   * @return Array
   */
  public function getDimensions() {
    return $this->dimensions;
  }

  /**
   * Get an array of the metrics and the matchning
   * values for the current result
   *
   * @return Array
   */
  public function getMetrics() {
    return $this->metrics;
  }

  /**
   * Call method to find a matching metric or dimension to return
   *
   * @param String $name name of function called
   * @param Array $parameters
   * @return String
   * @throws Exception if not a valid metric or dimensions, or not a 'get' function
   */
  public function __call($name, $parameters) {
    if (!preg_match('/^get/', $name)) {
      throw new Exception('No such function "' . $name . '"');
    }

    $name = preg_replace('/^get/', '', $name);

    $metric_key = gapi::ArrayKeyExists($name, $this->metrics);

    if ($metric_key) {
      return $this->metrics[$metric_key];
    }

    $dimension_key = gapi::ArrayKeyExists($name, $this->dimensions);

    if ($dimension_key) {
      return $this->dimensions[$dimension_key];
    }

    throw new Exception('No valid metric or dimesion called "' . $name . '"');
  }
}

/**
 * OAuth2 Google API authentication
 *
 */
class gapiOAuth2 {
  const scope_url = 'https://www.googleapis.com/auth/analytics.readonly';
  const request_url = 'https://www.googleapis.com/oauth2/v3/token';
  const grant_type = 'urn:ietf:params:oauth:grant-type:jwt-bearer';
  const header_alg = 'RS256';
  const header_typ = 'JWT';

  private function base64URLEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
  }

  private function base64URLDecode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
  } 

  /**
   * Authenticate Google Account with OAuth2
   *
   * @param String $client_email
   * @param String $key_file
   * @param String $delegate_email
   * @return String Authentication token
   */
  public function fetchToken($client_email, $key_file, $delegate_email = null) {
    $header = array(
      "alg" => self::header_alg,
      "typ" => self::header_typ,
    );

    $claimset = array(
      "iss" => $client_email,
      "scope" => self::scope_url,
      "aud" => self::request_url,
      "exp" => time() + (60 * 60),
      "iat" => time(),
    );

    if(!empty($delegate_email)) {
      $claimset["sub"] = $delegate_email;
    }

    $data = $this->base64URLEncode(json_encode($header)) . '.' . $this->base64URLEncode(json_encode($claimset));

    if (!file_exists($key_file)) {
      if ( !file_exists(__DIR__ . DIRECTORY_SEPARATOR . $key_file) ) {
        throw new Exception('GAPI: Failed load key file "' . $key_file . '". File could not be found.');
      } else {
        $key_file = __DIR__ . DIRECTORY_SEPARATOR . $key_file;
      }
    }

    $key_data = file_get_contents($key_file);
    
    if (empty($key_data)) {
      throw new Exception('GAPI: Failed load key file "' . $key_file . '". File could not be opened or is empty.');
    }

    openssl_pkcs12_read($key_data, $certs, 'notasecret');

    if (!isset($certs['pkey'])) {
      throw new Exception('GAPI: Failed load key file "' . $key_file . '". Unable to load pkcs12 check if correct p12 format.');
    }

    openssl_sign($data, $signature, openssl_pkey_get_private($certs['pkey']), "sha256");

    $post_variables = array(
      'grant_type' => self::grant_type,
      'assertion' => $data . '.' . $this->base64URLEncode($signature),
    );

    $url = new gapiRequest(self::request_url);
    $response = $url->post(null, $post_variables);
    $auth_token = json_decode($response['body'], true);

    if (substr($response['code'], 0, 1) != '2' || !is_array($auth_token) || empty($auth_token['access_token'])) {
      throw new Exception('GAPI: Failed to authenticate user. Error: "' . strip_tags($response['body']) . '"');
    }

    $this->auth_token = $auth_token['access_token'];

    return $this->auth_token;
  }

  /**
   * Return the auth token string retrieved from Google
   *
   * @return String
   */
  public function getToken() {
    return $this->auth_token;
  }
  
  /**
   * Generate authorization token header for all requests
   *
   * @param String $token
   * @return Array
   */
  public function generateAuthHeader($token=null) {
    if ($token == null)
      $token = $this->auth_token;
    return array('Authorization' => 'Bearer ' . $token);
  }
}

/**
 * Google Analytics API request
 *
 */
class gapiRequest {
  const http_interface = 'auto'; //'auto': autodetect, 'curl' or 'fopen'
  const interface_name = gapi::interface_name;

  private $url = null;

  public function __construct($url) {
    $this->url = $url;
  }

  /**
   * Return the URL to be requested, optionally adding GET variables
   *
   * @param Array $get_variables
   * @return String
   */
  public function getUrl($get_variables=null) {
    if (is_array($get_variables)) {
      $get_variables = '?' . str_replace('&amp;', '&', urldecode(http_build_query($get_variables, '', '&')));
    } else {
      $get_variables = null;
    }

    return $this->url . $get_variables;
  }

  /**
   * Perform http POST request
   * 
   *
   * @param Array $get_variables
   * @param Array $post_variables
   * @param Array $headers
   */
  public function post($get_variables=null, $post_variables=null, $headers=null) {
    return $this->request($get_variables, $post_variables, $headers);
  }

  /**
   * Perform http GET request
   * 
   *
   * @param Array $get_variables
   * @param Array $headers
   */
  public function get($get_variables=null, $headers=null) {
    return $this->request($get_variables, null, $headers);
  }

  /**
   * Perform http request
   * 
   *
   * @param Array $get_variables
   * @param Array $post_variables
   * @param Array $headers
   */
  public function request($get_variables=null, $post_variables=null, $headers=null) {
    $interface = self::http_interface;

    if (self::http_interface == 'auto')
      $interface = function_exists('curl_exec') ? 'curl' : 'fopen';

    switch ($interface) {
      case 'curl':
        return $this->curlRequest($get_variables, $post_variables, $headers);
      case 'fopen':
        return $this->fopenRequest($get_variables, $post_variables, $headers);
      default:
        throw new Exception('Invalid http interface defined. No such interface "' . self::http_interface . '"');
    }
  }

  /**
   * HTTP request using PHP CURL functions
   * Requires curl library installed and configured for PHP
   * 
   * @param Array $get_variables
   * @param Array $post_variables
   * @param Array $headers
   */
  private function curlRequest($get_variables=null, $post_variables=null, $headers=null) {
    $ch = curl_init();

    if (is_array($get_variables)) {
      $get_variables = '?' . str_replace('&amp;', '&', urldecode(http_build_query($get_variables, '', '&')));
    } else {
      $get_variables = null;
    }

    curl_setopt($ch, CURLOPT_URL, $this->url . $get_variables);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //CURL doesn't like google's cert

    if (is_array($post_variables)) {
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_variables, '', '&'));
    }

    if (is_array($headers)) {
      $string_headers = array();
      foreach ($headers as $key => $value) {
        $string_headers[] = "$key: $value";
      }
      curl_setopt($ch, CURLOPT_HTTPHEADER, $string_headers);
    }

    $response = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return array('body' => $response, 'code' => $code);
  }

  /**
   * HTTP request using native PHP fopen function
   * Requires PHP openSSL
   *
   * @param Array $get_variables
   * @param Array $post_variables
   * @param Array $headers
   */
  private function fopenRequest($get_variables=null, $post_variables=null, $headers=null) {
    $http_options = array('method'=>'GET', 'timeout'=>3);

    $string_headers = '';
    if (is_array($headers)) {
      foreach ($headers as $key => $value) {
        $string_headers .= "$key: $value\r\n";
      }
    }

    if (is_array($get_variables)) {
      $get_variables = '?' . str_replace('&amp;', '&', urldecode(http_build_query($get_variables, '', '&')));
    }
    else {
      $get_variables = null;
    }

    if (is_array($post_variables)) {
      $post_variables = str_replace('&amp;', '&', urldecode(http_build_query($post_variables, '', '&')));
      $http_options['method'] = 'POST';
      $string_headers = "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . strlen($post_variables) . "\r\n" . $string_headers;
      $http_options['header'] = $string_headers;
      $http_options['content'] = $post_variables;
    }
    else {
      $post_variables = '';
      $http_options['header'] = $string_headers;
    }

    $context = stream_context_create(array('http'=>$http_options));
    $response = @file_get_contents($this->url . $get_variables, null, $context);

    return array('body'=>$response!==false?$response:'Request failed, consider using php5-curl module for more information.', 'code'=>$response!==false?'200':'400');
  }
}