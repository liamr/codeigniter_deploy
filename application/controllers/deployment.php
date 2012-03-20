<?php

define('ENVIRONMENT_BASE', (isset($_SERVER['APP_BASEPATH']) ? $_SERVER['APP_BASEPATH'] : FCPATH));

class Deployment extends CI_Controller{

	public function __construct() 
	{
		parent::__construct();

		$this->load->helper('file');
		
		
        $this->key = "475e434d51253c43352723732a";

        //Check if we are secure.
        $this->_create_htaccess();
        		
        		
	}

	function index($key = ''){

		if($key == '' || $key != $this->key){
			exit();
		}

		echo('<style>body{ font-family:Helvetica Neue, Helventica, sans-serif;</style>');
		echo('<strong>Environment Base: ' . ENVIRONMENT_BASE . ' Environment: ' . ENVIRONMENT . '</strong> <br />');

		$this->load->helper('file');

		echo(read_file('./app_version'));
	}

	function post_receive($key = ''){

		if($key == '' || $key != $this->key){
			exit();
		}


		if (isset($_POST['payload']) && !empty($_POST['payload']))
		{

			$payload = json_decode($_POST['payload']);

			//make sure this is the correct environment.

			if ($payload->ref == 'refs/heads/' . ENVIRONMENT){

				//Write commit info to 

				$data = 'COMMIT: ' . $payload->commits[0]->id . ' AUTHOR: ' . $payload->commits[0]->author->name . ' MESSAGE: ' . $payload->commits[0]->message . ' TIME: ' . $payload->commits[0]->timestamp . '<br />';     

				write_file('./app_version', $data, 'a');


				log_message('debug', 'DEPLOYMENT: Post-receive hook - '. ENVIRONMENT);

				//Done right

				shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" --work-tree="' . ENVIRONMENT_BASE . '" reset --hard HEAD'); 
				shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" --work-tree="' . ENVIRONMENT_BASE . '" clean -f'); 
				shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" --work-tree="' . ENVIRONMENT_BASE . '" pull origin ' . ENVIRONMENT); 

				

			}

		} else {
			echo('Nope');
		}

	}

	function rollback($key = "", $commit_number = ''){

		if($key == '' || $key != $this->key){
			exit();
		}

		if($commit_number == ''){
		
			log_message('debug', 'DEPLOYMENT: rollback to previous version - '. ENVIRONMENT);
			
			//Write commit info to 

			$data = 'SITE WAS ROLLED BACK TO PREVIOUS VERSION<br />';     

			write_file('./app_version', $data, 'a');

			shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" --work-tree="' . ENVIRONMENT_BASE . '" reset --hard HEAD~1'); 

		} else {

			log_message('debug', 'DEPLOYMENT: rollback to commit / tag - '. $commit_number);
			
			//Write commit info to 

			$data = 'SITE WAS CHECKED OUT TO ' . $commit_number . '<br />';     

			write_file('./app_version', $data, 'a');

			shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" --work-tree="' . ENVIRONMENT_BASE . '" reset --hard HEAD'); 
			shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" --work-tree="' . ENVIRONMENT_BASE . '" clean -f'); 
			shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" --work-tree="' . ENVIRONMENT_BASE . '" checkout ' . $commit_number); 

		}

	}

	function _create_htaccess(){

		if(is_dir('.git')){
			if(!file_exists('.git/.htaccess')){
				write_file('.git/.htaccess', 'Deny from all');
				//echo('yup');
			} else {
				//echo('.htaccess already exists');
			}
			
		} else {
			//echo('no git');
		}

		//Maybe add chmod rules?
		//chmod -R og-rx /home/saintsjd/www/.git

		

	}

	
}

?>