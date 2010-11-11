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
define ('PHOTOS_PER_PAGE', 20);
define ('DOWNLOAD_PATH', dirname(__FILE__) . '/Albums/');
define ('EVER_OVERWRITE', false);

/**
 * Script that saves all of your albums (and photos) into a selected folder
 * This script is ready to be executed through the command line.
 *
 * @author     Keyvan Akbary <keyvan@kiwwito.com>
 * @copyright  Copyright (c) 2010, Keyvan Akbary
 * @package    TuentiAPI
 */
try
{
  $tapi = new Kiwwito\TuentiAPI\Bundle (TUENTI_USERNAME, TUENTI_PASSWORD);
  
  //Create photos album
  if (!file_exists(DOWNLOAD_PATH))
  {
    mkdir (DOWNLOAD_PATH);
  }
  
  //Save albums loop
  foreach ($tapi->getAlbums() as $album)
  {
    //Create album folder (if not exists)
    if (!file_exists(DOWNLOAD_PATH . $album->getName()))
    {
      mkdir (DOWNLOAD_PATH . $album->getName());
    }
    
    echo 'Size (' . $album->getName() . '): ' . $album->getSize() . "\n";
    //Save loop
    $j = 1;
    for ($i = 0; $i < $album->getSize(); $i = $i+PHOTOS_PER_PAGE)
    {
      echo 'Page ' . floor($i/PHOTOS_PER_PAGE) . ', photos ' . $i . "\n";
      foreach ($album->getPhotos(floor($i/PHOTOS_PER_PAGE)) as $photo)
      {
        $savePath = DOWNLOAD_PATH . $album->getName() . '/' . basename($photo->getPhotoUrl600());
        
        //Only save if the file not exist
        if (EVER_OVERWRITE || !file_exists($savePath))
        {
          file_put_contents($savePath, file_get_contents($photo->getPhotoUrl600()));
          echo 'Saved: ' . basename($photo->getPhotoUrl600()) . ' (' . $j . ') [' . $savePath .']' . "\n";
        }
        
        $j++;
      }
    }
  }
}
catch (Exception $e)
{
  echo 'An error have ocurred during execution: ' . $e->getMessage();
}
