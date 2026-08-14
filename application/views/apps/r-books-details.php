<?php
$jkas = json_encode($kas);
?>

<div class="section wallet-card-section pt-1">
  <div class="wallet-card">

    <div class="balance">
      <div class="left">
        <span class="title">Saldo Buku <?= $kas[0]['kas_nama'] ?> (Rp)</span>
        <h1 class="total"><span id="total_semua">0</span></h1>
        <span class="text-muted">Per <?= date("d M Y") ?></span>
      </div>
      <div class="right">
  
      </div>
    </div>

  </div>
  <div class="row mt-2">
    <div class="col-6">
      <div class="stat-box">
        <div class="title">Semua Debet</div>
        <div class="value text-success"><span id="debet_semua">0</span></div>
      </div>
    </div>
    <div class="col-6">
      <div class="stat-box">
        <div class="title">Semua Kredit</div>
        <div class="value text-danger"><span id="kredit_semua">0</span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section full mt-2">
  <div class="section-heading padding">
    <!-- <h2 class="title">Rincian  </h2> -->
  </div>

  <!-- carousel single -->
  <div class="carousel-single splide">
    <div class="splide__track">
      <ul class="splide__list" id="list_rinci">


      </ul>
    </div>
  </div>
  <!-- * carousel single -->

</div>



<div class="modal fade action-sheet" id="withdrawActionSheet" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rincian Transaksi</h5>
      </div>
      <div class="modal-body">
        <div class="action-sheet-content">

          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email4">Nominal</label>
              <input type="text" disabled readonly class="form-control" id="nominal_edit" placeholder="0" name="nominal">
              <input type="text" hidden id="id_edit">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="textarea4">Uraian</label>
              <textarea id="uraian_edit" disabled readonly rows="3" class="form-control"
              placeholder="Textarea" name="uraian"></textarea>
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function hitungKas(data) {
  let totalMasuk = 0;
  let totalKeluar = 0;

  data.forEach(item => {
    const nominal = parseFloat(item.nominal);

    if (item.jenis_transaksi === "masuk") {
      totalMasuk += nominal;
    } else if (item.jenis_transaksi === "keluar") {
      totalKeluar += nominal;
    }
  });

  const saldo = totalMasuk - totalKeluar;

  return {
    totalMasuk,
    totalKeluar,
    saldo
  };
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

function startGo(){
  var jskas = groupKasByTahunBulan(JSON.parse('<?= $jkas ?>'));
  var jnp = hitungKas(JSON.parse('<?= $jkas ?>'));

  $('#total_semua').text(jnp.saldo.toLocaleString('id-ID'));
  $('#debet_semua').text(jnp.totalMasuk.toLocaleString('id-ID'));
  $('#kredit_semua').text(jnp.totalKeluar.toLocaleString('id-ID'));
  var htg = '';
  jskas.forEach(itemTahun => {

    itemTahun.bulan.forEach(itemBulan => {
      htg += `
      <li class="splide__slide">
      <div class="card">
      <h3 class="ms-2 mt-2">${getNamaBulan(itemBulan.bulan)}/${itemTahun.tahun}</h3>
      <ul class="listview flush transparent no-line image-listview detailed-list mt-1 mb-1">
      `;

      itemBulan.transaksi.forEach(trx => {
        var warn = trx.jenis_transaksi == 'masuk' ? 'text-success' : 'text-danger';
        var bad = trx.jenis_transaksi == 'masuk' ? 'badge-success' : 'badge-danger';
        var nom = parseInt(trx.nominal).toLocaleString("id-ID");
        const sal = parseInt(trx.saldo).toLocaleString('id-ID');
        htg += `
        <li onclick="modalDetail('${trx.id}')">
        <div class="item">
        <div class="icon-box ${warn}">
        ${trx.tahun}
        </div>
        <div class="in">
        <div>
        <div class="text-small">
        <span class="badge ${bad}">

        Rp ${nom}
        </span>
        </div>

        <div class="text-small text-secondary">${trx.kas_kategori}</div>
        </div>
        <div class="text-end">
        <strong>Rp ${sal}</strong>

        </div>
        </div>
        </div>
        </li>
        `;
      });

      htg += `    
      </ul>
      </div>
      </li>
      `;
    });
  });

  $('#list_rinci').html(htg);
}

function modalDetail(id){
  var ge = JSON.parse('<?= $jkas ?>');
  var si = ge.filter(w=> w.id == id)[0];
  $('#nominal_edit').val(si.nominal);
  $('#uraian_edit').val(si.uraian);
  $('#id_edit').val(id);
  $('#withdrawActionSheet').modal('toggle');
}




function groupKasByTahunBulan(data) {
  const saldoKas = {};      // saldo per kas_nama
  const grouped = {};

  // 🔥 1. SORT semua transaksi secara kronologis
  // Data kamu punya kolom:
  //  - tgl      → tahun
  //  - bulan    → bulan
  //  - tahun    → hari
  const sortedData = [...data].sort((a, b) => {
    const d1 = `${a.tgl}-${a.bulan}-${a.tahun}`;
    const d2 = `${b.tgl}-${b.bulan}-${b.tahun}`;
    return new Date(d1) - new Date(d2);
  });

  // 🔥 2. Proses saldo BERDASARKAN URUTAN WAKTU
  sortedData.forEach(item => {
    const tahun = item.tgl;       // tahun
    const bulan = item.bulan;     // bulan
    const hari = item.tahun;      // nama field 'tahun' = tanggal sebenarnya
    const nominal = Number(item.nominal);

    // Key kas
    const kasKey = item.kas_nama || 'Default';

    // Inisialisasi saldo kas
    if (!saldoKas[kasKey]) saldoKas[kasKey] = 0;

    // Hitung saldo berjalan sesuai urutan sorted
    saldoKas[kasKey] += item.jenis_transaksi === "masuk" ? nominal : -nominal;

    // Siapkan grouping
    if (!grouped[tahun]) grouped[tahun] = {};
    if (!grouped[tahun][bulan]) grouped[tahun][bulan] = [];

    grouped[tahun][bulan].push({
      ...item,
      tanggal_num: parseInt(hari),
      saldo: saldoKas[kasKey] // saldo berjalan valid!
    });
  });

  // 🔥 3. Konversi jadi array terstruktur
  const result = Object.entries(grouped).map(([tahun, bulanObj]) => {
    const bulanArray = Object.entries(bulanObj)
      .map(([bulan, list]) => ({
        bulan,
        transaksi: list
      }))
      .sort((a, b) => parseInt(a.bulan) - parseInt(b.bulan));

    return { tahun, bulan: bulanArray };
  });

  // 🔥 4. Urutkan tahun naik
  result.sort((a, b) => parseInt(a.tahun) - parseInt(b.tahun));

  return result;
}

startGo();
</script>