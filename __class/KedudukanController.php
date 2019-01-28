<?php
error_reporting(0);
require_once "db.php";

class KedudukanController extends db{
    protected $table = "kedudukan";
    protected $fild = "*";
    
    public function data($orderby=null){

        if($orderby==null):
            $orderby = "DESC";
        endif;

        $order = "id_kedudukan $orderby";
        $i = 0;
        $no = 1;
        foreach(parent::select($this->table, $this->fild, '', '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id'] = $data['id_kedudukan'];
            $datas[$i]['nama_kedudukan'] = ucwords($data['nama_kedudukan']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $where = "id_kedudukan='$id'";
        $i = 0;

        foreach(parent::select($this->table, $this->fild, $where) as $data):
            $datas[$i]['nama_kedudukan'] = ucwords($data['nama_kedudukan']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    //count relation of kategori
    public function count($id){
        $tbr = "user";
        $rowname = "id_kedudukan";
        $count = parent::getCount($tbr, $rowname, $id);

        return $count;
    }
}
?>