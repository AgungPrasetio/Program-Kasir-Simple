<?php
error_reporting(0);
require_once "db.php";
require_once "KedudukanController.php";

class UserController extends db{
    protected $table = array(
        'user U',
        'kedudukan K'
    ); 
    protected $fild = "*";
    protected $where = "U.id_kedudukan=K.id_kedudukan";
    
    public function data($orderby=null){

        if($orderby==null):
            $orderby = "DESC";
        endif;

        $order = "U.id_user DESC";
        $i = 0;
        $no = 1;
        foreach(parent::select($this->table, $this->fild, $this->where, '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id'] = $data['id_user'];
            $datas[$i]['nama_lengkap'] = ucwords($data['nama_lengkap']);
            $datas[$i]['username'] = $data['username'];
            $datas[$i]['kedudukan'] = ucwords($data['nama_kedudukan']);
            if($data['status']=="A"):
                $status = "Aktif";
            else:
                $status = "Tidak Aktif";
            endif;
            $datas[$i]['status'] = $status;
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $where = "U.id_user='$id' AND U.id_kedudukan=K.id_kedudukan";
        $i = 0;

        foreach(parent::select($this->table, $this->fild, $where) as $data):
            $datas[$i]['id'] = $data['id_user'];
            $datas[$i]['nama_lengkap'] = ucwords($data['nama_lengkap']);
            $datas[$i]['username'] = $data['username'];
            $datas[$i]['kedudukan'] = ucwords($data['nama_kedudukan']);
            $datas[$i]['id_kedudukan'] = ucwords($data['id_kedudukan']);
            if($data['status']=="A"):
                $status = "Aktif";
            else:
                $status = "Tidak Aktif";
            endif;
            $datas[$i]['status'] = $status;
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

    public function SelectKedudukan(){
        $KedudukanCon = new KedudukanController();
        $orderby = "ASC";
        $data = $KedudukanCon->data($orderby);

        return $data;
    }

    public function SelectKasir(){
        $tkasir = array(
            'user K',
            'kedudukan KE'
        );
        $fkasir = "*";
        $wkasir = "K.id_kedudukan=KE.id_kedudukan AND KE.nama_kedudukan='Kasir'";
        $i= 0;
        foreach(parent::select($tkasir, $fkasir, $wkasir) as $dkasir):
            $datas[$i]['id'] = $dkasir['id_user'];
            $datas[$i]['nama_lengkap'] = ucwords($dkasir['nama_lengkap']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }
}
?>