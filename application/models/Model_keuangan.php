<?php

class Model_keuangan extends Ci_Model
{
	function tampilkan_biaya() {

		return 
		$this->db->get('keu_biaya')->result(); 
	}

	function tampilkan_bonsem(){
		return 
		$this->db->get('keu_bonsem')->result();
	}


	function tambah_biaya($data){
		$this->db->insert('keu_biaya', $data);
	}

	function tambah_bonsem($data){
		$this->db->insert('keu_bonsem', $data);
	}

	function hapus_biaya($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('keu_biaya');
	}

	function hapus_bonsem($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('keu_bonsem');
	}
}
?>