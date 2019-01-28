<?php
session_start();
error_reporting(0);
require_once "db.php";

class KategoriController extends db{
    protected $table = "kategori";
    protected $fild = "*";
    
    public function data($orderby=null){

        if($orderby==null):
            $orderby = "DESC";
        endif;

        $order = "id_kategori $orderby";
        $i = 0;
        $no = 1;
        
        foreach(parent::select($this->table, $this->fild, '', '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id'] = $data['id_kategori'];
            $datas[$i]['nama_kategori'] = $data['nama_kategori'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $where = "id_kategori='$id'";
        $i = 0;

        foreach(parent::select($this->table, $this->fild, $where) as $data):
            $datas[$i]['nama_kategori'] = $data['nama_kategori'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    //count relation of kategori
    public function count($id){
        $tbr = "jenis_barang";
        $rowname = "id_kategori";
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