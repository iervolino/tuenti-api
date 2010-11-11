<?php

// Parent class of all Hydrated clases
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
// IN THE SOFTWARE.

namespace Kiwwito\HydroObject;

/**
 * Parent class of all hydrated clases. This class implement the magic methods
 * for use the getter/setter methods of a given structure.
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.1.2
 *
 * @TODO remove structure methods (lower memory consumption)
 */
class Bundle
{
  protected $data = array();
  protected $structure = null;
  
  /**
   * Retrieve all the data as an array
   * @return array
   */
  public function toArray ()
  {
    return $this->data;
  }
  /**
   * Overrideable method for the object structure
   * @return array structure
   */
  public static function getStructure ()
  {
    return array();
  }
  /**
   * Hydrate the object following the structure
   * This method dont check for the structure and sets directly the pointer of the content in due to optimization
   * @param array $data
   */
  public function hydrate (array &$data)
  {
    $this->data = $data;
  }
  /**
   * Know if a character is uppercased
   * @param string $character
   * @return true if is uppercased
   */
  private function _isUpperCased ($str)
  {
    $ord = ord($str);
    return ($ord > 64 && $ord < 91);
  }
  /**
   * Check if the passed string is a number
   * @return true if 0-9 number
   */
  private function _isNumber ($str)
  {
    return (ord($str) > 47 && ord($str) < 58);
  }
  /**
   * Uncamelize a string
   * @param string $str string to uncamelize
   * @return string uncamelized string
   */
  private function _uncamelizeStr ($str)
  {
    $return = strtolower($str[0]);
    for ($i = 1; $i < strlen($str); $i++)
    {
      if ($this->_isUpperCased($str[$i]) || ($this->_isNumber($str[$i]) && $i != 1 && !$this->_isNumber($str[$i-1])))
        $return .= '_';
      $return .= strtolower($str[$i]);
    }
    return $return;
  }
  /**
   * Magic method por getters and setterss
   * @param string $method method name
   * @param array $arguments arguments for the method
   * @return mixed return values
   */
  public function __call ($method, $arguments)
  {
    $get = false;
    $error = false;
    
    //If is a setter
    if (strpos($method, 'get') !== false)
    {
      $get = true;
      $camelizedAttribute = str_replace('get', '', $method);
    }
    //If is a getter
    else if (strpos($method, 'set') !== false)
    {
      $camelizedAttribute = str_replace('set', '', $method);
    }
    //In other casess
    else
      $error = true;    
    
    //Check for errors or if the first letter of the camelized attribute is or not uppercased (standard)
    if ($error || !$this->_isUpperCased($camelizedAttribute[0]))
      throw new \Exception ('Method "' . $method . '" not found in class "' . __CLASS__ . '"');
    
    //Uncamelize attribute
    $attribute = $this->_uncamelizeStr($camelizedAttribute);
    
    //If is no structure setted yet
    if ($this->structure == null)
      $this->structure = array_flip($this::getStructure());
    
    //Check for the attribute existence
    if (!array_key_exists($attribute, $this->structure))
    {
      throw new \Exception('The attribute "' . $attribute . '" is not defined in the object structure');
    }
    
    //If is a getter method
    if ($get)
    {
      return (isset($this->data[$attribute])) ?
        $this->data[$attribute] : $this->structure[$attribute];
    }
    //If is a setter method
    else
    {
      if (count($arguments) > 1)
        throw new \Exception ('The mutators methods only accepts one argument');
      $this->data[$attribute] = current($arguments);
    }
  }
}
