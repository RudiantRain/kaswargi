<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        $this->load->database();
    }

    // ==============================
    // LIST DATA
    // ==============================
    public function index()
    {   $CI = &get_instance();
        $session = $CI->session->userdata;
        if ($session['status_login'] != 'oke') {
            redirect('auth/login');
        }else{
                    $data['news'] = $this->db->order_by('id', 'DESC')->get('news')->result_array();
        $this->template->load('template/template-p', 'apps/k-news', $data);
        }

    }


    public function create()
    {
        // $this->load->template('apps/k-news', $data);
    }

    public function store()
    {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;

        $this->upload->initialize($config);

        $filename = null;

        if (!empty($_FILES['gambar']['name'])) {
            if ($this->upload->do_upload('gambar')) {
                $filename = $this->upload->data('file_name');
            } else {
                echo $this->upload->display_errors();
                return;
            }
        }

        $data = [
            'org_code'  => $_SESSION['org_code'],
            'judul'     => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'gambar'    => $filename,
            'show'      => '1',
        ];

        $this->db->insert('news', $data);

        redirect('News');
    }

    // ==============================
    // FORM EDIT
    // ==============================
    public function edit($id)
    {
        $data['row'] = $this->db->get_where('news', ['id' => $id])->row();
        $this->load->view('news/edit', $data);
    }

    // ==============================
    // PROSES UPDATE
    // ==============================
    public function update($id)
    {
        $row = $this->db->get_where('news', ['id' => $id])->row();

        $config['upload_path']   = './uploads/news/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;

        $this->upload->initialize($config);

        $filename = $row->gambar;

        if (!empty($_FILES['gambar']['name'])) {
            if ($this->upload->do_upload('gambar')) {

                // hapus file lama
                if ($row->gambar && file_exists('./uploads/news/' . $row->gambar)) {
                    unlink('./uploads/news/' . $row->gambar);
                }

                $filename = $this->upload->data('file_name');
            } else {
                echo $this->upload->display_errors();
                return;
            }
        }

        $data = [
            'org_code'  => $this->input->post('org_code'),
            'judul'     => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'gambar'    => $filename,
            'show'      => $this->input->post('show')
        ];

        $this->db->where('id', $id)->update('news', $data);

        redirect('news');
    }

    // ==============================
    // HAPUS + HAPUS GAMBAR
    // ==============================
    public function delete($id)
    {
        $row = $this->db->get_where('news', ['id' => $id])->row();

        // hapus gambar fisik
        if ($row->gambar && file_exists('./uploads/' . $row->gambar)) {
            unlink('./uploads/' . $row->gambar);
        }

        $this->db->delete('news', ['id' => $id]);

        redirect('News');
    }



}
?>