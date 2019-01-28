<?php
// session_start();
error_reporting(0);
require_once "db.php";
require_once "BarangController.php";

class LabaBersihController extends db{
    
    public function data_laporan($post){
        $m = substr($post, 0,2);
        $y = substr($post, -4);

        // get total penjualan
        $penjualan = "penjualan";
        $fpenjualan = "sum(total) AS total_penjualan";
        $total_penjualan = "";
        $wpenjualan = "month(tanggal_penjualan)=$m AND year(tanggal_penjualan)=$y";
        foreach(parent::select($penjualan, $fpenjualan, $wpenjualan) as $dpenjualan):
        endforeach;
        $total_penjualan = $dpenjualan['total_penjualan'];

        //get data pembelian
        $pembelian = "pembelian";
        $fpembelian = "sum(total_pembelian) AS total_pembelian";
        $total_pembelian = "";
        $wpembelian = "month(tanggal_pembelian)=$m AND year(tanggal_pembelian)=$y";

        foreach(parent::select($pembelian, $fpembelian, $wpembelian) as $dpembelian):
        endforeach;
        $total_pembelian = $dpembelian['total_pembelian'];

        if($total_penjualan==""){
            $total_penjualan = 0;
        }
        if($total_pembelian==""){
            $total_pembelian = 0;
        }

        $datas['total_penjualan'] = $total_penjualan;
        $datas['total_pembelian'] = $total_pembelian;
        
        return $datas;
    }

    public function get_data_pengeluaran($post){
        $m = substr($post, 0,2);
        $y = substr($post, -4);

        $tabel = "pengeluaran";
        $fild = "*";
        $where = "month(tanggal)=$m AND year(tanggal)=$y";
        $order = "jenis_pengeluaran ASC";

        // $datas = "asdasd";
        $i=0;
        foreach(parent::select($tabel, $fild, $where, '', $order) as $data):
            $datas[$i]['jenis_pengeluaran'] = $data['jenis_pengeluaran'];
            $datas[$i]['keterangan'] = $data['keterangan'];
            $datas[$i]['tanggal'] = $data['tanggal'];
            $datas[$i]['nominal'] = $data['nominal'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }


    public function list_penjualan($post){
        $m = substr($post, 0,2);
        $y = substr($post, -4);

        $tabel = array(
            'penjualan PE',
            'pelanggan PL',
            'user U',
        ); 
        $fild = "DISTINCT PE.id_penjualan, PL.nama_pelanggan, U.nama_lengkap, PE.tanggal_penjualan, PE.total, PE.diskon";
        $where = "PE.id_pelanggan=PL.id_pelanggan AND PE.id_user=U.id_user AND month(PE.tanggal_penjualan)=$m AND year(PE.tanggal_penjualan)=$y";
        $order = "PE.tanggal_penjualan DESC";

        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '',$order,$limit) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id_penjualan'] = $data['id_penjualan'];
            $datas[$i]['nama_pelanggan'] = ucwords($data['nama_pelanggan']);
            $datas[$i]['nama_kasir'] = ucwords($data['nama_lengkap']);
            $datas[$i]['tanggal'] = date("d M Y, H:i", strtotime($data['tanggal_penjualan']));
            $datas[$i]['total'] = $data['total'];
            $datas[$i]['diskon'] = $data['diskon'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function list_detil_penjualan($id){
        $diskon = $this->get_diskon_penjualan($id);
        // DETIL TRANSAKSI
        $tdetil = array(
            'detil_penjualan D',
            'barang B'
        ); 
        $fdetil = "*";
        $wdetil = "D.kode_barang=B.kode_barang AND D.id_penjualan='$id'";
        $odetil = "B.nama_barang ASC";

        $html .='
        <table width="100%" class="table table-bordered table-striped">
            <tr>
                <td width="30%">Nama Barang</td>
                <td width="15%">Jumlah</td>
                <td width="28%">Harga Barang</td>
                <td width="28%">Potongan Per Barang</td>
                <td width="27%">Sub Total</td>
            </tr>';

            $i = 0;
            $no = 1;
            $tot = 0;
            foreach(parent::select($tdetil, $fdetil, $wdetil, '',$odetil) as $ddetil):
                $potongan_per_barang = $ddetil['potongan_per_barang'];
                $jumlah = $ddetil['jumlah'];
                $harga_barang = $ddetil['harga'];
                $sub_total = ($harga_barang*$jumlah)-($potongan_per_barang*$jumlah);
                $tot+=$sub_total;
                
                $html .='
                    <tr>
                        <td>'.ucwords($ddetil['nama_barang']).'</td>
                        <td>'.$jumlah.'</td>
                        <td>Rp '.number_format($harga_barang,0).'</td>
                        <td>Rp '.number_format($potongan_per_barang,0).'</td>
                        <td>Rp '.number_format($sub_total,0).'</td>
                    </tr>
                ';
            endforeach;

            if($diskon!=0){
                $html .= '
                    <tr>
                        <td colspan="4" style="text-align:right">Diskon</td>
                        <td>'.$diskon.'%</td>
                    </tr>
                '; 
                $tot = $tot-($tot*($diskon/100));
            }

            $html .= '
                <tr>
                    <td colspan="4" style="text-align:right">Total</td>
                    <td>Rp '.number_format($tot,0).'</td>
                </tr>
            ';
            

        $html .= '
        </table>
        ';
        
        return $html;
    }

    public function get_diskon_penjualan($id_penjualan){
        $tabel = "penjualan";
        $fild = "diskon";
        $where = "id_penjualan='$id_penjualan'";
        foreach(parent::select($tabel, $fild, $where) as $d):
        endforeach;

        return $d['diskon'];
    }


    public function list_pembelian($post){
        $m = substr($post, 0,2);
        $y = substr($post, -4);

        $tabel = array(
            'pembelian PE',
            'pemasok PM',
            'user U'
        ); 
        $fild = "*";
        
        $where = "PE.id_pemasok=PM.id_pemasok AND PE.id_user=U.id_user AND month(PE.tanggal_pembelian)=$m AND year(PE.tanggal_pembelian)=$y";
        $order = "PE.tanggal_pembelian DESC";

        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '',$order,$limit) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id_pembelian'] = $data['id_pembelian'];
            $datas[$i]['nama_pemasok'] = ucwords($data['nama_pemasok']);
            $datas[$i]['nama_petugas'] = ucwords($data['nama_lengkap']);
            $datas[$i]['tanggal'] = date("d M Y, H:i", strtotime($data['tanggal_pembelian']));
            $datas[$i]['total'] = $data['total_pembelian'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }


    public function list_detil_pembelian($id){
        // DETIL TRANSAKSI
        $tdetil = array(
            'detil_pembelian D',
            'barang B',
            'satuan_barang as S'
        ); 
        $fdetil = "*";
        $wdetil = "D.kode_barang=B.kode_barang AND S.id_satuan_barang=D.id_satuan_barang AND D.id_pembelian='$id'";
        $odetil = "B.nama_barang ASC";

        $html .='
        <table width="100%" class="table table-bordered table-striped">
            <tr>
                <td width="30%">Nama Barang</td>
                <td width="28%">Satuan Barang</td>
                <td width="15%">Jumlah</td>
                <td width="28%">Harga Barang</td>
                <td width="27%">Sub Total</td>
            </tr>';

            $i = 0;
            $no = 1;
            $tot = 0;
            foreach(parent::select($tdetil, $fdetil, $wdetil, '',$odetil) as $ddetil):
                $jumlah = $ddetil['jumlah_beli'];
                $harga_barang = $ddetil['harga_beli'];
                $sub_total = $jumlah*$harga_barang;
                $tot+=$sub_total;
                
                $html .='
                    <tr>
                        <td>'.ucwords($ddetil['nama_barang']).'</td>
                        <td>'.ucwords($ddetil['nama_satuan_barang']).'</td>
                        <td>'.$jumlah.'</td>
                        <td>Rp '.number_format($harga_barang,0).'</td>
                        <td>Rp '.number_format($sub_total,0).'</td>
                    </tr>
                ';
            endforeach;

            $html .= '
                <tr>
                    <td colspan="4" style="text-align:right">Total</td>
                    <td>Rp '.number_format($tot,0).'</td>
                </tr>
            ';
            

        $html .= '
        </table>
        ';
        
        return $html;
    }

}
?>