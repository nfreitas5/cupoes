<?php

function connectbd($servername, $username, $password, $database){

	$conn = new mysqli($servername, $username, $password, $database);
	if ($conn->connect_error){
	  die ("Connection failed: " . $conn->connect_error);
	}

	return $conn;
}

function getallcupoes($conn) {
	$sql = "SELECT * from cupao";
	$result = $conn->query($sql);

	if($result->num_rows > 0 ) {
		while($row = $result->fetch_assoc()) {
			$cupoes_existentes[]=$row["code"];
		}
	}

	return $cupoes_existentes;
}

function checkcupao ($cupao) {
	/* verificar directamente na BD se cupao existe*/
	$sql = "SELECT * from cupao where code='".mysql_escape_string($cupao)."'";
	$result = $conn->query($sql);


	if($result->num_rows > 0 ) {
		return 0; /*já existe o cupão*/
	} else {
		return 1; /*não existe o cupao*/
	}

}

function insertcupao ($conn,$cupao) {
	$sql = "INSERT INTO cupao (id, code) VALUES (NULL,'".mysql_escape_string($cupao)."')";
    if( $conn->query($sql) === TRUE) {
		echo "<br>New record created successfully<br>";
		return 0;
	} else {
		echo "<br>Error: " . $sql . "<br>" . $conn->error ."<br>";
		return 1;
	} 
}

function closebd ($conn) {
	$conn->close();
	return 0;
}

?>