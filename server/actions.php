<?php 
	
	header('Content-Type: text/json');
	require_once("config.php");
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
		if (isset($_POST['text'])) {
			$text = $_POST['text'];
		} else {
			echo "you didn't specify a text";
			return;
		}

	}

?>