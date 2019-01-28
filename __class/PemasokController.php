<?php
error_reporting(0);
require_once "db.php";

class PemasokController extends db{
    protected $table = "pemasok";
    protected $fild = "*";
    
    public function data($orderby=null){

        if($orderby==null):
            $orderby = "DESC";
        endif;

        $order = "id_pemasok DESC";
        $i = 0;
        $no = 1;
        foreach(parent::select($this->table, $this->fild, '', '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id'] = $data['id_pemasok'];
            $datas[$i]['nama'] = ucwords($data['nama_pemasok']);
            $datas[$i]['telpon'] = $data['telpon_pemasok'];
            $datas[$i]['alamat'] = $data['alamat_pemasok'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $where = "id_pemasok='$id'";
        $i = 0;

        foreach(parent::select($this->table, $this->fild, $where) as $data):
            $datas[$i]['id'] = $data['id_pemasok'];
            $datas[$i]['nama'] = ucwords($data['nama_pemasok']);
            $datas[$i]['telpon'] = $data['telpon_pemasok'];
            $datas[$i]['alamat'] = $data['alamat_pemasok'];
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
}
?>