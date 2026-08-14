<?php

class Riwayat extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		chek_role();
		$this->load->model('Model_barang');
		$this->load->model('Model_kategori');
		$this->load->model('Model_stok');
	}
	function index()
	{
		$data['record'] = $this->Model_stok->get_riwayat()->result();
		// $data['base_domain'] = $config['base_url'];
		$this->template->load('template/template', 'riwayat/lihat_data', $data);
		$this->load->view('template/datatables');

	}

	function index_keluar()
	{
		$data['record'] = $this->Model_stok->get_riwayat_keluar()->result();
		// $data['base_domain'] = $config['base_url'];
		$this->template->load('template/template', 'riwayat/lihat_keluar', $data);
		$this->load->view('template/datatables');
	}
}

?>