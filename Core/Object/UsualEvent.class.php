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
 * Hydrated class that represents a UsualEvent object in the TuentiAPI package
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 *
 * @method int getId() getId()
 * @method void setId() setId(int $id)
 * @method string getName() getName()
 * @method void setName() setName(string $name)
 * @method boolean getAllDay() getAllDay()
 * @method void setAllDay() setAllDay(bollean $allDay)
 * @method string getAvatarUrl() getAvatarUrl()
 * @method void setAvatarUrl() setAvatarUrl(string $avatarUrl)
 * @method string getDescription() getDescription()
 * @method void setDescription() setDescription(string $description)
 * @method string getAddress() getAddress()
 * @method void setAddress() setAddress(string $address)
 * @method string getPlace() getPlace()
 * @method void setPlace() setPlace(string $place)
 * @method string getPhoneNumber() getPhoneNumber()
 * @method void setPhoneNumber() setPhoneNumber(string $phoneNumber)
 * @method string getWebpage() getWebpage()
 * @method void setWebpage() setWebpage(string $webpage)
 * @method int getAttendingCount() getAttendingCount()
 * @method void setAttendingCount() setAttendingCount(int $attendingCount)
 * @method int getMaybeAttendingCount() getMaybeAttendingCount()
 * @method void setMaybeAttendingCount() setMaybeAttendingCount(int $maybeAttendingCount)
 * @method int getNotAttendingCount() getNotAttendingCount()
 * @method void setNotAttendingCount() setNotAttendingCount(int $notAttendingCount)
 * @method string getRsvp() getRsvp()
 * @method void setRsvp() setRsvp(string $rsvp)
 * @method boolean getHasWall() getHasWall()
 * @method void setHasWall() setHasWall(boolean $hasWall)
 * @method boolean getNotDecidedCount() getNotDecidedCount()
 * @method void setNotDecidedCount() setNotDecidedCount(boolean $notDecidedCount)
 * @method User getCreator() getCreator()
 * @method void setCreator() setCreator(User $creator)
 * @method User getInviter() getInviter()
 * @method void setInviter() setInviter(User $inviter)
 */
class UsualEvent extends Event
{
  /**
   * Auto hydrate the object
   */
  public function load ()
  {
    $this->hydrate($this->getConnection()->getUsualEvent($this->getId())->toArray());
  }
  
  /**
   * Get UsualEvent wall comments
   * @return array
   */
  public function getWallComments ($startPage = 0, $numElementsPerPage = 10)
  {
    return $this->getConnection()->getUsualEventWallComments($this->getId(), $startPage, $numElementsPerPage);
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
        'id',
        'name',
        'all_day',
        'avatar_url',
        'description',
        'address',
        'place',
        'phone_number',
        'webpage',
        'attending_count',
        'maybe_attending_count',
        'not_attending_count',
        'rsvp',
        'has_wall',
        'not_decided_count',
        'creator',
        'inviter'
      )
    );
  }
  
  /**
   * String representation of the object
   * @return string value
   */
  public function __toString ()
  {
    return $this->getName();
  }
}
