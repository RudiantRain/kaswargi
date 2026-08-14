<?php

class Customer extends CI_Controller{


	function __construct()
	{
		parent::__construct();
		chek_session();
		$this->load->model('Model_customer');
	}

	function index()
	{
		$data['record'] = $this->Model_customer->tampilkan_data();
		$this->template->load('template/template', 'customer/lihat_data', $data);
		$this->load->view('template/datatables');

	}

	function post()
	{
		if (isset($_POST['submit'])) {
			//proses kategori
			$this->Model_customer->post();
			redirect('customer');
		} else {
			$this->template->load('template/template', 'customer/form_input');
		}
	}
}

?>