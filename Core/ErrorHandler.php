<?php

/**
 * Core ErrorHandler
 *
 * @version PHP 7
 *
 * @package COREphp
 * @author John Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace Core;

class ErrorHandler
{
    /**
     * Convert erros to Exceptions by throwing \ErrorException
     *
     * @param int    $level   - error level
     * @param string $message - error message
     * @param string $file    - filename the error was raised in
     * @param int    $line    - line number in the file
     *
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Handles exceptions - including default HTTP status codes
     *
     * @param $exception - the exception
     *
     * @return void
     *
     */
    public static function exceptionHandler($exception)
    {
        // set default HTTP code to 500 (404 handled in the Core Router)
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);

        // if ERROR_DISPLAY = debug (debug mode) then print error text on the page
        if ($_ENV['ERROR_DISPLAY'] = 'debug') {
            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception :'" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
        } else {
            // if ERROR_DISPLAY != debug (prod mode) then write the errors to the logs/ directory
            // render the corresponding twig template for the HTTP status code returned
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
