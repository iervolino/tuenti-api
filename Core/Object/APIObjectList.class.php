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

namespace Kiwwito\TuentiAPI\Object;

/**
 * List data structure for APIObjects
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 *
 * @method APIObject findOneBy*() findOneBy*(string $searchString)
 * @method APIObject findOneLike*() findOneLike*(string $searchString)
 * @method APIObjectList selectBy*() selectBy*(string $searchString)
 * @method APIObjectList selectLike*() selectLike*(string $searchString)
 */
class APIObjectList implements \Iterator
{
  protected $objects = array();
  
  /**
   * @see Iterator::rewind()
   */
  public function rewind() {
    reset($this->objects);
  }

  /**
   * @see Iterator::current()
   */
  public function current() {
    return current($this->objects);
  }

  /**
   * @see Iterator::key()
   */
  public function key() {
    return key($this->objects);
  }

  /**
   * @see Iterator::next()
   */
  public function next() {
    return next($this->objects);
  }

  /**
   * @see Iterator::valid()
   */
  public function valid() {
    return isset($this->objects[key($this->objects)]);
  }
  
  /**
   * Add an objecto to the list
   * @param APIObject $object object to add
   */
  public function add (APIObject $object)
  {
    $this->objects[] = $object;
  }
  
  /**
   * Count the number of elements of the list
   * @return int number of elements into the list
   */
  public function count ()
  {
    return count($this->objects);
  }
  
  /**
   * Magic methods (implements findOneBy* && findOneLike*)
   */
  public function __call ($method, $args)
  {
    //select*
    $select = (substr($method, 0, 6) == 'select');
    //findOne*
    $find = (substr($method, 0, 7) == 'findOne');
    //*By*
    $by = (substr($method, ($find) ? 7 : 6, 2) == 'By');
    //*Like*
    $like = (substr($method, ($find) ? 7 : 6, 4) == 'Like');
    
    if (!$select && !$find || !$by && !$like) return $this->$method($args);
    
    //Calculate length
    $length = 0;
    $length = ($select && $by) ? 8 : $length;
    $length = ($select && $like) ? 10 : $length;
    $length = ($find && $by) ? 9 : $length;
    $length = ($find && $like) ? 11 : $length;
    
    //Real object method
    $objectMethod = 'get' . substr($method, $length);
    
    $return = ($select) ? new APIObjectList() : null;
    foreach ($this->objects as $object)
    {
      $str = $object->$objectMethod();
      //By
      if ($by)
      {
        if ($str == $args[0])
        {
          if ($select)
            $return->add($object);
          else
            return $object;
        }
      }
      //Like
      else
      {
        if (strpos($str, $args[0]) !== false)
          if ($select)
            $return->add($object);
          else
            return $object;
      }
    }
    return $return;
  }
}
