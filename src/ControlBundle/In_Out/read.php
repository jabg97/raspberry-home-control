<?php
require("Mail.php");

$server     = 'localhost'; //servidor
$username   = 'home'; //usuario de la base de datos
$password   = '2022Home*'; //password del usuario de la base de datos
$database   = 'home'; //nombre de la base de datos
 

$conexion = new MySQLi();
@$conexion->connect($server, $username, $password, $database);
//new Mail("test");
if ($conexion->connect_error) 
{
    die('Error de conexión: ' . $conexion->connect_error); 
}
 
$sql="SELECT * FROM dispositivos WHERE tipo = 2";
 
$result = $conexion->query($sql);
 
if ($result->num_rows > 0) 
{
	$i = 0;
	$actual = array();
    while ($row = $result->fetch_array()) 
    {
		 $comando = "gpio mode ".$row['log']." in";
        exec($comando); 
        $comando = "gpio read ".$row['log'];
        exec($comando,$actual);
echo "\nPin ".$row['pin'].") ".$row['nombre']." (".$actual[$i].")";

if($actual[$i++] == 1){
	 new Mail($row['nombre']);
	echo "\nPin ".$row['pin']." Activado (".$row['nombre'].")";
	
	$comando = "gpio mode ".$row['log']." out";
        exec($comando);        
        $comando = "gpio write ".$row['log']." 1";
        exec($comando); 
	 }
    }
}
else
{
    echo "No hay dispositivos de entrada";
}
$conexion->close();

?>			
