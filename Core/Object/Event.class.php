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
 * Hydrated class that represents an Event in the TuentiAPI package
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 *
 * @method int getType() getType()
 * @method void setType() setType(int $type)
 * @method int getTimestamp() getTimestamp()
 * @method void setTimestamp() setTimestamp(int $timestamp)
 */
class Event extends APIObject
{
  const USUAL_EVENT = 1;
  const BIRTHDAY_EVENT = 0;
  /**
   * Overrided hydration method for build the structure of the object
   * @return array structure
   */
  public static function getStructure()
  {
    return array(
      'type',
      'timestamp'
    );
  }
  
  /**
   * String representation of the object
   * @return string value
   */
  public function __toString ()
  {
    return $this->getType();
  }
}
