<?php
$khas = json_encode($kas);
$iur = json_encode($iuran);
?>        

<div class="section wallet-card-section pt-1">
    <div class="wallet-card">

        <div class="balance">
            <div class="left">
                <span class="title">Saldo Semua Buku (Rp)</span>
                <h1 class="total"><span id="total_semua">0</span></h1>
                <span class="text-muted">Per <?= date("d M Y") ?></span>
            </div>
            <div class="right">
                <a href="<?php echo base_url() ?>Buku/create" class="button">
                    <ion-icon name="add-outline"></ion-icon>
                </a>
            </div>
        </div>

    </div>
</div>


<div class="section">
    <div class="row mt-2">
        <div class="col-6">
            <div class="stat-box">
                <div class="title">Semua Debet</div>
                <div class="value text-success"><span id="debet_semua">0</span></div>
            </div>
        </div>
        <div class="col-6">
            <div class="stat-box">
                <div class="title">Semua Kredit</div>
                <div class="value text-danger"><span id="kredit_semua">0</span>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- my cards -->
<div class="section full mt-4">
    <div class="section-heading padding">
        <h2 class="title">Pembukuan</h2>
        <a href="#" class="link">Semua</a>
    </div>

    <!-- carousel single -->
    <div class="carousel-single splide">
        <div class="splide__track">
            <ul class="splide__list" id="list_rinci">


            </ul>
        </div>
    </div>
    <!-- * carousel single -->

</div>

<div class="section full mt-4">
    <div class="section-heading padding">
        <h2 class="title">Total Pembayaran Iuran</h2>
        <a href="#" class="link">Semua</a>
    </div>
    <div id="chart"></div>
    <!-- * carousel single -->

</div>
<!-- * my cards -->
<script type="text/javascript">



    function startGo(){
        var jskas = olahKas(JSON.parse('<?= $khas ?>'));
        var ghu = JSON.parse('<?= $khas ?>');
        var iurt =JSON.parse('<?= $iur ?>');
        // console.log(iurt);

        $('#total_semua').text(jskas.total.saldo.toLocaleString('ID-id'));
        $('#debet_semua').text(jskas.total.masuk.toLocaleString('ID-id'));
        $('#kredit_semua').text(jskas.total.keluar.toLocaleString('ID-id'));
        var htj = '';
        Object.values(jskas.rekap_kas).forEach(kas=>{
            var sal = kas.saldo.toLocaleString();
            var deb = kas.masuk.toLocaleString();
            var kre = kas.keluar.toLocaleString();
            htj+=`
            <li class="splide__slide">
            <div class="card-block bg-dark">
            <div class="card-main">
            <div class="card-button dropdown">
            <button type="button" class="btn btn-link btn-icon" data-bs-toggle="dropdown">
            <ion-icon name="ellipsis-horizontal"></ion-icon>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="<?= base_url() ?>Buku/readByIdKas/${kas.id_kas}">
            <ion-icon name="pencil-outline"></ion-icon>Lihat Rincian
            </a>
            </div>
            </div>
            <div class="balance">
            <span class="label">SALDO</span>
            <h1 class="title">${sal}</h1>
            </div>
            <div class="in">
            <div class="card-number">
            <span class="label">NAMA BUKU KAS</span>
            ${kas.kas_nama}
            </div>
            <div class="bottom">
            <div class="card-expiry">
            <span class="label">Debet</span>
            ${deb}
            </div>
            <div class="card-ccv">
            <span class="label">Kredit</span>
            ${kre}
            </div>
            </div>
            </div>
            </div>
            </div>
            </li>
            `;
        });

        $('#list_rinci').html(htj);


                // Format label tahun-bulan
                var xLabels = iurt.map(item => `${getNamaBulan(item.pada_bulan)}-${item.pada_tahun}`);

        // Konversi nominal menjadi angka (int)
        var yValues = iurt.map(item => parseInt(item.tot_bulanan));

        var options = {
            chart: {
                type: 'bar',   // bisa diganti 'bar'
                height: 350,
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                  borderRadius: 8,
                  columnWidth: '43%',
                  endingShape: 'rounded',
                  startingShape: 'rounded'
              }
          },

          series: [{
            name: 'Total (Rp)',
            data: yValues
        }],
        xaxis: {
            categories: xLabels,
            labels: {
                show: false
            }

        },
        yaxis: {
            labels: {
                formatter: (value) => value.toLocaleString('id-ID')
            },
            show: false,
        },
        dataLabels: {
            enabled: false,
        },

        tooltip: {
            y: {
                formatter: function (value) {
                    return "Rp " + value.toLocaleString('id-ID');
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
}


function olahKas(data) {

  const grouped = {};

  data.forEach(item => {
    const kas = item.kas_nama;
    const id_nama = item.id_kas_nama;
    const nominal = parseFloat(item.nominal);

    if (!grouped[kas]) {
      grouped[kas] = {
        kas_nama: kas,
        id_kas : id_nama,
        masuk: 0,
        keluar: 0,
        saldo: 0,
        transaksi: []
    };
}

    // Pisahkan transaksi masuk dan keluar
    if (item.jenis_transaksi === 'masuk') {
      grouped[kas].masuk += nominal;
  } else if (item.jenis_transaksi === 'keluar') {
      grouped[kas].keluar += nominal;
  }

    // Simpan semua transaksi untuk referensi detail
    grouped[kas].transaksi.push(item);
});

  // Hitung saldo tiap kas
  Object.keys(grouped).forEach(kas => {
    grouped[kas].saldo = grouped[kas].masuk - grouped[kas].keluar;
});

  // Hitung total keseluruhan semua kas
  const totalMasuk = Object.values(grouped).reduce((sum, kas) => sum + kas.masuk, 0);
  const totalKeluar = Object.values(grouped).reduce((sum, kas) => sum + kas.keluar, 0);
  const totalSaldo = totalMasuk - totalKeluar;

  return {
    rekap_kas: grouped,
    total: {
      masuk: totalMasuk,
      keluar: totalKeluar,
      saldo: totalSaldo
  }
};
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


startGo();

</script>