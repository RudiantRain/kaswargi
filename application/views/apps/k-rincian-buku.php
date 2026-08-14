<style>
  .masuk {
    color:green;
  }
  .keluar {
    color: red;
  }

</style>

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
        <a href="<?php echo base_url() ?>Buku/create" class="button">
          <ion-icon name="add-outline"></ion-icon>
        </a>
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

<div class="modal fade action-sheet" id="quickCreate" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Transaksi</h5>
      </div>
      <div class="modal-body">
        <div class="action-sheet-content">

          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email4">Tanggal</label>
              <input type="date" class="form-control" id="periode" placeholder="periode" name="periode">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="select4">Jenis Transaksi</label>
              <select class="form-control custom-select" id="jenis_transaksi" name="jenis_transaksi">
                <?php
                foreach ($kas_kategori as $key => $v) {
                  $cls =  $v['tipe'] == 'masuk'? 'masuk' : 'keluar';
                  ?>
                  <option value="<?= $v['tipe'] ?>|<?= $v['nama'] ?>" class="<?= $cls ?>"><?= $v['tipe'] ?> | <?= $v['nama'] ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="select4">Buku Kas</label>
              <select class="form-control custom-select" id="id_kas_nama" name="id_kas_nama">
                <?php
                foreach ($kas_nama as $key => $k) {
                  ?>
                  <option value="<?= $k['id'] ?>-<?= $k['nama_kas'] ?>"><?= $k['nama_kas'] ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email4">Nominal</label>
              <input type="number" class="form-control" id="nominal" placeholder="0" name="nominal">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="textarea4">Uraian</label>
              <textarea id="uraian" rows="3" class="form-control"
              placeholder="Textarea" name="uraian"></textarea>
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
          <div class="form-button-group  transparent">
            <button type="button" onclick="quickTrans()" class="btn btn-primary btn-block btn-lg">Simpan</button>
          </div>

        </div>
      </div>
    </div>
  </div>
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
              <input type="number" class="form-control" id="nominal_edit" placeholder="0" name="nominal">
              <input type="text" hidden id="id_edit">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="textarea4">Uraian</label>
              <textarea id="uraian_edit" rows="3" class="form-control"
              placeholder="Textarea" name="uraian"></textarea>
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>

          <div class="form-group basic">
            <div class="row">
              <div class="col-4">
                <button type="button" class="btn btn-danger btn-block btn-lg"
                data-bs-dismiss="modal" onclick="deleteTrans()">Hapus</button>
              </div>
              <div class="col-8">
                <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal" onclick="editTrans()">Simpan</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function quickTrans(){
    let page = '<?= base_url() ?>';
    var id = $('#id_edit').val();
    var url = page + "Buku/quickCreate";
    $.ajax({
      url: url,
      type: "POST",
      data: {
        'periode': $('#periode').val(),
        'jenis_transaksi': $('#jenis_transaksi').val(),
        'id_kas_nama' : $('#id_kas_nama').val(),
        'nominal' : $('#nominal').val(),
        'uraian' : $('#uraian').val(),
      },
      success: function(data) {
        window.location.reload();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });


  }

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

function quc(tgl){
  $('#periode').val(tgl),
  $('#quickCreate').modal('toggle');
}

function startGo(){
  var jskas = groupKasByTahunBulan(JSON.parse('<?= $jkas ?>'));
  var jnp = hitungKas(JSON.parse('<?= $jkas ?>'));
  console.log(jnp);
  console.log(jskas);

  $('#total_semua').text(jnp.saldo.toLocaleString('id-ID'));
  $('#debet_semua').text(jnp.totalMasuk.toLocaleString('id-ID'));
  $('#kredit_semua').text(jnp.totalKeluar.toLocaleString('id-ID'));
  var htg = '';
  jskas.forEach(itemTahun => {

    itemTahun.bulan.forEach(itemBulan => {
      htg += `
      <li class="splide__slide">
      <div class="card">
      <div class="section-heading padding mt-2">
      <h3 class="title">${getNamaBulan(itemBulan.bulan)}/${itemTahun.tahun}</h3>
      <span class="badge badge-dark" onclick="quc('${itemTahun.tahun}-${itemBulan.bulan}-01')">+ transaksi</span>
      </div>
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
  console.log(ge);
  var si = ge.filter(w=> w.id == id)[0];
  $('#nominal_edit').val(si.nominal);
  $('#uraian_edit').val(si.uraian);
  $('#id_edit').val(id);
  $('#withdrawActionSheet').modal('toggle');
}

function editTrans(){
  let page = '<?= base_url() ?>';
  var id = $('#id_edit').val();
  var url = page + "Buku/editTrans";
  $.ajax({
    url: url,
    type: "POST",
    data: {
      'id_edit': id,
      'id_kas_nama' : '<?= $kas[0]['id_kas_nama'] ?>',
      'nominal' : $('#nominal_edit').val(),
      'uraian' : $('#uraian_edit').val(),
    },
    success: function(data) {
      window.location.reload();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert('Error adding / update data');
    }
  });


}

function deleteTrans(){
  let page = '<?= base_url() ?>';
  var id = $('#id_edit').val();
  var url = page + "Buku/deleteKasEntry";
  $.ajax({
    url: url,
    type: "POST",
    data: {
      'id_edit': id,
      'id_kas_nama' : '<?= $kas[0]['id_kas_nama'] ?>',
    },
    success: function(data) {
      window.location.reload(true);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert('Error adding / update data');
    }
  });

            // window.location.reload();
          }

//           function groupKasByTahunBulan(data) {
//             const grouped = {};
//   const saldoKas = {}; // saldo per kas_nama

//   data.forEach(item => {
//     // 🔧 Perbaiki kolom tertukar
//     const tahun = item.tgl;               // seharusnya tahun
//     const bulan = item.bulan;             // bulan tetap
//     const tanggal = parseInt(item.tahun); // field 'tahun' isinya tanggal (seharusnya 'tgl')
//     const nominal = Number(item.nominal);

//     // Hitung saldo berjalan per kas
//     const kasKey = item.kas_nama || 'Default';
//     if (!saldoKas[kasKey]) saldoKas[kasKey] = 0;
//     saldoKas[kasKey] += item.jenis_transaksi === 'masuk' ? nominal : -nominal;

//     // Siapkan struktur grouping
//     if (!grouped[tahun]) grouped[tahun] = {};
//     if (!grouped[tahun][bulan]) grouped[tahun][bulan] = [];

//     grouped[tahun][bulan].push({
//       ...item,
//       tanggal_num: tanggal,
//       saldo: saldoKas[kasKey]
//     });
//   });

//   // 🔁 Ubah hasil jadi array terstruktur
//   const result = Object.entries(grouped).map(([tahun, dataBulan]) => {
//     const bulanArr = Object.entries(dataBulan).map(([bulan, list]) => {
//       // urutkan transaksi berdasarkan tanggal
//       list.sort((a, b) => a.tanggal_num - b.tanggal_num);
//       return { bulan, transaksi: list };
//     });

//     // urutkan bulan secara numerik (01, 02, 03, ...)
//     bulanArr.sort((a, b) => parseInt(a.bulan) - parseInt(b.bulan));

//     return { tahun, bulan: bulanArr };
//   });

//   // urutkan tahun secara menaik
//   result.sort((a, b) => parseInt(a.tahun) - parseInt(b.tahun));

//   return result;
// }

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