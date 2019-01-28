<?php
session_start();
error_reporting(0);
require_once "db.php";
require_once "KategoriController.php";

class JenisBarangController extends db{
    protected $table = array(
        'jenis_barang JB',
        'kategori K'
    );
    protected $fild = "*";
    
    public function data($orderby=null){

        if($orderby==null):
            $orderby = "DESC";
        endif;

        $where = "JB.id_kategori=K.id_kategori";
        $order = "JB.id_jenis_barang $orderby";
        $i = 0;
        $no = 1;

        foreach(parent::select($this->table, $this->fild, $where, '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id'] = $data['id_jenis_barang'];
            $datas[$i]['nama_jenis_barang'] = $data['nama_jenis_barang'];
            $datas[$i]['nama_kategori'] = $data['nama_kategori'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $where = "JB.id_kategori=K.id_kategori AND JB.id_jenis_barang='$id'";
        $i = 0;

        foreach(parent::select($this->table, $this->fild, $where) as $data):
            $datas[$i]['nama_jenis_barang'] = $data['nama_jenis_barang'];
            $datas[$i]['kategori'] = $data['id_kategori'];
            $datas[$i]['nama_kategori'] = $data['nama_kategori'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    //count relation of jenis barang
    public function count($id){
        $tbr = "barang";
        $rowname = "id_jenis_barang";
        $count = parent::getCount($tbr, $rowname, $id);

        return $count;
    }

    public function SelectKategori(){
        $KategoriCon = new KategoriController();
        $orderby = "ASC";
        $data = $KategoriCon->data($orderby);

        return $data;
    }

    public function SetKodeJenis(){
        $tabel = "jenis_barang";
        $fild = "MAX(RIGHT(id_jenis_barang,3))+1 as max";
        
        foreach(parent::select($tabel, $fild) as $datamax):
            $angka = $datamax['max'];
        endforeach;

        if($angka < 10):
            $result = "100".$angka;
        elseif($angka < 100):
            $result = "10".$angka;
        elseif($angka < 1000):
            $result = "1".$angka;
        else:
            $result = $angka;
        endif;

        return $result;

    }

    public function get_kedudukan_session(){
        $kedudukan = $_SESSION['kedudukan'];

        $name_kedudukan = parent::kedudukan_session($kedudukan);
        return $name_kedudukan;
    }
}
?>