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
 * Hydrated class that represents a Profile object in the TuentiAPI package
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
 * @method void setSurname() setSurname(string $surname)
 * @method array getAvatar() getAvatar()
 * @method void setAvatar() setAvatar(string $avatar)
 * @method int getSex() getSex()
 * @method void setSex() setSex(int $sex)
 * @method string getPhoneNumber() getPhoneNumber()
 * @method void setPhoneNumber() setPhoneNumber(string $phoneNumber)
 * @method string getChatServer() getChatServer()
 * @method void setChatServer() setChatServer(string $chatServer)
 * @method string getFavoriteBooks() getFavoriteBooks()
 * @method void setFavoriteBooks() setFavoriteBooks(string $favoriteBooks)
 * @method string getFavoriteMovies() getFavoriteMovies()
 * @method void setFavoriteMovies() setFavoriteMovies(string $favoriteMovies)
 * @method string getFavoriteMusic() getFavoriteMusic()
 * @method void setFavoriteMusic() setFavoriteMusic(string $favoriteMusic)
 * @method string getFavoriteQuotes() getFavoriteQuotes()
 * @method void setFavoriteQuotes() setFavoriteQuotes(string $favoriteQuotes)
 * @method string getHobbies() getHobbies()
 * @method void setHobbies() setHobbies(string $hobbies)
 * @method string getWebsite() getWebsite()
 * @method void setWebsite() setWebsite(string $website)
 * @method string getAboutMeTitle() getAboutMeTitle()
 * @method void setAboutMeTitle() setAboutMeTitle(string $aboutMeTitle)
 * @method string getAboutMe() getAboutMe()
 * @method void setAboutMe() setAboutMe(string $aboutMe)
 * @method string getBirthday() getBirthday()
 * @method void setBirthday() setBirthday(string $birthday)
 * @method string getCity() getCity()
 * @method void setCity() setCity(string $city)
 * @method string getProvince() getProvince()
 * @method void setProvince() setProvince(string $province)
 * @method string getStatus() getStatus()
 * @method void setStatus() setStatus(string $status)
 * @method void sendMessage() sendMessage(string $message)
 * @method Profile getProfile() getProfile()
 */
class Profile extends User
{
  /**
   * Overrided hydration method for build the structure of the object
   * @return array structure
   */
  public static function getStructure ()
  {
    return array_merge(
      parent::getStructure(),
      array(
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
        'status',
        'province'
      )
    );
  }

  /**
   * String representation of the object
   * @return string value
   */
  public function __toString ()
  {
    return $this->getStatus();
  }
}
