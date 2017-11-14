<?php

namespace App;

/**

  TODO:
  - app configs
  - cleanup / comment / move sensitive stuff to .env
  - https://github.com/vlucas/phpdotenv - for .env implementation

 */

/**
* config class
*/
class Config
{
  /**
  
    TODO:
    - comment all of these emelemts
    - move to .env
  
   */
  const DB_HOST = 'localhost';
  const DB_NAME = 'mvc';
  const DB_USER = 'root';
  const DB_PASSWORD = 'root';
  const SHOW_ERRORS = true;
}