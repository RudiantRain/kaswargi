<style>
  .masuk {
    color:green;
  }
  .keluar {
    color: red;
  }

</style>
<div class="section mt-2 mb-2">
    <div class="section-title">Ganti Password</div>
    <div class="card">
        <div class="card-body">

            <?php
            echo form_open('Operator/edit_pass', array('style' => 'text-align:center;'));
            ?>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="email4">Password Saat Ini</label>
                    <input type="password" class="form-control" id="email4" placeholder="****" name="pass_lama">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="email4">Password Baru</label>
                    <input type="password" class="form-control" id="email4" placeholder="****" name="pass_baru">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="email4">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="email4" placeholder="****" name="pass_baru_confirm">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <i>Anda akan keluar dari aplikasi, silahkan login kembali menggunakan password yang diperbarui.</i>
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
