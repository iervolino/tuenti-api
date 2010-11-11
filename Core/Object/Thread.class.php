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
 * Hydrated class that represents a thread of messages in the TuentiAPI
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 *
 * @method string getKey() getKey()
 * @method void setKey() setKey(string $key)
 * @method int getTotalMessages() getTotalMessages()
 * @method void setTotalMessages() setTotalMessages(int $totalMessages)
 * @method int getUnreadMessages() getUnreadMessages()
 * @method void setUnreadMessages() setUnreadMessages(int $unreadMessages)
 * @method int getLastTime() getLastTime()
 * @method void setLastTime() setLastTime(int $lastTime)
 * @method string getPreview() getPreview()
 * @method void setPreview() setPreview(string $preview)
 * @method int getCounterPart() getCounterPart()
 * @method void setCounterPart() setCounterPart(int $counterPart)
 */
class Thread extends APIObject
{
  /**
   * Get thread messages
   * @param int $startPage
   * @param int $numElementsPerPage
   * @return APIObjectList
   */
  public function getMessages($startPage = 0, $numElementsPerPage = 10)
  {
    return $this->getConnection()->getThreadMessages($this->getKey(), $startPage, $numElementsPerPage);
  }

  /**
   * Send a message related with the thread
   * @param string $message
   */
  public function sendMessage($message)
  {
    $this->getConnection()->sendThreadMessage(
      $this->getCounterPart()->getId(),
      $this->getKey(),
      $message
    );
  }

  /**
   * Overrided hydration method for build the structure of the object
   * @return array structure
   */
  public static function getStructure()
  {
    return array(
      'key',
      'total_messages',
      'unread_messages',
      'last_time',
      'preview',
      'counter_part'
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
