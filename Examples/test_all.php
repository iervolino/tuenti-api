<?php

// Example of how-to-use Kiwwito's TuentiAPI
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

include dirname(__FILE__) . '/../Core/autoloader.php';

//Script configuration, change to yours in order to login correctly
define ('TUENTI_USERNAME', 'user@example.com');
define ('TUENTI_PASSWORD', 'password');

/**
 * Script for test some TuentiAPI methods. Uncomment to test whatever you want.
 * This script is ready to be executed through the command line.
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 */
try
{
  //Put your user/password in order to login into Tuenti
  $tapi = new Kiwwito\TuentiAPI\Bundle (TUENTI_USERNAME, TUENTI_PASSWORD);

  /*
  //Get posts and states from the wall
  foreach ($tapi->getWallPostsAndStatus() as $post)
    echo $post . "\n";
  */

  //Change status
  //$tapi->setStatus('API Status Test');

  /*
  //Get friend list
  //print_r($tapi->getFriends());
  //Filtering by chat server
  foreach ($tapi->getFriends()->selectByChatServer('xmpp9.tuenti.com') as $friend)
    echo $friend . "\n";
  */
  
  //Get profile
  //print_r($tapi->getProfile());

  //Get profile of the first user in our friend list
  //print_r($tapi->getFriends()->current()->getProfile());
  
  //Get personal notifications
  //print_r($tapi->getPersonalNotifications());
  
  /*
  //Get friend public notifications
  foreach ($tapi->getFriendsPublicNotifications() as $friendPublicNotification)
    echo $friendPublicNotification . "\n";
  */
  
  //Get inbox threads
  //print_r($tapi->getInboxThreads());
  
  //Get sentbox threads
  //print_r($tapi->getSentboxThreads());
  
  //Get spambox threads
  //print_r($tapi->getSpamboxThreads());
  
  /*
  //Get messages of the first thread
  print_r($tapi->getInboxThreads()->current()->getMessages());
  //We can also get the profile of the sender of the first message
  //print_r($tapi->getInboxThreads()->current()->getMessages()->current()->getSenderProfile());
  */

  //Send a message related with a thread and user
  //$tapi->getInboxThreads()->current()->sendMessage('API test');

  //Send a message to the first user
  //$tapi->getFriends()->current()->sendMessage('API test');
  
  //Get photo albums
  //foreach ($tapi->getAlbums() as $album) echo $album . "\n";
  
  /*
  //Obtener las fotos de un album
  foreach ($tapi->getAlbums()->current()->getPhotos() as $photo)
    echo $photo->getPhotoUrl200() . "\n";
  */
  
  //Get the profile of the user wich is the author of the first post in our wall
  //print_r($tapi->getWallPostsAndStatus()->current()->getAuthorProfile());
  
  //Get tags of the first photo of the first album
  //print_r($tapi->getAlbums()->current()->getPhotos()->current()->getTags());
  
  //Add a comment to the first photo of the first album
  //$tapi->getAlbums()->current()->getPhotos()->current()->addPostToWall('API test');
  
  
  //Get the comments of the first photo of the first album
  //print_r($tapi->getAlbums()->current()->getPhotos()->current()->getWallComments());
  
  //Get non birthday events
  //print_r($tapi->getEvents());
  //Get events (with birthdays included)
  //print_r($tapi->getEvents(10, true));
  
  /*
  //Get information of the first event
  $event = $tapi->getEvents()->current();
  $event->load();
  print_r($event);
  */
  
  //Get comments of the first event
  //print_r($tapi->getEvents()->current()->getWallComments());
}
catch (Exception $e)
{
  echo 'An error have ocurred during execution: ' . $e->getMessage();
}
