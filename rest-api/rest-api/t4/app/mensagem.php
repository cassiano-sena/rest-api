<?php
    class Mensagem{
        private $id;
        private $usuario;
        private $veiculo;
        private $rota;
        private $data;
        private $hora;
        private $descricao;
        private $status;
        private $createdOn;
        private $tableName='tab_mensagens';
        private $dbConn;

        function setId($id){$this->id=$id;}
        function getId(){return $this->id;}
        function setUsuario($usuario){$this->usuario=$usuario;}
        function getUsuario(){return $this->usuario;}
        function setVeiculo($veiculo){$this->veiculo=$veiculo;}
        function getVeiculo(){return $this->veiculo;}
        function setRota($rota){$this->rota=$rota;}
        function getRota(){return $this->rota;}
        function setData($data){$this->data=$data;}
        function getData(){return $this->data;}
        function setDescricao($descricao){$this->descricao=$descricao;}
        function getDescricao(){return $this->descricao;}
        function setHora($hora){$this->hora=$hora;}
        function getHora(){return $this->hora;}
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

        // listar todas as mensagens
        public function getAllMensagens(){
            $stmt=$this->dbConn->prepare("SELECT * FROM ".$this->tablename);
            $stmt->execute();
            $usuarios=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarios;
        }

        // listar uma mensagem
        /*public function getMensagem(){
            $stmt=$this->dbConn->prepare('SELECT FROM '.$this->tablename.' WHERE id = :id');
            $stmt->bindParam(':id',$this->id);
            $stmt->execute();
            $usuario=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuario;
        }*/

        // inserir no banco
        public function insert(){
            $sql='INSERT INTO '.$this->tableName.'(id, usuario, rota, data, hora, descricao, status, created_on) VALUES(null, :usuario, :rota, :data, :hora, :descricao, :status, :created_on)';
            $stmt=$this->dbConn->prepare($sql);
            $stmt->bindParam(':usuario',$this->usuario);
            $stmt->bindParam(':rota',$this->rota);
            $stmt->bindParam(':data',$this->data);
            $stmt->bindParam(':hora',$this->hora);
            $stmt->bindParam(':descricao',$this->descricao);
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
            $sql="UPDATE $this->tableName SET";
            // caso nao informar, nao deixar em branco
            if(null!=$this->getUsuario()){
                $sql.= " usuario = '".$this->getUsuario()."',";
            }
            if(null!=$this->getRota()){
                $sql.= " rota = '".$this->getRota()."',";
            }
            if(null!=$this->getData()){
                $sql.= " data = '".$this->getData()."',";
            }
            if(null!=$this->getHora()){
                $sql.= " hora = '".$this->getHora()."',";
            }
            if(null!=$this->getDescricao()){
                $sql.= " descricao = '".$this->getDescricao()."',";
            }
            if(null!=$this->getStatus()){
                $sql.= " status = '".$this->getStatus()."',";
            }
            if(null!=$this->getCreatedOn()){
                $sql.= " created_on = '".$this->getCreatedOn()."',";
            }
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
            $stmt= $this->dbConn->prepare('DELETE FROM '.$this->getTableName.' WHERE id = :id');
            $stmt->bindParam(':id',$this->id);
            
            if($stmt->execute()){
                return true;
            }else {
                return false;
            }
        }
    }
?>