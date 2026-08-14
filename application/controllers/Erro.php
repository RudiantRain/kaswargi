<?php
class Erro extends CI_controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$this->template->load('template/template-p', 'errors/html/error_404');
	}

}

?>