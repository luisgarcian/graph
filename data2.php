<?php
//---------------------------

function &get_conn()
{
   global $conn;
   $myServer = "ZTSISPC03-PC\SQLEXPRESS";
   $myUser   = "";
   $myPass   = "";
   $myDB     = "Sirco"; 
   
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

//$sp_params = array(
//  array(&$myparams['suc'], SQLSRV_PARAM_IN),
//);

//$sql ="{CALL usp_TraerVentas2()} @suc = ?";
$sql ="{CALL usp_TraerVentas2()} ";

//$result = sqlsrv_query($conn, $sql, $sp_params); //ejecuta la query
$result = sqlsrv_query($conn, $sql); //ejecuta la query

//initialize the array to store the processed data
$jsonArray = array();

//check if there is any data returned by the SQL Query
if ($result <> false) {
  //Converting the results into an associative array
  while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
    $jsonArrayItem = array();
    $jsonArrayItem['label'] = $row['vendedor'];
    $jsonArrayItem['value'] = $row['ventas'];
    //append the above created object into the main array.
    array_push($jsonArray, $jsonArrayItem);
  }
}

//Closing the connection to DB
sqlsrv_close($conn);

//set the response content type as JSON
header('Content-type: application/json');
//output the return value of json encode using the echo function. 
echo json_encode($jsonArray);

?>
