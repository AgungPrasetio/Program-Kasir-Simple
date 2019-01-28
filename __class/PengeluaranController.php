<?php
session_start();
error_reporting(0);
require_once "db.php";

class PengeluaranController extends db{
    protected $table = "pengeluaran";
    protected $fild = "*";
    
    public function data($orderby=null){

        if($orderby==null):
            $orderby = "DESC";
        endif;

        // $where = "JB.id_kategori=K.id_kategori";
        $order = "id_pengeluaran $orderby";
        $i = 0;
        $no = 1;

        foreach(parent::select($this->table, $this->fild, $where, '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id'] = $data['id_pengeluaran'];
            $datas[$i]['jenis'] = ucwords($data['jenis_pengeluaran']);
            $datas[$i]['keterangan'] = $data['keterangan'];
            $datas[$i]['tanggal'] = $data['tanggal'];
            $datas[$i]['nominal'] = "Rp ".number_format($data['nominal']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $where = "id_pengeluaran='$id'";
        $i = 0;

        foreach(parent::select($this->table, $this->fild, $where) as $data):
            $datas[$i]['id'] = $data['id_pengeluaran'];
            $datas[$i]['jenis'] = ucwords($data['jenis_pengeluaran']);
            $datas[$i]['keterangan'] = $data['keterangan'];
            $datas[$i]['tanggal'] = $data['tanggal'];
            $datas[$i]['nominal'] = ($data['nominal']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }


    public function get_kedudukan_session(){
        $kedudukan = $_SESSION['kedudukan'];

        $name_kedudukan = parent::kedudukan_session($kedudukan);
        return $name_kedudukan;
    }
}
?>