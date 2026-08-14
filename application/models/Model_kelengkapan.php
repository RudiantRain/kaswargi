<?php

class Model_kelengkapan extends CI_Model{

	function tampil_data2(){
		return $this->db->get('kelengkapan');
	}

}

?>