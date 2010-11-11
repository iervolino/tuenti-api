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
 * Hydrated class that represents a personal notifications in the TuentiAPI
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 *
 * @method int getNewProfileWallPosts() getNewProfileWallPosts()
 * @method void setNewProfileWallPosts() setNewProfileWallPosts(int $newProfileWallPosts)
 * @method int getAcceptedFriendRequests() getAcceptedFriendRequests()
 * @method void setAcceptedFriendRequests(int $acceptedFriendRequests)
 * @method int getNewTaggedPhotos() getNewTaggedPhotos()
 * @method void setNewTaggedPhotos() setNewTaggedPhotos(int $newTaggedPhotos)
 * @method int getUnreadFriendMessages() getUnreadFriendMessages()
 * @method void setUnreadFriendMessages() setUnreadFriendMessages(int $unreadFriendMessages)
 * @method int getUnreadSpamMessages() getUnreadSpamMessages()
 * @method void setUnreadSpamMessages() setUnreadSpamMessages(int $unreadSpamMessages)
 * @method int getNewFriendRequests() getNewFriendRequests()
 * @method void setNewFriendRequests() setNewFriendRequests(int $newFriendRequests)
 * @method int getNewPhotoWallPosts() getNewPhotoWallPosts()
 * @method void setNewPhotoWallPosts() setNewPhotoWallPosts(int $newPhotoWallPosts)
 * @method int getNewEventInvitations() getNewEventInvitations()
 * @method void setNewEventInvitations() setNewEventInvitations(int $newEventInvitations)
 * @method int getNewProfileWallComments() getNewProfileWallComments()
 * @method void setNewProfileWallComments() setNewProfileWallComments($newProfileWallComments)
 */
class PersonalNotifications extends APIObject
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
      'unread_friend_messages',
      'unread_spam_messages',
      'new_friend_requests',
      'new_photo_wall_posts',
      'new_event_invitations',
      'new_profile_wall_comments'
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
