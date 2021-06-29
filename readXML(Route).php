<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

$conn = mysqli_connect("localhost","root","","atwd")or die(mysqli_connect_error());
$affectedRow = 0;

$domTree = new DOMDocument();
$domTree->load('ROUTE_BUS.xml');

$routeArray = $domTree->getElementsByTagName ("ROUTE");

$sql = "CREATE TABLE IF NOT EXISTS route (
    ROUTE_ID INT(7) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    COMPANY_CODE VARCHAR(15) NULL,
    ROUTE_NAMEC VARCHAR(10)  NULL,
    ROUTE_NAMES VARCHAR(10) NULL,
    ROUTE_NAMEE VARCHAR(10) NULL,
    ROUTE_TYPE INT(7) NULL,
    SERVICE_MODE VARCHAR(7) NULL,
    SPECIAL_TYPE INT(7) NULL,
    JOURNEY_TIME INT(7) NULL,
    LOC_START_NAMEC VARCHAR(20) NULL,
    LOC_START_NAMES VARCHAR(20) NULL,
    LOC_START_NAMEE VARCHAR(100) NULL,
    LOC_END_NAMEC VARCHAR(20) NULL,
    LOC_END_NAMES VARCHAR(20) NULL,
    LOC_END_NAMEE VARCHAR(100) NULL,
    HYPERLINK_C VARCHAR(255) NULL,
    HYPERLINK_S VARCHAR(255) NULL,
    HYPERLINK_E VARCHAR(255) NULL,
    FULL_FARE DOUBLE NULL,
    LAST_UPDATE_DATE VARCHAR(25) NULL
)";

if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

foreach ($routeArray as $r) {
    $routeIDArray = $r->getElementsByTagName("ROUTE_ID");
    $routeIDNode = $routeIDArray->item(0);
    $routeIDValue = $routeIDNode->nodeValue;

    $companyArray = $r->getElementsByTagName("COMPANY_CODE");
    $companyNode = $companyArray->item(0);
    $companyValue = $companyNode->nodeValue;

    $rnamecArray = $r->getElementsByTagName("ROUTE_NAMEC");
    $rnamecNode = $rnamecArray->item(0);
    $rnamecValue = $rnamecNode->nodeValue;

    $rnamesArray = $r->getElementsByTagName("ROUTE_NAMES");
    $rnamesNode = $rnamesArray->item(0);
    $rnamesValue = $rnamesNode->nodeValue;

    $rnameeArray = $r->getElementsByTagName("ROUTE_NAMEE");
    $rnameeNode = $rnameeArray->item(0);
    $rnameeValue = $rnameeNode->nodeValue;

    $routetypeArray = $r->getElementsByTagName("ROUTE_TYPE");
    $routetypeNode = $routetypeArray->item(0);
    $routetypealue = $routetypeNode->nodeValue;

    $smodeArray = $r->getElementsByTagName("SERVICE_MODE");
    $smodeNode = $smodeArray->item(0);
    $smodeValue = $smodeNode->nodeValue;

    $stypeArray = $r->getElementsByTagName("SPECIAL_TYPE");
    $stypeNode = $stypeArray->item(0);
    $stypeValue = $stypeNode->nodeValue;

    $jtimeArray = $r->getElementsByTagName("JOURNEY_TIME");
    $jtimeNode = $jtimeArray->item(0);
    $jtimeValue = $jtimeNode->nodeValue;

    $locstartnamecArray = $r->getElementsByTagName("LOC_START_NAMEC");
    $locstartnamecNode = $locstartnamecArray->item(0);
    $locstartnamecValue = $locstartnamecNode->nodeValue;

    $locstartnamesArray = $r->getElementsByTagName("LOC_START_NAMES");
    $locstartnamesNode = $locstartnamesArray->item(0);
    $locstartnamesValue = $locstartnamesNode->nodeValue;

    $locstartnameeArray = $r->getElementsByTagName("LOC_START_NAMEE");
    $locstartnameeNode = $locstartnameeArray->item(0);
    $locstartnameeValue = $locstartnameeNode->nodeValue;

    $locendnamecArray = $r->getElementsByTagName("LOC_END_NAMEC");
    $locendnamecNode = $locendnamecArray->item(0);
    $locendnamecValue = $locendnamecNode->nodeValue;

    $locendnamesArray = $r->getElementsByTagName("LOC_END_NAMES");
    $locendnamesNode = $locendnamesArray->item(0);
    $locendnamesValue = $locendnamesNode->nodeValue;
    
    $locendnameeArray = $r->getElementsByTagName("LOC_END_NAMEE");
    $locendnameeNode = $locendnameeArray->item(0);
    $locendnameeValue = $locendnameeNode->nodeValue;

    $hyperlinkcArray = $r->getElementsByTagName("HYPERLINK_C");
    $hyperlinkcNode = $hyperlinkcArray->item(0);
    $hyperlinkcValue = $hyperlinkcNode->nodeValue;
    
    $hyperlinksArray = $r->getElementsByTagName("HYPERLINK_S");
    $hyperlinksNode = $hyperlinksArray->item(0);
    $hyperlinksValue = $hyperlinksNode->nodeValue;
    
    $hyperlinkeArray = $r->getElementsByTagName("HYPERLINK_E");
    $hyperlinkeNode = $hyperlinkeArray->item(0);
    $hyperlinkeValue = $hyperlinkeNode->nodeValue;
    
    $fullfareArray = $r->getElementsByTagName("FULL_FARE");
    $fullfareNode = $fullfareArray->item(0);
    $fullfareValue = $fullfareNode->nodeValue;

    $lastupdatedateArray = $r->getElementsByTagName("LAST_UPDATE_DATE");
    $lastupdatedateNode = $lastupdatedateArray->item(0);
    $lastupdatedateValue = $lastupdatedateNode->nodeValue;

    $sql = "INSERT INTO route (
    ROUTE_ID, 
    COMPANY_CODE, 
    ROUTE_NAMEC, 
    ROUTE_NAMES,
    ROUTE_NAMEE, 
    ROUTE_TYPE, 
    SERVICE_MODE, 
    SPECIAL_TYPE, 
    JOURNEY_TIME, 
    LOC_START_NAMEC, 
    LOC_START_NAMES, 
    LOC_START_NAMEE, 
    LOC_END_NAMEC, 
    LOC_END_NAMES, 
    LOC_END_NAMEE, 
    HYPERLINK_C, 
    HYPERLINK_S, 
    HYPERLINK_E, 
    FULL_FARE,
    LAST_UPDATE_DATE)  
    VALUES (
      '".$routeIDValue."',
      '".$companyValue."',
      '".$rnamecValue."',
      '".$rnamesValue."',
      '".$rnameeValue."',
      '".$routetypealue."',
      '".$smodeValue."',
      '".$stypeValue."',
      '".$jtimeValue."',
      '".$locstartnamecValue."',
      '".$locstartnamesValue."',
      '".$locstartnameeValue."',
      '".$locendnamecValue."',
      '".$locendnamesValue."',
      '".$locendnameeValue."',
      '".$hyperlinkcValue."',
      '".$hyperlinksValue."',
      '".$hyperlinkeValue."',
      '".$fullfareValue."',
      '".$lastupdatedateValue."')";

    $rs = mysqli_query($conn,$sql);

    if(! empty($rs)){
      $affectedRow ++;
    } else {
      $error_message = mysqli_error($conn) . "\n";
    }
}

mysqli_close($conn);

?>