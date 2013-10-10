<?php	
	
class dbDriver{
	private $conexion;
	
	function __construct(){
	    $this->conexion = mysql_connect("127.0.0.1:3306", "root", "") or die("Error while connecting the database");
		mysql_select_db("teamperformanceviz");
		session_start();
	}
	
	function __destruct(){
		mysql_close($this->conexion);
	}
	
	function getJson($year){
		$sql = mysql_query("SELECT * FROM goals_year WHERE year=$year");
		$response = array();
		$posts = array();
		while($row=mysql_fetch_array($sql)){
			$name = $row['point_name'];
			$finalTarget = $row['description'];
			$goalStatus = $row['latitude'];
			$data = "";
			
			$posts[] = array('name'=> $name, 'finalTarget'=> $finalTarget, 'goalStatus'=> $goalStatus, 'data'=> $data);
		}
		$response['posts'] = $posts;
		$fp = fopen("$team-performance.json", 'w');
		fwrite($fp, json_encode($response));
		fclose($fp);
	}
}

?>