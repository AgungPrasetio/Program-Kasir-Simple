<?php
error_reporting(0);
require_once "db.php";

class PelangganController extends db{
    protected $table = "pelanggan";
    protected $fild = "*";
    
    public function data($orderby=null){

        if($orderby==null):
            $orderby = "DESC";
        endif;

        $order = "id_pelanggan DESC";
        $i = 0;
        $no = 1;
        foreach(parent::select($this->table, $this->fild, '', '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id'] = $data['id_pelanggan'];
            $datas[$i]['nama'] = ucwords($data['nama_pelanggan']);
            $datas[$i]['telpon'] = $data['telpon_pelanggan'];
            $datas[$i]['alamat'] = $data['alamat_pelanggan'];
            if($data['jenis_kelamin']=="P"):
                $jenis_kelamin = "Pria";
            else:
                $jenis_kelamin = "Wanita";
            endif;
            $datas[$i]['jk'] = $jenis_kelamin;
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $where = "id_pelanggan='$id'";
        $i = 0;

        foreach(parent::select($this->table, $this->fild, $where) as $data):
            $datas[$i]['nama'] = ucwords($data['nama_pelanggan']);
            $datas[$i]['telpon'] = ucwords($data['telpon_pelanggan']);
            $datas[$i]['alamat'] = ucwords($data['alamat_pelanggan']);
            if($data['jenis_kelamin']=="P"):
                $jenis_kelamin = "Pria";
            else:
                $jenis_kelamin = "Wanita";
            endif;
            $datas[$i]['jk'] = $jenis_kelamin;
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