<?php
    // vai acessar as funcoes criadas em rest
    class Api extends Rest{
        public $dbConn;
        public function __construct(){
            parent::__construct();
            $db=new DbConnect;
            $this->dbConn=$db->connect();
        }
        // aqui gera um token
        public function generateToken(){
            // validar usuario e senha
            $email=$this->validateParameters('email',$this->param['email'],STRING);
            $pass=$this->validateParameters('pass',$this->param['pass'],STRING);
            try{
                $stmt=$this->dbConn->prepare("SELECT * FROM tab_usuarios WHERE email=:email AND senha=:pass");
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":pass",$pass);
                $stmt->execute();
                $email=$stmt->fetch(PDO::FETCH_ASSOC);
                if(!is_array($email)){
                    $this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
                }
                if($email['ativo']==1){
                    $this->returnResponse(USER_IS_ACTIVE, "User is already active in the system.");
                }
                if($email['status']!=='A'){
                    $this->returnResponse(LIMITED_USER_ACCESS, "User access is limited. Please contact support for further information.");
                }
                // valido por 60s
                $payload=[
                    'iat'=>time(),
                    'iss'=>'localhost',
                    'exp'=>time()+(60),
                    'userId'=>$email['id']
                ];
                $token=JWT::encode($payload, SECRET_KEY);
                $data=['token'=>$token];
                $this->returnResponse(SUCCESS_RESPONSE, $data);
            }catch(Exception $e){
                $this->throwError(JWT_PROCESSING_ERROR,$e->getMessage());
            }
        }
        // adicionar um usuario
        public function addUsuario(){
            $nome=$this->validateParameters('nome',$this->param['nome'],STRING,false);
            $email=$this->validateParameters('email',$this->param['email'],STRING,false);
            $telefone=$this->validateParameters('telefone',$this->param['telefone'],STRING,false);
            try{
                //precisa de token, chave secreta e o algoritmo
                //talvez nao esteja executando a funcao getbearertoken
                //echo $token=$this->getBearerToken();
                $token=$this->getBearerToken();
                $payload=JWT::decode($token,SECRET_KEY,['HS256']);
                print_r($payload);
            }catch(Exception $e){
                $this->throwError(ACCESS_TOKEN_ERROR,$e->getMessage());
            }
        }
    }
