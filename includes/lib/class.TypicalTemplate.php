<?php
/***************************************************************************
					class.TypicalTemplate.php
					------------
	product			: TypicalTemplate
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    A simple and efficient, yet powerful, templating class. 
    Also includes a caching function to reduce load on the server
    
    DO NOT EDIT unless you know what you are doing.

***************************************************************************/

class Template {
var $vars; /// Holds all the template variables
var $template_dir; // directory that contains the templates
var $default_dir; // directory that contains the default template files
var $main_file; // main file to process
var $debug;
var $parsing = false;

    /**
     * Constructor
     *
     */

    function Template($default_dir, $debug=false) {
        $this->debug = $debug;
        $this->default_dir = $default_dir;
    }


    /**
     * Set debug mode.
     */
    function setDebug($debug) {
        $this->debug = $debug;
    }

    /**
     * Set main display file.
     */
    function setMainFile($file = null) {
        $this->main_file = $file;
    }

    /**
     * Set a template variable.
     */
    function set($name, $value) {
        $this->vars[$name] = is_object($value) ? $value->fetch() : $value;
    }

    /**
     * get the value of a template variable.
     */
    function get($name) {
        return $$name;
    }

    /**
     * Open, parse, and return the template file.
     *
     * @param $file string the template file name
     */
    function fetch($file = null) {
        if (!$file) $file = $this->main_file;

        $this->parsing = true;

        extract($this->vars);                   // Extract the vars to local namespace
        ob_start();                             // Start output buffering
        if (!$this->debug)
            //error_reporting(0);
        if (file_exists($this->template_dir . $file)) {
			@include($this->template_dir . $file);   // Include the file
		} else {
			include($this->default_dir . $file);    // include default file
		}
        error_reporting(ERROR_LEVEL);
        $contents = ob_get_contents();          // Get the contents of the buffer
        ob_end_clean();                         // End buffering and discard

        $this->parsing = false;

        return $contents;                       // Return the contents
    }

    function display($file = null) {
        // Fetch the file contents and echo them
   
        echo $this->fetch($file);
    }

    /**
     * Clear the template array
     */
    function clear() {
        // reset the vars array
       $this->vars = array();
    }
}

?>
