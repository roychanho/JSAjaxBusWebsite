<?php
require_once 'RESTfulInterface.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

class RouteHandler implements RESTfulInterface{
    
    public function restGet($params){
        $conn = mysqli_connect("localhost","root","","atwd");

        if (!$conn) {
            die("502, Connection failed: " . mysqli_connect_error());
        }

        $Bus = $params[0];
        $SEQ = $params[1];

        $sql = "SELECT * FROM route where ROUTE_NAMEC = '".$Bus."'";
        
        $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($rs->num_rows > 0) {
            $route = array();
            // output data of each row
            while($row = $rs->fetch_assoc()) {
                $route['route'] = $row['ROUTE_ID'];
                $route['company'] = $row['COMPANY_CODE'];
                $route['Bus'] = $row['ROUTE_NAMEC'];
                $route['StartCN'] = urlencode($row['LOC_START_NAMEC']);
                $route['StartENG'] = $row['LOC_START_NAMEE'];
                $route['EndCN'] = urlencode($row['LOC_END_NAMEC']);
                $route['EndENG'] = $row['LOC_END_NAMEE'];
                $route['Fullpay'] = $row['FULL_FARE'];
            }
            // $resultArray[] = $route;
            // echo json_encode($resultArray);

          } else {
            $error =array(
                "ErrorNumber" => 404,
                "ErrorDetail" => "0 result"
            );
             echo json_encode($error);
            // $resultArray[] = $error;
            // echo json_encode($resultArray);
          }
    // mysqli_close($conn);

        if(isset($route['route'])){
            $sql = "select * from rstop where ROUTE_ID = ".$route['route']." AND ROUTE_SEQ = $SEQ ORDER BY STOP_SEQ ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            if ($rs->num_rows > 0) {
                // $route = array();
                
                while($row = $rs->fetch_assoc()) {
                    $route[] = urlencode($row['STOP_NAMEC']);
                    $route[] = $row['STOP_NAMEE'];
                    // $resultArray[] = $route;
                }
                    // $resultArray[] = $route;
                    // echo urldecode (json_encode($resultArray));
                    echo urldecode (json_encode($route));
            } else {
                $error = array(
                    "ErrorNumber" => 405,
                    "ErrorDetail" => "0 result"
                );
                // $resultArray[] = $error;
                // echo json_encode($resultArray);
                 echo json_encode($error);
            }   
        }

    mysqli_close($conn);
    }
    // ------------------------------------------------------------------Put function ---------------------------------------------------------------------------------
     public function restPut($params){
        $putData = file_get_contents("php://input");
        $request = json_decode($putData);

        // $Bus = $request->routeNumber;
        // $NewBus = $request->newrouteNumber;
        // $LSNC = $request->startPointCN;
        // $LSNE = $request->startPointEN;
        // $LENC = $request->endPointCN;
        // $LENE = $request->endPointEN;

        $Bus = $params[0];
        $NewBus = $params[1];
        $LSNC = $params[2];
        $LSNE = $params[3];
        $LENC = $params[4];
        $LENE = $params[5];

        $conn = mysqli_connect("localhost","root","","atwd");

        if (!$conn) {
            die("502, Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE route SET ROUTE_NAMEC = '$NewBus', LOC_START_NAMEC = '$LSNC', 
        LOC_START_NAMEE = '$LSNE', LOC_END_NAMEC = '$LENC', LOC_END_NAMEE = '$LENE' 
        WHERE ROUTE_NAMEC = '$Bus'";
        
        if(mysqli_query($conn, $sql)){
            // $last_id = $conn->insert_id;
            $success = array(
                "Success" => "BusRoute updated:".$NewBus."-".$LSNC."-".$LSNE."-".$LENC."-".$LENE
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
        
        // $Bus = $request->routeNumber;
        // $LSNC = $request->startPointCN;
        // $LSNE = $request->startPointEN;
        // $LENC = $request->endPointCN;
        // $LENE = $request->endPointEN;
        // $STNC = $request->stopCN;
        // $STNE = $request->stopEN;
        // $StopCN = explode(":",$STNC);
        // $StopEN = explode(":",$STNE);

        $Bus = $params[0];
        $LSNC = $params[1];
        $LSNE = $params[2];
        $LENC = $params[3];
        $LENE = $params[4];
        $STNC = explode(":",$params[5]);
        $STNE = explode(":",$params[6]);

        $conn = mysqli_connect("localhost","root","","atwd");   
        if (!$conn) {
            die("502, Connection failed: " . mysqli_connect_error());
        }
    
        $sql = "INSERT INTO route (ROUTE_NAMEC,LOC_START_NAMEC,LOC_START_NAMEE,LOC_END_NAMEC,LOC_END_NAMEE)
        VALUES ('".$Bus."','".$LSNC."','".$LSNE."','".$LENC."','".$LENE."')";
    
        if(mysqli_query($conn, $sql)){
            $last_id = $conn->insert_id;
            $success = array(
                "Success" => "BusRoute Table created".$last_id
            );
            $resultArray[] = $success;
            // echo json_encode($resultArray);
        }else{
            $error =array(
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
                // while($i<count($StopCN)){
                while($i<count($STNC)){
                    $num = $i+1;
                    // $sql = "INSERT INTO rstop (ROUTE_ID, ROUTE_SEQ, STOP_SEQ, STOP_NAMEC, STOP_NAMEE) 
                    // VALUES ($last_id, 1 , $num ,'".$StopCN[$i]."','".$StopEN[$i]."')";
                    
                     $sql = "INSERT INTO rstop (ROUTE_ID, ROUTE_SEQ, STOP_SEQ, STOP_NAMEC, STOP_NAMEE) 
                     VALUES ($last_id, 1 , $num ,'".$STNC[$i]."','".$STNE[$i]."')";

                    if(mysqli_query($conn, $sql)){
                        $success = array(
                            "Success" => "BusRoute Table created and BusStop created"
                        );
                        $resultArray[] = $success;
                        // echo json_encode($resultArray);
                    }else{
                        $error =array(
                            "ErrorNumber" => 501,
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
                "ErrorNumber" => 503,
                "ErrorDetail" => "Can't Deleted Rstop"
            );
            $resultArray[] = $error;
            echo json_encode($resultArray);
        }
        mysqli_close($conn);
    }
}
?>