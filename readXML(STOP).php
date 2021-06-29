<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

$conn = mysqli_connect("localhost","root","","atwd")or die(mysqli_connect_error());
$affectedRow = 0;

$domTree = new DOMDocument();
$domTree->load('STOP_BUS.xml');

$STOPArray = $domTree->getElementsByTagName ("STOP");

$sql = "CREATE TABLE stop (
    STOP_ID INT(10) NULL,
    STOP_TYPE INT(4) NULL,
    X INT(7) NULL,
    Y INT(7) NULL,
    LAST_UPDATE_DATE VARCHAR(20) NULL
)";

if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

foreach ($STOPArray as $r) {
    $STOPArray = $r->getElementsByTagName("STOP_ID");
    $STOPNode = $STOPArray->item(0);
    $STOPValue = $STOPNode->nodeValue;

    $STOP_TYPEArray = $r->getElementsByTagName("STOP_TYPE");
    $STOP_TYPENode = $STOP_TYPEArray->item(0);
    $STOP_TYPEValue = $STOP_TYPENode->nodeValue;

    $XArray = $r->getElementsByTagName("X");
    $XNode = $XArray->item(0);
    $XValue = $XNode->nodeValue;

    $YArray = $r->getElementsByTagName("Y");
    $YNode = $YArray->item(0);
    $YValue = $YNode->nodeValue;

    $LAST_UPDATE_DATEArray = $r->getElementsByTagName("LAST_UPDATE_DATE");
    $LAST_UPDATE_DATENode = $LAST_UPDATE_DATEArray->item(0);
    $LAST_UPDATE_DATEValue = $LAST_UPDATE_DATENode->nodeValue;

    $sql = "INSERT INTO stop (STOP_ID, STOP_TYPE, X, Y, LAST_UPDATE_DATE)VALUES ('$STOPValue','$STOP_TYPEValue','$XValue','$YValue','$LAST_UPDATE_DATEValue')";
    $rs = mysqli_query($conn,$sql);
    // $answerArray[] = $STOP; //push into array

}
mysqli_close($conn);
// echo json_encode($answerArray);
?>