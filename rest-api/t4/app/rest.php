<?php
require_once('constants.php');
    class Rest {
        protected $request;
        protected $serviceName;
        protected $param;
        public function __construct(){
            /**
            * APENAS POSSIBILITA 'POST', COMENTAR ABAIXO CASO NECESSARIO
            */
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                $this->throwError(REQUEST_METHOD_NOT_VALID, 'Request method is not valid.');
            }
            $handler = fopen('php://input', 'r');
            $this->request = stream_get_contents($handler);
            $this->validateRequest();
        }
        public function validateRequest(){
            // se conteudo nao e json, erro
            if($_SERVER['CONTENT_TYPE'] !== 'application/json'){
                $this->throwError(REQUEST_CONTENTTYPE_NOT_VALID, 'Request content type is not valid');
            }
            $data = json_decode($this->request, true);

            // se api sem nome, erro
            if(!isset($data['name']) || $data['name'] == ""){
                $this->throwError(API_NAME_REQUIRED, "API name required.");
            }
            $this->serviceName=$data['name'];

            // se sem parametro, erro
            if(!is_array($data['param'])){
                $this->throwError(API_PARAM_REQUIRED, "API PARAM is required.");
            }
            $this->param=$data['param'];
        }
        public function processApi(){
            $api=new Api;
            $rMethod=new reflectionMethod('API',$this->serviceName);
            if(!method_exists($api,$this->serviceName)){
                $this->throwError(API_DOES_NOT_EXIST,"API does not exist.");
            }
            $rMethod->invoke($api);
        }
        public function validateParameters($fieldName,$value,$dataType,$required=true){
            if($required==true && empty($value)==true){
                $this->throwError(VALIDATE_PARAMETER_REQUIRED,$fieldName." Parameter is required");
            }
            switch($dataType){
                // se nao boolean, erro
                case BOOLEAN:
                    if(!is_bool($value)){
                        $this->throwError(VALIDATE_PARAMETER_DATATYPE,"Datatype is not valid for ".$fieldName.". It should be boolean.");
                    }
                    break;
                // se nao integer, erro
                case INTEGER:
                    if(!is_numeric($value)){
                        $this->throwError(VALIDATE_PARAMETER_DATATYPE,"Datatype is not valid for ".$fieldName.". It should be numeric.");
                    }
                    break;
                // se nao string, erro
                case STRING:
                    if(!is_string($value)){
                        $this->throwError(VALIDATE_PARAMETER_DATATYPE,"Datatype is not valid for ".$fieldName.". It should be string.");
                    }
                    break;
                // erro padrao
                default:
                    $this->throwError(VALIDATE_PARAMETER_DATATYPE,"Datatype is not valid for ".$fieldName);
                    break;
            }
            return $value;
        }
        public function throwError($code,$message){
            header("content-type: application/json");
            $errorMsg = json_encode(['error'=>['status'=>$code, 'message'=>$message]]);
            echo $errorMsg; exit;
        }
        public function returnResponse($code,$data){
            header("content-type: application/json");
            $response=json_encode(['response'=>['status'=>$code,"result"=>$data]]);
            echo $response; exit;
        }
    }