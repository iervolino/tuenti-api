<?php

// Class that implements a web browser based in cURL
// Copyright (C) 2010 Keyvan Akbary
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace Kiwwito\WebBrowser;

/**
 * Class that implements a web browser based in cURL
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    Kiwwito
 * @subpackage WebBrowser
 * @version    2.0.0
 */
class Bundle
{
  protected $ch;
  //Host
  protected $hostname;
  //Vars
  protected $vars = array();
  //Connection protocol
  protected $protocol = 'http';

  /**
   * Constructor
   * @param string $hostname
   */
  public function __construct($hostname = '')
  {
    $this->hostname = ($hostname != '') ? $hostname : 'localhost';
    //Check for cURL
    if (!function_exists('curl_init'))
    {
      throw new Exception('cURL extension not loaded');
    }
    //Init cURL handler
    $this->ch = curl_init();
  }
  /**
   * Add a header to the request
   * @param string $header header name
   * @param string $content header content
   * @return $this (fluent interface)
   */
  public function addHeader ($header, $content)
  {
    $this->vars['HEADERS'][$header] = $content;
    return $this;
  }
  /**
   * Set the user agent
   * @param string $userAgent UserAgent
   * @return $this (fluent interface)
   */
  public function setUserAgent ($userAgent)
  {
    $this->vars['USER_AGENT'] = $userAgent;
    return $this;
  }
  /**
   * Configure a file to store the session data
   * @param string $cookieFile path to the cookie file
   * @return $this (fluent interface)
   */
  public function setCookieFile ($cookieFile)
  {
    $this->vars['COOKIE_FILE'] = $cookieFile;
    return $this;
  }
  /**
   * Enable web browser auto-redirection
   * @return $this (fluent interface)
   */
  public function enableFollowLocation ()
  {
    $this->vars['FOLLOW'] = true;
    return $this;
  }
  /**
   * Disable web browser auto-redirection
   * @return $this (fluent interface)
   */
  public function disableFollowLocation ()
  {
    unset($this->vars['FOLLOW']);
    return $this;
  }
  /**
   * Enable retrieve headers
   * @return $this (fluent interface)
   */
  public function enableHeaders ()
  {
    $this->vars['HEADER'] = true;
    return $this;
  }
  /**
   * Disable header collection
   * @return $this (fluent interface)
   */
  public function disableHeaders ()
  {
    unset($this->vars['HEADER']);
    return $this;
  }
  /**
   * Enable secure HTTPS protocol
   * @return $this (fluent interface)
   */
  public function enableSecureConnection ()
  {
    $this->protocol = 'https';
    return $this;
  }
  /**
   * Disable secure HTTPS protocol
   * @return $this (fluent interface)
   */
  public function disableSecureConnection ()
  {
    $this->protocol = 'http';
    return $this;
  }
  /**
  * Send a GET request to the server
  * @param string $uri
  * @param array $params parameters to send to the server
  * @return string value of the response
  */
  public function get ($uri, $params = array())
  {
    return $this->call('get', $uri, $params);
  }
  /**
  * Encode array of parameters (into a composed string)
  * @param array $params parameteres
  * @return string encoded parameters
  */
  protected function encodeParameters ($params) {
    $return = '';
    foreach($params as $param => $value) $return .= $param . '=' . $value . '&';
    //Quitamos el último ampersand
    $return = substr($return, 0, strlen($return) - 1);
    return $return;
  }
  /**
   * Set the referer field to a specified valu
   * @param string $referer
   * @return $this (fluent interface)
   */
  public function setReferer ($referer)
  {
    $this->vars['REFERER'] = $referer;
    return $this;
  }
  /**
   * Change the hostname
   * @param string $newHostname new host
   * @return $this (fluent interface)
   */
  public function changeHostname($newHostname)
  {
    $this->hostname = $newHostname;
    return $this;
  }
  /**
  * Send a POST request to the server
  * @param string $uri
  * @param array $params parameters to send to the server
  * @return string value of the response
  */
  public function post ($uri, $params = array())
  {
    return $this->call('post', $uri, $params);
  }
  /**
  * Aux method for server requests
  * @param string $method connection method (get|post)
  * @param string $uri
  * @param array $params parameters to send to the server
  * @return string value of the response
  */
  protected function call ($method, $uri, $params = array())
  {
    /*
    //DEBUG
    curl_setopt($this->ch, CURLOPT_VERBOSE, true);
    curl_setopt($this->ch, CURLINFO_HEADER_OUT, true);
    */
    //Return a string
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    //Headers
    curl_setopt($this->ch, CURLOPT_HEADER, isset($this->vars['HEADER']));
    //Follow redirections
    curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, isset($this->vars['FOLLOW']));
    
    //Referer field
    if (isset($this->vars['REFERER']))
    {
      curl_setopt($this->ch, CURLOPT_REFERER, $this->vars['REFERER']);
    }
    
    //Cookie file
    if (isset($this->vars['COOKIE_FILE']))
    {
      curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->vars['COOKIE_FILE']);
      curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->vars['COOKIE_FILE']);
    }
    
    //Headers
    if (isset($this->vars['HEADERS']))
    {
      $headers = array();
      foreach ($this->vars['HEADERS'] as $header => $value)
        $headers[] = $header . ': ' . $value;

      curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
    }
    
    //UserAgent
    if (isset($this->vars['USER_AGENT']))
    {
      curl_setopt($this->ch, CURLOPT_USERAGENT, $this->vars['USER_AGENT']);
    }
    
    //Call method
    switch ($method)
    {
      case 'post':
        curl_setopt($this->ch, CURLOPT_POST, true);
        if (!empty($params))
        {
          curl_setopt($this->ch, CURLOPT_POSTFIELDS, (is_array($params)) ? $this->encodeParameters($params) : $params);
        }
        break;
      case 'get':
        curl_setopt($this->ch, CURLOPT_HTTPGET, true);
        if (!empty($params))
        {
          $uri .= '?' . $this->encodeParameters($params);
        }
        break;
      default:
        throw new Exception ('Method "' . $method . '" not recognized by the browser class');
    }
    //Set the URL
    curl_setopt($this->ch, CURLOPT_URL, $this->protocol . '://' . $this->hostname . '/' . $uri);
    //Get the request
    return curl_exec($this->ch);
  }
  /**
   * Destroy cURL handler
   */
  public function __destruct ()
  {
    curl_close($this->ch);
  }
}
