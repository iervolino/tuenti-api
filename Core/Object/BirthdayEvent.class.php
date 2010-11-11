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
 * Hydrated class that represents a BirthdayEvent object in the TuentiAPI
 * package
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 *
 * @method int getUserId() getUserId()
 * @method void setUserId() setUserId(int $userId)
 * @method string getUserName() getUserName()
 * @method void setUserName() setUserName(string $userName)
 * @method int getAge() getAge()
 * @method void setAge() setAge(int $age)
 * @method array getAvatar() getAvatar()
 * @method void setAvatar() setAvatar(string $avatar)
 */
class BirthdayEvent extends Event
{
  /**
   * Get the user profile of the BirthdayEvent
   * @return Profile
   */
  public function getUserProfile()
  {
    return $this->getConnection()->getUserProfile($this->getUserId());
  }
  
  /**
   * Overrided hydration method for build the structure of the object
   * @return array structure
   */
  public static function getStructure()
  {
    return array_merge(
      parent::getStructure(),
      array(
        'user_id',
        'user_name',
        'age',
        'avatar'
      )
    );
  }
  
  /**
   * String representation of the object
   * @return string value
   */
  public function __toString ()
  {
    return $this->getUserName();
  }
}
