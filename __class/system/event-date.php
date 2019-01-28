<?php
	function event_date($dt){
			$date = substr($dt,0,2);
			$month = getMonth(substr($dt,3,2));
			return $date.' '.$month.'';
	}

	function article_date($dt){
			$date = substr($dt,8,2);
			$month = getMonth(substr($dt,5,2));
			return "<span>$date</span><span>$month</span>";
	}

	function post_date($dt){
			$date = substr($dt,8,2);
			$month = getMonth(substr($dt,5,2));
			$year = substr($dt,0,4);
			return "$month $date, $year";
	}

	function getMonth($month){
		switch ($month){
			case 1:
				return "Jan";
				break;
			case 2:
				return "Feb";
				break;
			case 3:
				return "Mar";
				break;
			case 4:
				return "Apr";
				break;
			case 5:
				return "May";
				break;
			case 6:
				return "Jun";
				break;
			case 7:
				return "Jul";
				break;
			case 8:
				return "Aug";
				break;
			case 9:
				return "Sep";
				break;
			case 10:
				return "Oct";
				break;
			case 11:
				return "Nov";
				break;
			case 12:
				return "Dec";
				break;
		}
	}

	function tgl_indo($tgl){
		$tanggal = substr($tgl,8,2); $bulan = getBulan(substr($tgl,5,2)); $tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;
	}

	function getBulan($bln){
		switch ($bln){
			case 1:return "Januari";
			break;
			case 2:return "Februari";
			break;
			case 3:return "Maret";
			break;
			case 4:return "April";
			break;
			case 5:return "Mei";
			break;
			case 6:return "Juni";
			break;
			case 7:return "Juli";
			break;
			case 8:return "Agustus";
			break;
			case 9:return "September";
			break;
			case 10:return "Oktober";
			break;
			case 11:return "Nopember";
			break;
			case 12:return "Desember";
			break;
		}
	}

	function getAngkaMonth($bulan){
		switch($bulan){
			case "Jan":
				$bln = 1;
			break;
			case "Feb":
				$bln = 2;
			break;
			case "Mar":
				$bln = 3;
			break;
			case "Apr":
				$bln = 4;
			break;
			case "May":
				$bln = 5;
			break;
			case "Jun":
				$bln = 6;
			break;
			case "Jul":
				$bln = 7;
			break;
			case "Aug":
				$bln = 8;
			break;
			case "Sep":
				$bln = 9;
			break;
			case "Oct":
				$bln = 10;
			break;
			case "Nov":
				$bln = 11;
			break;
			case "Dec":
				$bln = 12;
			break;
		}

		return $bln;
	}

	function getAngkaBulan($bulan){
		switch ($bulan){
			case "January":
				$angka = 1;
			break;
			case "February":
				$angka = 2;
			break;
			case "March":
				$angka = 3;
			break;
			case "April":
				$angka = 4;
			break;
			case "May":
				$angka = 5;
			break;
			case "June":
				$angka = 6;
			break;
			case "July":
				$angka = 7;
			break;
			case "August":
				$angka = 8;
			break;
			case "September":
				$angka = 9;
			break;
			case "October":
				$angka = 10;
			break;
			case "November":
				$angka = 11;
			break;
			case "December":
				$angka = 12;
			break;
		}

		return $angka;
	}

	function subDate($date){
		$tgl = substr($date,8,2);
		$thn = substr($date,11,4);
		$bulan = substr($date,4,3);
		switch($bulan){
			case "Jan":
				$bln = 1;
			break;
			case "Feb":
				$bln = 2;
			break;
			case "Mar":
				$bln = 3;
			break;
			case "Apr":
				$bln = 4;
			break;
			case "May":
				$bln = 5;
			break;
			case "Jun":
				$bln = 6;
			break;
			case "Jul":
				$bln = 7;
			break;
			case "Aug":
				$bln = 8;
			break;
			case "Sep":
				$bln = 9;
			break;
			case "Oct":
				$bln = 10;
			break;
			case "Nov":
				$bln = 11;
			break;
			case "Dec":
				$bln = 12;
			break;
		}
		$jadi = $thn."-".$bln."-".$tgl;
		return $jadi;
	}
?>
