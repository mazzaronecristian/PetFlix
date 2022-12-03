<?php 
	header("Access-Controll-Allow-Origin: null");
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
		case "remove" :
			removeData();
		break;
	}

	function loadData(){
		if (isset($_POST['flag'])) {
			$flag = $_POST['flag'];
		} else {
			echo "you didn't specify a type";
			return;
		}
		$query_string ="SELECT * FROM orari WHERE controlFlag=$flag ORDER BY time ASC";
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE); 

		$result = $mysqli->query($query_string); 
	
    	$times = array();	

    	while($row = $result->fetch_array(MYSQLI_ASSOC)){
    		$row_id = $row['id'];
    		$row_flag = $row['controlFlag'];
    		$row_time = $row['time'];
    	
			$time = array('id' => $row_id,'controlFlag' =>$row_flag, 'time' => $row_time);
			array_push($times, $time);    	
		}

    	$response = array('times' => $times, 'type' => 'insert');

		// encodo l'array in JSON
		echo json_encode($response);
	}

	function insertData(){
		if (isset($_POST['time'])) {
			$time = $_POST['time'];
		} else {
			echo "you didn't specify a text";
			return;
		}	

		$flag = $_POST['flag'];

		$query_string = "SELECT * FROM orari WHERE controlFlag=$flag AND time= '".htmlspecialchars($time)."'";
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE); 
		$result = $mysqli->query($query_string);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
		if($row != null){
			echo "orario già inserito";
			return;
		}

		$query_string = "INSERT INTO orari (controlFlag, time) values ($flag, '". htmlspecialchars($time) ."')";
		$result = $mysqli->query($query_string);

		//ritorno il dato appena inserito per poterlo aggiungere alla schermata del sito e al popup
		$query_string = "SELECT * FROM orari WHERE controlFlag=$flag AND time= '".htmlspecialchars($time)."'";
		$result = $mysqli->query($query_string);  
		
    	$times = array();	

    	while($row = $result->fetch_array(MYSQLI_ASSOC)){
    		$row_id = $row['id'];
    		$row_flag = $row['controlFlag'];
    		$row_time = $row['time'];
    	
			$time = array('id' => $row_id,'controlFlag' =>$row_flag, 'time' => $row_time);
			array_push($times, $time);    	
		}

    	$response = array('times' => $times, 'type' => 'insert');

		// encodo l'array in JSON
		echo json_encode($response);
	}

	function removeData(){
		if(isset($_POST["id"]))
			$id = $_POST["id"];
		else{
			echo "errore, id non specificato";
			return;
		}

		$query_string = "DELETE FROM orari WHERE id=$id";
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE); 
		$result = $mysqli->query($query_string);  

		echo json_encode($response);

	}
?>