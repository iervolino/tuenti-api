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
 * Hydrated class that represents a photo tag in the TuentiAPI
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 *
 * @method User getUser() getUser()
 * @method void setUser() setUser(User $user)
 * @method User getTagger() getTagger()
 * @method void setTagger() setTagger(User $user)
 * @method int getTime() getTime()
 * @method void setTime() setTime(int $time)
 * @method array getCoordinates() getCoordinates()
 * @method void setCoordinates() setCoordinates(array $coordinates)
 * @method boolean getCanEdit() getCanEdit()
 * @method void setCanEdit() setCanEdit(boolean $canEdit)
 */
class Tag extends APIObject
{

  /**
   * Overrided hydration method for build the structure of the object
   * @return array structure
   */
  public static function getStructure()
  {
    return array(
      'user',
      'tagger',
      'time',
      'coordinates',
      'can_edit'
    );
  }
  
  /**
   * String representation of the object
   * @return string value
   */
  public function __toString ()
  {
    return '';
  }
}
