<?php
//---------------------------

function &get_conn()
{
   global $conn;
   $myServer = "zapateriastorreon.database.windows.net";
   $myUser   = "pappos";
   $myPass   = "SirCo_33";
   $myDB     = "SircoDWH"; 
   
   if(!$conn)
   {

    $ConnectionInfo = array( "Database"=>$myDB, "UID"=>$myUser, "PWD"=>$myPass);
    $conn = sqlsrv_connect( $myServer, $ConnectionInfo)
         or die("Couldn't connect to SQL Server on $myServer");
    if( $conn === false) {
          die( print_r( sqlsrv_errors(), true));
      }   
   }
   return $conn;
}
    
// llamamos a la conexion
$conn =& get_conn();

// se crean los parametros
/*  
$procedure_params = array(
array(&$myparams['Item_ID'], SQLSRV_PARAM_OUT),
array(&$myparams['Item_Name'], SQLSRV_PARAM_OUT)
);
*/
$fecini = '2020-11-01';
$fecfin = '2020-11-30';

$params = array (
  array($fecini, SQLSRV_PARAM_IN),
  array($fecfin, SQLSRV_PARAM_IN)
);

// String para llamar el sp (3 maneras)
//$sql = "EXEC  Db.Owner.SpName @Item_ID = ?, @Item_Name = ?"
//$sql = "{call Db.Owner.SpName (@Item_ID = ?, @Item_Name = ?)} "
//$sql = "{call Db.Owner.SpName(?,?)}";

$sql = "EXEC usp_TraerventasNetas @fechaini = ?, @fechafin = ?"; 

//Preparar la ejecucion
//if ($stmt = sqlsrv_prepare($conn, $sql, $sp_params)) {
if (($stmt = sqlsrv_prepare( $conn, $sql, $params)) === false) {
    echo "Statement could not be prepared.\n";  
    die(print_r(sqlsrv_errors(), true));  
} ;

//initialize the array to store the processed data
$jsonArray = array();

//Ejecutar la preparacion
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
    $jsonArrayItem = array();
    $jsonArrayItem['label'] = $row['descrip'];
    $jsonArrayItem['value'] = $row['venta'];
   // $jsonArrayItem['ctd'] = $row['ctd'];

   //append the above created object into the main array.
    array_push($jsonArray, $jsonArrayItem);
};

//Closing the connection to DB
sqlsrv_close($conn);

//set the response content type as JSON
header('Content-type: application/json');
//output the return value of json encode using the echo function. 
echo json_encode($jsonArray);

?>
