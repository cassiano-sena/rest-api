<?php
    class Rota{
        private $id;
        private $rota;
        private $veiculo;
        private $motorista;
        private $senha;
        private $datas;
        private $horarios;
        private $status;
        private $createdOn;
        private $tableName='tab_rotas';
        private $dbConn;

        function setId($id){$this->id=$id;}
        function getId(){return $this->id;}
        function setRota($rota){$this->rota=$rota;}
        function getRota(){return $this->rota;}
        function setVeiculo($veiculo){$this->veiculo=$veiculo;}
        function getVeiculo(){return $this->veiculo;}
        function setMotorista($motorista){$this->motorista=$motorista;}
        function getMotorista(){return $this->motorista;}
        function setSenha($senha){$this->senha=$senha;}
        function getSenha(){return $this->senha;}
        function setDatas($datas){$this->datas=$datas;}
        function getDatas(){return $this->datas;}
        function setHorarios($horarios){$this->horarios=$horarios;}
        function getHorarios(){return $this->horarios;}
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

        // listar todas as rotas
        public function getAllRotas(){
            $stmt=$this->dbConn->prepare("SELECT * FROM ".$this->tablename);
            $stmt->execute();
            $usuarios=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarios;
        }

        // listar uma rota
        /*public function getRota(){
            $stmt=$this->dbConn->prepare('SELECT FROM '.$this->tablename.' WHERE id = :id');
            $stmt->bindParam(':id',$this->id);
            $stmt->execute();
            $usuario=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuario;
        }*/

        // inserir no banco
        public function insert(){
            $sql='INSERT INTO '.$this->tableName.'(id, rota, veiculo, motorista, datas, horarios, status, created_on) VALUES(null, :rota, :veiculo, :motorista, :datas, :horarios, :status, :created_on)';
            $stmt=$this->dbConn->prepare($sql);
            $stmt->bindParam(':rota',$this->rota);
            $stmt->bindParam(':veiculo',$this->veiculo);
            $stmt->bindParam(':motorista',$this->motorista);
            $stmt->bindParam(':datas',$this->datas);
            $stmt->bindParam(':horarios',$this->horarios);
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
            if(null!=$this->getRota()){
                $sql.= " rota = '".$this->getRota()."',";
            }
            if(null!=$this->getVeiculo()){
                $sql.= " veiculo = '".$this->getVeiculo()."',";
            }
            if(null!=$this->getMotorista()){
                $sql.= " motorista = '".$this->getMotorista()."',";
            }
            if(null!=$this->getDatas()){
                $sql.= " datas = '".$this->getDatas()."',";
            }
            if(null!=$this->getHorarios()){
                $sql.= " horarios = '".$this->getHorarios()."',";
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