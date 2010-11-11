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
 * Hydrated class that represents a user in the TuentiAPI
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 *
 * @method int setId() setId(int $id)
 * @method void getId() getId()
 * @method void setName() setName(string $name)
 * @method string getName() getName()
 * @method string getSurname() getSurname()
 * @method void setSurname() setSurname(string surname)
 * @method array getAvatar() getAvatar()
 * @method void setAvatar() setAvatar(string $avatar)
 * @method int getSex() getSex()
 * @method void setSex() setSex(int $sex)
 * @method string getPhoneNumber() getPhoneNumber()
 * @method void setPhoneNumber() setPhoneNumber(string $phoneNumber)
 * @method string getChatServer() getChatServer()
 * @method void setChatServer() setChatServer(string $chatServer)
 */
class User extends APIObject
{
  //Class constants
  const SEX_MALE = 1;
  const SEX_FEMALE = 2;
  
  /**
   * Get user albums
   * @param int $startPage starting page
   * @param int $numElementsPerPage number of elements per page
   * @return APIObjectList list of Album objects
   */
  public function getAlbums($startPage = 0, $numElementsPerPage = 10)
  {
    return $this->getConnection()->getUserAlbums($this->getId(), $startPage, $numElementsPerPage);
  }

  /**
   * Send a message to this user
   * @param string $message
   */
  public function sendMessage ($message)
  {
    return $this->getConnection()->sendMessage($this->getId(), $message);
  }

  /**
   * Get profile of the user
   * @return Profile profile
   */
  public function getProfile ()
  {
    return $this->getConnection()->getUserProfile($this->getId());
  }

  /**
   * Get wall posts and status of the user
   * @param int $startPage starting page
   * @param int $numElementsPerPage number of elements per page
   * @return Profile profile
   */
  public function getWallPostsAndStatus ($startPage = 0, $numElementsPerPage = 10)
  {
    return $this->getConnection()->getUserWallPostsAndStatus($this->getId(), $startPage, $numElementsPerPage);
  }

  /**
   * Overrided hydration method for build the structure of the object
   * @return array structure
   */
  public static function getStructure()
  {
    return array(
      'id',
      'name',
      'surname',
      'avatar',
      'sex',
      'phone_number',
      'chat_server',
    );
  }
  
  /**
   * String representation of the object
   * @return string value
   */
  public function __toString ()
  {
    return $this->getName() . ' ' . $this->getSurname();
  }
}
