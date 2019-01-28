<?php

?>
<nav>
    <ul class="nav">
        <li><a href="main.php"><i class="lnr lnr-home"></i> <span>Home</span></a></li>
        <?php
        if(strtolower($namekedudukan)=="administrator"):
            echo '
            <li>
                <a href="#user" data-toggle="collapse" class="collapsed"><i class="fa fa-user" aria-hidden="true"></i> <span>User</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="user" class="collapse ">
                    <ul class="nav">
                        <li><a href="?mod=kedudukan" class="">Kedudukan</a></li>
                        <li><a href="?mod=user" class="">User</a></li>
                        <li><a href="?mod=pelanggan">Pelanggan</a></li>
                        <li><a href="?mod=pemasok">Pemasok</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="?mod=pengeluaran"><i class="lnr lnr-file-empty"></i> <span>Pengeluaran</span></a></li>
            <li><a href="?mod=kepemilikan"><i class="fa fa-user"></i> <span>Kepemilikan Barang</span></a></li>
            ';
        endif;
        ?>
        
        <?php if(strtolower($namekedudukan)!='Owner'): ?>
        <li>
            <a href="#barang" data-toggle="collapse" class="collapsed"><i class="fa fa-cubes" aria-hidden="true"></i> <span>Barang</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
            <div id="barang" class="collapse ">
                <ul class="nav">
                    <li><a href="?mod=merek" class="">Merek</a></li>
                    <li><a href="?mod=kategori" class="">Kategori</a></li>
                    <li><a href="?mod=jenis_barang" class="">Jenis Barang</a></li>
                    <li><a href="?mod=satuan_barang" class="">Satuan Barang</a></li>
                    <li><a href="?mod=barang" class="">Barang (No Barcode)</a></li>
                    <li><a href="?mod=barang_barcode" class="">Barang (With Barcode)</a></li>
                </ul>
            </div>
        </li>
        <li>
            <a href="#transaksi" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Transaksi</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
            <div id="transaksi" class="collapse ">
                <ul class="nav">
                    <li><a href="?mod=penjualan" class="">Penjualan Barang</a></li>
                    <?php
                    if(strtolower($namekedudukan)=="administrator"):
                    echo '
                        <li><a href="?mod=pembelian" class="">Pembelian Barang</a></li>
                    ';
                    endif;
                    ?>
                </ul>
            </div>
        </li>
        <?php endif; ?>
        
        <li>
            <a href="#laporan" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Laporan</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
            <div id="laporan" class="collapse ">
                <ul class="nav">
                    <li><a href="?mod=history_penjualan" class="">Penjualan Barang</a></li>
                    <?php
                    if(strtolower($namekedudukan)!="kasir"):
                    echo '
                        <li><a href="?mod=history_pembelian" class="">Pembelian Barang</a></li>
                        <li><a href="?mod=laba_rugi" class="">Laba Kotor</a></li>
                        <li><a href="?mod=laba_bersih" class="">Laba Bersih</a></li>
                        <li><a href="?mod=lap_penjualan">Penjualan Tiap Kasir</a></li>
                        <li><a href="?mod=stok_barang_habis">Stok Barang Habis</a></li>
                    ';
                    endif;
                    ?>
                </ul>
            </div>
        </li>
    </ul>
</nav>