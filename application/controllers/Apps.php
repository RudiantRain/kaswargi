<?php
class Apps extends CI_controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_apps');
        $this->load->model('Model_customer');
        $this->load->model('Model_barang');
        $this->load->model('Model_kategori');
        $this->load->model('Model_stok');
        $this->load->model('Model_penjualan');
        $this->load->model('Model_kelengkapan');
        $this->load->library('cart');
        chek_session();
    }

    function index()
    {
        $org = $_SESSION['org_code'];
        $data['kas'] = $this->db->query("SELECT * FROM kas_buku WHERE org_code = '$org'")->result_array();
        $data['iuran'] = $this->db->query("SELECT pada_tahun, pada_bulan, SUM(total_nominal) as tot_bulanan FROM iuran_alter WHERE org_code = '$org' GROUP BY pada_tahun, pada_bulan")->result_array();
        $this->template->load('template/template-p', 'apps/k-home', $data);
        // var_dump($this->session->userdata());
        // die;
    }    

    function index_transaksi()
    {
    	$data['penjualan'] = $this->Model_apps->lihat_trans();
        $this->template->load('template/template-fi', 'apps/transaksi', $data);
        // var_dump($this->session->userdata());
        // die;
    }

    function lihat_customer()
    {
        $data['customer'] = $this->Model_customer->tampilkan();
        $this->template->load('template/template-fi', 'apps/customer', $data);
    }

    function post_customer()
    {
        if (isset($_POST['submit'])) {
            //proses kategori
            $this->Model_customer->post();
            $this->session->set_flashdata('message_name', 'Berhasil menyimpan data customer baru.');
            redirect('apps/post_customer');
        } else {
            $this->template->load('template/template-fi', 'apps/customer_tambah');
        }
    }

    function post_penjualan()
    {
        $data['customer'] = $this->Model_customer->tampilkan_data();
        $this->template->load('template/template-fi', 'apps/penjualan_tambah', $data);
    }

    function post_penjualan_tambah_barang($id, $qty)
    {
        $barang = $this->Model_penjualan->lihat_barang($this->input->post('idbarang'));
        if ($barang->row()->jumlah > 100) {
            $this->session->set_flashdata('message', 'Stok Barang melebihi kapasitas');
            redirect(base_url('index.php/apps/post_penjualan'));
        } else {
            $result = $this->Model_penjualan->cart($id);
            $data = array(
                'id_barang'    => $result->id_barang,
                'stok_barang'      => $result->jumlah_stok,
                'id'        => $result->id_barang,
                'name'      => $result->nama_barang,
                'qty'       => $qty,
                'price'     => $result->harga,
                'size'      => $result->ukuran,
                'namesize' => $result->nama_ukuran,
            );
            $this->cart->insert($data);
            redirect(base_url('index.php/apps/post_penjualan'));
        }
    }

    function post_penjualan_caribarang()
    {
        $key = $this->input->get('q');
        $data = $this->Model_penjualan->hasilcari($key);
        foreach ($data as $result) {
            echo '<a href="' . base_url() . 'index.php/apps/post_penjualan_tambah_barang/' . $result->id_barang . '/1">' . $result->nama_barang . '</a><br />';
        }
    }

    function post_penjualan_ubah_qty()
    {
        $barang = $this->Model_penjualan->lihat_barang($this->input->post('idbarang'));
        $permintaan = intval($this->input->post('qty'));
        $jumlahstok = intval($barang->row()->jumlah);
        if ($permintaan >= $jumlahstok) {
            $this->session->set_flashdata('message', 'Jumlah permintaan melebihi stok barang');
            redirect(base_url('index.php/apps/post_penjualan'));
        } else {
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'qty'   => $this->input->post('qty')
            );
            $this->cart->update($data);
            redirect(base_url('index.php/apps/post_penjualan'));
        }
    }
    function post_penjualan_hapus_cart($row)
    {
        $data = array(
            'rowid' => $row,
            'qty'   => 0,
        );
        $this->cart->update($data);
        redirect(base_url('index.php/apps/post_penjualan'));
    }

    function formatNbr($nbr)
    {
        if ($nbr == 0 || $nbr == NULL)
            return "001";
        else if ($nbr < 10)
            return "00" . $nbr;
        elseif ($nbr >= 10 && $nbr < 100)
            return "0" . $nbr;
        else
            return strval($nbr);
    }

    function post_penjualan_transaksi()
    {
        $no_trf = $this->Model_penjualan->get_byr($this->input->post('metode'));
        if ($no_trf->id_byr == 1) {
            $metode = strtoupper($no_trf->metode);
            $notrf = substr($metode, 0, 1);
        } else if ($no_trf->id_byr == 2) {
            $metode = strtoupper($no_trf->metode);
            $notrf = substr($metode, 0, 1);
        } else {
            $notrf = "0";
        }
        $kode = $this->Model_penjualan->get_nourut();
        $nourut = $this->formatNbr($kode[0]->nomor);
        $tgl = date('Ymd');
        $kodeurut = $notrf . $tgl . $nourut;
        $payment = array(
            'no_trf' => $kodeurut,
            'id_customer' => $this->input->post('customer'),
            'nama_pelanggan' => $this->input->post('pelanggan'),
            'totalpure' => $this->input->post('totalpure'),
            'grand_total ' => $this->input->post('grandtotal'),
            'diskon' => $this->input->post('diskon'),
            'bayar' => $this->input->post('bayar'),
            'kembalian' => $this->input->post('kembalian'),
            'catatan' => $this->input->post('note'),
            'tgl_trf' => date('Y-m-d'),
            'jam_trf' => date('H:i:s'),
            'id_pembayaran' => $this->input->post('metode'),
            'no_rek' => $this->input->post('norek'),
            'atas_nama' => $this->input->post('atas_nama'),
            'id_bank' => $this->input->post('payments'),
            'operator' => $this->session->userdata['username'],
        );
        $detail_penjualan =  $this->Model_penjualan->tambah_trf($payment);
        $id_dtlpenjualan = $this->Model_penjualan->get_id($kodeurut);

        $pjl = array();
        foreach ($this->cart->contents() as $q) {
            $pjl[] = array(
                'id_barang' => $q['id_barang'],
                'stok_barang' => intval($this->Model_penjualan->total_barang($q['id_barang'])->row()->total) - intval($q['qty']),
                'tanggal_stok' => date('Y-m-d'),
            );
        }

        foreach ($this->cart->contents() as $items) {
            $penjualan[] = array(
                'id_dtlpen'    => $id_dtlpenjualan['id'],
                'id_barang'     => $items['id_barang'],
                'jumlah_stok'     => $items['qty'],
                'harga_barang' => $items['price'],
                'sub_total' => $items['subtotal'],
            );
        }

        $png = $this->Model_penjualan->pengurangan_stok($pjl);
        $pjl = $this->Model_penjualan->tambah_pjl($penjualan);
        if (!$detail_penjualan && !$pjl && !$png) {
            $this->cart->destroy();
            $this->session->set_flashdata('message', 'Penjualan Sukses');
            // redirect('penjualan/struk/' . $id_dtlpenjualan['id']);
            redirect('apps');
        } else {
            $this->session->set_flashdata('message', 'Ooopss! Penjualan Gagal, Namun Stok Data Berubah!');
            // redirect('penjualan');
            redirect('apps');
        }
    }

    function index_stok(){
        $data['barang'] = $this->Model_barang->tampil_data()->result();
        $this->template->load('template/template-fi', 'apps/stok', $data);
    }


    function penjualan_stok(){
        $data['customer'] = $this->Model_customer->tampilkan_data();
        $data['kelengkapan'] = $this->Model_kelengkapan->tampil_data2()->result_array();
        $data['barang'] = $this->Model_barang->tampil_data()->result();
        $this->template->load('template/template-fi', 'apps/penjualan_stok', $data);
    }

    function penjualan_stok_caribarang()
    {
        $key = $this->input->get('q');
        $data = $this->Model_penjualan->hasilcari($key);
        foreach ($data as $result) {
            echo '<a href="#" onclick="tampilStok('.$result->id_barang.')" >' . $result->nama_barang . '</a><br />';
        }
    }

    function penjualan_stok_tampil_stok(){
        $key = $this->input->get('q');
        $data = $this->Model_stok->get_all_stok($key)->result();
        echo json_encode($data);
    }

    function penjualan_stok_transaksi(){
        // var_dump($this->input->post());
        $no_trf = $this->Model_penjualan->get_byr($this->input->post('metode'));
        if ($no_trf->id_byr == 1) {
            $metode = strtoupper($no_trf->metode);
            $notrf = substr($metode, 0, 1);
        } else if ($no_trf->id_byr == 2) {
            $metode = strtoupper($no_trf->metode);
            $notrf = substr($metode, 0, 1);
        } else {
            $notrf = "0";
        }
        $kode = $this->Model_penjualan->get_nourut();
        $nourut = $this->formatNbr($kode[0]->nomor);
        $tgl = date('Ymd');
        $kodeurut = $notrf . $tgl . $nourut;
        $payment = array(
            'no_trf' => $kodeurut,
            'id_customer' => $this->input->post('customer'),
            'nama_pelanggan' => $this->input->post('pelanggan'),
            'totalpure' => $this->input->post('totalpure'),
            'grand_total ' => $this->input->post('grandtotal'),
            'diskon' => $this->input->post('diskon'),
            'bayar' => $this->input->post('bayar'),
            'bayar_tunai' => str_replace(",","",$this->input->post('bayar_tunai')),
            'bayar_transfer' => str_replace(",","",$this->input->post('bayar_transfer')),
            'kembalian' => $this->input->post('kembalian'),
            'catatan' => $this->input->post('note'),
            'tgl_trf' => date('Y-m-d'),
            'jam_trf' => date('H:i:s'),
            'id_pembayaran' => $this->input->post('metode'),
            'no_rek' => $this->input->post('norek'),
            'atas_nama' => $this->input->post('atas_nama'),
            'id_bank' => $this->input->post('payments'),
            'operator' => $this->session->userdata['username'],
        );
        $detail_penjualan =  $this->Model_penjualan->tambah_trf($payment);
        $id_dtlpenjualan = $this->Model_penjualan->get_id($kodeurut);

        $penjualan[] = array(
            'id_dtlpen'    => $id_dtlpenjualan['id'],
            'id_barang'     => $this->input->post('idbarang'),
            'jumlah_stok'     => (float)$this->input->post('item_count'),
            'harga_barang' => str_replace(",","",$this->input->post('rataHarga')),
            'kelengkapan' => $this->input->post('total_kelengkapan'),
            'sub_total' => $this->input->post('subtotal'),
        );

        $pjl = $this->Model_penjualan->tambah_pjl($penjualan);

        $qty_input = $this->input->post('qty');
        foreach ($qty_input as $id_stok => $qty) {
            $this->Model_stok->kurangi_stok($id_stok, (float)$qty);
            $this->Model_stok->stok_keluar($id_stok, (float)$qty, $id_dtlpenjualan['id']);
        }

        $qty_kel = $this->input->post('kel-qty');
        foreach ($qty_kel as $id_kel => $qty) {

            $this->Model_stok->kurangi_pelengkap($id_kel, $qty);
            
        }


        redirect('apps');

    }


    function struk($id)
    {
        $cek = $this->Model_penjualan->cek_transaksi($this->uri->segment(3));
        $data = array(
            'tanggal' => $cek[0]->tgl_trf,
            'jam' => $cek[0]->jam_trf,
            'nota' => $cek[0]->no_trf,
            'operator' => $cek[0]->operator,
            'pelanggan' => $cek[0]->nama_pelanggan,
            'total' => $cek[0]->totalpure,
            'diskon' => $cek[0]->diskon,
            'grand_total' => $cek[0]->grand_total,
            'result' => $cek,
            'metode' => $cek[0]->metode,
            'bayar' => $cek[0]->bayar,
            'kembalian' => $cek[0]->kembalian,
            'rekening' => $cek[0]->no_rek,
            'bank' => $cek[0]->nama_bank,
            'atasnama' => $cek[0]->atas_nama,
        );
        $this->load->view('apps-struk', $data);
    }


}
?>