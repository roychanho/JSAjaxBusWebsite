<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

$conn = mysqli_connect("localhost","root","","atwd")or die(mysqli_connect_error());
$affectedRow = 0;

$domTree = new DOMDocument();
$domTree->load('RSTOP_BUS.xml');

$RSTOPArray = $domTree->getElementsByTagName ("RSTOP");

$sql = "CREATE TABLE IF NOT EXISTS rstop (
    ROUTE_ID INT(7) NULL,
    ROUTE_SEQ INT(3) NULL,
    STOP_SEQ INT(3) NULL,
    STOP_ID INT(7) NULL,
    STOP_PICK_DROP INT(3) NULL,
    STOP_NAMEC VARCHAR(20) NULL,
    STOP_NAMES VARCHAR(20) NULL,
    STOP_NAMEE VARCHAR(100) NULL,
    LAST_UPDATE_DATE VARCHAR(25) NULL
)";

if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

foreach ($RSTOPArray as $r) {
    $ROUTE_IDArray = $r->getElementsByTagName("ROUTE_ID");
    $ROUTE_IDNode = $ROUTE_IDArray->item(0);
    $ROUTE_IDValue = $ROUTE_IDNode->nodeValue;

    $ROUTE_SEQArray = $r->getElementsByTagName("ROUTE_SEQ");
    $ROUTE_SEQNode = $ROUTE_SEQArray->item(0);
    $ROUTE_SEQValue = $ROUTE_SEQNode->nodeValue;

    $STOP_SEQArray = $r->getElementsByTagName("STOP_SEQ");
    $STOP_SEQNode = $STOP_SEQArray->item(0);
    $STOP_SEQValue = $STOP_SEQNode->nodeValue;

    $STOP_IDArray = $r->getElementsByTagName("STOP_ID");
    $STOP_IDNode = $STOP_IDArray->item(0);
    $STOP_IDValue = $STOP_IDNode->nodeValue;

    $STOP_PICK_DROPArray = $r->getElementsByTagName("STOP_PICK_DROP");
    $STOP_PICK_DROPNode = $STOP_PICK_DROPArray->item(0);
    $STOP_PICK_DROPValue = $STOP_PICK_DROPNode->nodeValue;

    $STOP_NAMECArray = $r->getElementsByTagName("STOP_NAMEC");
    $STOP_NAMECNode = $STOP_NAMECArray->item(0);
    $STOP_NAMECValue = $STOP_NAMECNode->nodeValue;

    $STOP_NAMESArray = $r->getElementsByTagName("STOP_NAMES");
    $STOP_NAMESNode = $STOP_NAMESArray->item(0);
    $STOP_NAMESValue = $STOP_NAMESNode->nodeValue;

    $STOP_NAMEEArray = $r->getElementsByTagName("STOP_NAMEE");
    $STOP_NAMEENode = $STOP_NAMEEArray->item(0);
    $STOP_NAMEEValue = $STOP_NAMEENode->nodeValue;

    $LAST_UPDATE_DATEArray = $r->getElementsByTagName("LAST_UPDATE_DATE");
    $LAST_UPDATE_DATENode = $LAST_UPDATE_DATEArray->item(0);
    $LAST_UPDATE_DATEValue = $LAST_UPDATE_DATENode->nodeValue;


    $sql = "INSERT INTO rstop (ROUTE_ID, ROUTE_SEQ, STOP_SEQ, STOP_ID, STOP_PICK_DROP, STOP_NAMEC, STOP_NAMES, STOP_NAMEE, LAST_UPDATE_DATE)
    VALUES ('$ROUTE_IDValue','$ROUTE_SEQValue','$STOP_SEQValue','$STOP_IDValue','$STOP_PICK_DROPValue','$STOP_NAMECValue','$STOP_NAMESValue','$STOP_NAMEEValue','$LAST_UPDATE_DATEValue')";
    $rs = mysqli_query($conn,$sql);

    if(! empty($rs)){
      $affectedRow ++;
    } else {
      $error_message = mysqli_error($conn) . "\n";
    }

}
mysqli_close($conn);
// echo json_encode($answerArray);
?>