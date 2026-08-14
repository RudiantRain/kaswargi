<?php
    $wrg = json_encode($komponen);
    
?>


<div class="section mt-4">
            <div class="section-heading">
                <h2 class="title">Komponen Iuran</h2>
<!--                 <a href="#" data-bs-toggle="modal" data-bs-target="#addWarga" class="badge badge-primary">+ Warga</a> -->
            </div>
            <div class="transactions">
      
               
            </div>
        </div>

<script type="text/javascript">
    var allwar = JSON.parse('<?= $wrg ?>');

        function start(){
        var htg = '';
        console.log(allwar);
        $.each(allwar,function(q,w){
            var bg = w.aktif == '1'? `<div class="badge badge-success">AKTIF</div>` : `<div class="badge badge-danger">NON-AKTIF</div>`;
            htg += `
                <a href="#" class="item">
                    <div class="detail">
                        <div>
                            <strong>${w.nama_iuran}</strong>
        
                        </div>
                    </div>
                    <div class="right">
                            <div class="price">Rp ${parseInt(w['nominal']).toLocaleString('id-ID')}</div>
                    </div>
                </a>
            `;
        });
        $('.transactions').html(htg);
    }



    start();

</script>



