<?php
class Warga extends CI_controller
{

	function __construct()
	{
		parent::__construct();
        chek_session();
    }

    public function index(){
    	$org = $_SESSION['org_code'];
    	$data['warga'] = $this->db->query("SELECT id,org_code,nama_warga,blok,total_iuran,aktif,deposit FROM warga WHERE org_code = '$org'")->result_array();
    	$this->template->load('template/template-p', 'apps/k-warga', $data);
    }

    public function wargaDetail(){
    	$id = $this->uri->segment(3);
    	$org = $_SESSION['org_code'];
    	$warga = $this->db->query("SELECT * FROM warga WHERE org_code = '$org' AND id = '$id'")->result_array();

        $data['warga'] = $warga;
        $data['kat_iuran'] = $this->db->query("SELECT * FROM iuran_kategori WHERE org_code = '$org'")->result_array();
        $data['kartu'] = $this->db->query("SELECT id,org_code,kode_periode,id_warga,nama_warga,nominal,status,tgl_bayar,bulan,tahun,nama_operator FROM iuran_bayar WHERE id_warga = '$id'  ORDER BY id DESC")->result_array();
        $this->template->load('template/template-p', 'apps/k-warga-detail', $data);
    }


    public function wargaBayar(){
        $id = $this->input->post('id_bayar');
        $data = [
            'status' => 'LUNAS',
            'tgl_bayar' => date('d-M-Y'),
        ];

        $get = $this->db->query("SELECT * FROM iuran_bayar WHERE id = '$id'")->result_array()[0];

        $this->db->where('id', $id);
        $this->db->update('iuran_bayar', $data);
        $peri = $get['kode_periode'];
        $cek = $this->db->query("SELECT * FROM iuran_alter WHERE kode_periode LIKE '%$peri%'")->result_array();
        if(count($cek)==0){
            $dataa = [
                'org_code' => $_SESSION['org_code'],
                'kode_periode' => json_encode([$get['kode_periode']]),
                'id_warga' => $get['id_warga'],
                'nama_warga' => $get['nama_warga'],
                'nominal' => $get['nominal'],
                'total_nominal' => $get['nominal'],
                'jum_periode' => 1,
                'untuk_periode' => json_encode([$get['tahun'].'-'.$get['bulan']]),
                'pada_bulan' => date('m'),
                'pada_tahun' => date('Y'),
                'nama_operator' => $_SESSION['username'],
            ];

            $this->db->insert('iuran_alter', $dataa);
        }

        return json_encode(['status'=>'success']);
    }

    public function hapusBayar(){
        $id = $this->input->post('id_bayar');

        $this->db->where('id', $id);
        $this->db->delete('iuran_bayar');

        return json_encode(['status'=>'success']);
    }

    public function wargaDepo(){
        $id = $this->input->post('id_edit');
        $nominal_edit = $this->input->post('nominal_edit');
        $data = [
            'deposit' => $nominal_edit,
        ];

        $this->db->where('id', $id);
        $this->db->update('warga', $data);

        return json_encode(['status'=>'success']);
    }

    public function wargaNama(){
        $id = $this->input->post('id_edit');
        $nominal_edit = $this->input->post('nama_warga');
        $data = [
            'nama_warga' => $nominal_edit,
        ];

        $this->db->where('id', $id);
        $this->db->update('warga', $data);

        return json_encode(['status'=>'success']);
    }

    public function editIuran(){
        $id = $this->input->post('id_edit');
        $nominal_edit = $this->input->post('nominal_edit');
        $data = [
            'total_iuran' => $nominal_edit,
        ];

        $this->db->where('id', $id);
        $this->db->update('warga', $data);

        return json_encode(['status'=>'success']);
    }


    public function toggleStatus(){
         $id = $this->input->post('id_status');

         $cek = $this->db->query("SELECT * FROM warga WHERE id = '$id'")->result_array()[0];
         $status = '1';
         if($cek['aktif'] == '1'){
            $status = '0';
         }else{
            $status = '1';
         }

        $this->db->where('id', $id);
        $this->db->update('warga', ['aktif' => $status]);

        return json_encode(['status'=>'success']);
    }


    public function quickAddWarga(){
        $org = $_SESSION['org_code'];
        $nama_warga = $this->input->post('nama_warga');
        $blok = $this->input->post('blok');
        $total_iuran = $this->input->post('total_iuran');

        $data = [
            'org_code' => $org,
            'nama_warga' => $nama_warga,
            'nama_iuran' => '[]',
            'total_iuran' => $total_iuran,
            'blok' => $blok,
            'aktif' => '1',
        ];

        $this->db->insert('warga',$data);
        return json_encode(['status'=>'success']);
    }

    public function updateKomponen(){
        $id_warga = $this->input->post('id_warga');
        $nama_komponen = $this->input->post('nama_komponen');
        $nominal_edit = $this->input->post('nominal_edit');

        $data = [
            'nama_iuran' => $nama_komponen,
            'total_iuran' => $nominal_edit,
        ];

        $this->db->where('id', $id_warga);
        $this->db->update('warga', $data);
        return json_encode(['status'=>'success']);
    }
}