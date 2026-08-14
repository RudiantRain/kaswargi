<?php
$khas = json_encode($kas);
?>
<div class="section full mt-4">
    <div class="section-heading padding">
        <h2 class="title">Pembukuan</h2>
        <a href="#" class="link">Semua</a>
    </div>
</div>    
<div class="section mt-2" id="list_rinci">
</div>



<script>
	function starGo(){
		var jskas = olahKas(JSON.parse('<?= $khas ?>'));

		        var htj = '';
        Object.values(jskas.rekap_kas).forEach(kas=>{
            var sal = kas.saldo.toLocaleString();
            var deb = kas.masuk.toLocaleString();
            var kre = kas.keluar.toLocaleString();
            htj+=`

            <div class="card-block bg-dark mb-2">
            <div class="card-main">
            <div class="card-button dropdown">
            <button type="button" class="btn btn-link btn-icon" data-bs-toggle="dropdown">
            <ion-icon name="ellipsis-horizontal"></ion-icon>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="<?= base_url() ?>Buku/readByIdKas/${kas.id_kas}">
            <ion-icon name="pencil-outline"></ion-icon>Lihat Rincian
            </a>
            </div>
            </div>
            <div class="balance">
            <span class="label">SALDO</span>
            <h1 class="title">${sal}</h1>
            </div>
            <div class="in">
            <div class="card-number">
            <span class="label">NAMA BUKU KAS</span>
            ${kas.kas_nama}
            </div>
            <div class="bottom">
            <div class="card-expiry">
            <span class="label">Debet</span>
            ${deb}
            </div>
            <div class="card-ccv">
            <span class="label">Kredit</span>
            ${kre}
            </div>
            </div>
            </div>
            </div>
            </div>

            `;
        });

        $('#list_rinci').html(htj);
	}

    function olahKas(data) {

      const grouped = {};

      data.forEach(item => {
        const kas = item.kas_nama;
        const id_nama = item.id_kas_nama;
        const nominal = parseFloat(item.nominal);

        if (!grouped[kas]) {
          grouped[kas] = {
            kas_nama: kas,
            id_kas : id_nama,
            masuk: 0,
            keluar: 0,
            saldo: 0,
            transaksi: []
        };
    }

    // Pisahkan transaksi masuk dan keluar
    if (item.jenis_transaksi === 'masuk') {
      grouped[kas].masuk += nominal;
  } else if (item.jenis_transaksi === 'keluar') {
      grouped[kas].keluar += nominal;
  }

    // Simpan semua transaksi untuk referensi detail
    grouped[kas].transaksi.push(item);
});

  // Hitung saldo tiap kas
  Object.keys(grouped).forEach(kas => {
    grouped[kas].saldo = grouped[kas].masuk - grouped[kas].keluar;
});

  // Hitung total keseluruhan semua kas
  const totalMasuk = Object.values(grouped).reduce((sum, kas) => sum + kas.masuk, 0);
  const totalKeluar = Object.values(grouped).reduce((sum, kas) => sum + kas.keluar, 0);
  const totalSaldo = totalMasuk - totalKeluar;

  return {
    rekap_kas: grouped,
    total: {
      masuk: totalMasuk,
      keluar: totalKeluar,
      saldo: totalSaldo
  }
};
}

starGo();
</script>