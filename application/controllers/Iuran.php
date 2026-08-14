<?php
class Iuran extends CI_controller
{

	function __construct()
	{
		parent::__construct();
		chek_session();
	}

	function index()
	{
		$org = $_SESSION['org_code'];
		$data['rekap'] = $this->db->query("SELECT id,org_code,kode_periode,id_warga,nama_warga,nominal,status,tgl_bayar,bulan,tahun,nama_operator FROM iuran_bayar WHERE org_code = '$org'")->result_array();
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

        $data['tunggak'] = $this->db->query("SELECT id,org_code,kode_periode,id_warga,nama_warga,nominal,status,tgl_bayar,bulan,tahun,nama_operator, COUNT(org_code) as tunggak, SUM(nominal) as jumlah FROM iuran_bayar WHERE `status` = 'BELUM' AND org_code = '$org' GROUP BY id_warga ORDER BY tunggak DESC")->result_array();
        $this->template->load('template/template-p', 'apps/k-iuran', $data);
    }

    function create()
    {
      if (isset($_POST["submit"])) {
			$datax = $this->input->post('data'); // select pertama, sebaiknya ubah name-nya nanti
			$warga      = $this->input->post('warga');
            $dari       = $this->input->post('dari');  // format: YYYY-MM
            $sampai     = $this->input->post('sampai');
            $pada_bulan = $this->input->post('pada_bulan');

            $org = $_SESSION['org_code'];

            list($id_warga, $nama_warga) = explode('|', $warga);

            $start = new DateTime($dari . '-01');
            $end   = new DateTime($sampai . '-01');
            $end->modify('last day of this month'); // agar menghitung sampai akhir bulan

            // Loop per bulan
            $period = new DatePeriod(
            	$start,
            	new DateInterval('P1M'),
                (clone $end)->modify('+1 day') // agar bulan akhir juga ikut dihitung
            );

            $getWarg = $this->db->query("SELECT * FROM warga WHERE id = '$id_warga'")->result_array()[0];

            $ko_alter = [];
            $u_per = [];
            $ct = 0;

            foreach ($period as $dt) {
            	$bulan = $dt->format('m');
            	$tahun = $dt->format('Y');

                $ko_alter[] = $id_warga.$bulan.$tahun;
                $u_per[] = $tahun.'-'.$bulan;

                $cek = $this->db->get_where('iuran_bayar',['kode_periode' => $id_warga.$bulan.$tahun])->result_array();

                if(count($cek)>0){
                        // JIKA TAGIHAN SUDAH DIBUAT
                  $data = [
                   'status' => $datax,
                   'tgl_bayar' => date('d-M-Y'),
               ];

               $this->db->where('kode_periode', $id_warga.$bulan.$tahun);
               $this->db->update('iuran_bayar', $data);
           }else{
                        // JIKA TAGIHAN BELUM DIBUAT
              $data = [
               'org_code' => $org,
               'kode_periode' => $id_warga.$bulan.$tahun,
               'id_warga' => $id_warga,
               'nama_warga' => $nama_warga,
               'nominal' => $getWarg['total_iuran'],
               'komponen' => $getWarg['nama_iuran'],
               'status' => $datax,
               'tgl_bayar' => $datax == 'LUNAS' ? date('d-M-Y') : '',
               'bulan' => $bulan,
               'tahun' => $tahun,
               'nama_operator' => $_SESSION['username'],
           ];

           $this->db->insert('iuran_bayar', $data);	
       }

       $ct++;
   }


   if($datax == 'LUNAS'){
       $kop = json_encode($ko_alter);
       $cekalter = $this->db->query("SELECT * FROM iuran_alter WHERE kode_periode = '$kop'")->result_array();

       if(count($cekalter) == 0){
        $pb = explode('-', $pada_bulan);
        $dataa = [
            'org_code' => $org,
            'kode_periode' => json_encode($ko_alter),
            'id_warga' => $id_warga,
            'nama_warga' => $nama_warga,
            'nominal' => $getWarg['total_iuran'],
            'total_nominal' => (int)$getWarg['total_iuran'] * $ct,
            'jum_periode' => $ct,
            'untuk_periode' => json_encode($u_per),
            'pada_bulan' => $pb[1],
            'pada_tahun' => $pb[0],
            'nama_operator' => $_SESSION['username'],
        ];

        $this->db->insert('iuran_alter', $dataa);
    }
}

redirect('Iuran');

} else {
 $org = $_SESSION['org_code'];

 $data['warga'] = $this->db->query("SELECT * FROM warga WHERE org_code = '$org'")->result_array();
 $this->template->load('template/template-p', 'apps/k-input-iuran', $data);
}
}

function createBulk(){
 $bultag = $this->input->post('bulan_tagihan');
 $org = $_SESSION['org_code'];

 $tag = new DateTime($bultag);

 $getWarg = $this->db->query("SELECT * FROM warga WHERE org_code = '$org' AND aktif = '1'")->result_array();

 foreach ($getWarg as $g) {
  $bulan = $tag->format('m');
  $tahun = $tag->format('Y');
  $kode = $g['id'].$bulan.$tahun;

  $cek = $this->db->query("SELECT * FROM iuran_bayar WHERE kode_periode = '$kode'")->result_array();

  if(count($cek) == 0){
   $data = [
    'org_code' => $org,
    'kode_periode' => $kode,
    'id_warga' => $g['id'],
    'nama_warga' => $g['nama_warga'],
    'nominal' => $g['total_iuran'],
    'komponen' => $g['nama_iuran'],
    'status' => 'BELUM',
    'bulan' => $bulan,
    'tahun' => $tahun,
    'nama_operator' => $_SESSION['username'],
];

$this->db->insert('iuran_bayar', $data);
}
}
return json_encode(['status' => 'success']);
}

function cancelPayment(){
    $id = $this->input->post('id_batalkan');

    $getPay = $this->db->query("SELECT * FROM iuran_alter WHERE id = '$id'")->result_array()[0];

    $fre = json_decode($getPay['kode_periode'], true);

    foreach ($fre as $key => $v) {
        $data = [
            'tgl_bayar' => '',
            'status' => 'BELUM'
        ];

        $this->db->where('kode_periode', $v);
        $this->db->update('iuran_bayar', $data);
    }
    $this->db->where('id', $id);
    $this->db->delete('iuran_alter');

    return json_encode(['status' => 'success']);
}

}

?>