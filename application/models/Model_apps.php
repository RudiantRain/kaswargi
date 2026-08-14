<?php

class Model_apps extends Ci_Model
{
	function lihat_trans_today(){
		return $this->db->query("SELECT a.*,b.id, b.nama_pelanggan, b.tgl_trf, b.no_trf, c.nama_barang
	FROM penjualan a 
	LEFT JOIN detail_penjualan b ON a.id_dtlpen = b.id
	LEFT JOIN barang c ON a.id_barang = c.id_barang
	WHERE b.tgl_trf = CURDATE()")->result_array();
	}

	function lihat_trans(){
		return $this->db->query("SELECT a.*,b.id, b.nama_pelanggan, b.tgl_trf, b.no_trf, c.nama_barang
	FROM penjualan a 
	LEFT JOIN detail_penjualan b ON a.id_dtlpen = b.id
	LEFT JOIN barang c ON a.id_barang = c.id_barang")->result_array();
	}
}
?>