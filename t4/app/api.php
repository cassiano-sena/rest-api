<?php
    // vai acessar as funcoes criadas em rest
    class Api extends Rest{
        // forma para conectar na db
        public function __construct(){
            parent::__construct();
        }
        // aqui gera um token
        public function generateToken(){
            // validar usuario e senha
            $user=$this->validateParameter('email',$this->param['email'],STRING);
            $pass=$this->validateParameter('senha',$this->param['senha'],STRING);
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
            $nome=$this->validateParameter('nome',$this->param['nome'],STRING,false);
            $email=$this->validateParameter('email',$this->param['email'],STRING,false);
            $telefone=$this->validateParameter('telefone',$this->param['telefone'],STRING,false);
            $senha=$this->validateParameter('senha',$this->param['senha'],STRING,false);

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
            }$this->returnResponse(SUCCESS_RESPONSE, $message);
        }

        // pegar detalhes do usuario a partir do id
        public function getUsuarioDetails() {
			$usuarioId = $this->validateParameter('id', $this->param['id'], INTEGER);

			$aux = new Usuario;
			$aux->setId($usuarioId);
			$usuario = $aux->getUsuarioById();
			if(!is_array($usuario)) {
				$this->returnResponse(SUCCESS_RESPONSE, ['message' => 'User details not found.']);
			}

			$response['id']=$usuario['id'];
			$response['nome']=$usuario['nome'];
			$response['email']=$usuario['email'];
			$response['telefone']=$usuario['telefone'];
			$response['senha']=$usuario['senha'];
			$response['is_admin']=$usuario['is_admin'];
			$response['is_driver']=$usuario['is_driver'];
			$response['ativo']=$usuario['ativo'];
			$response['status']=$usuario['status'];
			$response['created_on']=$usuario['created_on'];
			$this->returnResponse(SUCCESS_RESPONSE, $response);
		}
        
        // deletar usuario
        public function deleteUsuario() {
			$usuarioId = $this->validateParameter('id', $this->param['id'], INTEGER);
			$user=new Usuario;
			$user->setId($usuarioId);

			if(!$user->delete()) {
				$message='Failed to delete.';
			}else {
				$message="Deleted successfully.";
			}$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

        // adicionar uma rota
        public function addRota(){
            $nomeRota=$this->validateParameter('rota',$this->param['rota'],STRING,false);
            $veiculo=$this->validateParameter('veiculo',$this->param['veiculo'],STRING,false);
            $motorista=$this->validateParameter('motorista',$this->param['motorista'],STRING,false);
            $datas=$this->validateParameter('datas',$this->param['datas'],STRING,false);
            $horarios=$this->validateParameter('horarios',$this->param['horarios'],STRING,false);

            $rota=new Rota;
            $rota->setRota($nomeRota);
            $rota->setVeiculo($veiculo);
            $rota->setMotorista($motorista);
            $rota->setDatas($datas);
            $rota->setHorarios($horarios);
            $rota->setCreatedOn(date('Y-m-d'));
            if($rota->insert()){
                $message='Failed to insert.';
            }else{
                $message="Inserted successfully.";                
            }$this->returnResponse(SUCCESS_RESPONSE, $message);
        }

        // pegar detalhes da rota a partir do id
        public function getRotaDetails() {
			$rotaId = $this->validateParameter('id', $this->param['id'], INTEGER);

			$aux = new Rota;
			$aux->setId($rotaId);
			$rota = $aux->getRotaById();
			if(!is_array($rota)) {
				$this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Route details not found.']);
			}

			$response['id']=$rota['id'];
			$response['rota']=$rota['rota'];
			$response['veiculo']=$rota['veiculo'];
			$response['motorista']=$rota['motorista'];
			$response['datas']=$rota['datas'];
			$response['horarios']=$rota['horarios'];
			$response['status']=$rota['status'];
			$response['created_on']=$rota['created_on'];
			$this->returnResponse(SUCCESS_RESPONSE, $response);
		}

        // deletar uma rota
        public function deleteRota() {
			$rotaId = $this->validateParameter('id', $this->param['id'], INTEGER);
			$rota=new Rota;
			$rota->setId($rotaId);

			if(!$rota->delete()) {
				$message='Failed to delete.';
			}else {
				$message="Deleted successfully.";
			}$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

        // adicionar uma mensagem
        public function addMensagem(){
            $usuario=$this->validateParameter('usuario',$this->param['usuario'],STRING,false);
            $rota=$this->validateParameter('rota',$this->param['rota'],STRING,false);
            //$data=$this->validateParameter('data',$this->param['data'],STRING,false);
            //$hora=$this->validateParameter('hora',$this->param['hora'],STRING,false);
            $descricao=$this->validateParameter('descricao',$this->param['descricao'],STRING,false);
            $status=$this->validateParameter('status',$this->param['status'],STRING,false);

            $mensagem=new Mensagem;
            $mensagem->setUsuario($usuario);
            $mensagem->setRota($rota);
            //$mensagem->setData($data);
            $mensagem->setData(date('Y-m-d'));
            // $mensagem->setHora($hora);
            $mensagem->setHora(date('H:i:s'));
            $mensagem->setDescricao($descricao);
            $mensagem->setStatus($status);
            $mensagem->setCreatedOn(date('Y-m-d'));
            if($mensagem->insert()){
                $message='Failed to insert.';
            }else{
                $message="Inserted successfully.";                
            }$this->returnResponse(SUCCESS_RESPONSE, $message);
        }

        // pegar detalhes de uma mensagem a partir do id
        public function getMensagemDetails() {
			$mensagemId = $this->validateParameter('id', $this->param['id'], INTEGER);

			$aux = new Mensagem;
			$aux->setId($mensagemId);
			$mensagem = $aux->getMensagemById();
			if(!is_array($mensagem)) {
				$this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Message details not found.']);
			}

			$response['id']=$mensagem['id'];
			$response['usuario']=$mensagem['usuario'];
			$response['rota']=$mensagem['rota'];
			$response['data']=$mensagem['data'];
			$response['hora']=$mensagem['hora'];
			$response['descricao']=$mensagem['descricao'];
			$response['status']=$mensagem['status'];
			$response['created_on']=$mensagem['created_on'];
			$this->returnResponse(SUCCESS_RESPONSE, $response);
		}

        // deletar mensagem
        public function deleteMensagem() {
			$mensagemId = $this->validateParameter('id', $this->param['id'], INTEGER);
			$mensagem=new Mensagem;
			$mensagem->setId($mensagemId);

			if(!$mensagem->delete()) {
				$message='Failed to delete.';
			}else {
				$message="Deleted successfully.";
			}$this->returnResponse(SUCCESS_RESPONSE, $message);
		}
    }
