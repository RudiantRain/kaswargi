<?php
class Keuangan extends CI_controller
{

	function __construct()
	{
		parent::__construct();
        check_session();
        $this->load->model('Model_keuangan');
    }

    function index()
    {
        $data['record'] = $this->Model_keuangan->tampilkan_biaya();
        // $data['base_domain'] = $config['base_url'];
        $this->template->load('template/template', 'keuangan/biaya', $data);
        $this->load->view('template/datatables');

    }

    function index_bonsem()
    {
        $data['record'] = $this->Model_keuangan->tampilkan_bonsem();
        // $data['base_domain'] = $config['base_url'];
        $this->template->load('template/template', 'keuangan/bonsem', $data);
        $this->load->view('template/datatables');

    }

    function post_biaya()
    {
        $nama_biaya = $this->input->post('nama_biaya');
        $keterangan = $this->input->post('keterangan');
        $tanggal = $this->input->post('tanggal');
        $nominal = $this->input->post('nominal');

        $data = array(
            'nama_biaya' => $nama_biaya,
            'keterangan' => $keterangan,
            'tanggal' => $tanggal,
            'nominal' => $nominal,
        );

        $this->Model_keuangan->tambah_biaya($data);

        redirect('keuangan');
    }

    function post_bonsem()
    {
        $dari = $this->input->post('dari');
        $keterangan = $this->input->post('keterangan');
        $sampai = $this->input->post('sampai');
        $nominal = $this->input->post('nominal');

        $data = array(
            'dari' => $dari,
            'keterangan' => $keterangan,
            'sampai' => $sampai,
            'nominal' => $nominal,
        );

        $this->Model_keuangan->tambah_bonsem($data);

        redirect('keuangan/index_bonsem');
    }

    function hapus_biaya()
    {
        $id = $this->uri->segment(3);
        $this->Model_keuangan->hapus_biaya($id);
        redirect('keuangan');
    }    

    function hapus_bonsem()
    {
        $id = $this->uri->segment(3);
        $this->Model_keuangan->hapus_bonsem($id);
        redirect('keuangan');
    }


}