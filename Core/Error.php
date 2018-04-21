<?php

namespace Core;

use \Core\View,
    Mailgun\Mailgun;

/**
 * Error and exception handler
 */
class Error {

    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level  Error level
     * @param string $message  Error message
     * @param string $file  Filename the error was raised in
     * @param int $line  Line number in the file
     *
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line) {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler.
     *
     * @param Exception $exception  The exception
     *
     * @return void
     */
    public static function exceptionHandler($exception) {

        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);

        if (\App\Config::SHOW_ERRORS) {
            View::renderTemplate('Exception.php', [
                'uncaught_exception' => get_class($exception),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'file_line' => $exception->getLine(),
                'stack' => $exception->getTraceAsString(),
                'get_data' => $_GET,
                'post_data' => $_POST,
                'cookie_data' => $_COOKIE,
                'session_data' => $_SESSION,
                'server_data' => $_SERVER,
                'code_lines' => preg_replace("/\r|\n/", "", file($exception->getFile()))
            ]);
        } else {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.log';
            ini_set('error_log', $log);

            $message = date("jS, F Y - H:i:s a")." (".date('T')." ".sprintf("%s%02d:%02d",(timezone_offset_get(new \DateTimeZone(date_default_timezone_get()),new \DateTime()) >= 0) ? '+' : '-', abs( timezone_offset_get(new \DateTimeZone(date_default_timezone_get()),new \DateTime()) / 3600 ), abs( timezone_offset_get(new \DateTimeZone(date_default_timezone_get()),new \DateTime()) % 3600 ) )." (".date_default_timezone_get()."))".PHP_EOL;
            $message .= "Uncaught exception: '" . get_class($exception) . "'";
            $message .= " with message '" . $exception->getMessage() . "'";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();
            $message .= PHP_EOL;

            $messageHtml = "<b>Date</b>: " .date("jS, F Y - H:i:s a")." (".date('T')." ".sprintf("%s%02d:%02d",(timezone_offset_get(new \DateTimeZone(date_default_timezone_get()),new \DateTime()) >= 0) ? '+' : '-', abs( timezone_offset_get(new \DateTimeZone(date_default_timezone_get()),new \DateTime()) / 3600 ), abs( timezone_offset_get(new \DateTimeZone(date_default_timezone_get()),new \DateTime()) % 3600 ) )." (".date_default_timezone_get()."))<br>";
            $messageHtml .= "<br><b>Uncaught exception</b>: '" . get_class($exception) . "'";
            $messageHtml .= "<br><b>With message</b> '" . $exception->getMessage() . "'<br>";
            $messageHtml .= "<b>Stack trace</b>: " . self::getExceptionTraceAsString($exception);
            $messageHtml .= "<br><b>Thrown in</b> '" . $exception->getFile() . "' <b>on line</b> " . $exception->getLine();
            $messageHtml .= '<br><br>Please fix ASAP.<Br><br>';
            $messageHtml .= '<b>Url</b>: '.$_SERVER['REQUEST_URI'].'<Br>';
            $messageHtml .= '<b>Ip</b>: '.\Core\Users::getRealIP().'<Br>';
            $messageHtml .= '<b>User Agent</b>: '.$_SERVER['HTTP_USER_AGENT']??null.'<Br>';

            /**
             * What's messageHtml?
             * I use it to send an email when a 500 error happens
             */

            error_log($message);
            View::renderTemplate("$code.php");
        }
    }

    public static function getExceptionTraceAsString($exception) {
        $rtn = "";
        $count = 0;
        foreach ($exception->getTrace() as $frame) {
            $args = "";
            if (isset($frame['args'])) {
                $args = array();
                foreach ($frame['args'] as $arg) {
                    if (is_string($arg)) {
                        $args[] = "'" . $arg . "'";
                    } elseif (is_array($arg)) {
                        $args[] = "Array";
                    } elseif (is_null($arg)) {
                        $args[] = 'NULL';
                    } elseif (is_bool($arg)) {
                        $args[] = ($arg) ? "true" : "false";
                    } elseif (is_object($arg)) {
                        $args[] = get_class($arg);
                    } elseif (is_resource($arg)) {
                        $args[] = get_resource_type($arg);
                    } else {
                        $args[] = $arg;
                    }   
                }   
                $args = join(", ", $args);
            }
            $rtn .= sprintf( "#%s %s(%s): %s(%s)\n",
                @$count,
                @$frame['file'],
                @$frame['line'],
                @$frame['function'],
                @$args);
            $count++;
        }
        return $rtn;
    }
}