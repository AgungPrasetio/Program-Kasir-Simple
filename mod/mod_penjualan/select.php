<?php
session_start();
include_once "../../__class/system/currency.php";
require_once "../../__class/PenjualanController.php";
require_once "../../__class/PelangganController.php";
$pelanggancon = new PelangganController();
$controller = new PenjualanController();

if(!isset($_SESSION['totbayar'])){
    $_SESSION['totbayar'] = 0;
}

if(isset($_GET['addSuccess'])):
    echo '
    <div class="alert alert-success" style="height:65px;">
        <div class="col-md-8"> 
            <i class="fa fa-check" aria-hidden="true"></i> &nbsp; Transaksi berhasil di simpan !
        </div>
        <div class="col-md-2 col-md-offset-2">
            <a href="cetaknota.php?id_penjualan='.$_GET['id_penjualan'].'" target="_blank" class="btn btn-block btn-md btn-info">Cetak Nota</a>
        </div>
    </div>';
endif;
?>

<div id="infotrans"></div>
<form action="" method="POST" id="form-transaksi">
    <div class="form-group">
        <label for="kode_barang" class="col-sm-2">Nama Pelanggan</label>
        <div class="col-sm-4">
            <!-- <div id="select-pelanggan"></div> -->
            <select name="pelanggan" id="pelanggan" onchange="changepelanggan()" class="selectize_data">
                <?php
                    $pelanggan = $pelanggancon->data();
                    foreach($pelanggan as $K):
                        if(isset($_SESSION['id_pelanggan'])):
                            if($_SESSION['id_pelanggan']==$K->id):
                                echo '<option value="'.$K->id.'" selected>'.$K->nama.'</option>';
                            else:
                                echo '<option value="'.$K->id.'">'.$K->nama.'</option>';
                            endif;
                        else:
                            echo '<option value="'.$K->id.'">'.$K->nama.'</option>';
                        endif;
                    endforeach;
                ?>
            </select>
        </div>
        <div class="col-sm-4 col-sm-offset-2">
           <h2 style="margin:0px; padding:0px; text-align:right;">TOTAL = <span id="totaltrans"></span></h2>
        </div><br/><br/>
    </div>
    <table class="table table-bordered table-striped" style="font-size:13px;">
        <thead>
            <tr>
                <th width="10px">No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th width="60px">Qty</th>
                <th>Harga</th>
                <th width="100px">Total</th>
                <th width="100px">Potongan Per Barang</th>
                <th width="120px">Total Potongan</th>
                <th width="90px">Sub Total</th>
                <th width="30px">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php
                @$awal = $_SESSION['nilai'];
                $no=1;
                $j=0;
                for($i=0; $i<=$awal;$i++):
                    if(@$_SESSION['isi'][$i][0]!=''):
                        $kode_barang = @$_SESSION['isi'][$i][0];
                        $nama_barang = @$_SESSION['isi'][$i][1];
                        $harga_barang = @$_SESSION['isi'][$i][2];
                        $qty = @$_SESSION['isi'][$i][3];
                        $potongan = @$_SESSION['isi'][$i][4];
                        echo '
                            <tr>
                                <td>'.$no++.'</td>
                                <td>'.$kode_barang.'</td>
                                <td>'.$nama_barang.'</td>
                                <td>
                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" max="400" name="qty" style="text-align:right; width:60px;" value="'.$qty.'" onchange="change()" style="width:60px;" />
                                    <input type="hidden" name="k" value="'.$i.'" />
                                </td>
                                <td>
                                    Rp '.formatRupiah($harga_barang).'
                                    <input type="hidden" name="harga" value='.$harga_barang.' />
                                </td>
                                <td><span id="total_harga'.$j.'"></span></td>
                                <td>
                                    <input type="number" onkeypress="return event.charCode >= 48" style="text-align:right; width:80px;" value="'.$potongan.'" onchange="change_potongan()" name="potongan" id="potongan" />
                                </td>
                                <td><span id="total_potongan'.$j.'"></span></td>
                                <td><span id="sub_total'.$j.'"></span></td>
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
                    <td colspan="8"><p align="right">Total</p></td>
                    <td>
                        <b id="total"></b>
                        <input type="hidden" name="totbayar" id="totbayar" value="'.$_SESSION['totbayar'].'" />
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="8"><p align="right">Diskon</p></td>
                    <td>
                        <input type="number" style="text-align:right; width:100px;" onkeyup="change_diskon()" name="diskon" id="diskon" value="0" />
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="8"><p align="right">Total Setelah Diskon</p></td>
                    <td>
                        <div id="total_after_diskon"></div>
                        <input type="hidden" name="total_after_diskon" />
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="8"><p align="right">Bayar</p></td>
                    <td>
                        <input type="text" onkeypress="return event.charCode >= 48" style="text-align:right; width:100px;" onkeyup="bayarr()" name="bayar" id="bayar" />
                        <input type="hidden" name="nominalbayar" id="nominalbayar" />
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="8"><p align="right">Kembali</p></td>
                    <td><b id="kembali"></b></td>
                    <td></td>
                </tr>';
                if($j!=0):
                echo'
                <tr>
                    <td colspan="8"></td>
                    <td colspan="2"><button type="submit" id="simpantrans" class="btn btn-block btn-primary"> Simpan Transaksi</button></td>
                </tr>
                ';
                endif;
            ?>
            
        </tbody>
    </table>
</form>

<script src="assets/js/system.js"></script>
<script type="text/javascript" src="assets/js/jquery/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/TransPenjualan.js?v=<?php echo date("d M Y H:i:s") ?>"></script>
<script>
$('.selectize_data').selectize({
  sortField: {
    field: 'text',
    direction: 'asc'
  }
});
</script>