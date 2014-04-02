<?php
// converte datetime (sql) em um array X. 
// Onde X[0] = dia/mes/ano  e  X[1] = hora:min:segundo
class Tools {
	public function dateTime($string) {
		$date = explode(' ',$string);
		$hour = $date[1];
      	$date = explode('-',$date[0]);
		$date = array_reverse($date);
      	$date = implode('/',$date);
		$datetime = array($date,$hour);
		return($datetime);
	}
}
/* teste da função datetime
$data=date('Y-m-d H:i:s');
$obj = new Tools;
$d=$obj->dateTime($data); print_r($d);
*/


?>


