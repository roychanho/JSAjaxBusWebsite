<?php
require_once 'RESTfulInterface.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

class RoutesHandler implements RESTfulInterface{
    
    public function restGet($params){
        // set_error_handler("customError");

        $conn = mysqli_connect("localhost","root","","atwd");

        if (!$conn) {
            die("502, Connection failed: " . mysqli_connect_error());
        }

        $search = $params[0];
        $searchKey = $params[1];

        if(strcmp($search, "route") == 0){
            $sql = "SELECT * FROM route where ROUTE_NAMEC = '".$searchKey."'";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $resultArray = array();
            if ($rs->num_rows > 0) {
                $route = array();
                // output data of each row
                while($row = $rs->fetch_assoc()) {
                    $route['route'] = $row['ROUTE_ID'];
                    $route['routeNumber'] = $row['ROUTE_NAMEC'];
                    $route['fare'] = $row['FULL_FARE'];   
                    $route['startPoint'] = urlencode($row['LOC_START_NAMEC']);  
                    $route['endPoint'] = urlencode($row['LOC_END_NAMEC']);
                    $resultArray[] = $route;  
                }
                $urldecode = json_encode($resultArray);
                echo urldecode($urldecode);
              } else {
                $error = array(
                    "ErrorNumber" => 404,
                    "ErrorDetail" => "0 result"
                );
                $resultArray[] = $error;
                echo json_encode($resultArray);
              }
            //   $resultArray2[] = $error;
            //   echo json_encode($resultArray2);
            //   $urldecode = json_encode($resultArray);
            //   echo urldecode($urldecode);
        }else if (strcmp($search, "fare") == 0){
            $sql = "SELECT * FROM route where FULL_FARE LIKE '%".$searchKey."%' ORDER BY FULL_FARE ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $resultArray = array();
            if ($rs->num_rows > 0) {
                $route = array();
                // output data of each row
                while($row = $rs->fetch_assoc()) {
                    $route['route'] = $row['ROUTE_ID'];
                    $route['routeNumber'] = $row['ROUTE_NAMEC'];
                    $route['fare'] = $row['FULL_FARE'];   
                    $route['startPoint'] = urlencode($row['LOC_START_NAMEC']);  
                    $route['endPoint'] = urlencode($row['LOC_END_NAMEC']); 
                    $resultArray[] = $route;  
                }
                // $resultArray[] = $route;
                $urldecode = json_encode($resultArray);
                echo urldecode($urldecode);
              } else {
                $error = array(
                    "ErrorNumber" => 405,
                    "ErrorDetail" => "Wrong Input Type"
                );
                $resultArray[] = $error;
                echo json_encode($resultArray);
              }
        }else if (strcmp($search, "startpoint") == 0){
            $sql = "SELECT * FROM route where LOC_START_NAMEC = '".$searchKey."'";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $resultArray = array();
            if ($rs->num_rows > 0) {
                $route = array();
                // output data of each row
                while($row = $rs->fetch_assoc()) {
                    $route['route'] = $row['ROUTE_ID'];
                    $route['routeNumber'] = $row['ROUTE_NAMEC'];
                    $route['fare'] = $row['FULL_FARE'];   
                    $route['startPoint'] = urlencode($row['LOC_START_NAMEC']);  
                    $route['endPoint'] = urlencode($row['LOC_END_NAMEC']);   
                    $resultArray[] = $route;
                }
                // $resultArray[] = $route;
                $urldecode = json_encode($resultArray);
                echo urldecode($urldecode);
              } else {
                $error =array(
                    "ErrorNumber" => 406,
                    "ErrorDetail" => "0 result"
                );
                $resultArray[] = $error;
                echo json_encode($resultArray);
              }
        }else if (strcmp($search, "endpoint") == 0){
            $sql = "SELECT * FROM route where LOC_END_NAMEC = '".$searchKey."'";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $resultArray = array();
            if ($rs->num_rows > 0) {
                $route = array();
                // output data of each row
                while($row = $rs->fetch_assoc()) {
                    $route['route'] = $row['ROUTE_ID'];
                    $route['routeNumber'] = $row['ROUTE_NAMEC'];
                    $route['fare'] = $row['FULL_FARE'];   
                    $route['startPoint'] = urlencode($row['LOC_START_NAMEC']);  
                    $route['endPoint'] = urlencode($row['LOC_END_NAMEC']);   
                    $resultArray[] = $route;
                }
                // $resultArray[] = $route;
                $urldecode = json_encode($resultArray);
                echo urldecode($urldecode);
              } else {
                $error =array(
                    "ErrorNumber" => 407,
                    "ErrorDetail" => "0 result"
                );
                $resultArray[] = $error;
                echo json_encode($resultArray);
              }
        }
        
    mysqli_close($conn);
    }
    // ------------------------------------------------------------------Put function ---------------------------------------------------------------------------------
       public function restPut($params){
        $putData = file_get_contents("php://input");
        $request = json_decode($putData);

        $Bus = $request->routeNumber;
        $NewBus = $request->newrouteNumber;
        $LSNC = $request->startPointCN;
        $LSNE = $request->startPointEN;
        $LENC = $request->endPointCN;
        $LENE = $request->endPointEN;

        $conn = mysqli_connect("localhost","root","","atwd");

        if (!$conn) {
            die("502, Connection failed: " . mysqli_connect_error());
        }

        // $Bus = $params[0];
        // $NewBus = $params[1];
        // $LSNC = $params[2];
        // $LSNE = $params[3];
        // $LENC = $params[4];
        // $LENE = $params[5];

        $sql = "UPDATE route SET ROUTE_NAMEC = '$NewBus', LOC_START_NAMEC = '$LSNC', 
        LOC_START_NAMEE = '$LSNE', LOC_END_NAMEC = '$LENC', LOC_END_NAMEE = '$LENE' 
        WHERE ROUTE_NAMEC = '$Bus'";
        $resultArray = array();
        if(mysqli_query($conn, $sql)){
            // $last_id = $conn->insert_id;
            $success = array(
                "newrouteNumber" => $NewBus,
                "startPointCN" => $LSNC,
                "startPointEN" => $LSNE,
                "endPointCN" => $LENC,
                "endPointEN" => $LENE
            );
            $resultArray[] = $success;
            echo json_encode($resultArray);
        }else{
            $error =array(
                "ErrorNumber" => 500,
                "ErrorDetail" => "BusRoute up date error"
            );
            $resultArray[] = $error;
            echo json_encode($resultArray);
        }
        mysqli_close($conn);

    }
    // ------------------------------------------------------------------Post function----------------------------------------------------------------------------------
     public function restPost($params){
        $postData = file_get_contents("php://input");
        $request = json_decode($postData);
        
        $Bus = $request->routeNumber;
        $LSNC = $request->startPointCN;
        $LSNE = $request->startPointEN;
        $LENC = $request->endPointCN;
        $LENE = $request->endPointEN;
        $STNC = $request->stopCN;
        $STNE = $request->stopEN;

        $StopCN = explode(":",$STNC);
        $StopEN = explode(":",$STNE);

        $conn = mysqli_connect("localhost","root","","atwd");   
        if (!$conn) {
            die("502, Connection failed: " . mysqli_connect_error());
        }
    
        $sql = "INSERT INTO route (ROUTE_NAMEC,LOC_START_NAMEC,LOC_START_NAMEE,LOC_END_NAMEC,LOC_END_NAMEE)
        VALUES ('".$Bus."','".$LSNC."','".$LSNE."','".$LENC."','".$LENE."')";
        $resultArray = array();
        if(mysqli_query($conn, $sql)){
            $last_id = $conn->insert_id;
            // $resultArray = array();
            $success = array(
                "routeNumber" => $Bus,
                "startPointCN" => $LSNC,
                "startPointEN" => $LSNE,
                "endPointCN" => $LENC,
                "endPointEN" => $LENE
            );
            $resultArray[] = $success;
            // echo json_encode($resultArray);
        }else{
            $error = array(
                "ErrorNumber" => 501,
                "ErrorDetail" => "BusRoute Table can't create"
            );
            $resultArray[] = $error;
            echo json_encode($resultArray);
        }
        
        // mysqli_close($conn);

            if(isset($last_id)){
                $conn = mysqli_connect("localhost","root","","atwd");
                $i = 0;
                while($i<count($StopCN)){
                    $num = $i+1;
                    $sql = "INSERT INTO rstop (ROUTE_ID, ROUTE_SEQ, STOP_SEQ, STOP_NAMEC, STOP_NAMEE) 
                    VALUES ($last_id, 1 , $num ,'".$StopCN[$i]."','".$StopEN[$i]."')";
                    // $resultArray = array();
                    if(mysqli_query($conn, $sql)){
                        $success = array(
                            "stopCN" => $StopCN,
                            "stopEN" => $StopEN
                        );
                        $resultArray[] = $success;
                        // echo json_encode($resultArray);
                    }else{
                        $error =array(
                            "ErrorNumber" => 502,
                            "ErrorDetail" => "BusRoute Table can't create"
                        );
                        $resultArray[] = $error;
                        echo json_encode($resultArray);
                    }
                    $i++;
                    
                }
                
                echo json_encode($resultArray);
            }
            mysqli_close($conn);
    }
// ----------------------------------------------------------------------Delete function----------------------------------------------------------------------------------------
     public function restDelete($params){
        $RouteID = $params[0];
        $conn = mysqli_connect("localhost","root","","atwd");
        
        if (!$conn) {
            die("502, Connection failed: " . mysqli_connect_error());
        }

        $sql = "DELETE FROM route WHERE ROUTE_ID = $RouteID";
        $resultArray = array();
        if(mysqli_query($conn, $sql)){
            $success = array(
                "Success" => "Route Deleted:".$RouteID
            );
            $resultArray[] = $success;
        }else{
            $error =array(
                "ErrorNumber" => 503,
                "ErrorDetail" => "Can't Deleted Route"
            );
            $resultArray[] = $error;
            echo json_encode($resultArray);
        }

        $sql = "DELETE FROM rstop WHERE ROUTE_ID = $RouteID";

        if(mysqli_query($conn, $sql)){
            $success = array(
                "Success" => "Rstop Deleted:".$RouteID
            );
            $resultArray[] = $success;
            echo json_encode($resultArray); 
        }else{
            $error =array(
                "ErrorNumber" => 504,
                "ErrorDetail" => "Can't Deleted Rstop"
            );
            $resultArray[] = $error;
            echo json_encode($resultArray);
        }
        mysqli_close($conn);
    }
    
}
?>