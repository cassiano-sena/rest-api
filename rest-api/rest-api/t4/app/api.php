<?php
    // vai acessar as funcoes criadas em rest
    class Api extends Rest{
        // forma para conectar na db
        public $dbConn;
        public function __construct(){
            parent::__construct();
            $db=new DbConnect;
            $this->dbConn=$db->connect();
        }
        // aqui gera um token
        public function generateToken(){
            // validar usuario e senha
            $user=$this->validateParameters('email',$this->param['email'],STRING);
            $pass=$this->validateParameters('senha',$this->param['senha'],STRING);
            try{
                $stmt=$this->dbConn->prepare("SELECT * FROM tab_usuarios WHERE email=:email AND senha=:senha");
                $stmt->bindParam(":email",$user);
                $stmt->bindParam(":senha",$pass);
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
                // valido por 15m
                $payload=[
                    'iat'=>time(),
                    'iss'=>'localhost',
                    'exp'=>time()+(15*60),
                    'userId'=>$user['id']
                ];
                $token=JWT::encode($payload, SECRET_KEY);
                $data=['token'=>$token];
                $this->returnResponse(SUCCESS_RESPONSE,$data);
            }catch(Exception $e){
                $this->throwError(JWT_PROCESSING_ERROR,$e->getMessage());
            }
        }
        // adicionar um usuario
        public function addUsuario(){
            $nome=$this->validateParameters('nome',$this->param['nome'],STRING,false);
            $email=$this->validateParameters('email',$this->param['email'],STRING,false);
            $telefone=$this->validateParameters('telefone',$this->param['telefone'],STRING,false);
            $senha=$this->validateParameters('senha',$this->param['senha'],STRING,false);
            try{
                //precisa de token, chave secreta e o algoritmo(hs256)
                //esta funcionando!
                $token=$this->getBearerToken();
                $payload=JWT::decode($token,SECRET_KEY,['HS256']);
                $stmt=$this->dbConn->prepare("SELECT * FROM tab_usuarios WHERE id = :userId");
                $stmt->bindParam(":userId",$payload->id);
                $stmt->execute();
                $user=$stmt->fetch(PDO::FETCH_ASSOC);
                // cai nesse laço
                if(!is_array($user)){
                    $this->returnResponse(INVALID_USER_PASS, "This user was not found in database.");
                }
                if($user['status']!=='A'){
                    $this->returnResponse(LIMITED_USER_ACCESS, "This user access is limited. Please contact support for further information.");
                }
                $usuario=new Usuario;
                $usuario->setNome($nome);
                $usuario->setEmail($email);
                $usuario->setTelefone($telefone);
                $usuario->setSenha($senha);
                $usuario->setCreatedOn(date('Y-m-d'));
                if($usuario->insert()){
                    $message='Failed to insert.';
                }else{
                    $message="Inserted successfully.";                
                }
                $this->returnResponse(SUCCESS_RESPONSE,$message);
            }catch(Exception $e){
                $this->throwError(ACCESS_TOKEN_ERROR,$e->getMessage());
            }
        }
    }
