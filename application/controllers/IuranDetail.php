<?php
class IuranDetail extends CI_controller
{

	function __construct()
	{
		parent::__construct();
		chek_session();
	}

	function index()
	{
		$this->template->load('template/template-p', 'apps/k-iuran-detail');
	}

	function alokasi()
	{

		$org = $this->uri->segment(3);
		$bln = $this->uri->segment(4);
		$thn = $this->uri->segment(5);
		$id_op = $_SESSION['id'];
		$data['kas_kategori'] = $this->db->query("SELECT * FROM kas_kategori WHERE org_code = '$org'")->result_array();
        $data['kas_nama'] = $this->db->query("SELECT * FROM kas_nama WHERE org_code = '$org' AND id_operator = '$id_op' ")->result_array();

		$alter = $this->db->query("SELECT * FROM iuran_alter WHERE org_code = '$org' AND pada_bulan = '$bln' AND pada_tahun = '$thn' ")->result_array();

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
		$this->template->load('template/template-p', 'apps/k-iuran-detail', $data);
	}

	function getTotalAlter(){
		$org = $this->input->post('org');
		$bln = $this->input->post('bln');
		$thn = $this->input->post('thn');

		$alter = $this->db->query("SELECT * FROM iuran_alter WHERE org_code = '$org' AND pada_bulan = '$bln' AND pada_tahun = '$thn' ")->result_array();


		$koper = [];
		foreach ($alter as $key => $row) {
			$clean = trim($row['kode_periode'], '"');
			$j = json_decode($clean,true);
			foreach ($j as $key => $v) {
				$koper[] = $v;
			}
		}

		$ger = '('.implode(',', $koper).' )';

		$rekap = $this->db->query("SELECT * FROM iuran_bayar WHERE kode_periode IN $ger")->result_array();


		echo json_encode($rekap);
	}
}
?>