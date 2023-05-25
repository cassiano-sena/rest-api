<?php
    class Usuario{
        private $id;
        private $nome;
        private $email;
        private $telefone;
        private $senha;
        private $isAdmin;
        private $isDriver;
        private $isActive;
        private $status;
        private $createdOn;
        private $tableName='tab_usuarios';
        private $dbConn;

        function setId($id){$this->id=$id;}
        function getId(){return $this->id;}
        function setNome($nome){$this->nome=$nome;}
        function getNome(){return $this->nome;}
        function setEmail($email){$this->email=$email;}
        function getEmail(){return $this->email;}
        function setTelefone($telefone){$this->telefone=$telefone;}
        function getTelefone(){return $this->telefone;}
        function setSenha($senha){$this->senha=$senha;}
        function getSenha(){return $this->senha;}
        function setIsAdmin($isAdmin){$this->isAdmin=$isAdmin;}
        function getIsAdmin(){return $this->isAdmin;}
        function setIsDriver($isDriver){$this->isDriver=$isDriver;}
        function getIsDriver(){return $this->isDriver;}
        function setIsActive($isActive){$this->isActive=$isActive;}
        function getIsActive(){return $this->isActive;}
        function setStatus($status){$this->status=$status;}
        function getStatus(){return $this->status;}
        function setCreatedOn($createdOn){$this->createdOn=$createdOn;}
        function getCreatedOn(){return $this->createdOn;}
        function setTableName($tableName){$this->tableName=$tableName;}
        function getTableName(){return $this->tableName;}
        function setDbConn($dbConn){$this->dbConn=$dbConn;}
        function getDbConn(){return $this->dbConn;}

        public function __construct(){
            $db=new DbConnect;
            $this->dbConn=$db->connect();
        }

        // listar todos os usuarios
        public function getAllUsuarios(){
            $stmt=$this->dbConn->prepare("SELECT * FROM ".$this->tableName);
            $stmt->execute();
            $usuarios=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarios;
        }

        // listar um usuario
        public function getUsuarioById(){
            $stmt=$this->dbConn->prepare('SELECT FROM '.$this->tableName.' WHERE id = :id');
            $stmt->bindParam(':id',$this->id);
            $stmt->execute();
            $usuario=$stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario;
        }

        // inserir no banco
        public function insert(){
            $sql='INSERT INTO '.$this->tableName.' (id, nome, email, telefone, senha, is_admin, is_driver, is_active, status, created_on) VALUES(null, :nome, :email, :telefone, :senha, :is_admin, :is_driver, :is_active, :status, :created_on) ';
            $stmt=$this->dbConn->prepare($sql);
            $stmt->bindParam(':nome',$this->nome);
            $stmt->bindParam(':email',$this->email);
            $stmt->bindParam(':telefone',$this->telefone);
            $stmt->bindParam(':senha',$this->senha);
            $stmt->bindParam(':is_admin',$this->isAdmin);
            $stmt->bindParam(':is_driver',$this->isDriver);
            $stmt->bindParam(':is_active',$this->isActive);
            $stmt->bindParam(':status',$this->status);
            $stmt->bindParam(':created_on',$this->createdOn);

            if($stmt->execute()){
                return true;
            }else {
                return false;
            }
        }

        // atualizar no banco
        public function update(){
            getId();
            $sql="UPDATE $this->tableName SET";
            // precisa necessariamente de id
            // caso nao informar, nao deixar em branco
            if(null!=$this->getNome()){
                $sql.= " nome = '".$this->getNome()."',";
            }
            if(null!=$this->getEmail()){
                $sql.= " email = '".$this->getEmail()."',";
            }
            if(null!=$this->getTelefone()){
                $sql.= " telefone = '".$this->getTelefone()."',";
            }
            if(null!=$this->getSenha()){
                $sql.= " senha = '".$this->getSenha()."',";
            }
            if(null!=$this->getIsAdmin()){
                $sql.= " is_admin = '".$this->getIsAdmin()."',";
            }
            if(null!=$this->getIsDriver()){
                $sql.= " is_driver = '".$this->getIsDriver()."',";
            }
            if(null!=$this->getIsActive()){
                $sql.= " is_active = '".$this->getIsActive()."',";
            }
            if(null!=$this->getStatus()){
                $sql.= " status = '".$this->getStatus()."',";
            }
            // if(null!=$this->getCreatedOn()){
            //     $sql.= " created_on = '".$this->getCreatedOn()."',";
            // }
            $sql.=" WHERE id = :id";

            $stmt=$this->dbConn->prepare($sql);
            $stmt->bindParam(':id',$this->id);

            if($stmt->execute()){
                return true;
            }else {
                return false;
            }
        }
        
        // deletar no banco
        public function delete(){
            $stmt= $this->dbConn->prepare('DELETE FROM '.$this->getTableName().' WHERE id = :id');
            $stmt->bindParam(':id',$this->id);

            if($stmt->execute()){
                return true;
            }else {
                return false;
            }
        }
    }
?>