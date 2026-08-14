
<div class="section mt-2 mb-2">
    <div class="section-title">Input Iuran</div>
    <div class="card">
        <div class="card-body">

            <?php
            echo form_open('Iuran/create', array('style' => 'text-align:center;'));
            ?>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="email4">Input Data</label>
                    <select class="form-control custom-select" id="select4" name="data">
                        <option value="LUNAS">Pembayaran</option>
                        <option value="BELUM">Tagihan</option>
                    </select>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="select4">Warga</label>
                    <select class="form-control custom-select" id="select4" name="warga">
                        <?php
                        foreach ($warga as $key => $v) {
                            ?>
                            <option value="<?= $v['id'] ?>|<?= $v['nama_warga'] ?>"><?= $v['nama_warga'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <h6>Periode Data</h6>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="email4">Dari</label>
                    <input type="month" class="form-control" id="daribulan" placeholder="0" name="dari" required>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="email4">Sampai</label>
                    <input type="month" class="form-control" id="sampaibulan" placeholder="0" name="sampai" required>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="email4">Dibayar pada</label>
                    <input type="month" class="form-control" id="email4" placeholder="0" name="pada_bulan" required>
                </div>
            </div>
            <!-- TAMBAHKAN CHECKER UNTUK WARGA YANG SUDAH MEMBAYAR, SEHINGGA TIDAK TERJADI DOUBLE INPUT -->

            <div class="form-button-group  transparent">
                <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg">Simpan</button>
            </div>
            <?php
            echo form_close();
            ?>


        </div>
    </div>
</div>

<script>
document.getElementById('daribulan').addEventListener('change', function () {
    const dari = this.value;            // yyyy-mm
    const sampai = document.getElementById('sampaibulan');

    // Set minimal bulan yang boleh dipilih
    sampai.min = dari;

    // Jika bulan sampai < dari, reset
    if (sampai.value && sampai.value < dari) {
        sampai.value = dari;
    }
});
</script>