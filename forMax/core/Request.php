<?php

/**
 * Helper class providing static methods for handling, cleaning, etc.
 * a request uri
 */
class Request
{
  public static function uri()
  {
    // trim: strip whitespace (or other characters) from the beginning
    // and end of a string
    return trim($_SERVER['REQUEST_URI'],'/');
  }
}
