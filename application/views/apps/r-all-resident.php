<?php
    $wrg = json_encode($warga);
   $org = $this->uri->segment(3);
?>

<div class="section mt-4">
            <div class="section-heading">
                <h2 class="title">Data Keluarga</h2>
            </div>
            <div class="transactions">
      
               
            </div>
        </div>

<script type="text/javascript">
    var allwar = JSON.parse('<?= $wrg ?>');

    function start(){
        var org = '<?= $org ?>';
        var htg = '';
        console.log(allwar);
        $.each(allwar,function(q,w){
            var bg = w.aktif == '1'? `<div class="badge badge-success">AKTIF</div>` : `<div class="badge badge-danger">NON-AKTIF</div>`;
            htg += `
                <a href="<?= base_url() ?>Review/resident/${org}/${w.id}" class="item">
                    <div class="detail">
                        <div>
                            <strong>${w.nama_warga}</strong>
                            <p>${w.blok}</p>
                        </div>
                    </div>
                    <div class="right">
                        ${bg}

                    </div>
                </a>
            `;
        });
        $('.transactions').html(htg);
    }
                        // <div class="price">Rp ${parseInt(w['total_iuran']).toLocaleString('id-ID')}</div>

    start();
</script>