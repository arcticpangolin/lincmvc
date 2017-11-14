<?php

/**
 *
 * Core ErrorHandler
 * PHP 7
 * Written by John Lincoln 2017
 */

namespace Core;

/**

  TODO:
  - COMMENT EVERYHING
  - make this much better
  - fix action to user if SHOW_ERRORS is not enabled

 */

class ErrorHandler
{

  /**
   *
   * Fcuntion errorHandler
   * convert erros to Exceptions by throwing \ErrorException
   * 
   * @param int $level - error level
   * @param string $message - error message
   * @param string $file - filename the error was raised in
   * @param int $line - line number in the file
   *
   * @return void
   */
  
  public static function errorHandler($level, $message, $file, $line) {
    if (error_reporting() !== 0) {
      throw new \ErrorException($message, 0, $level, $file, $line);
    }
  }

  /**
   *
   * Function exceptionHandler
   * handle exceptions - including default HTTP status codes
   *
   * @param $exception - the exception
   * 
   * @return void
   *
   */

  public static function exceptionHandler($exception) {
    
    $code = $exception->getCode();
    if ($code != 404) {
      $code = 500;
    }

    http_response_code($code);

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

      View::renderTemplate("Errors/$code.twig");
    }
  }
}