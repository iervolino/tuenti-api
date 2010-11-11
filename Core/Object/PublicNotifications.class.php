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
 * Hydrated class that represents a public notifications in the TuentiAPI
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 *
 * @method int getNewProfileWallPosts() getNewProfileWallPosts()
 * @method void setNewProfileWallPosts() setNewProfileWallPosts(int $newProfileWallPosts)
 * @method int getNewAcceptedFriendRequests() getNewAcceptedFriendRequests()
 * @method void setNewAcceptedFriendRequests() setNewAcceptedFriendRequests(int $newAcceptedFriendRequests)
 * @method int getNewTaggedPhotos() getNewTaggedPhotos()
 * @method void setNewTaggedPhotos() setNewTaggedPhotos(int $newTaggedPhotos)
 * @method int getNewCommentsOnStatus() getNewCommentsOnStatus()
 * @method void setNewCommentsOnStatus() setNewCommentsOnStatus(int $newCommentsOnStatus)
 */
class PublicNotifications extends APIObject
{
  /**
   * Overrided hydration method for build the structure of the object
   * @return array structure
   */
  public static function getStructure()
  {
    return array(
      'new_profile_wall_posts',
      'accepted_friend_requests',
      'new_tagged_photos',
      'new_comments_on_status'
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
