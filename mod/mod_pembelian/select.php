<?php
session_start();
include_once "../../__class/system/currency.php";
require_once "../../__class/PembelianController.php";
$controller = new PembelianController();
if(!isset($_SESSION['totbayarpembelian'])){
    $_SESSION['totbayarpembelian'] = 0;
}

if(isset($_GET['addSuccess'])):
    echo '<div class="alert alert-success"> <i class="fa fa-check" aria-hidden="true"></i> &nbsp; Transaksi berhasil di simpan !</div>';
endif;
?>

<div id="infotrans"></div>
<form action="" method="POST" id="form-pembelian">
    <div class="form-group">
        <label for="pemasok" class="col-sm-2">Pilih Pemasok</label>
        <div class="col-sm-4">
            <div id="select-pemasok"></div>
        </div>
        <div class="col-sm-4 col-sm-offset-2">
           <h2 style="margin:0px; padding:0px; text-align:right;">TOTAL = <span id="totaltrans"></span></h2>
        </div><br/><br/>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="30px">No</th>
                <th width="120px">Kode Barang</th>
                <th width="150px">Nama Barang</th>
                <th width="60px">Qty</th>
                <th width="100px">Satuan</th>
                <th width="120px">Jumlah Per Satuan</th>
                <th>Harga Beli</th>
                <th>Harga Beli Persatuan</th>
                <th width="60px">Laba</th>
                <th width="120px">Harga Jual</th>
                <th width="80px">Sub Total</th>
                <th width="30px">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php
                @$awal = $_SESSION['nilaipembelian'];
                $no=1;
                $j=0;
                for($i=0; $i<=$awal;$i++):
                    if(@$_SESSION['isipembelian'][$i][0]!=''):
                        $kode_barang = @$_SESSION['isipembelian'][$i][0];
                        $nama_barang = @$_SESSION['isipembelian'][$i][1];
                        $harga_barang = @$_SESSION['isipembelian'][$i][2];
                        $qty = @$_SESSION['isipembelian'][$i][3];
                        $satuan = @$_SESSION['isipembelian'][$i][4];
                        $jmlPerSatuan = @$_SESSION['isipembelian'][$i][5];
                        $laba = @$_SESSION['isipembelian'][$i][6];

                        $datasatuan = $controller->getNameSatuan($satuan);
                        foreach($datasatuan as $DS):
                            $name_satuan = $DS->nama_satuan_barang;
                        endforeach;

                        $harga_beli_persatuan = $harga_barang/$jmlPerSatuan;
                        $harga_jual_after_laba = $harga_beli_persatuan+($harga_beli_persatuan*($laba/100));
                        echo '
                            <tr>
                                <td>'.$no++.'</td>
                                <td>'.$kode_barang.'</td>
                                <td>'.$nama_barang.'</td>
                                <td>
                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" max="400" name="qty" style="text-align:right; width:60px;" value="'.$qty.'" onchange="change()" style="width:60px;" />
                                    <input type="hidden" name="k" value="'.$i.'" />
                                </td>
                                <td><label>'.$name_satuan.'</label></td>
                                <td>'.$jmlPerSatuan.'</td>
                                <td>
                                    Rp '.formatRupiah($harga_barang).'
                                    <input type="hidden" readonly name="hargabeli" value='.$harga_barang.' />
                                </td>
                                <td>Rp '.formatRupiah(ceil($harga_beli_persatuan)).'</td>
                                <td>'.$laba.'%</td>>
                                <td>Rp '.formatRupiah($harga_jual_after_laba).'</td>
                                <td><span id="subtotal'.$j.'"></span></td>
                                <td>
                                    <input type="hidden" name="l" id="l'.$i.'" value="'.$i.'" />
                                    <input type="hidden" name="hargal" id="hargal'.$i.'" value="'.$harga_barang.'" />
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus('.$i.')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        ';
                        $j++;
                    endif;
                endfor;
                echo '
                <tr>
                    <td colspan="10"><p align="right">Total</p></td>
                    <td>
                        <b id="total"></b>
                        <input type="hidden" name="totbayar" id="totbayar" value="'.$_SESSION['totbayarpembelian'].'" />
                    </td>
                    <td></td>
                </tr>';
                if($j!=0):
                    echo'
                    <tr>
                        <td colspan="10"></td>
                        <td colspan="2"><button type="submit" id="simpantrans" class="btn btn-block btn-primary"> Simpan Transaksi</button></td>
                    </tr>
                    ';
                endif;
            ?>
            
        </tbody>
    </table>
</form>

<script src="assets/js/system.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/TransPembelian.js"></script>
