<?php

namespace Core;

/**

  TODO:
  - COMMENT EVERYHING
  - make this much better
  - fix action to user if SHOW_ERRORS is not enabled

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

/**
 *
 * write errors or log errors based on config
 *
 */


  public static function exceptionHandler($exception) {
    if (\App\Config::SHOW_ERRORS) {
      echo "<h1>Fatal error</h1>";
      echo "<p>Uncaught exception :'" . get_class($exception) . "'</p>";
      echo "<p>Message: '" . $exception->getMessage() . "'</p>";
      echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
      echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
    } else {
      $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
      ini_set('error_log', $log);

      $message = "Uncaught exception :'" . get_class($exception) . "'";
      $message .= " with message '" . $exception->getMessage() . "'";
      $message .= "\nStack trace: " . $exception->getTraceAsString();
      $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

      error_log($message);
      echo "<h1>An internal error has occurred.</h1>";
    }
  }
}