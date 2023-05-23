<?php
require_once('constants.php');
    class Rest {
        protected $request;
        protected $serviceName;
        protected $param;
        public function __construct(){
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                $this->throwError(REQUEST_METHOD_NOT_VALID, 'Request method is not valid.');
            }
            $handler = fopen('php://input', 'r');
            $this->$request = stream_get_contents($handler);
            $this->validateRequest($this->request);
        }
        public function validateRequest($request){
            // se conteudo nao e json, erro
            if($_SERVER['CONTENT_TYPE'] !== 'application/json'){
                $this->throwError(REQUEST_CONTENTTYPE_NOT_VALID, 'Request content type is not valid');
            }
            $data = json_decode($request);
        }
        public function processApi(){

        }
        public function validateParameters($fieldName,$value,$dataType,$required){

        }
        public function throwError($code,$message){
            header("content-type: application/json");
            $errorMsg = json_encode(['error'=>['status'=>$code, 'message'=>$message]]);
            echo $errorMsg; exit;
        }
        public function returnRestponse(){

        }
    }