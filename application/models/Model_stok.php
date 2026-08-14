<?php

class Model_stok extends CI_Model{

	function tampil_data()
	{
		return 
		$this->db->join('barang','barang.id_barang = stok.id_barang','left')
		->join('kategori','kategori.id_kategori = barang.id_kategori','left')
		->get('stok')->result();
	}

	function tampil_data2(){
		return $this->db->get('stok')->result();
	}

	function post($data)
	{
		$this->db->insert('stok', $data);
	}

	function get_one($id)
	{
		$param = array ('id_stok'=>$id);
		return $this->db->get_where('stok', $param);
	}

	function edit($id,$data)
	{
		$this->db->where('id_stok', $id);
		$this->db->update('stok', $data);
	}

	function tambah_stok($id,$data)
	{
		$this->db->where('id_barang', $id);
		$this->db->update('stok', $data);
	}

	function hapus($id)
	{
		$this->db->where('id_stok', $id);
		$this->db->delete('stok');
	}
	
	function get_stok($id){
		$param = array('id_barang' => $id);
		return $this->db->get_where('stok',$param)->row();
	}

	function get_all_stok($id){
		return $this->db->query("SELECT a.*, b.nama_barang FROM stok a LEFT JOIN barang b ON a.id_barang = b.id_barang WHERE a.id_barang = '$id' AND a.stok_barang > 0");
	}

	function post_riwayat($data){
		$this->db->insert('riwayat_harga', $data);
	}

	function get_riwayat(){
		return $this->db->query("SELECT a.*, b.nama_barang FROM riwayat_harga a LEFT JOIN barang b ON a.id_barang = b.id_barang");
	}
	function get_riwayat_keluar(){
		return $this->db->query("SELECT a.*,b.kode_stok, c.nama_barang, d.no_trf FROM stok_keluar a LEFT JOIN stok b ON a.id_stok = b.id_stok LEFT JOIN barang c ON b.id_barang = c.id_barang LEFT JOIN detail_penjualan d ON a.id_dtlpen = d.id");
	}

	function get_last_stok($id){
		return $this->db->query("SELECT * FROM stok WHERE id_barang = '$id' ORDER BY id_stok DESC LIMIT 1");
	}

	public function kurangi_stok($id_stok, $qty) {
        $this->db->set('stok_barang', 'stok_barang - ' . (float) $qty, FALSE);
        $this->db->where('id_stok', $id_stok);
        $this->db->update('stok');
    }

    public function kurangi_pelengkap($id_stok, $qty){
    	$this->db->set('stok', 'stok - ' . (int) $qty, FALSE);
        $this->db->where('id', $id_stok);
        $this->db->update('kelengkapan');
    }

    public function stok_keluar($id_stok, $qty, $iddtl){
    	$this->db->query("INSERT INTO stok_keluar (id_stok, qty, id_dtlpen) VALUES ($id_stok, $qty, $iddtl)");
    }

    public function kembalikan_stok($id_stok, $qty) {
        $this->db->set('stok_barang', 'stok_barang + ' . (float) $qty, FALSE);
        $this->db->where('id_stok', $id_stok);
        $this->db->update('stok');
    }

    public function get_stok_keluar($id_dtlpen){
    	return $this->db->query("SELECT * FROM stok_keluar WHERE id_dtlpen = '$id_dtlpen'")->result_array();
    }

    public function hapus_stok_keluar($id){
    	$this->db->where('id', $id);
		$this->db->delete('stok_keluar');
    }

}
