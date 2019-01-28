<?php
class db extends PDO{
	protected $dbms = "mysql";
	protected $dbhost ="localhost";
	protected $dbuser = "root";
	protected $dbpass = "";
	protected $dbnm = "new_kasir";

	private $a = "";

	private $hasil;

	function __construct(){
		try{
			parent::__construct($this->dbms.':host='.$this->dbhost.';dbname='.$this->dbnm, $this->dbuser, $this->dbpass);
			PDO::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbms == 'mysql' ? PDO::exec("SET CHARACTER SET utf8") : '';
		}catch(PDOException $e){
			echo $e->getMessage();
			exit();
		}
	}

	/* Function Tampil */
	public function select($table=null, $rows=null, $where=null, $lj=null, $order=null, $limit=null, $groupby=null, $having=null, $value_having=null){
		//check kondisi parameter $tabel
		if($rows!=null):
			if(is_array($rows)):
				foreach ($rows as $row){
	                $fild[] = $row;
	            }
				$fild = implode(', ', $fild);
			else:
				$fild = $rows;
			endif;
		endif;

		if($table!=null):
			if(is_array($table)):
				foreach ($table as $key):
				  $param[] = $key;
				endforeach;
				$param = implode(', ', $param);
	    	else:
				$param = $table;
			endif;
			$sql = 'SELECT '.$fild.' FROM '.$param;
		elseif($table==null):
			$sql = 'SELECT '.$fild;
		endif;
		//check kondisi parameter $rows

		// check kondisi $where

		if($lj != null):
			$sql = 'SELECT '.$fild.' FROM '.$lj;
		endif;
		if($where != null):
			$sql .= ' WHERE '.$where;
		endif;
		if($groupby != null):
			$sql .= ' GROUP BY '.$groupby;
		endif;
		if($order != null):
			$sql .= ' ORDER BY '.$order;
		endif;
		if($limit != null):
			$sql .= ' LIMIT '.$limit;
		endif;
		if($having != null):
			$sql .= ' HAVING '.$value_having.' '.$having;
		endif;

		$query = $this->prepare($sql);
		$query->execute();
		$posts = array();

		while($row = $query->fetch()):
			$posts[] = $row;
		endwhile;

		return $posts;
	}

	/* Function Tambah */
	public function add($table, $rows){
		if(is_array($rows)):
			foreach($rows as $key => $val):
				$vals[] = "'".$val."'";
				$keys[] = $key;
			endforeach;
		endif;
		$field = implode(', ',$keys);
		$value = implode(', ',$vals);
		$sql = "INSERT INTO ".$table." (".$field.") VALUES (".$value.")";
		$query = $this->prepare($sql);
		$query->execute();
	}

	//function update
	public function update($table=null, $data=null, $where=null){
		if(is_array($table)):
			foreach ($table as $key):
				$paramtable[] = $key;
			endforeach;
			$paramtable = implode(', ', $paramtable);
		else:
			$paramtable = $table;
		endif;

		$sql = "UPDATE ".$paramtable;
		
		if(is_array($data)):
			foreach ($data as $key =>$val):
				$vals = "'".$val."'";
				$param[] = $key." = ".$vals;
			endforeach;
			$param = implode(', ', $param);
		else:
			$param = $data;
		endif;
		$a = "";
		$sql .= " SET ".$param;
		if($where != null):
			$sql .= ' WHERE '.$where;
		endif;

		$query = $this->prepare($sql);
		$query->execute();
		if(!$query):
			$a = "gagal";
		endif;

		return $a;
  }

    //function delete
	public function delete($table,$where=null){
		$sql = "DELETE FROM ".$table;
		if(!empty($where)):
			$sql .= ' WHERE '.$where;
		endif;
		$query = $this->prepare($sql);
		$query->execute();
		$a = "";
		if(!$query):
			$a = "gagal";
		endif;

		return $a;
	}

	/* Function GET Count Name Each T(able */

	public function getCount($tabel, $fild=null, $data=null, $where=null){
		$query = "COUNT(*) as jml";

		if($where==null){
			if($fild!=null && $data!=null):
				$where = "$fild='$data'";
			else:
				$where = "";
			endif;
		}

		foreach($this->select($tabel, $query, $where) as $data):
			$jml = $data['jml'];
		endforeach;
		

		return $jml;
	}

	public function getRowName($table, $fild, $where){
		foreach($this->select($table, $fild, $where) as $data):
			$result = $data[$fild];
		endforeach;

		return $result;
	}

	public function kedudukan_session($id){
		$tkedudukan = "kedudukan";
		$fkedudukan = "nama_kedudukan";
		$wkedudukan = "id_kedudukan='$id'";
		$namekedudukan = ucwords($this->getRowName($tkedudukan, $fkedudukan, $wkedudukan));

		return $namekedudukan;
	}

}
?>
