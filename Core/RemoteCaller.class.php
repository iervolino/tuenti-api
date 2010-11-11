<?php

// This file is part of Kiwwito's TuentiAPI
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

namespace Kiwwito\TuentiAPI;
use Kiwwito\WebBrowser as KWB;

/**
 * Remote Procedure Caller for the public Tuenti webservice
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.1.1
 *
 * @TODO Delete cURL dependency
 */
class RemoteCaller
{
  protected $wb = null;
  protected $sessionData = array();
  
  protected static $version = '0.5';
  //iPhone userAgent emulation
  protected static $userAgent = 'Tuenti/1.2 CFNetwork/485.10.2 Darwin/10.3.1';
  protected static $apiKey = 'MDI3MDFmZjU4MGExNWM0YmEyYjA5MzRkODlmMjg0MTU6MC43NzQ4ODAwMCAxMjc1NDcyNjgz';
  protected $language = '';
  
  /**
   * Conectar con tuenti
   * @param string $email email
   * @param string $password contraseña
   */
  public function __construct ($email, $password, $language = 'es-es')
  {
    $this->language = $language;
    $this->wb = new KWB\Bundle ('api.tuenti.com');
    
    //Call to remote get challenge procedure
    $chall = $this->getChallenge(array('type' => 'login'));
    
    //Call to remote login procedure
    $this->sessionData = $this->getSession(array(
      'passcode' => md5($chall['challenge'] . md5($password)),
      'seed' => $chall['seed'],
      'email' => $email,
      'timestamp' => $chall['timestamp'],
      'application_key' => self::$apiKey
    ));
  }
  /**
   * Get the session data
   * @return array data
   */
  public function getSessionData ()
  {
    return $this->sessionData;
  }
  /**
   * Magic method to call remote procedures
   * @param string $method method name
   * @param array $arguments arguments for the method
   * @return mixed
   */
  public function __call ($method, $arguments)
  {
    $reqArray = array(
      'version' => self::$version,
      'requests' => array(
        array(
          $method,
          current($arguments)
        )
      )
    );
    
    //If is the user is logged
    if (count($this->sessionData) > 0)
    {
      $reqArray['session_id'] = $this->sessionData['session_id'];
    }
    
    $return = current(json_decode(
      $this->wb
        ->addHeader('Accept', '*/*')
        ->addHeader('Accept-Language', $this->language)
        ->addHeader('Connection', 'keep-alive')
        ->setUserAgent(self::$userAgent)
        ->post('api/', json_encode($reqArray))
    , true));
    
    //Errors detection
    if (isset($return['error']))
    {
      throw new \Exception($return['message'], $return['error']);
    }
    
    return $return;
  }
}
