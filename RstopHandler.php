<?php
require_once 'RESTfulInterface.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

class RstopHandler implements RESTfulInterface{
    public function restGet($params){
        $conn = mysqli_connect("localhost","root","","atwd");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $Stopname = $params[0];

        $sql = "SELECT * FROM rstop WHERE STOP_NAMEC LIKE '%".$Stopname."%'";
        // $stop = array();
        $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        if ($rs->num_rows > 0) {
            $rstop = array();
            // $resultArray = array();
            // output data of each row
            while($row = $rs->fetch_assoc()) {
                $rstop['route'] = $row['ROUTE_ID'];
                
                $rstop['go'] = $row['ROUTE_SEQ'];
                $rstop['back'] = $row['STOP_SEQ'];
                $rstop['stoppoint'] = urlencode($row['STOP_NAMEC']);

                // $rstop['ROUTE_ID'] = $row['ROUTE_ID'];
                // $rstop['ROUTE_SEQ'] = $row['ROUTE_SEQ'];
                // $rstop['STOP_SEQ'] = $row['STOP_SEQ'];
                // $rstop['STOP_NAMEC'] = urlencode($row['STOP_NAMEC']);
                // $rstop['STOP_NAMES'] = urlencode($row['STOP_NAMES']);
                // $rstop['STOP_NAMEE'] = urlencode($row['STOP_NAMEE']);

                // $rstop['STOP_NAMES'] = urlencode($row['STOP_NAMES']);
                // $rstop['STOP_NAMEE'] = urlencode($row['STOP_NAMEE']);
                $resultArray[] = $rstop;
            }
            $urldecode = json_encode($resultArray);
            echo urldecode($urldecode);
          } else {
            $error = array(
              "ErrorNumber" => 408,
              "ErrorDetail" => "Wrong Input Type"
            );
            $resultArray[] = $error;
            echo json_encode($resultArray);
          }    
          mysqli_close($conn);
    }


    public function restPut($params){echo'rstopHandler:restPut';}
    public function restPost($params){echo'rstopHandler:restPost';}
    public function restDelete($params){echo'rstopHandler:restDelete';}
}

?>