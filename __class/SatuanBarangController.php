<?php
session_start();
error_reporting(0);
require_once "db.php";

class SatuanBarangController extends db{
    protected $table = "satuan_barang";
    protected $fild = "*";
    
    public function data($orderby=null){

        if($orderby==null):
            $orderby = "DESC";
        endif;

        $order = "id_satuan_barang $orderby";
        $i = 0;
        $no = 1;
        
        foreach(parent::select($this->table, $this->fild, '', '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id'] = $data['id_satuan_barang'];
            $datas[$i]['nama_satuan_barang'] = $data['nama_satuan_barang'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $where = "id_satuan_barang='$id'";
        $i = 0;

        foreach(parent::select($this->table, $this->fild, $where) as $data):
            $datas[$i]['nama_satuan_barang'] = $data['nama_satuan_barang'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    //count relation of satuan barang
    public function count($id){
        $tbr = "detil_pembelian";
        $rowname = "id_satuan_barang";
        $count = parent::getCount($tbr, $rowname, $id);

        return $count;
    }

    public function get_kedudukan_session(){
        $kedudukan = $_SESSION['kedudukan'];

        $name_kedudukan = parent::kedudukan_session($kedudukan);
        return $name_kedudukan;
    }
}
?>