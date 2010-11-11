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

namespace Kiwwito\TuentiAPI;

/**
 * Non official Tuenti API
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 * @version    0.8.0
 *
 * @TODO Add support for image upload
 * @TODO Add support for image tagging
 * @TODO Add support for event posts
 * @TODO Fix getPersonalNotifications, non-OOP method
 */
class Bundle
{
  protected $rc;
  
  /**
   * Conectar con tuenti
   * @param string $email email
   * @param string $password contraseña
   */
  public function __construct ($email, $password)
  {
    $this->rc = new RemoteCaller ($email, $password);
  }

  /**
   * Get all the friends of the current logged user
   * @return APIObjectList 
   */
  public function getFriends ()
  {
    //Call to the remote procedure
    $friends = $this->rc->getFriendsData(array(
      'fields' => array(
        'name',
        'surname',
        'avatar',
        'sex',
        'status',
        'phone_number',
        'chat_server'
      )
    ));
    
    //Hydration loop
    $return = new Object\APIObjectList();
    for ($i = 0; $i < count($friends); $i++)
    {
      $user = new Object\User();
      $user->hydrate($friends[$i]);
      $user->setConnection($this);
      $return->add($user);
    }
    return $return;
  }

  /**
   * Get the profile of the current logged user
   * @return Profile profile
   */
  public function getProfile ()
  {
    $sessionData = $this->rc->getSessionData();
    return $this->getMultipleProfiles($sessionData['user_id']);
  }

  /**
   * Get a specified user profile
   * @param int $userId user id wich will be used to obtain the profile
   * @return Profile profile
   */
  public function getUserProfile($userId)
  {
    return $this->getMultipleProfiles($userId);
  }

  /**
   * Get multiple profiles in one call
   * @param int $userId1 user id 1 to get his profile
   * @param int $userId2 user id 2 to get his profile
   * @param int $userId3 user id 3 to get his profile
   * @param ...
   * @return array profiless
   */
  public function getMultipleProfiles()
  {
    //Check the args
    $args = func_get_args();
    if (count($args) < 1)
    {
      throw new \Exception('You must specify de ID of the user to get his profile');
    }
    //Call to the remote procedures
    $profileData = current($this->rc->getUsersData(array(
      'ids' => $args,
      'fields' => array(
        'favorite_books',
        'favorite_movies',
        'favorite_music',
        'favorite_quotes',
        'hobbies',
        'website',
        'about_me_title',
        'about_me',
        'birthday',
        'city',
        'province',
        'name',
        'surname',
        'avatar',
        'sex',
        'status',
        'phone_number',
        'chat_server'
      )
    )));
    if (count($args) == 1)
    {
      $profileData = current($profileData);
    }
    
    $profile = new Object\Profile();
    $profile->hydrate($profileData);
    
    return $profile;
  }

  /**
   * Simple user hydration loop
   * @param array &$sourceArray source array
   * @param array &$destArray destiny array
   */
  protected function hydrateUsers (&$sourceArray, &$destArray)
  {
    $list = new Object\APIObjectList();
    for ($j = 0; $j < count($sourceArray); $j++)
    {
      $obj = new Object\User();
      $sourceArray[$j]['id'] = $sourceArray[$j]['user_id'];
      unset($sourceArray[$j]['user_id']);
      $obj->hydrate($sourceArray[$j]);
      $obj->setConnection($this);
      $list->add($obj);
    }
    $destArray = $list;
  }

  /**
   * Simple photo hydration loop
   * @param array &$sourceArray source array
   * @param array &$destArray destiny array
   */
  protected function hydratePhotos (&$sourceArray, &$destArray)
  {
    $list = new Object\APIObjectList();
    for ($j = 0; $j < count($sourceArray); $j++)
    {
      $obj = new Object\Photo();
      $sourceArray[$j]['id'] = $sourceArray[$j]['photo_id'];
      unset($sourceArray[$j]['photo_id']);
      $obj->hydrate($sourceArray[$j]);
      $obj->setConnection($this);
      $list->add($obj);
    }
    $destArray = $list;
  }

  /**
   * Get the personal notifications of the current logged user
   * @return PersonalNotifications profile
   */
  public function getPersonalNotifications ()
  {
    $notifications = $this->rc->getUserNotifications(array(
      'types' => array(
        'unread_friend_messages',
        'unread_spam_messages',
        'new_profile_wall_posts',
        'new_friend_requests',
        'accepted_friend_requests',
        'new_photo_wall_posts',
        'new_tagged_photos',
        'new_event_invitations',
        'new_profile_wall_comments'
      )
    ));
    $pNotif = new Object\PersonalNotifications();
    //Hydrate and remote call
    $pNotif->hydrate($notifications);
    return $pNotif;
  }

  /**
   * Get all friends (of the current logged user) public notifications
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (user notifications) per
   * page
   * @return array friends notifications
   */
  public function getFriendsPublicNotifications ($startPage = 0, $numElementsPerPage = 10)
  {
    //Remote call
    $notifications = current($this->rc->getFriendsNotifications(array(
      'page' => $startPage,
      'page_size' => $numElementsPerPage,
    )));
    
    //Hydration loop
    $return = new Object\APIObjectList();
    for ($i = 0; $i < count($notifications); $i++)
    {
      $uNotif = new Object\UserNotifications();
      $uNotif->hydrate($notifications[$i]);
      $notif = new Object\PublicNotifications();
      
      //New accepted friends hydration loop
      $this->hydrateUsers(
        $notifications[$i]['notifications']['accepted_friend_requests']['friends'],
        $notifications[$i]['notifications']['accepted_friend_requests']
      );
      
      //New tagged photos hydration loop
      $this->hydratePhotos(
        $notifications[$i]['notifications']['new_tagged_photos']['photos'],
        $notifications[$i]['notifications']['new_tagged_photos']
      );
      
      $notif->hydrate($notifications[$i]['notifications']);
      $uNotif->setNotifications($notif);
      $return->add($uNotif);
    }
    return $return;
  }

  /**
   * Get a list of inbox threads
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (threads) per page
   * @return array inbox threads
   */
  public function getInboxThreads ($startPage = 0, $numElementsPerPage = 10)
  {
    $inbox = $this->rc->getInbox(array(
      'page' => $startPage,
      'threads_per_page' => $numElementsPerPage,
    ));
    return $this->getThreads($startPage, $numElementsPerPage, $inbox);
  }

  /**
   * Get a list of sentbox threads
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (threads) per page
   * @return array sentbox threads
   */
  public function getSentboxThreads ($startPage = 0, $numElementsPerPage = 10)
  {
    $sentbox = $this->rc->getSentBox(array(
      'page' => $startPage,
      'threads_per_page' => $numElementsPerPage,
    ));
    return $this->getThreads($startPage, $numElementsPerPage, $sentbox);
  }

  /**
   * Get a list of spambox threads
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (threads) per page
   * @return array spambox threads
   */
  public function getSpamboxThreads ($startPage = 0, $numElementsPerPage = 10)
  {
    $spambox = $this->rc->getSpamBox(array(
      'page' => $startPage,
      'threads_per_page' => $numElementsPerPage,
    ));
    return $this->getThreads($startPage, $numElementsPerPage, $spambox);
  }

  /**
   * Generic/auxiliar for get threads methods
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (threads) per page
   * @return array box threads
   */
  protected function getThreads ($startPage, $numElementsPerPage, &$box)
  {
    $threads = $box['threads'];
    
    //Hydration loop
    $return = new Object\APIObjectList();
    for ($i = 0; $i < count($threads); $i++)
    {
      $thread = new Object\Thread();
      $thread->hydrate($threads[$i]);
      $thread->setConnection($this);
      
      $user = new Object\User();
      $user->hydrate($threads[$i]['counter_part']);
      $user->setConnection($this);
      
      $thread->setCounterPart($user);
      $return->add($thread);
    }
    return $return;
  }

  /**
   * Get all the messages of a thread
   * @param int $threadKey thread key
   * @return array messages
   */
  public function getThreadMessages ($threadKey, $startPage = 0, $numElementsPerPage = 10)
  {
    $messages = $this->rc->getThread(array(
      'thread_key' => $threadKey,
      'page' => $startPage,
      'messages_per_page' => $numElementsPerPage,
    ));
    $messages = $messages['messages'];
    
    //Hydration loop
    $return = new Object\APIObjectList();
    for ($i = 0; $i < count($messages); $i++)
    {
      $message = new Object\Message();
      $message->hydrate($messages[$i]);
      $message->setConnection($this);
      $return->add($message);
    }
    
    return $return;
  }

  /**
   * Send a message to a specified user
   * @param int $toUserId identifier of the user that will recieve it
   * @param string $message the message to send
   */
  public function sendMessage ($toUserId, $message)
  {
    $this->rc->sendMessage(array(
      'recipient' => $toUserId,
      'body' => $message
    ));
  }

  /**
   * Send a message to a specified user with a thread context
   * @param int $toUserId identifier of the user that will recieve it
   * @param int $threadKey thread context identifier for the message
   * @param string $message the message to send
   */
  public function sendThreadMessage ($toUserId, $threadKey, $message)
  {
    $this->rc->sendMessage(array(
      'recipient' => $toUserId,
      'thread_key' => $threadKey,
      'body' => $message
    ));
  }

  /**
   * Get current user albums
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (albums) per page
   * @return array albums
   */
  public function getAlbums ($startPage = 0, $numElementsPerPage = 10)
  {
    $sessionData = $this->rc->getSessionData();
    return $this->getUserAlbums($sessionData['user_id'], $startPage, $numElementsPerPage);
  }

  /**
   * Get albums from a specified user
   * @param int $userId the user to extract the albums
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (albums) per page
   * @return array albums
   */
  public function getUserAlbums ($userId, $startPage = 0, $numElementsPerPage = 10)
  {
    $albums = $this->rc->getUserAlbums(array(
      'user_id' => $userId,
      'page' => $startPage,
      'albums_per_page' => $numElementsPerPage
    ));
    
    //Hydration loop
    $return = new Object\APIObjectList();
    foreach ($albums as $key => $albumData)
    {
      $album = new Object\Album();
      $album->hydrate($albumData);
      //Save de ID
      $album->setId($key);
      //Set the connection
      $album->setConnection($this);
      $return->add($album);
      
      //Free memory
      unset($albums[$key]);
    }
    return $return;
  }

  /**
   * Get 20 photos (API limited) from album
   * @param int $albumId id of the album
   * @param int $startPage page to start
   * @return array photos
   */
  public function getAlbumPhotos ($albumId, $startPage = 0)
  {
    $sessionData = $this->rc->getSessionData();
    $photos = current($this->rc->getAlbumPhotos(array(
      'album_id' => $albumId,
      'user_id' => $sessionData['user_id'],
      'page' => $startPage
    )));
    
    //Hydration loop
    $return = new Object\APIObjectList();
    for ($i = 0; $i < count($photos); $i++)
    {
      $photo = new Object\Photo();
      $photo->hydrate($photos[$i]);
      //Set the connection
      $photo->setConnection($this);
      $return->add($photo);
    }
    return $return;
  }

  /**
   * Get all tags of a selected photo
   * @param int $photoId photo identifier
   * @param array tags
   */
  public function getPhotoTags ($photoId)
  {
    $tags = $this->rc->getPhotoTags(array(
      'photo_id' => $photoId
    ));
    
    //Hydration loop
    $return = new Object\APIObjectList();
    for ($i = 0; $i < count($tags); $i++)
    {
      $tag = new Object\Tag();
      $tag->hydrate($tags[$i]);
      //Set the connection
      $tag->setConnection($this);

      //Save the user
      $user = new Object\User();
      $user->hydrate($tags[$i]['user']);
      //Set the connection
      $user->setConnection($this);
      $tag->setUser($user);

      //Save the tagger (user)
      $tagger = new Object\User();
      $tagger->hydrate($tags[$i]['tagger']);
      //Set the connection
      $tagger->setConnection($this);
      $tag->setTagger($tagger);
      
      $return->add($tag);
    }
    return $return;
  }

  /**
   * Add a post to the selected photo wall
   * @param int $photoId photo identifier
   * @param string $message body
   */
  public function addPostToPhotoWall ($photoId, $message)
  {
    $this->rc->addPostToPhotoWall(array(
      'photo_id' => $photoId,
      'body' => $message
    ));
  }

  /**
   * Get all wall posts and statuses stablished in the past
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (posts) per page
   * @return array posts
   */
  public function getWallPostsAndStatus ($startPage = 0, $numElementsPerPage = 10)
  {
    $sessionData = $this->rc->getSessionData();
    return $this->getUserWallPostsAndStatus($sessionData['user_id'], $startPage, $numElementsPerPage);
  }

  /**
   * Get all wall posts and statuses stablished in the past of a specified user
   * @param int $userId user identifier
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (posts) per page
   * @return array posts
   */
  public function getUserWallPostsAndStatus ($userId, $startPage = 0, $numElementsPerPage = 10)
  {
    
    $posts = $this->rc->getProfileWallWithStatus(array(
      'user_id' => $userId,
      'page' => $startPage,
      'page_size' => $numElementsPerPage
    ));
    $posts = $posts['posts'];
    
    //Hydration loop
    $return = new Object\APIObjectList();
    for ($i = 0; $i < count($posts); $i++)
    {
      $post = new Object\Post();
      $post->hydrate($posts[$i]);
      
      //If the post have comments
      $comments = new Object\APIObjectList();
      if (isset($posts[$i]['comments']['preview']))
      {
        //Hydration loop for comments
        for ($j = 0; $j < count($posts[$i]['comments']['preview']); $j++)
        {
          $subPost = new Object\Post();
          $subPost->hydrate($posts[$i]['comments']['preview'][$j]);
          //Set the connection
          $subPost->setConnection($this);
          
          $comments->add($subPost);
        }
      }
      $post->setComments($comments);
      $post->setConnection($this);
      $return->add($post);
    }
    return $return;
  }

  /**
   * Hydration loop for comments
   * @param array &$data source data
   * @return array hydrated comments objects array
   */
  protected function hydrateComments (&$data)
  {
    //Hydration loop
    $return = new Object\APIObjectList();
    for ($i = 0; $i < count($data); $i++)
    {
      $comment = new Object\Comment();
      $comment->hydrate($data[$i]);
      $author = new Object\User();
      $author->hydrate($data[$i]['author']);
      $comment->setAuthor($author);
      $return->add($comment);
    }
    return $return;
  }

  /**
   * Get posts from a given photo
   * @param int $photoId photo id
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (comments) per page
   * @return array posts
   */
  public function getPhotoWallComments ($photoId, $startPage = 0, $numElementsPerPage = 10)
  {
    $comments = $this->rc->getPhotoWall(array(
      'photo_id' => $photoId,
      'page' => $startPage,
      'post_per_page' => $numElementsPerPage
    ));
    
    //Hydration
    return $this->hydrateComments($comments['posts']);
  }

  /**
   * Change the status to a new one
   * @param string $newStatus
   */
  public function setStatus ($newStatus)
  {
    $this->rc->setUserData(array(
      'status' => $newStatus
    ));
  }

  /**
   * Get upcoming events
   * @param int $numberOfElements number of events to get
   * @param boolean $includeBirthdays true if you want to get the birthdays too
   * @return events array
   */
  public function getEvents ($numberOfElements = 10, $includeBirthdays = false)
  {
    $events = $this->rc->getUpcomingEvents(array(
      'desired_number' => $numberOfElements,
      'include_friend_birthdays' => $includeBirthdays
    ));
    $events = $events['list'];
    
    //Hydration loop
    $return = new Object\APIObjectList();
    for ($i = 0; $i < count($events); $i++)
    {
      $obj = ($events[$i]['type'] == 0) ? new Object\BirthdayEvent() : new Object\UsualEvent();
      $obj->hydrate($events[$i]);
      $obj->setConnection($this);
      $return->add($obj);
    }
    return $return;
  }

  /**
   * Retrieve the full data of a given event
   * @param int $eventId the event identifier
   * @return UsualEvent
   */
  public function getUsualEvent ($eventId)
  {
    $eventData = $this->rc->getEvent(array(
      'event_id' => $eventId
    ));
    
    $event = new Object\UsualEvent();
    $event->hydrate($eventData);
    $event->setConnection($this);
    
    //Save the creator (user) object
    $creator = new Object\User();
    $creator->hydrate($eventData['creator']);
    $creator->setConnection($this);
    
    //Save the invitor (user) object
    $inviter = new Object\User();
    $inviter->hydrate($eventData['inviter']);
    $inviter->setConnection($this);
    
    //Save into the event
    $event->setCreator($creator);
    $event->setInviter($inviter);
    //Save event type
    $event->setType(Object\Event::USUAL_EVENT);
    return $event;
  }

  /**
   * Get wall comments from a given event ID
   * @param int $eventId event identifier
   * @param int $startPage the start page of elements
   * @param int $numElementsPerPage number of elements (comments) per page
   */
  public function getUsualEventWallComments ($eventId, $startPage = 0, $numElementsPerPage = 10)
  {
    $posts = $this->rc->getEventWall(array(
      'event_id' => $eventId,
      'page' => $startPage,
      'posts_per_page' => $numElementsPerPage
    ));
    
    //Hydration
    return $this->hydrateComments($posts['posts']);
  }
}
