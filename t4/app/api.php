<?php
    // vai acessar as funcoes criadas em rest
    class Api extends Rest{
        public $dbConn;
        public function __construct(){
            parent::__construct();
            $db=new DbConnect;
            $this->dbConn=$db->connect();
        }
        public function generateToken(){
            // validar usuario e senha
            $user=$this->validateParameters('user',$this->param['email'],STRING);
            $pass=$this->validateParameters('pass',$this->param['pass'],STRING);
            try{
                $stmt=$this->dbConn->prepare("SELECT * FROM tab_usuarios WHERE email=:email AND senha=:pass");
                $stmt->bindParam(":email",$user);
                $stmt->bindParam(":pass",$pass);
                $stmt->execute();
                $user=$stmt->fetch(PDO::FETCH_ASSOC);
                if(!is_array($user)){
                    $this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
                }
                if($user['ativo']==1){
                    $this->returnResponse(USER_IS_ACTIVE, "User is already active in the system.");
                }
                if($user['status']!=='A'){
                    $this->returnResponse(LIMITED_USER_ACCESS, "User access is limited. Please contact support for further information.");
                }
                // valido por 60s
                $payload=[
                    'iat'=>time(),
                    'iss'=>'localhost',
                    'exp'=>time()+(60),
                    'userId'=>$user['id']
                ];
                $token=JWT::encode($payload, SECRET_KEY);
                $data=['token'=>$token];
                $this->returnResponse(SUCCESS_RESPONSE, $data);
            }catch(Exception $e){
                $this->throwError(JWT_PROCESSING_ERROR,$e->getMessage());
            }
        }
    }