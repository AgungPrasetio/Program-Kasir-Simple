<?php
error_reporting(0);
require_once "db.php";
include_once "system/event-date.php";

class DashboardController extends db{
    protected $table = array(
        'jenis_barang JB',
        'kategori K'
    );
    protected $fild = "*";
    
    public function data(){
        
        $option_month = $_REQUEST['option_month'];

        return $option_month;
    }

    public function option_month(){
        $option_month = $_REQUEST['option_month'];
        if($option_month==""){
            $option_month = date("m");
        }
        $option = "";
        for($i=1;$i<=12;$i++):
            $bulan = getBulan($i);
            if($option_month==$i){
                $option .= "<option value='$i' selected>$bulan</option>";
            }else{
                $option .= "<option value='$i'>$bulan</option>";
            }
        endfor;

        return $option;
    }

    public function option_year(){
        $option_year = $_REQUEST['option_year'];
        if($option_year==""){
            $option_year = date("Y");
        }
        $option = "";
        $year_now = date("Y");
        $min_year = $year_now-5;
        for($i=$min_year;$i<=$year_now;$i++):
            if($option_year==$i){
                $option .= "<option value='$i' selected>$i</option>";
            }else{
                $option .= "<option value='$i'>$i</option>";
            }
        endfor;

        return $option;
    }

    public function search(){
        $option_month = $_REQUEST['option_month'];
        $option_year = $_REQUEST['option_year'];
        if($option_month=="" || $option_year==""){
            $option_month = date("m");
            $option_year = date("Y");
        }
        $countdays = cal_days_in_month(CAL_GREGORIAN, $option_month, $option_year);

        for($i=1;$i<=$countdays;$i++):
            $date = $option_year."-".$option_month."-".$i;
            $data['days'] .= "$i,";

            //get count penjualan
            $tpenjualan = "penjualan";
            $fpenjualan = "COUNT(*) count_penjualan";
            $wpenjualan = "date(tanggal_penjualan)='$date'";
            foreach(parent::select($tpenjualan,$fpenjualan,$wpenjualan) as $dpenjualan):
            endforeach;
            $data['cpenjualan'] .= $dpenjualan['count_penjualan'].",";

            //get count pembelian
            $tpembelian = "pembelian";
            $fpembelian = "COUNT(*) count_pembelian";
            $wpembelian = "date(tanggal_pembelian)='$date'";
            foreach(parent::select($tpembelian,$fpembelian,$wpembelian) as $dpembelian):
            endforeach;
            $data['cpembelian'] .= $dpembelian['count_pembelian'].",";
        endfor;
        
        return $data;
    }

    public function check_saldo_awal(){
        $today = date("Y-m-d");
        $tsaldo = "saldo_awal";
        $fsaldo = array(
            'saldo_awal_nominal',
        );
        $wsaldo = "id_user='$_SESSION[id_user]' AND tanggal='$today'";
        foreach(parent::select($tsaldo,$fsaldo,$wsaldo) as $dsaldo):
        endforeach;

        return $dsaldo['saldo_awal_nominal'];
    }
}
?>