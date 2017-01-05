<?php
require 'bdfunctions.php';


$servername="localhost";
$username="nuno";
$password="5B4WA5ae9KAVNCm7";
$database="cupoes";

$conn = connectbd($servername, $username, $password, $database);

$existing_cupons = array();

$existing_cupons = getallcupons($conn);

//echo print_r($existing_cupons);

//range de valores decimais dos caracteres ascci imprimiveis
$range_start = 33;
$range_end = 127;

//cupão e tanhamo
$random_code = "";
$random_code_length = 6;

//array com o valor decimal dos caracteres ascii imprimiveis excluidos
$bad_ascii= array (48,49,79,108);
$attempts = 0;

do {
	for($i=0;$i < $random_code_length; $i++)
	{
		do{
			$ascii_no = round( mt_rand( $range_start, $range_end ) );
		} while (in_array($ascii_no, $bad_ascii));
		
		$random_code .= chr ( $ascii_no);
	}
	
	$attempts++;

	/*descomentar para testar codigo de cupão repetido, ciclo acaba quando o numero de tentativas é maior que a quantidade de cupões já existentes
	para ser necessário terminar desta forma, o gerador teria de criar 1 cupão já existente em cada ciclo*/
	//$random_code=",:zi*>";
}	
while (in_array($random_code, $existing_cupons) && $attempts <= count($existing_cupons));

//echo "<br>Attempts = ".$attempts."<br>";
echo "<br>Novo cupão - ".$random_code."<br>";

if (insertcupon ($conn,$random_code) == 1)
{
	echo "Erro ao guardar cupão<br>";
}

closebd($conn);

?>