<?php

namespace Core;

/**

  TODO:
  - COMMENT EVERYHING
  - make this much better

 */


/**
* base error handler
*/
class ErrorHandler
{
  public static function errorHandler($level, $message, $file, $line) {
    if (error_reporting() !== 0) {
      throw new \ErrorException($message, 0, $level, $file, $line);
    }
  }

  public static function exceptionHandler($exception) {
    echo "<h1>Fatal error</h1>";
    echo "<p>Uncaught exception :'" . get_class($exception) . "'</p>";
    echo "<p>Message: '" . $exception->getMessage() . "'</p>";
    echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
    echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
  }
}