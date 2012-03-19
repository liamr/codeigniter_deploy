<?php

define('ENVIRONMENT_BASE', (isset($_SERVER['APP_BASEPATH']) ? $_SERVER['APP_BASEPATH'] : BASEPATH));

class Deployment extends CI_Controller{

	function index(){
		echo(ENVIRONMENT_BASE);
	}

	function post_receive(){


		if (isset($_POST['payload']) && !empty($_POST['payload']))
		{

			$payload = json_decode($_POST['payload']);

			//make sure this is the correct environment

			if ($payload->ref == 'refs/heads/' . ENVIRONMENT){

				//Write commit info to 

				$this->load->helper('file');

				$data = 'COMMIT: ' . $payload->commits[0]->id . ' AUTHOR: ' . $payload->commits[0]->author->name . ' MESSAGE: ' . $payload->commits[0]->message . ' TIME: ' . $payload->commits[0]->timestamp . '\n';     

				write_file('./app_version', $data, 'a');


				log_message('debug', 'DEPLOYMENT: Post-receive hook - '. ENVIRONMENT);


				shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" ‘ . ‘--work-tree="' . ENVIRONMENT_BASE . '" ‘ . ‘reset --hard HEAD'); 
				shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" ‘ . ‘--work-tree="' . ENVIRONMENT_BASE . '" clean -f'); 
				shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" ‘ . ‘--work-tree="' . ENVIRONMENT_BASE . '" ‘ . ‘pull origin . ENV'); 

				//reset, clean and pull


				/*shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" ‘ .                                                   ‘--work-tree="' . ENVIRONMENT_BASE . '" ‘ .                                                   ‘reset --hard HEAD');


				shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" ‘ .                                                   ‘--work-tree="' . ENVIRONMENT_BASE . '" clean -f');


				shell_exec('/usr/bin/git --git-dir="' . ENVIRONMENT_BASE . '.git" ‘ .                                                   ‘--work-tree="' . ENVIRONMENT_BASE . '" ‘ .                                                   ‘pull origin ' . ENV);

				*/

			}

		} else {
			echo('Nope');
		}

	}

	
}

?>