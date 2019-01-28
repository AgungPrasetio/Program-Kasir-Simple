<?php
require_once "__class/PenjualanController.php";
require_once "__class/PembelianController.php";
require_once "__class/DashboardController.php";
require_once "__class/BarangController.php";
require_once "__class/system/currency.php";

$penjualan = new PenjualanController();
$pembelian = new PembelianController();
$dashboard = new DashboardController();
$controller = new BarangController();

$data = $dashboard->search();
$check_saldo = $dashboard->check_saldo_awal();

?>
<script type="text/javascript" src="assets/js/controller/DashboardJS.js"></script>
<!-- OVERVIEW -->
<div class="panel panel-headline">
    <div class="panel-body">
        <?php
        if($check_saldo==""){
            echo '
            <h3 class="panel-title">Input Saldo Awal</h3>
            <div class="row">
                <form action="" method="POST" name="search">
                    <div class="form-group">
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="saldo_awal" />
                        </div>
                        <div class="col-sm-2">
                            <button type="button" name="simpan_saldo" class="btn btn-md btn-success btn-block">Simpan</button
                        </div>
                    </div>
                </form>
            </div>
            ';
        }else{
            echo '
            
            <div class="row">
                <div class="col-md-2">
                    <h3 class="panel-title">Saldo Awal</h3>
                </div>
                <div class="col-md-4">
                    <p>Rp '.number_format($check_saldo).'</p>
                </div>
            </div>
            ';
        }
        ?>
        
    </div>
</div>

<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title">Laporan Stok Barang Habis</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <!-- Data-->
                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kepemilikan Barang</th>
                            <th>Stok Minimum</th>
                            <th>Stok Saat Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $controller->data_stok_barang_habis();
                        $i=1;
                        foreach($data as $D):
                            $id = $D->kode_barang;
                            $stok_now = $controller->get_stok_akhir($id);
                            $stok_minimum = $D->limit_stok;

                            if($stok_now < $stok_minimum):
                                //count relation of $kategori
                                $count = $controller->count($id);
                                //harga barang sesuai hpp
                                $harga = $controller->set_harga_jual($id);
                                if(is_nan($harga)):
                                    $harga = $D->harga_barang;
                                endif;
                                echo '
                                <tr>
                                    <td>'.$i++.'</td>
                                    <td>'.$id.'</td>
                                    <td>'.$D->nama_barang.'</td>
                                    <td>'.$D->kepemilikan.'</td>
                                    <td>'.$D->limit_stok.'</td>
                                    <td>'.$stok_now.'</td>
                                </tr>
                                ';
                            endif;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title">Dashboard</h3>
        <div class="row">
            <form action="" method="POST" name="search">
                <div class="form-group">
                    <div class="col-sm-2">
                        <select name="option_month" class="form-control required">
                            <?php echo $dashboard->option_month(); ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select name="option_year" class="form-control required">
                            <?php echo $dashboard->option_year(); ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="submit" name="cari_chart" value="Cari" class="btn btn-md btn-info" />
                    </div>
                </div>
            </form>
        </div>
        <!--<p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>-->
    </div>
    <div class="panel-body">
        
        <div class="row">
            <div class="col-md-12">
            
                <canvas id="chart_trans" width="400" height="400"></canvas>
                <script>
                var ctx = document.getElementById("chart_trans");
                ctx.height = 170;
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [<?php echo $data['days']; ?>],
                        datasets: [{
                        label: 'Transaksi Penjualan',
                        data: [<?php echo $data['cpenjualan']; ?>],
                        backgroundColor: '#d9534f',
                        }, {
                        label: 'Transaksi Pembelian',
                        data: [<?php echo $data['cpembelian']; ?>],
                        backgroundColor: '#f0ad4e'
                        }]
                    },
                    options: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                        scales:{
                            yAxes:[{
                                display:true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
                </script>
            </div>
        </div>
    </div>
</div>
<!-- END OVERVIEW -->
<div class="row">
    <div class="col-md-6">
        <!-- Transaksi Penjualan -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Transaksi Penjualan</h3>
                <div class="right">
                    <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                </div>
            </div>
            <div class="panel-body no-padding">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="120px">No. Transaksi</th>
                            <th>Kasir</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = "0,5";
                        $data_pen = $penjualan->data('',$limit);

                        foreach($data_pen as $P):
                            $id = $P->id_penjualan;
                            $no = $P->no;
                            echo '
                            <tr>
                                <td>'.$id.'</td>
                                <td>'.$P->nama_kasir.'</td>
                                <td>'.date('d M Y', strtotime($P->tanggal)).'</td>
                                <td>'.$P->total.'</td>
                            </tr>
                            ';
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> Transaksi Penjualan Terbaru</span></div>
                    <div class="col-md-6 text-right"><a href="main.php?mod=history_penjualan" target="_blank" class="btn btn-primary">Lihat Semua Transaksi</a></div>
                </div>
            </div>
        </div>
        <!-- END Transaksi Penjualan -->
    </div>

    <div class="col-md-6">
        <!-- Transaksi Pembelian -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Transaksi Pembelian</h3>
                <div class="right">
                    <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                </div>
            </div>
            <div class="panel-body no-padding">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="120px">No. Transaksi</th>
                            <th>Supplier</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = "0,5";
                        $data_beli = $pembelian->data('',$limit);

                        foreach($data_beli as $B):
                            $id = $B->id_pembelian;
                            $no = $B->no;
                            echo '
                            <tr>
                                <td>'.$id.'</td>
                                <td>'.$B->nama_pemasok.'</td>
                                <td>'.date('d M Y', strtotime($P->tanggal)).'</td>
                                <td>'.$B->total.'</td>
                            </tr>
                            ';
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> Transaksi Pembelian Terakhir</span></div>
                    <?php if($namekedudukan!="Kasir"): ?>
                    <div class="col-md-6 text-right"><a href="main.php?mod=history_pembelian" class="btn btn-primary">Lihat Semua Transaksi</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- END Transaksi Pembelian -->
    </div>
</div>

<script>
$("[name='simpan_saldo']").click(function(){
    var saldo_awal = $("[name='saldo_awal']").val();

    var data = "saldo_awal="+saldo_awal;
    

    var error = 0;

    if(saldo_awal==""){
        $("[name='saldo_awal']").css('border', '1px solid red');
        error = 1;
    }

    if(error==0){
        $.ajax({
            type : 'POST',
            url  : '__class/action/ActionPenjualan.php?addSaldoAwal',
            data : data,
            beforeSend: function()
            {
                $("[name='simpan_saldo']").html('<i class="fa fa-spinner fa-spin "></i> &nbsp;mengirimkan ...');
            },
            success :  function(response)
            {
                $("[name='simpan_saldo']").html('Simpan');
                if(response=="ok"){
                    alert("Saldo awal berhasil disimpan");
                    window.location = "main.php";
                }else{
                    // alert("Terjadi kesalahan dalam sistem!");
                    console.log(response);
                }
            }
        });
    }

});
</script>