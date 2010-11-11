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
 * @method int getId() getId()
 * @method void setId() setId(int $id)
 * @method string getTitle() getTitle()
 * @method void setTitle() setTitle(string $title)
 * @method string getPhotoUrl() getPhotoUrl100()
 * @method void setPhotoUrl() setPhotoUrl100(string $photoUrl100)
 * @method string getPhotoUrl200() getPhotoUrl200()
 * @method void setPhotoUrl200() setPhotoUrl200(string $photoUrl200)
 * @method string getPhotoUrl600() getPhotoUrl600()
 * @method void setPhotoUrl600() setPhotoUrl600(string $photoUrl600)
 * @method boolean getCanEditTitle() getCanEditTitle()
 * @method void setCanEditTitle() setCanEditTitle(boolean $canEditTitle)
 * @method boolean getCanTag() getCanTag()
 * @method void setCanTag() setCanTag(boolean $canTag)
 * @method boolean getCanSeeProfile() getCanSeeProfile()
 * @method void setCanSeeProfile() setCanSeeProfile(boolean $canSeeProfile)
 * @method boolean getCanSeeWall() getCanSeeWall()
 * @method void setCanSeeWall() setCanSeeWall(boolean $canSeeWall)
 * @method boolean getCanDownload() getCanDownload()
 * @method void setCanDownload() setCanDownload(boolean $canDownload)
 * @method int getNumNewWallPosts() getNumNewWallPosts()
 * @method void setNumNewWallPosts() setNumNewWallPosts(int $numNewWallPosts)
 * @method boolean getEmptyWall() getEmptyWall()
 * @method void setEmptyWall() setEmptyWall(boolean $emptyWall)
 */
class Photo extends APIObject
{
  /**
   * Get photo comments
   * @return APIObjectList
   */
  public function getWallComments ()
  {
    return $this->getConnection()->getPhotoWallComments($this->getId());
  }
  
  /**
   * Post to photo wall
   */
  public function addPostToWall ($message)
  {
    return $this->getConnection()->addPostToPhotoWall($this->getId(), $message);
  }

  /**
   * Get photo tags
   * @return APIObjectList
   */
  public function getTags ()
  {
    return $this->getConnection()->getPhotoTags($this->getId());
  }

  /**
   * Overrided hydration method for build the structure of the object
   * @return array structure
   */
  public static function getStructure()
  {
    return array(
      'id',
      'title',
      'photo_url_100',
      'photo_url_200',
      'photo_url_600',
      'can_edit_title',
      'can_tag',
      'can_see_profile',
      'can_see_wall',
      'can_download',
      'num_new_wall_posts',
      'empty_wall'
    );
  }
  
  /**
   * String representation of the object
   * @return string value
   */
  public function __toString ()
  {
    return $this->getPhotoUrl600();
  }
}
