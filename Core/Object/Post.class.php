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
 * Hydrated class that represents a post in the TuentiAPI
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    1.0.0
 *
 * @method int getType() getType()
 * @method void setType() setType(int $type)
 * @method int getPostId() getPostId()
 * @method void setPostId() setPostId(int $postId)
 * @method int getAuthor() getAuthor()
 * @method void setAuthor() setAuthor(int $author)
 * @method string getBody() getBody()
 * @method void setBody() setBody(string $body)
 * @method int getTime() getTime()
 * @method void setTime() setTime(int $time)
 * @method int getApplicationId() getApplicationId()
 * @method void setApplicationId() setApplicationId(int $applicationId)
 * @method boolean getCanReply() getCanReply()
 * @method void setCanReply() setCanReply(boolean $canReply)
 * @method boolean getCanDelete() getCanDelete()
 * @method void setCanDelete() setCanDelete(boolean $canDelete)
 * @method array getParent() getParent()
 * @method void setParent() setParent(array $parent)
 * @method APIObjectList getComments() getComments()
 * @method void setComments() setComments(APIObjectList $comments)
 * @method boolean getIsNew() getIsNew()
 * @method void setIsNew() setIsNew(boolean $isNew)
 * @method Profile getAuthorProfile() getAuthorProfile()
 */
class Post extends APIObject
{
  const POST_TYPE = 2;
  const STATUS_TYPE = 1;
  
  const IPHONE_APP = 0;
  const WEB_APP = 4;
  
  /**
   * Get the profile of the author of the post
   * @return Profile
   */
  public function getAuthorProfile ()
  {
    return $this->getConnection()->getUserProfile($this->getAuthor());
  }
  
  /**
   * Overrided hydration method for build the structure of the object
   * @return array structure
   */
  public static function getStructure()
  {
    return array(
      'type',
      'post_id',
      'author',
      'body',
      'time',
      'application_id',
      'can_reply',
      'can_delete',
      'parent',
      'comments',
      'is_new'
    );
  }
  
  /**
   * String representation of the object
   * @return string value
   */
  public function __toString ()
  {
    return $this->getBody();
  }
}
