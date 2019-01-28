<?php
error_reporting(0);
require_once "db.php";

class KepemilikanController extends db{
    protected $table = "kepemilikan_barang";
    protected $fild = "*";
    
    public function data($orderby=null){

        if($orderby==null):
            $orderby = "DESC";
        endif;

        $order = "id_kepemilikan $orderby";
        $i = 0;
        $no = 1;
        foreach(parent::select($this->table, $this->fild, '', '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id'] = $data['id_kepemilikan'];
            $datas[$i]['nama'] = ucwords($data['nama_pemilik']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $where = "id_kepemilikan='$id'";
        $i = 0;

        foreach(parent::select($this->table, $this->fild, $where) as $data):
            $datas[$i]['nama'] = ucwords($data['nama_pemilik']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    //count relation of kategori
    public function count($id){
        $tbr = "barang";
        $rowname = "id_kepemilikan";
        $count = parent::getCount($tbr, $rowname, $id);

        return $count;
    }

    public function SelectPemilik(){
        $table = 'kepemilikan_barang';
        $fild = "*";
        $i= 0;
        foreach(parent::select($table, $fild) as $data):
            $datas[$i]['id'] = $data['id_kepemilikan'];
            $datas[$i]['nama_lengkap'] = ucwords($data['nama_pemilik']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function get_nama_pemilik($id){
        $table = "kepemilikan_barang";
        $fild = "nama_pemilik";
        $where = "id_kepemilikan='$id'";

        foreach(parent::select($table, $fild, $where) as $data):
        endforeach;

        return $data['nama_pemilik'];
    }
}
?>