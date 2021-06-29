<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

interface RESTfulInterface{
    public function restGet($params);
    public function restPut($params);
    public function restPost($params);
    public function restDelete($params);
}
?>