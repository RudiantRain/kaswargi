<?php
class Buku extends CI_controller
{

	function __construct()
	{
		parent::__construct();
        chek_session();
    }

    function index()
    {
        $org = $_SESSION['org_code'];
        $data['kas'] = $this->db->query("SELECT * FROM kas_buku WHERE org_code = '$org'")->result_array();
        $this->template->load('template/template-p', 'apps/k-buku-kas', $data);
        // var_dump($this->session->userdata());
        // die;
    }

    function create()
    {
        if (isset($_POST["submit"])) {
            $periode = $this->input->post('periode');
            $jenis_transaksi = $this->input->post('jenis_transaksi');
            $id_kas_nama = $this->input->post('id_kas_nama');
            $nominal = $this->input->post('nominal');
            $uraian = $this->input->post('uraian');

            $pr = explode("-",$periode);
            $jt = explode("|",$jenis_transaksi);
            $kn = explode("-",$id_kas_nama);

            $uran = str_replace(array("'",'"'),"", $uraian);

            $data = [
                'tanggal' => $periode,
                'id_kas_nama' => $kn[0],
                'kas_nama' => $kn[1],
                // 'uraian' => preg_replace("/[\n\r]/", "", $uran),
                'uraian' => preg_replace('/[\r\n\'"]/', '', $uran),
                'jenis_transaksi' => trim($jt[0]),
                'operator_name' => $_SESSION['username'],
                'org_code' => $_SESSION['org_code'],
                'tgl' => $pr[0],
                'bulan' => $pr[1],
                'tahun' => $pr[2],
                'kas_kategori' => trim($jt[1]),
                'nominal' => $nominal,
            ];

            $this->db->insert('kas_buku', $data);

            // redirect('Apps');
            $red = base_url().'Buku/readByIdKas/'.$kn[0];
            redirect($red);
        } else {
            $org = $_SESSION['org_code'];
            $id_op = $_SESSION['id'];
            $data['kas_kategori'] = $this->db->query("SELECT * FROM kas_kategori WHERE org_code = '$org'")->result_array();
            $data['kas_nama'] = $this->db->query("SELECT * FROM kas_nama WHERE org_code = '$org' AND id_operator = '$id_op' ")->result_array();
            $this->template->load('template/template-p', 'apps/k-input-buku', $data);
        }
    }

    function readByIdKas(){
        $id = $this->uri->segment(3);
        $org = $_SESSION['org_code'];
        $id_op = $_SESSION['id'];
        $data['kas_kategori'] = $this->db->query("SELECT * FROM kas_kategori WHERE org_code = '$org'")->result_array();
        $data['kas_nama'] = $this->db->query("SELECT * FROM kas_nama WHERE org_code = '$org' AND id_operator = '$id_op' ")->result_array();
        $data['kas'] = $this->db->query("SELECT * FROM kas_buku WHERE org_code = '$org' AND id_kas_nama = '$id'")->result_array();
        $this->template->load('template/template-p', 'apps/k-rincian-buku', $data);
    }

    function editTrans(){
        $id_edit = $this->input->post('id_edit');
        $id_kas_nama = $this->input->post('id_kas_nama');
        $nominal = $this->input->post('nominal');
        $uraian = $this->input->post('uraian');

        $uran = str_replace(array("'",'"'),"", $uraian);

        $data = [
            'nominal' => trim($nominal),
            'uraian' => preg_replace("/[\n\r]/", "|", $uran),
        ];




        $this->db->where('id', $id_edit);
        $this->db->update('kas_buku', $data);
        return json_encode(['status' => 'success']);
    }

    function deleteKasEntry(){
        $id_edit = $this->input->post('id_edit');
        $id_kas_nama = $this->input->post('id_kas_nama');
        $this->db->where('id', $id_edit);
        $this->db->delete('kas_buku');
        // $red = base_url().'Buku/readByIdKas/'.$id_kas_nama;
        // redirect($red);
        return json_encode(['status' => 'success']);
    }

    function quickCreate(){
        $periode = $this->input->post('periode');
        $jenis_transaksi = $this->input->post('jenis_transaksi');
        $id_kas_nama = $this->input->post('id_kas_nama');
        $nominal = $this->input->post('nominal');
        $uraian = $this->input->post('uraian');

        $pr = explode("-",$periode);
        $jt = explode("|",$jenis_transaksi);
        $kn = explode("-",$id_kas_nama);

        $data = [
            'tanggal' => $periode,
            'id_kas_nama' => $kn[0],
            'kas_nama' => $kn[1],
            'uraian' => preg_replace("/[\n\r]/", "", $uraian),
            'jenis_transaksi' => trim($jt[0]),
            'operator_name' => $_SESSION['username'],
            'org_code' => $_SESSION['org_code'],
            'tgl' => $pr[0],
            'bulan' => $pr[1],
            'tahun' => $pr[2],
            'kas_kategori' => trim($jt[1]),
            'nominal' => $nominal,
        ];

        $this->db->insert('kas_buku', $data);
        return json_encode(['status' => 'success']);
    }    

}