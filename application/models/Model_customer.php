<?php

class Model_customer extends CI_Model{
	
	function tampilkan_data() {

		return 
		$this->db->get('customer')->result(); 
	}

	function tampilkan() {

		return 
		$this->db->get('customer')->result_array(); 
	}
	function post()
	{
		$data=array
		(
			'nama'=> $this->input->post('nama'),
			'kontak' => $this->input->post('kontak')
		);
		$this->db->insert('customer', $data);
	}

	// function edit()
	// {
	// 	$data=array('nama_kategori'=> $this->input->post('kategori'));
	// 	$this->db->where('id_kategori', $this->input->post('id'));
	// 	$this->db->update('kategori',$data);
	// }

	// function get_one($id)
	// {
	// 	$param = array('id_kategori'=>$id);
	// 	return $this->db->get_where('kategori',$param);
	// }


}


?>