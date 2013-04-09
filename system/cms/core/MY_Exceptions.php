<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS' Exceptions handler.
 *
 * Override Codeigniter's exceptions for managing our 404 errors.
 *
 * This file contains some functions originally from Kohana.  They have been modified
 * to work with CodeIgniter. Here is the Kohana license info:
 *
 * @author      PyroCMS Dev Team
 * @copyright   (c) 2008-2009 Kohana Team
 * @package		PyroCMS\Core\Libraries\Exceptions
 */
class MY_Exceptions extends CI_Exceptions
{
	/**
	 * 404 Not Found Handler
	 *
	 * @param string $page The slug of the Page Missing page. Since this is handled by the Page module it is immutable
	 * @param bool $log_error All 404s are logged by the Page module as the page segments are not available here
	 */
	public function show_404($page = 404, $log_error = true)
	{
		// Set the HTTP Status header
		set_status_header(404);

		// clear out assets set by the first module before the 404 handler takes over
		Asset::reset();

		Modules::run('pages/_remap', 404);
	}

    /**
     * Some nice names for the error types
     */
    public static $php_errors = array(
        E_ERROR              => 'Fatal Error',
        E_USER_ERROR         => 'User Error',
        E_PARSE              => 'Parse Error',
        E_WARNING            => 'Warning',
        E_USER_WARNING       => 'User Warning',
        E_STRICT             => 'Strict',
        E_NOTICE             => 'Notice',
        E_RECOVERABLE_ERROR  => 'Recoverable Error',
    );

    /**
     * The Shutdown errors to show (all others will be ignored).
     */
    public static $shutdown_errors = array(E_PARSE, E_ERROR, E_USER_ERROR, E_COMPILE_ERROR);

    /**
     * Construct
     *
     * Sets the error handlers.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // If we are in production, then lets dump out now.
        if (ENVIRONMENT === PYRO_PRODUCTION) {
            return;
        }

        //Set the Exception Handler
        set_exception_handler(array('MY_Exceptions', 'exception_handler'));

        // Set the Error Handler
        set_error_handler(array('MY_Exceptions', 'error_handler'));

        // Set the handler for shutdown to catch Parse errors
        register_shutdown_function(array('MY_Exceptions', 'shutdown_handler'));
    }

    /**
     * Debug Path
     *
     * This makes nicer looking paths for the error output.
     *
     * @param  string $file
     * @return string
     */
    public static function debug_path($file)
    {
        if (strpos($file, APPPATH) === 0) {
            $file = 'APPPATH/'.substr($file, strlen(APPPATH));
        } elseif (strpos($file, SYSDIR) === 0) {
            $file = 'SYSDIR/'.substr($file, strlen(SYSDIR));
        } elseif (strpos($file, FCPATH) === 0) {
            $file = 'FCPATH/'.substr($file, strlen(FCPATH));
        }

        return $file;
    }

    /**
     * Error Handler
     *
     * Converts all errors into ErrorExceptions. This handler
     * respects error_reporting settings.
     *
     * @throws ErrorException
     * @return bool
     */
    public static function error_handler($code, $error, $file = null, $line = null)
    {
        if (error_reporting() & $code) {
            // This error is not suppressed by current error reporting settings
            // Convert the error into an ErrorException
            self::exception_handler(new ErrorException($error, $code, 0, $file, $line));
        }

        // Do not execute the PHP error handler
        return true;
    }

    /**
     * Exception Handler
     *
     * Displays the error message, source of the exception, and the stack trace of the error.
     *
     * @param   object   exception object
     * @return boolean
     */
    public static function exception_handler(Exception $e)
    {
        try {
            // Get the exception information
            $type    = get_class($e);
            $code   = $e->getCode();
            $message = $e->getMessage();
            $file    = $e->getFile();
            $line    = $e->getLine();

            // Create a text version of the exception
            $error = self::exception_text($e);

            // Log the error message
            log_message('error', $error, true);

            // Get the exception backtrace
            $trace = $e->getTrace();

            if ($e instanceof ErrorException) {
                if (isset(self::$php_errors[$code])) {
                    // Use the human-readable error name
                    $code = self::$php_errors[$code];
                }

                if (version_compare(PHP_VERSION, '5.3', '<')) {
                    // Workaround for a bug in ErrorException::getTrace() that exists in
                    // all PHP 5.2 versions. @see http://bugs.php.net/bug.php?id=45895
                    for ($i = count($trace) - 1; $i > 0; --$i) {
                        if (isset($trace[$i - 1]['args'])) {
                            // Re-position the args
                            $trace[$i]['args'] = $trace[$i - 1]['args'];

                            // Remove the args
                            unset($trace[$i - 1]['args']);
                        }
                    }
                }
            }
            // Start an output buffer
            ob_start();

            // This will include the custom error file.
            require APPPATH . 'views/errors/error_php_custom.php';

            // Display the contents of the output buffer
            echo ob_get_clean();

            return true;
        } catch (Exception $e) {
            // Clean the output buffer if one exists
            ob_get_level() and ob_clean();

            // Display the exception text
            echo self::exception_text($e), "\n";

            // Exit with an error status
            exit(1);
        }
    }

    /**
     * Shutdown Handler
     *
     * Catches errors that are not caught by the error handler, such as E_PARSE.
     *
     * @return void
     */
    public static function shutdown_handler()
    {
        $error = error_get_last();
        if ($error = error_get_last() and in_array($error['type'], self::$shutdown_errors)) {
            // Clean the output buffer
            ob_get_level() and ob_clean();

            // Fake an exception for nice debugging
            self::exception_handler(new ErrorException($error['message'], $error['type'], 0, $error['file'], $error['line']));

            // Shutdown now to avoid a "death loop"
            exit(1);
        }
    }

    /**
     * Exception Text
     *
     * Makes a nicer looking, 1 line extension.
     *
     * @param   object  Exception
     * @return string
     */
    public static function exception_text(Exception $e)
    {
        return sprintf('%s [ %s ]: %s ~ %s [ %d ]',
            get_class($e), $e->getCode(), strip_tags($e->getMessage()), $e->getFile(), $e->getLine());
    }

    /**
     * Debug Source
     *
     * Returns an HTML string, highlighting a specific line of a file, with some
     * number of lines padded above and below.
     *
     * @param   string   file to open
     * @param   integer  line number to highlight
     * @param   integer  number of padding lines
     * @return string source of file
     * @return false  file is unreadable
     */
    public static function debug_source($file, $line_number, $padding = 5)
    {
        if ( ! $file or ! is_readable($file)) {
            // Continuing will cause errors
            return false;
        }

        // Open the file and set the line position
        $file = fopen($file, 'r');
        $line = 0;

        // Set the reading range
        $range = array('start' => $line_number - $padding, 'end' => $line_number + $padding);

        // Set the zero-padding amount for line numbers
        $format = '% '.strlen($range['end']).'d';

        $source = '';
        while (($row = fgets($file)) !== false) {
            // Increment the line number
            if (++$line > $range['end'])
                break;

            if ($line >= $range['start']) {
                // Make the row safe for output
                $row = htmlspecialchars($row, ENT_NOQUOTES);

                // Trim whitespace and sanitize the row
                $row = '<span class="number">'.sprintf($format, $line).'</span> '.$row;

                if ($line === $line_number) {
                    // Apply highlighting to this row
                    $row = '<span class="line highlight">'.$row.'</span>';
                } else {
                    $row = '<span class="line">'.$row.'</span>';
                }

                // Add to the captured source
                $source .= $row;
            }
        }

        // Close the file
        fclose($file);

        return '<pre class="source"><code>'.$source.'</code></pre>';
    }

    /**
     * Trace
     *
     * Returns an array of HTML strings that represent each step in the backtrace.
     *
     * @param   string  path to debug
     * @return string
     */
    public static function trace(array $trace = null)
    {
        if ($trace === null) {
            // Start a new trace
            $trace = debug_backtrace();
        }

        // Non-standard function calls
        $statements = array('include', 'include_once', 'require', 'require_once');

        $output = array();
        foreach ($trace as $step) {
            if ( ! isset($step['function'])) {
                // Invalid trace step
                continue;
            }

            if (isset($step['file']) and isset($step['line'])) {
                // Include the source of this step
                $source = self::debug_source($step['file'], $step['line']);
            }

            if (isset($step['file'])) {
                $file = $step['file'];

                if (isset($step['line'])) {
                    $line = $step['line'];
                }
            }

            // function()
            $function = $step['function'];

            if (in_array($step['function'], $statements)) {
                if (empty($step['args'])) {
                    // No arguments
                    $args = array();
                } else {
                    // Sanitize the file path
                    $args = array($step['args'][0]);
                }
            } elseif (isset($step['args'])) {
                if (strpos($step['function'], '{closure}') !== false) {
                    // Introspection on closures in a stack trace is impossible
                    $params = null;
                } else {
                    if (isset($step['class'])) {
                        if (method_exists($step['class'], $step['function'])) {
                            $reflection = new ReflectionMethod($step['class'], $step['function']);
                        } else {
                            $reflection = new ReflectionMethod($step['class'], '__call');
                        }
                    } else {
                        $reflection = new ReflectionFunction($step['function']);
                    }

                    // Get the function parameters
                    $params = $reflection->getParameters();
                }

                $args = array();

                foreach ($step['args'] as $i => $arg) {
                    if (isset($params[$i])) {
                        // Assign the argument by the parameter name
                        $args[$params[$i]->name] = $arg;
                    } else {
                        // Assign the argument by number
                        $args[$i] = $arg;
                    }
                }
            }

            if (isset($step['class'])) {
                // Class->method() or Class::method()
                $function = $step['class'].$step['type'].$step['function'];
            }

            $output[] = array(
                'function' => $function,
                'args'     => isset($args)   ? $args : null,
                'file'     => isset($file)   ? $file : null,
                'line'     => isset($line)   ? $line : null,
                'source'   => isset($source) ? $source : null,
            );

            unset($function, $args, $file, $line, $source);
        }

        return $output;
    }

    /**
     * General Error Page
     *
     * This function takes an error message as input
     * (either as a string or an array) and displays
     * it using the specified template.
     *
     * @param   string  the heading
     * @param   string  the message
     * @param   string  the template name
     * @return string
     */
    public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {
        // If we are in production, then lets dump out now.
        if (ENVIRONMENT === PYRO_PRODUCTION) {
            return parent::show_error($heading, $message, $template, $status_code);
        }

        if ( ! headers_sent()) {
            set_status_header($status_code);
        }
        $trace = debug_backtrace();
        $file = null;
        $line = null;

        $is_from_app = false;
        if (isset($trace[1]['file']) and strpos($trace[1]['file'], APPPATH) === 0) {
            $is_from_app = !self::is_extension($trace[1]['file']);
        }

        // If the application called show_error, don't output a backtrace, just the error
        if ($is_from_app) {
            $message = '<p>'.implode('</p><p>', ( ! is_array($message)) ? array($message) : $message).'</p>';

            if (ob_get_level() > $this->ob_level + 1) {
                ob_end_flush();
            }
            ob_start();
            include(APPPATH.'views/errors/'.$template.'.php');
            $buffer = ob_get_contents();
            ob_end_clean();

            return $buffer;
        }

        $message = implode(' / ', ( ! is_array($message)) ? array($message) : $message);

        // If the system called show_error, so lets find the actual file and line in application/ that caused it.
        foreach ($trace as $call) {
            if (isset($call['file']) and strpos($call['file'], APPPATH) === 0 and !self::is_extension($call['file'])) {
                $file = $call['file'];
                $line = $call['line'];
                break;
            }
        }
        unset($trace);

        self::exception_handler(new ErrorException($message, E_ERROR, 0, $file, $line));

        return;
    }

    /**
     * Is Extension
     *
     * This checks to see if the file path is to a core extension.
     *
     * @param  string $file
     * @return bool
     */
    private static function is_extension($file)
    {
        foreach (array('libraries/', 'core/') as $folder) {
            if (strpos($file, APPPATH . $folder . config_item('subclass_prefix')) === 0) {
                return true;
            }
        }

        return false;
    }
}

/* End of file: MY_Exceptions.php */
