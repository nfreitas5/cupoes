<?php

function connectbd($servername, $username, $password, $database){

	$conn = new mysqli($servername, $username, $password, $database);
	if ($conn->connect_error){
	  die ("Connection failed: " . $conn->connect_error);
	}

	return $conn;
}

function getallcupons($conn) {
	$sql = "SELECT * from cupao";
	$result = $conn->query($sql);

	if($result->num_rows > 0 ) {
		while($row = $result->fetch_assoc()) {
			$existing_cupons[]=$row["code"];
		}
	}

	return $existing_cupons;
}

function checkcupon ($code) {
	/* verificar directamente na BD se cupao existe*/
	$sql = "SELECT * from cupao where code='".mysql_escape_string($code)."'";
	$result = $conn->query($sql);


	if($result->num_rows > 0 ) {
		return 0; /*já existe o cupão*/
	} else {
		return 1; /*não existe o cupao*/
	}

}

function insertcupon ($conn,$code) {
	$sql = "INSERT INTO cupao (id, code) VALUES (NULL,'".mysql_escape_string($code)."')";
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