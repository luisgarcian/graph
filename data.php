<?php
$myServer = "ZTSISPC03-PC\SQLEXPRESS";
$myUser   = "";
$myPass   = "";
$myDB     = "Sirco"; 

$ConnectionInfo = array( "Database"=>$myDB, "UID"=>$myUser, "PWD"=>$myPass);

//establishing the connection to the db.
$conn = sqlsrv_connect( $myServer, $ConnectionInfo);
//checking if there were any error during the last connection attempt
if  ($conn == false) {
  //echo "Connection established.<br /> ";
//} else {
  echo "Connection could not be established.<br />";
  die( print_r(sqlsrv_errors(), true));
}

//initialize the array to store the processed data
$jsonArray = array();

//the SQL query to be executed
$query = "SELECT * FROM topventas";

//storing the result of the executed query
$result = sqlsrv_query($conn, $query);

//$result->restore_include_path
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
