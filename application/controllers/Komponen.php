<?php
class Komponen extends CI_controller
{

	function __construct()
	{
		parent::__construct();
        chek_session();
    }

    public function index(){
    	$org = $_SESSION['org_code'];
    	$data['komponen'] = $this->db->query("SELECT * FROM iuran_kategori WHERE org_code = '$org'")->result_array();
    	$this->template->load('template/template-p', 'apps/k-komponen', $data);
    }

    public function override(){
        $org = $_SESSION['org_code'];
        $getAll = $this->db->query("SELECT * FROM warga WHERE org_code = '$org'")->result_array();

        foreach ($getAll as $key => $v) {
                 $data = [
                    'komponen' => $v['nama_iuran'],
                ];

                $this->db->where('id_warga', $v['id']);
                $this->db->update('iuran_bayar', $data);
        }
    }

}
?>