<?php
$krtu = json_encode($kartu);
$kat = json_encode($kat_iuran);
?>

<div class="section full gradientSection">
  <div class="in">
    <h5 class="title mb-2">Data Warga</h5>
    <h1 class="total" onclick="dialogGantiNama()"><?= $warga[0]['nama_warga'] ?></h1>
    <h4 class="caption">
      <?= $warga[0]['blok'] ?>
    </h4>
    <div class="wallet-inline-button mt-5">
      <a href="#" class="item" data-bs-toggle="modal" data-bs-target="#DialogAktif">
        <div class="iconbox">
          <ion-icon name="checkmark" role="img" class="md hydrated" aria-label="arrow down outline"><template shadowrootmode="open"><div class="icon-inner"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon s-ion-icon" viewBox="0 0 512 512"><title>Arrow Down</title><path stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M112 268l144 144 144-144M256 392V100" class="ionicon-fill-none"></path></svg></div></template></ion-icon>
        </div>
        <h3 class="caption"><strong><?= $warga[0]['aktif'] == '1' ? 'AKTIF' : 'NON-AKTIF!' ?></strong></h3>
      </a>
      <a href="#" class="item" data-bs-toggle="modal" data-bs-target="#BintangDialog">
        <div class="iconbox">
          <ion-icon name="star" role="img" class="md hydrated" aria-label="arrow down outline"><template shadowrootmode="open"><div class="icon-inner"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon s-ion-icon" viewBox="0 0 512 512"><title>Arrow Down</title><path stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M112 268l144 144 144-144M256 392V100" class="ionicon-fill-none"></path></svg></div></template></ion-icon>
        </div>
        <h3 class="caption"><strong><span id="persen"></span>%</strong></h3>
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
      <div class="stat-box" >
        <div class="title">Nilai Iuran (Rp)</div>
        <div class="value text-success" onclick="dialogIuran()"><span id="debet_semua"><?= number_format($warga[0]['total_iuran']) ?></span></div>
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


<div class="modal fade dialogbox" id="Deposit" data-bs-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Deposit?</h5>
      </div>
      <div class="modal-body">
        <div class="input-wrapper">
          <label class="label" for="email4">Nominal</label>
          <input type="number" class="form-control" id="nominal_edit" placeholder="0" name="nominal">
          <input type="text" hidden id="id_edit">

        </div>
        <input type="text" hidden id="id_deposit">
      </div>
      <div class="modal-footer">
        <div class="btn-inline">
          <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">Batal</a>
          <a href="#" onclick="saveDepo()" class="btn btn-text-primary" data-bs-dismiss="modal">Simpan</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade dialogbox" id="gantiNama" data-bs-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ganti Nama?</h5>
      </div>
      <div class="modal-body">
        <div class="input-wrapper">
          <label class="label" for="email4">Nama Baru</label>
          <input type="text" class="form-control" id="nama_edit" placeholder="" value="<?= $warga[0]['nama_warga'] ?>">
          <input type="text" hidden id="id_edit_nama">

        </div>
        <input type="text" hidden id="id_deposit">
      </div>
      <div class="modal-footer">
        <div class="btn-inline">
          <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">Batal</a>
          <a href="#" onclick="saveNama()" class="btn btn-text-primary" data-bs-dismiss="modal">Simpan</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade dialogbox" id="modalIuran" data-bs-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Iuran Nominal?</h5>
      </div>
      <div class="modal-body">
        <div class="input-wrapper">
          <label class="label" for="email4">Nominal</label>
          <input type="number" class="form-control" id="nominal_iuran" placeholder="0" name="nominal">
          <input type="text" hidden id="id_iuran">

        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-inline">
          <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">Batal</a>
          <a href="#" onclick="saveIuran()" class="btn btn-text-primary" data-bs-dismiss="modal">Simpan</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade dialogbox" id="DialogBasic" data-bs-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sudah Lunas?</h5>
      </div>
      <div class="modal-body">
        Pastikan sudah menerima uang senilai Rp <span id="senilai"></span>, atau anda ingin menghapus data ini?
        <input type="text" hidden id="id_bayar">
      </div>
      <div class="modal-footer">
        <div class="btn-list">
          <a href="#" onclick="sendBayar()" class="btn btn-text-primary btn-block" data-bs-dismiss="modal">Ya</a>
          <a href="#" class="btn btn-text-danger btn-block" onclick="deleteIuran()" data-bs-dismiss="modal">Hapus</a>
          <a href="#" class="btn btn-block " data-bs-dismiss="modal">Tutup</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade dialogbox" id="DialogAktif" data-bs-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Status Warga?</h5>
      </div>
      <div class="modal-body">
        Ubah status warga menjadi aktif / non-aktif, warga yang non-aktif tidak akan termasuk dalam tagihan iuran bulanan.
        <input type="text" hidden id="id_bayar">
      </div>
      <div class="modal-footer">
        <div class="btn-list">
          <a href="#" onclick="sendStatus()" class="btn btn-text-primary btn-block" data-bs-dismiss="modal">Ya</a>
          <a href="#" class="btn btn-block " data-bs-dismiss="modal">Batal</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade dialogbox" id="BintangDialog" data-bs-backdrop="static" tabindex="-1"
role="dialog">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-icon text-success">
      <ion-icon name="star"></ion-icon>
    </div>
    <div class="modal-header">
      <h5 class="modal-title">Bintang</h5>
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



<div class="modal fade action-sheet" id="addKomponen" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Komponen Iuran</h5>
      </div>
      <div class="modal-body">
        <div class="action-sheet-content">
          <div id="chkkomp">

          </div>

          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email4">Total Iuran</label>
              <input type="number" class="form-control" id="total_iuran_komponen" readonly>
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>

          <div class="form-group basic">
            <div class="row">
              <div class="col-4">
                <button type="button" class="btn btn-danger btn-block btn-lg"
                data-bs-dismiss="modal">Batal</button>
              </div>
              <div class="col-8">
                <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal" onclick="saveKomponen()">Simpan</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- BESAR IURAN + progress bayar, DEPOSIT, TUNGGAKAN -->

<script>
  var allkartu = JSON.parse('<?= $krtu ?>');
  var katiu = JSON.parse('<?= $kat ?>');
  // console.log(katiu)

  function dialogKomponen(){
    $('#chkkomp').empty();
    katiu.forEach(item => {
      $("#chkkomp").append(`
        <div class="form-check mb-1">
        <input type="checkbox" class="form-check-input chk-iuran" id="${item.nama_iuran}${item.id}" data-id="${item.id}" data-nama="${item.nama_iuran}" data-nominal="${item.nominal}" onclick="pilh()">
        <label class="form-check-label" for="${item.nama_iuran}${item.id}">${item.nama_iuran} : Rp ${item.nominal}</label>
        </div>
        `);
    });
    $('#addKomponen').modal('toggle');
  }

   function saveKomponen(){
   let page = '<?= base_url() ?>';
   var url = page + "Warga/updateKomponen";
   $.ajax({
     url: url,
     type: "POST",
     data: {
       'id_warga': '<?= $warga[0]['id'] ?>',
       'nama_komponen' : JSON.stringify(selected_komp),
       'nominal_edit' : $('#total_iuran_komponen').val()
     },
     success: function(data) {
       window.location.reload();
     },
     error: function(jqXHR, textStatus, errorThrown) {
       alert('Error adding / update data');
     }
   });
 }

  var selected_komp =[];
  function pilh(){
    let total = 0;
    selected_komp = [];

    $(".chk-iuran:checked").each(function () {
      let id = $(this).data("id");
      let nama = $(this).data("nama");
      let nominal = parseInt($(this).data("nominal"));

      total += nominal;

      selected_komp.push({
        id: id,
        nama_iuran: nama,
        nominal: nominal
      });
    });

    // Tampilkan total
    $("#total_iuran_komponen").val(total);

    // Tampilkan array hasil
    console.log(selected_komp);
  }

  function dialogGantiNama(){
   $('#gantiNama').modal('toggle');
   $('#id_edit_nama').val('<?= $warga[0]['id'] ?>');
 }


  function dialogDeposit(){
   $('#Deposit').modal('toggle');
   $('#id_edit').val('<?= $warga[0]['id'] ?>');
 }

 function dialogIuran(){
   $('#modalIuran').modal('toggle');
   $('#id_iuran').val('<?= $warga[0]['id'] ?>');
 }

 function sendStatus(){
   let page = '<?= base_url() ?>';
   var url = page + "Warga/toggleStatus";
   $.ajax({
     url: url,
     type: "POST",
     data: {
       'id_status': '<?= $warga[0]['id'] ?>',
     },
     success: function(data) {
       window.location.reload();
     },
     error: function(jqXHR, textStatus, errorThrown) {
       alert('Error adding / update data');
     }
   });
 }

 function saveIuran(){
   let page = '<?= base_url() ?>';
   var url = page + "Warga/editIuran";
   $.ajax({
     url: url,
     type: "POST",
     data: {
       'id_edit': $('#id_iuran').val(),
       'nominal_edit' : $('#nominal_iuran').val()
     },
     success: function(data) {
       window.location.reload();
     },
     error: function(jqXHR, textStatus, errorThrown) {
       alert('Error adding / update data');
     }
   });
 }

 function deleteIuran(){
  let page = '<?= base_url() ?>';
  var url = page + "Warga/hapusBayar";
  $.ajax({
    url: url,
    type: "POST",
    data: {
      'id_bayar': $('#id_bayar').val(),
    },
    success: function(data) {
      window.location.reload();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert('Error adding / update data');
    }
  });
}

function saveNama(){
 let page = '<?= base_url() ?>';
 var url = page + "Warga/wargaNama";
 $.ajax({
   url: url,
   type: "POST",
   data: {
     'id_edit': $('#id_edit_nama').val(),
     'nama_warga' : $('#nama_edit').val()
   },
   success: function(data) {
     window.location.reload();
   },
   error: function(jqXHR, textStatus, errorThrown) {
     alert('Error adding / update data');
   }
 });
}

function saveDepo(){
 let page = '<?= base_url() ?>';
 var url = page + "Warga/wargaDepo";
 $.ajax({
   url: url,
   type: "POST",
   data: {
     'id_edit': $('#id_edit').val(),
     'nominal_edit' : $('#nominal_edit').val()
   },
   success: function(data) {
     window.location.reload();
   },
   error: function(jqXHR, textStatus, errorThrown) {
     alert('Error adding / update data');
   }
 });
}

function dialogBayar(id,nominal){
 $('#DialogBasic').modal('toggle');
 $('#id_bayar').val(id);
 $('#senilai').text(parseInt(nominal).toLocaleString('id-ID'));
}

function sendBayar(){
 let page = '<?= base_url() ?>';
 var url = page + "Warga/wargaBayar";
 $.ajax({
   url: url,
   type: "POST",
   data: {
     'id_bayar': $('#id_bayar').val(),
   },
   success: function(data) {
     window.location.reload();
   },
   error: function(jqXHR, textStatus, errorThrown) {
     alert('Error adding / update data');
   }
 });
}

function start() {
 var gh = '';
 var tungg = 0;
 var hit = 0;
 var newes = sortByNewest(allkartu);
 $.each(newes,function(x,c){
  var stat = c.status == 'LUNAS' ? '<span class="text-success">LUNAS</span>': '<span class="text-danger">BELUM</span>';
  if(c.status == 'BELUM'){
    tungg += parseInt(c['nominal']);
  }else{
    hit ++;
  }
  gh += `
  <a href="#" onclick="dialogBayar('${c.id}','${c.nominal}')" class="item">
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
 // console.log(prosen);
 $('#persen').text(prosen.toFixed(0));


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