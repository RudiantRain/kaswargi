<?php
    $wrg = json_encode($warga);
    
?>

<div class="section mt-4">
            <div class="section-heading">
                <h2 class="title">Data Warga</h2>
                <a href="#" data-bs-toggle="modal" data-bs-target="#addWarga" class="badge badge-primary">+ Warga</a>
            </div>
            <div class="transactions">
      
               
            </div>
        </div>



<div class="modal fade action-sheet" id="addWarga" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Warga</h5>
      </div>
      <div class="modal-body">
        <div class="action-sheet-content">

          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email4">Nama</label>
              <input type="text" class="form-control" id="nama_warga" >
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
            <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email4">Blok</label>
              <input type="text" class="form-control" id="blok" >
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
            <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email4">Total Iuran</label>
              <input type="number" class="form-control" id="total_iuran" >
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
                <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal" onclick="addWarga()">Simpan</button>
              </div>
            </div>



          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    var allwar = JSON.parse('<?= $wrg ?>');

        function addWarga(){
      let page = '<?= base_url() ?>';
      var url = page + "Warga/quickAddWarga";
      $.ajax({
        url: url,
        type: "POST",
        data: {
          'nama_warga': $('#nama_warga').val(),
          'blok': $('#blok').val(),
          'total_iuran': $('#total_iuran').val(),
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
        console.log(allwar);
        $.each(allwar,function(q,w){
            var bg = w.aktif == '1'? `<div class="badge badge-success"><ion-icon name="checkmark"></ion-icon></div>` : `<div class="badge badge-danger"><ion-icon name="close"></ion-icon></div>`;
            htg += `
                <a href="<?= base_url() ?>Warga/wargaDetail/${w.id}" class="item">
                    <div class="detail">
                        <div>
                            <strong>${w.nama_warga} ${bg}</strong>
                            <p>${w.blok}</p>
                        </div>
                    </div>
                    <div class="right">
                                              <div class="price">Rp ${parseInt(w['total_iuran']).toLocaleString('id-ID')} </div>
                                              <div class="price text-success">(Rp ${parseInt(w['deposit'] ?? '0').toLocaleString('id-ID')}) </div>
                    </div>
                </a>
            `;
        });
        $('.transactions').html(htg);
    }



    start();
</script>