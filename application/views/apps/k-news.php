<div class="section full mt-4">
    <div class="section-heading padding">
        <h2 class="title">Galeri Kabar</h2>
        <a href="#" data-bs-toggle="modal" data-bs-target="#modalInput">+ Tambah</a>
    </div>
</div>    

<div class="section mt-2" id="list_news">
    <?php
    foreach ($news as $key => $v) {
    ?>

    <div class="card mt-2">
        <a href="<?= base_url() ?>uploads/<?= $v['gambar'] ?>" target="_BLANK">
        <img src="<?= base_url() ?>uploads/<?= $v['gambar'] ?>" class="card-img-top" alt="image">
        </a>
        <div class="card-body">
            <h5 class="card-title"><?= $v['judul'] ?></h5>
            <h6 class="card-subtitle mb-1"><?= $v['deskripsi'] ?></h6>
        </div>
        <div class="card-footer">
            <a href="<?= base_url('news/delete/'.$v['id']) ?>" class="btn btn-outline-danger btn-block" onclick="return confirm('Hapus data?')">Hapus</a>
        </div>
    </div>
    <?php
    } 
    ?>
</div>


<div class="modal fade action-sheet" id="modalInput" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Galeri Kabar</h5>
      </div>
      <div class="modal-body">
        <div class="action-sheet-content">
            <?php
            echo form_open_multipart('News/store', array('style' => 'text-align:center;'));
            ?>
            <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email4">Gambar</label>
              <input type="file" class="form-control" id="gambar" placeholder="0" name="gambar">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email4">Judul</label>
              <input type="text" class="form-control" id="judul" name="judul">
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="textarea4">Deskripsi</label>
              <textarea id="deskripsi" rows="3" class="form-control"
              placeholder="Textarea" name="deskripsi"></textarea>
              <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
              </i>
            </div>
          </div>
          <div class="form-button-group  transparent">
            <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg">Simpan</button>
          </div>
            <?php
            echo form_close();
            ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

</script>