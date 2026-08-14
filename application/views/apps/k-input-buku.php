<style>
  .masuk {
    color:green;
  }
  .keluar {
    color: red;
  }

</style>
<div class="section mt-2 mb-2">
    <div class="section-title">Input Transaksi Pembukuan</div>
    <div class="card">
        <div class="card-body">

            <?php
            echo form_open('Buku/create', array('style' => 'text-align:center;'));
            ?>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="email4">Tanggal</label>
                    <input type="date" class="form-control" id="email4" placeholder="periode" name="periode">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="select4">Jenis Transaksi</label>
                    <select class="form-control custom-select" id="select4" name="jenis_transaksi">
                        <?php
                        foreach ($kas_kategori as $key => $v) {
                            $cls =  $v['tipe'] == 'masuk'? 'masuk' : 'keluar';
                            ?>
                            <option value="<?= $v['tipe'] ?>|<?= $v['nama'] ?>" class="<?= $cls?>"><?= $v['tipe'] ?> | <?= $v['nama'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="select4">Buku Kas</label>
                    <select class="form-control custom-select" id="select4" name="id_kas_nama">
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
                    <input type="number" class="form-control" id="email4" placeholder="0" name="nominal">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="textarea4">Uraian</label>
                    <textarea id="textarea4" rows="3" class="form-control"
                    placeholder="Textarea" name="uraian"></textarea>
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