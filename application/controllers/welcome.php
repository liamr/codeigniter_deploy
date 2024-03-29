<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 * 
 * Licensed under the Academic Free License version 3.0
 * 
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		$this->load->helper('debug');

		$this->load->library('cache');

		$this->load->library('caching');

		$this->load->model('article_model');

		//non cached
		//$result = $this->article_model->get_many(array(1,3,4));

		//cached (file)
		//$result = $this->cache->model('article_model', 'get_many', array(array(1,3,4)), 120);

		//cached memcached
		
		//$result = $this->caching->model('article_model', 'get_many', array(array(1,3,4)), 120);

		//print_r($result);

		//2\

		//$result_2 = $this->caching->model('article_model', 'get', array(1));

		//print_r($result_2);



		//$this->load->view('welcome_message');

		echo('CI DEPLOY <br />');

		echo('Hello. NY<br />');

		echo(ENVIRONMENT .'<br />');

		echo(FCPATH .'<br />');

		$this->load->helper('file');

		echo(read_file('./app_version'));
	}

	public function info(){
		$this->load->library('caching');
		var_dump($this->caching->cache_info());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */