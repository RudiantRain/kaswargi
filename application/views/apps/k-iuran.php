    <?php
    $rek = json_encode($rekap);
    $tung = json_encode($tunggak);
    $alt = json_encode($alter);
    $org = $_SESSION['org_code'];
    ?>


    <div class="extraHeader pe-0 ps-0">
        <ul class="nav nav-tabs lined" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#kartu" role="tab">
                    Rekap
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tanggungan" role="tab">
                    Tertunggak
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#terima" role="tab">
                    Pembayaran
                </a>
            </li>
        </ul>
    </div>

    <div class="section tab-content mt-2 mb-1">
        <div class="tab-pane fade show active" id="kartu" role="tabpanel">

            <br>
            <div class="row mt-2">
                <div class="col-6">
                  <div class="stat-box">
                    <div class="title">Tot. Lunas</div>
                    <div class="value text-success"><span id="debet_semua">0</span></div>
                </div>
            </div>
            <div class="col-6">
              <div class="stat-box">
                <div class="title">Tot. Tertunggak</div>
                <div class="value text-danger"><span id="kredit_semua">0</span>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-toggle="modal" data-bs-target="#withdrawActionSheet">+ Tagihan Semua Warga</button>
    </div>

    <br>
    <div class="row mt-12">
        <div class="carousel-single splide">
            <div class="splide__track">
                <ul class="splide__list" id="list_rekap">


                </ul>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane fade" id="tanggungan" role="tabpanel">
    <br>
    <br>
    <div class="row mt-1 transaction" >
        <div class="transactions" id="list_tunggak">


        </div>
    </div>
</div>
<div class="tab-pane fade" id="terima" role="tabpanel">
    <br>
    <br>
    <div class="row">
        <a href="<?= base_url() ?>Iuran/create" class="btn btn-primary btn-block btn-lg">+ Pembayaran</a>
    </div>
    <br>
    <div class="row mt-12 transaction" >
        <div class="carousel-single splide">
            <div class="splide__track">
                <ul class="splide__list" id="list_alter">


                </ul>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade dialogbox" id="DialogBatal" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Batalkan?</h5>
            </div>
            <div class="modal-body">
                Batalkan pembayaran untuk periode : <span id="periode_list"></span>?
                <input type="text" hidden id="id_batalkan">
            </div>
            <div class="modal-footer">
                <div class="btn-list">
                    <a href="#" onclick="sendBatal()" class="btn btn-text-primary btn-block" data-bs-dismiss="modal">Ya</a>
                    <a href="#" class="btn btn-block" data-bs-dismiss="modal">Tidak</a>
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
                    <a href="#" class="btn btn-block" data-bs-dismiss="modal">Tutup</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade action-sheet" id="withdrawActionSheet" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buat Tagihan Semua Warga</h5>
      </div>
      <div class="modal-body">
        <div class="action-sheet-content">

          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email4">Periode Tagihan</label>
              <input type="month" class="form-control" id="bulan_tagihan" >
              <input type="text" hidden id="id_edit">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
            <i class="text-muted">Tagihan akan dibuat untuk semua warga, dengan status awal BELUM TERBAYAR. Tidak berlaku untuk warga yang SUDAH LUNAS pada bulan yang dipilih.</i>
          </div>

          <div class="form-group basic">
            <div class="row">
              <div class="col-4">
                <button type="button" class="btn btn-danger btn-block btn-lg"
                data-bs-dismiss="modal">Batal</button>
              </div>
              <div class="col-8">
                <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal" onclick="bulkTagihan()">Simpan</button>
              </div>
            </div>



          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    var alltung = JSON.parse('<?= $tung ?>');
    var allrekap = JSON.parse('<?= $rek ?>');
    var allalter = JSON.parse('<?= $alt ?>');
    // console.log(allalter);

    function bulkTagihan(){
      let page = '<?= base_url() ?>';
      var url = page + "Iuran/createBulk";
      $.ajax({
        url: url,
        type: "POST",
        data: {
          'bulan_tagihan': $('#bulan_tagihan').val(),
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

    function dialogBatal(id){
        $('#DialogBatal').modal('toggle');
        $('#id_batalkan').val(id);
        var gh = allalter.filter((r)=>r.id == id)[0];
        $('#periode_list').text(gh['untuk_periode'].toString());
    }

    function sendBatal(){
      let page = '<?= base_url() ?>';
      var url = page + "Iuran/cancelPayment";
      $.ajax({
        url: url,
        type: "POST",
        data: {
          'id_batalkan': $('#id_batalkan').val(),
      },
      success: function(data) {
          window.location.reload();
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert('Error adding / update data');
      }
  });
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


  function start(){
    var htg = '';
        // console.log(allwar);
        $.each(alltung,function(q,w){
            htg += `
            <a href="<?= base_url() ?>Warga/wargaDetail/${w.id_warga}" class="item">
            <div class="detail">
            <div>
            <strong>${w.nama_warga}</strong>
            <p lass="price text-danger">${w.tunggak} bulan</p>
            </div>
            </div>
            <div class="right">
            <div class="price text-danger">Rp ${parseInt(w['jumlah']).toLocaleString('id-ID')}</div>
            </div>
            </a>
            `;
        });
        $('#list_tunggak').html(htg);

        var alr = regroupRekap(allrekap);
        console.log(alr);
        var tot_lun = 0;
        var tot_bel = 0;

        var ght = ''
        $.each(alr, function(o,p){
            tot_lun += p.total_lunas;
            tot_bel += p.total_belum;
            var tot = (p.total_lunas + p.total_belum).toLocaleString('id-ID');
            ght += `
            <li class="splide__slide">
            <div class="card">

            <h3 class="title ms-2 mt-2">${p.bulan}/${p.tahun}</h2>

            <table class="table table-striped">
            <thead>
            <tr>
            <th scope="col">Nama</th>
            <th scope="col">Status</th>
            <th scope="col" class="text-end">Nominal (Rp)</th>
            </tr>
            </thead>
            <tbody>

            `;

            $.each(p['data'], function(t,y){
                var stat = y.status == 'LUNAS' ? '<span class="text-success">LUNAS</span>': '<span class="text-danger">BELUM</span>';
                ght += `
                <tr onclick="dialogBayar('${y.id}','${y.nominal}')">
                <td>${y.nama_warga}</td>
                <td>${stat}</td>
                <td class="text-end">${parseInt(y.nominal).toLocaleString()}</td>
                </tr>
                `;
            });

            ght += `        </tbody>
            </table>
            <hr>
            <h3 class="ms-2"><span class="text-success">${p.total_lunas.toLocaleString()}</span>+
            <span class="text-danger">${p.total_belum.toLocaleString()}</span>=
            <span class="text-dark">${tot}</span></h3>
            <p class="ms-2 mr-2"><i>*Jumlah ini akan berubah secara dinamis sesuai pembayaran iuran.</i></p>
            </div>
            </li>`
            ;
        });

        $('#list_rekap').html(ght);
        $('#debet_semua').text(tot_lun.toLocaleString('id-ID'));
        $('#kredit_semua').text(tot_bel.toLocaleString('id-ID'));

        var lisAlt = regroupAlter(allalter);
        var bn = '';
        $.each(lisAlt, function(q,t){
          bn+= `
            <li class="splide__slide">
            <div class="card">

            <h3 class="title ms-2 mt-2">${t.pada_bulan}/${t.pada_tahun}</h2>

            <table class="table table-striped">
            <thead>
            <tr>
            <th scope="col">Nama</th>
            <th scope="col">X</th>
            <th scope="col" class="text-end">Nominal</th>
            <th scope="col" class="text-end">Total</th>
            </tr>
            </thead>
            <tbody>
          `;

          $.each(t['data'], function(t,y){
                bn += `
                <tr onclick="dialogBatal('${y.id}')">
                <td>${y.nama_warga}</td>
                <td>${y.kode_periode.length} bln</td>
                <td class="text-end">${parseInt(y.nominal).toLocaleString()}</td>
                <td class="text-end">${parseInt(y.total_nominal).toLocaleString()}</td>
                </tr>
                `;
            })



          bn += `       </tbody>
            </table>
            <hr>
            <h3 class="ms-2 mr-2 text-end p-2"><span class="text-success" href="<?= base_url() ?>IuranDetail">Total: Rp ${t.total_nominal.toLocaleString()}</span></h3>
                 <a href="<?= base_url() ?>IuranDetail/alokasi/<?= $org ?>/${t.angka_bulan}/${t.pada_tahun}" class="btn btn-outline-dark me-1 ms-1 mb-1">Lihat Alokasi</a>
            </div>
            </li>`
            ;
        });

        $('#list_alter').html(bn);
    }


function regroupRekap(allRekap) {
    const namaBulan = {
        "01": "Januari",
        "02": "Februari",
        "03": "Maret",
        "04": "April",
        "05": "Mei",
        "06": "Juni",
        "07": "Juli",
        "08": "Agustus",
        "09": "September",
        "10": "Oktober",
        "11": "November",
        "12": "Desember"
    };

    const group = {};

    allRekap.forEach(item => {
        const bulan_num = item.bulan.padStart(2, "0");
        const key = `${item.tahun}-${bulan_num}`;

        if (!group[key]) {
            group[key] = {
                bulan: namaBulan[bulan_num],
                tahun: item.tahun,
                bulan_num: bulan_num,   // untuk sorting
                total_lunas: 0,
                total_belum: 0,
                data: []
            };
        }

        // Masukkan data
        group[key].data.push(item);

        // Hitung total
        const nominal = parseInt(item.nominal);
        if (item.status === "LUNAS") {
            group[key].total_lunas += nominal;
        } else if (item.status === "BELUM") {
            group[key].total_belum += nominal;
        }
    });

    // Sorting yang benar
    const result = Object.values(group).sort((a, b) => {
        const t1 = parseInt(a.tahun + a.bulan_num);
        const t2 = parseInt(b.tahun + b.bulan_num);
        return t1 - t2;
    });

    // Remove bulan_num dari hasil akhir
    result.forEach(r => delete r.bulan_num);

    return result;
}

function regroupAlter(allalter) {
    const namaBulan = {
        "01": "Januari",
        "02": "Februari",
        "03": "Maret",
        "04": "April",
        "05": "Mei",
        "06": "Juni",
        "07": "Juli",
        "08": "Agustus",
        "09": "September",
        "10": "Oktober",
        "11": "November",
        "12": "Desember"
    };

    const group = {};

    allalter.forEach(item => {
        const bulan_num = item.pada_bulan.toString().padStart(2, "0");
        const tahun = item.pada_tahun;
        const key = `${tahun}-${bulan_num}`;

        if (!group[key]) {
            group[key] = {
                angka_bulan: bulan_num,
                pada_bulan: namaBulan[bulan_num],
                pada_tahun: tahun,
                bulan_num: bulan_num,  // disimpan untuk sorting
                total_nominal: 0,
                data: []
            };
        }

        group[key].data.push(item);
        group[key].total_nominal += parseInt(item.total_nominal);
    });

    // urutkan berdasarkan tahun + bulan_num
    const result = Object.values(group).sort((a, b) => {
        const t1 = parseInt(a.pada_tahun + a.bulan_num);
        const t2 = parseInt(b.pada_tahun + b.bulan_num);
        return t1 - t2;
    });

    // hapus bulan_num agar output tetap bersih
    result.forEach(r => delete r.bulan_num);

    return result;
}


start();
</script>