<?php
class Review extends CI_controller
{

	function __construct()
	{
		parent::__construct();

    }

    function only()
    {
        $org = $this->uri->segment(3);
        $data['kas'] = $this->db->query("SELECT * FROM kas_buku WHERE org_code = '$org'")->result_array();
        $data['warga'] = $this->db->query("SELECT * FROM warga WHERE org_code = '$org'")->result_array();
        $data['iuran'] = $this->db->query("SELECT pada_tahun, pada_bulan, SUM(total_nominal) as tot_bulanan FROM iuran_alter WHERE org_code = '$org' GROUP BY pada_tahun, pada_bulan")->result_array();
         $data['news'] = $this->db->order_by('id', 'ASC')->get('news')->result_array();
        $this->template->load('template/template-p', 'apps/r-dash', $data);
        // var_dump($this->session->userdata());
        // die;
    }

    function recap()
    {
        $org = $this->uri->segment(3);
        $data['rekap'] = $this->db->query("SELECT id,org_code,kode_periode,id_warga,nama_warga,nominal,status,tgl_bayar,bulan,tahun,nama_operator FROM iuran_bayar WHERE org_code = '$org'")->result_array();
        $data['tunggak'] = $this->db->query("SELECT id,org_code,kode_periode,id_warga,nama_warga,nominal,status,tgl_bayar,bulan,tahun,nama_operator, COUNT(org_code) as tunggak, SUM(nominal) as jumlah FROM iuran_bayar WHERE `status` = 'BELUM' AND org_code = '$org' GROUP BY id_warga ORDER BY tunggak DESC")->result_array();

        $alter = $this->db->query("SELECT * FROM iuran_alter WHERE org_code = '$org'")->result_array();

    // --- FIX DATA YANG MASIH BERBENTUK STRING JSON ---
        foreach ($alter as &$row) {

        // Perbaiki kode_periode
            if (!empty($row['kode_periode']) && is_string($row['kode_periode'])) {
            // Hilangkan kutip pembungkus jika ada
                $clean = trim($row['kode_periode'], '"');
            // Decode JSON ke array PHP
                $row['kode_periode'] = json_decode($clean, true);
            }

        // Perbaiki untuk_periode
            if (!empty($row['untuk_periode']) && is_string($row['untuk_periode'])) {
                $clean = trim($row['untuk_periode'], '"');
                $row['untuk_periode'] = json_decode($clean, true);
            }
        }
        unset($row);

    // Masukkan kembali setelah diperbaiki
        $data['alter'] = $alter;

        $this->template->load('template/template-p', 'apps/r-recap', $data);
    }

    function allResident()
    {
        $org = $this->uri->segment(3);
        $data['warga'] = $this->db->query("SELECT id,org_code,nama_warga,blok,total_iuran,aktif FROM warga WHERE org_code = '$org' AND aktif = '1'")->result_array();
        $this->template->load('template/template-p', 'apps/r-all-resident', $data);
    }

    function resident()
    {
        $id = $this->uri->segment(4);
        $org = $this->uri->segment(3);
        $data['warga'] = $this->db->query("SELECT * FROM warga WHERE org_code = '$org' AND id = '$id'")->result_array()
        ;
        $data['kartu'] = $this->db->query("SELECT id,org_code,kode_periode,id_warga,nama_warga,nominal,status,tgl_bayar,bulan,tahun,nama_operator FROM iuran_bayar WHERE id_warga = '$id'  ORDER BY id DESC")->result_array();
        $this->template->load('template/template-p', 'apps/r-resident', $data);
    }

    function readByIdKas(){
        $id = $this->uri->segment(4);
        $org = $this->uri->segment(3);
        $data['kas'] = $this->db->query("SELECT * FROM kas_buku WHERE org_code = '$org' AND id_kas_nama = '$id'")->result_array();
        $this->template->load('template/template-p', 'apps/r-books-details', $data);
    }

    function printByIdKas(){
        $id = $this->uri->segment(4);
        $org = $this->uri->segment(3);
        $data['kas'] = $this->db->query("SELECT * FROM kas_buku WHERE org_code = '$org' AND id_kas_nama = '$id'")->result_array();
        $this->template->load('template/template-p', 'apps/r-books-print', $data);
    }


}

?>