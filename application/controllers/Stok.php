<?php

class Stok extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        chek_session();
        $this->load->model('Model_barang');
        $this->load->model('Model_kategori');
        $this->load->model('Model_stok');
    }


    function index()
    {
        $data['stok'] = $this->Model_stok->tampil_data();
        $this->template->load('template/template', 'stok/lihat_data', $data);
        $this->load->view('template/datatables');
    }

    function post()
    {
        if (isset($_POST["submit"])) {
            $barang = $this->input->post('barang');
            $beli = $this->input->post('harga_beli');
            $jual = $this->input->post('harga_jual');
            $kode = $this->input->post('kode');
            $stok = $this->Model_stok->get_stok($barang);
            if ($stok != NULL) {
                $stok_sebelumnya = $this->Model_stok->get_stok($barang)->stok_barang;
                $stok_baru = $this->input->post('stok');
                $hasil = intval($stok_sebelumnya) + intval($stok_baru);
                if ($hasil >= 1000000) {
                    $this->session->set_flashdata('message', 'Kapasitas Stok Barang Telah melebihi Batas Maksimum!');
                    redirect('stok');
                } else {
                    $data = array(
                        'id_barang' => $barang,
                        'kode_stok' => $kode,
                        'stok_barang' => $stok_baru,
                        'harga_beli' => $beli,
                        'harga_jual' => $jual,
                        'tanggal_stok' => date('Y-m-d')
                    );
                    $this->Model_stok->tambah_stok($barang, $data);

                    $data_barang = array('harga' => $jual);

                    $this->Model_barang->edit($data_barang, $barang);
                    // WAJIB memperbarui harga jual di tabel barang dan inputan di tabel riwayat
                    // WAJIB menambahkan 

                    $data_riwayat = array(
                        'id_barang' => $barang,
                        'kode_stok' => $kode,
                        'stok_barang' => $stok_baru,
                        'harga_beli' => $beli,
                        'harga_jual' => $jual,
                    );
                    $this->Model_stok->post_riwayat($data_riwayat);
                    redirect('stok');
                }
            } else {
                $stok = $this->input->post('stok');
                $data = array(
                    'id_barang' => $barang,
                    'stok_barang' => $stok,
                    'kode_stok' => $kode,
                    'harga_beli' => $beli,
                    'harga_jual' => $jual,
                    'tanggal_stok' => date('Y-m-d')
                );
                $this->Model_stok->post($data);

                $data_barang = array('harga' => $jual);
                $this->Model_barang->edit($data_barang, $barang);

                $data_riwayat = array(
                    'id_barang' => $barang,
                    'kode_stok' => $kode,
                    'stok_barang' => $stok,
                    'harga_beli' => $beli,
                    'harga_jual' => $jual,
                );
                $this->Model_stok->post_riwayat($data_riwayat);
                redirect('stok');
            }
        } else {
            $id = $this->uri->segment(3);
            $data['barang'] =  $this->Model_barang->tampil_dropdown()->result();
            $this->template->load("template/template", "stok/form_input", $data);
        }
    }

    function post2()
    {
        if (isset($_POST["submit"])) {
            $barang = $this->input->post('barang');
            $beli = $this->input->post('harga_beli');
            $jual = $this->input->post('harga_jual');
            $kode = $this->input->post('kode');

                $stok = $this->input->post('stok');
                $data = array(
                    'id_barang' => $barang,
                    'stok_barang' => $stok,
                    'kode_stok' => $kode,
                    'harga_beli' => $beli,
                    'harga_jual' => $jual,
                    'tanggal_stok' => date('Y-m-d')
                );
                $this->Model_stok->post($data);

                $data_barang = array('harga' => $jual);
                $this->Model_barang->edit($data_barang, $barang);

                $data_riwayat = array(
                    'id_barang' => $barang,
                    'kode_stok' => $kode,
                    'stok_barang' => $stok,
                    'harga_beli' => $beli,
                    'harga_jual' => $jual,
                );
                $this->Model_stok->post_riwayat($data_riwayat);
                redirect('stok');
            
        } else {
            $id = $this->uri->segment(3);
            $data['barang'] =  $this->Model_barang->tampil_dropdown()->result();
            $this->template->load("template/template", "stok/form_input", $data);
        }
    }

    function edit()
    {
        if (isset($_POST['submit'])) {
            $id         =   $this->input->post('id');
            $barang     =   $this->input->post('barang');
            $stok       =   $this->input->post('stok');
            $beli       =   $this->input->post('harga_beli');

            if (intval($stok) >= 1000000) {
                $this->session->set_flashdata('message', 'Stok Barang Yang Dimasukkan Telah melebihi Batas Maksimum!');
                redirect('stok');
            } else {
                $data       =   array(
                    'id_barang' => $barang,
                    'stok_barang' => $stok,
                    'harga_beli' => $beli
                );
                $this->Model_stok->edit($id, $data);
                redirect('stok');
            }
        } else {
            $id =  $this->uri->segment(3);
            $data['barang'] =  $this->Model_barang->tampil_dropdown()->result();
            $data['stok']   =  $this->Model_stok->get_one($id)->row_array();
            $this->template->load('template/template', 'Stok/form_edit', $data);
        }
    }

    function hapus()
    {
        $id = $this->uri->segment(3);
        $this->Model_stok->hapus($id);
        redirect('stok');
    }

    function get_last_stok_hpp(){
        $idf = $this->input->post('id');
        $last = $this->Model_stok->get_last_stok($idf)->result();
        echo json_encode($last);
    }
}
