<?php
session_start();
error_reporting(0);
require_once "db.php";
require_once "JenisBarangController.php";

class MerekController extends db{
    protected $table = "merek";
    protected $fild = "*";
    
    public function data($orderby=null){

        if($orderby==null):
            $orderby = "DESC";
        endif;

        $order = "id_merek DESC";
        $i = 0;
        $no = 1;
        foreach(parent::select($this->table, $this->fild, '', '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id'] = $data['id_merek'];
            $datas[$i]['nama_merek'] = ucwords($data['nama_merek']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $table = "merek as M";
        $fild = "*";
        $where = "M.id_merek='$id'";
        $join = "leftjoin jenis_barang as J ON M.id_jenis_barang=J.id_jenis_barang";
        $i = 0;

        foreach(parent::select($this->table, $this->fild, $where, $join) as $data):
            $datas[$i]['nama_merek'] = ucwords($data['nama_merek']);
            $datas[$i]['nama_jenis'] = ucwords($data['nama_jenis_barang']);
            $datas[$i]['id_jenis'] = ucwords($data['id_jenis_barang']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    //count relation of kategori
    public function count($id){
        $tbr = "barang";
        $rowname = "id_merek";
        $count = parent::getCount($tbr, $rowname, $id);

        return $count;
    }

    public function get_kedudukan_session(){
        $kedudukan = $_SESSION['kedudukan'];

        $name_kedudukan = parent::kedudukan_session($kedudukan);
        return $name_kedudukan;
    }

    public function SelectJenis(){
        $con = new JenisBarangController();
        $orderby = "ASC";
        $data = $con->data($orderby);

        return $data;
    }
}
?>