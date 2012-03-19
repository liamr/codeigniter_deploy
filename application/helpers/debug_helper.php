<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Debug helper
 * 
 * Print clear and readable data only in development environment and automatically put die in your code
 * 
 * @category	Helpers 
 * @author      Ahmad Samiei  <ahmad.samiei@gmail.com>
 * @version		1.2.0
 */





/**
 * Easy to debug & trace with benchmark option
 * 
 * @uses	call debug_profile() where you want start benchmark in your code 
 * 			-then call debug($data, TRUE) to get result with benchmark.
 * 
 * @access	public
 * @param	mixed		input data
 * @param	boolean		enable benchmark
 * @return	void		printed	data
 */
if ( ! function_exists('debug'))
{
	function debug($data = NULL, $benchmark = FALSE)
	{
	    if (ENVIRONMENT === 'production')
	    {
	        return null;
	    }
		
        list($call) = debug_backtrace();
        echo '<style>body, div {padding:0;margin:0;background:#fff;direction:ltr;}</style><div style="border-bottom:solid 1px #D8D8D8;background:#f1f1f1;color:#111;position:fixed;top:0px;left:0px;width:100%;padding:10px 20px;font-size:11px;font-family:arial,monospace;font-weight:normal;line-height:18px;">';
        
		if ( ! empty($benchmark))
		{
			$ci =& get_instance();
			$ci->benchmark->mark('debug_end');
            echo 'Elapsed time (benchmark): '	. $ci->benchmark->elapsed_time('debug_start', 'debug_end') . ' <br />';
		}
        
		echo ' ' . $call['file'] . ' @ line:' . $call['line'] . '</div><div style="background:#fff;padding:10px;padding-top:50px;"><pre>';
		if ((is_object($data) || is_array($data)) && ! function_exists('xdebug_call_function') )
		{
			// in default print_r is more clear for array/object
			print_r($data);
		}
		else
		{
			// if not array/object var_dump is better and is more detailed (for example in when data is boolean !)
			// or when xdebug installed it can style var_dump in output automatically
            @ini_set('html_errors', 1);
			var_dump($data);
		}
		echo '</pre>';
		echo '</div>';
		if ( ! empty($benchmark))
		{
			echo '</div>';
		}
		
		exit;	
	}
}

// ------------------------------------------------------------------------

/**
 * Start flag to make benchmark for debug function
 * 
 * You can use it before your function call ! and debug the function result with benchmark it.
 * 
 * @access	public
 * @return	void
 */
if ( ! function_exists('debug_profile'))
{
	function debug_profile()
	{
	    if (ENVIRONMENT === 'production')
	    {
	        return null;
	    }
	    
		$ci =& get_instance();
		$ci->benchmark->mark('debug_start');
	}
}

// ------------------------------------------------------------------------

/**
 * Easy to debug & trace with benchmark option
 * 
 * @uses	call debug_profile() where you want start benchmark in your code 
 * 			-then call debug($data, TRUE) to get result with benchmark.
 * 
 * @access	public
 * @param	mixed		input data
 * @param	boolean		enable benchmark
 * @return	void		printed	data
 */
if ( ! function_exists('print_d'))
{
	function print_d($data = NULL, $benchmark = FALSE)
	{
		debug($data, $benchmark);
	}
}

// ------------------------------------------------------------------------

/**
 * Dump
 * 
 * Outputs all variable(s) with formatting and location
 * 
 * @param	mixed
 * @return	string
 */
function dump()
{
    if (ENVIRONMENT === 'production')
    {
        return null;
    }
    
    list($call) = debug_backtrace();
    $arguments = func_get_args();
    $total_arguments = count($arguments);

    echo '<fieldset style="background: #fefefe !important; border:2px red solid; padding:5px">';
    echo '<legend style="background:lightgrey; padding:5px;">'.$call['file'].' @ line: '.$call['line'].'</legend><pre>';
    $i = 0;
    foreach ($arguments as $argument)
    {
        echo '<br/><strong>Debug #'.(++$i).' of '.$total_arguments.'</strong>: ';
        @ini_set('html_errors', 1);
		var_dump($argument);
    }

    echo "</pre>";
    echo "</fieldset>";
    exit;
}

// ------------------------------------------------------------------------


/* End of file debug_helper.php */
/* Location: ./application/helpers/debug_helper.php */