<?php
$org = $this->uri->segment(3);
$bln = $this->uri->segment(4);
$thn = $this->uri->segment(5); 
$alt = json_encode($alter);
?>

<div class="section inset mt-2">
    <div class="section-title">Alokasi Pembayaran Iuran</div>


    <div class="accordion" id="accordionExample1">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion01" aria-expanded="false">
                    Bulan ke <?= $bln ?>, Tahun <?= $thn ?>
                </button>
            </h2>
            <div id="accordion01" class="accordion-collapse collapse" data-bs-parent="#accordionExample1" style="">
                <div class="accordion-body" >
                    <div class="splide__track">
                        <ul class="splide__list" id="list_alter">


                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion03" aria-expanded="false">
                    Total Alokasi Anggaran:
                </button>
            </h2>
            <div id="accordion03" class="accordion-collapse collapse show" data-bs-parent="#accordionExample1">
                <div class="accordion-body">
                    <div id="chkkomp">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

            <div class="form-button-group  transparent" id="butswitch" data-bs-toggle="modal" data-bs-target="#quickCreate">
                <button type="button" name="submit" class="btn btn-primary btn-block btn-lg">Input Rp&nbsp;<span id="tmbh"></span>&nbsp;ke Pembukuan</button>
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


<script>
    var allalter = JSON.parse('<?= $alt ?>');

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
        window.location.href = page+"Iuran";
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });


  }


    function startGo(){
        $('#butswitch').hide();
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
          <h3 class="ms-2 mr-2 text-end p-2"><span class="text-success">Total: Rp ${t.total_nominal.toLocaleString()}</span></h3>
          </div>
          </li>`
          ;
      });

        $('#list_alter').html(bn);


        let page = '<?= base_url() ?>';
        var url = page + "IuranDetail/getTotalAlter";
        $.ajax({
            url: url,
            type: "POST",
            data: {
              'bln': '<?= $bln ?>', 
              'thn': '<?= $thn ?>',
              'org': '<?= $org ?>',
          },
          success: function(data) {
            resum(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error adding / update data');
      }
  });



    }

    function resum(data) {
    $("#chkkomp").empty(); // reset dulu

    const allKod = JSON.parse(data);
    const map = {};

    // Group dan total nominal
    allKod.forEach(item => {
        const komponen = JSON.parse(item.komponen);

        komponen.forEach(k => {
            if (!map[k.nama_iuran]) {
                map[k.nama_iuran] = {
                    id: k.id,
                    nama_iuran: k.nama_iuran,
                    total: 0,
                    count: 0
                };
            }
            map[k.nama_iuran].total += k.nominal;

            map[k.nama_iuran].count += 1;
        });
    });

    // Ubah ke array & sort sesuai total DESC
    const sorted = Object.values(map).sort((a, b) => b.total - a.total);

    // Render checkbox
    sorted.forEach(item => {
        $("#chkkomp").append(`
            <div class="form-check mb-1">
            <input type="checkbox"
            class="form-check-input chk-iuran"
            id="${item.nama_iuran}${item.id}"
            data-id="${item.id}"
            data-nama="${item.nama_iuran}"
            data-nominal="${item.total}"
            onclick="pilh()">
            <label class="form-check-label" for="${item.nama_iuran}${item.id}">
            ${item.nama_iuran} : Rp ${item.total.toLocaleString('id-ID')}
            </label>
            </div>
            `);
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
    $("#nominal").val(total);
    $("#tmbh").text(total.toLocaleString('id-ID'));

    if(selected_komp.length == 0){
        $('#butswitch').hide();
    }else{
        $('#butswitch').show();
    }
    // Tampilkan array hasil
    console.log(selected_komp);
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



startGo();
</script>