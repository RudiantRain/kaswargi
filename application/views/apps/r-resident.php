<?php
$krtu = json_encode($kartu);
?>

<div class="section full gradientSection">
    <div class="in">
        <h5 class="title mb-2">Data Warga</h5>
        <h1 class="total"><?= $warga[0]['nama_warga'] ?></h1>
        <h4 class="caption">
            <?= $warga[0]['blok'] ?>
        </h4>
        <div class="wallet-inline-button mt-5">
          <a href="#" class="item" data-bs-toggle="modal" data-bs-target="#CheckDialog">
            <div class="iconbox">
              <ion-icon name="checkmark" role="img" class="md hydrated" aria-label="arrow down outline"><template shadowrootmode="open"><div class="icon-inner"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon s-ion-icon" viewBox="0 0 512 512"><title>Arrow Down</title><path stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M112 268l144 144 144-144M256 392V100" class="ionicon-fill-none"></path></svg></div></template></ion-icon>
          </div>
          <h3 class="caption"><strong><?= $warga[0]['aktif'] == '1' ? 'AKTIF' : 'NON-AKTIF!' ?></strong></h3>
      </a>
      <a href="#" class="item" data-bs-toggle="modal" data-bs-target="#BintangDialog">
        <div class="iconbox">
          <ion-icon name="star" role="img" class="md hydrated" aria-label="arrow down outline"><template shadowrootmode="open"><div class="icon-inner"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon s-ion-icon" viewBox="0 0 512 512"><title>Arrow Down</title><path stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M112 268l144 144 144-144M256 392V100" class="ionicon-fill-none"></path></svg></div></template></ion-icon>
      </div>
      <h3 class="caption"><strong><span class="persen"></span>%</strong></h3>
  </a>
</div>
</div>
</div>
<div class="section mt-4">
    <div class="section-heading">
        <h2 class="title">Kartu Iuran</h2>

    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="stat-box">
                <div class="title">Nilai Iuran (Rp)</div>
                <div class="value text-success"><span id="debet_semua"><?= number_format($warga[0]['total_iuran']) ?></span></div>
                <br>
                <blockquote class="blockquote" onclick="dialogKomponen()"><span id="kat_iuran"></span></blockquote>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-6">
            <div class="stat-box" onclick="dialogDeposit()">
                <div class="title">Deposit (Rp)</div>
                <div class="value text-success"><span id="depo"><?= number_format($warga[0]['deposit']) ?></span></div>
            </div>
        </div>
        <div class="col-6">
            <div class="stat-box">
                <div class="title">Tertunggak (Rp)</div>
                <div class="value text-danger"><span id="tungtung">0</span>
                </div>
            </div>
        </div>
    </div>
    <div class="transactions mt-2">


    </div>
</div>

        <div class="modal fade dialogbox" id="BintangDialog" data-bs-backdrop="static" tabindex="-1"
            role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-icon text-warning">
                        <ion-icon name="star"></ion-icon>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title"><span class="persen">0</span>%</h5>
                    </div>
                    <div class="modal-body">
                        Persentase kedisiplinan pembayaran iuran.
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn" data-bs-dismiss="modal">OK</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade dialogbox" id="CheckDialog" data-bs-backdrop="static" tabindex="-1"
            role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-icon text-success">
                        <ion-icon name="checkmark-circle"></ion-icon>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Verifikasi</h5>
                    </div>
                    <div class="modal-body">
                        Warga Aktif
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn" data-bs-dismiss="modal">OK</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
  var allkartu = JSON.parse('<?= $krtu ?>');

  function start() {
   var gh = '';
   var tungg = 0;
   var hit = 0;

   var sorted = sortByNewest(allkartu);
   $.each(sorted,function(x,c){
    var stat = c.status == 'LUNAS' ? '<span class="text-success">LUNAS</span>': '<span class="text-danger">BELUM</span>';
    if(c.status == 'BELUM'){
        tungg += parseInt(c['nominal']);
    }else{
        hit ++;
    }
    gh += `
    <a href="#" class="item">
    <div class="detail">
    <div>
    <strong>${getNamaBulan(c.bulan)}/${c.tahun}</strong>
    <h3>${stat}</3>
    </div>
    </div>
    <div class="right">
    <div class="price">Rp ${parseInt(c['nominal']).toLocaleString('id-ID')}</div>
    </div>
    </a>
    `;
});

   $('.transactions').html(gh);
   $('#tungtung').text(tungg.toLocaleString('id-ID'));

    var prosen = (hit/allkartu.length) * 100;
 console.log(prosen);
 $('.persen').text(prosen.toFixed(0));

  var htk = '';
 $.each(JSON.parse('<?= $warga[0]['nama_iuran'] ?>'), function(j,k){
    htk += `<div class="badge badge-dark">${k.nama_iuran}</div>&nbsp;`;
 });



 $('#kat_iuran').html(htk);

}

function sortByNewest(data) {
    return data.sort((a, b) => {
        const tA = parseInt(a.tahun);
        const tB = parseInt(b.tahun);

        if (tA !== tB) return tB - tA;  // tahun besar dulu (DESC)

        // kalau tahun sama → bandingkan bulan
        const bA = parseInt(a.bulan);
        const bB = parseInt(b.bulan);

        return bB - bA; // bulan besar dulu (DESC)
    });
}

function getNamaBulan(bulan) {
    const namaBulan = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember"
    ];

  // Pastikan input berupa angka 1–12
  const index = parseInt(bulan, 10) - 1;

  // Validasi
  if (index >= 0 && index < 12) {
    return namaBulan[index];
} else {
    return "Bulan tidak valid";
}
}


start();
</script>  