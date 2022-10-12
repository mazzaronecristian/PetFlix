<?php 
	header("Access-Controll-Allow-Methods: POST");
	header('Content-Type: text/json');
	include("config.php");
	$action = $_POST['action'];

	/* conterrà la stringa di query al database */
	$query_string = "";
	
	/* smista secondo il tipo di richiesta */
	switch($action) {
		case "load" : 
			loadData();
		break;
		case "insert" :
			//echo($action);
			insertData();
		break; 
		case "update" :
	   		updateData();
		break;
		case "delete" :
			deleteData();
		break;
	}

	function insertData(){
		if (isset($_POST['time'])) {
			$time = $_POST['time'];
		} else {
			echo "you didn't specify a text";
			return;
		}	

		$flag = $_POST['flag'];

		$query_string = "SELECT * FROM orari WHERE time= '".htmlspecialchars($time)."'";
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE); 
		$result = $mysqli->query($query_string);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if($row == null){
			$query_string = "INSERT INTO orari (controlFlag, time) values ($flag, '". htmlspecialchars($time) ."')";
			$result = $mysqli->query($query_string);
		}

		$query_string = 'SELECT * FROM orari';
		$result = $mysqli->query($query_string);  
		
		$times = array();

		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		
			$id = $row['id'];
  			$timesDb = $row['text'];
			$controlFlag = $row['completed'];
  
			$time = array('id' => $id,'time' =>$timesDb, 'flag' => $controlFlag);
			array_push($times, $time);
		}

    	$response = array('times' => $todos, 'type' => 'insert');

    	echo json_encode($response);
	}

?>