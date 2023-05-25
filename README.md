# rest-api
pw_t4 redo backend only

/**
* Para habilitar o modo de POST-ONLY, descomentar 'rest.api' 14-16;
* Caso haja problema na conexão com o banco, trocar a senha da database em dbconnect.php
*/




Para gerar um token: 
(senha está sem case-sensitivity)

{
  "name": "generateToken",
  "param": {
    "email": "cassiano@email.com",
    "senha": "cassiano"
  }
}
{
  "name": "generateToken",
  "param": {
    "email": "eduardo@email.com",
    "senha": "eduardo"
  }
}





Copiar o Token 
Vá para 'Headers'
Escreva "Content-Type" "application/json"
Escreva "Authorization" "Bearer (token)"

Se o token for válido, você terá acesso por 15 minutos





//Para gerenciar usuários
//OK
{
  "name": "addUsuario",
  "param": {
    "nome": "1",
    "email": "2",
    "telefone": "3",
    "senha": "4",
    "is_admin": "0",
    "is_driver": "0",
    "is_active": "0",
    "usuario_status": "A"
  }
}

//OK
{
  "name": "getUsuarioDetails",
  "param": {
    "usuario_id":1
  }
}

//OK
{
  "name": "updateUsuario",
  "param": {
    "usuario_id": "1",
    "nome": "2",
    "email": "3",
    "telefone": "4",
    "senha": "5",
    "is_admin": "0",
    "is_driver": "0",
    "is_active": "0",
    "usuario_status": "A",
    "created_on":""
  }
}

//OK
{
  "name": "deleteUsuario",
  "param": {
    "usuario_id": ""
  }
}





//Para gerenciar rotas
//OK
{
  "name": "addRota",
  "param": {
    "rota": "1",
    "veiculo": "2",
    "motorista": "3",
    "datas": "4",
    "horarios": "5",
    "rota_status": "A"
  }
}

//OK
{
  "name": "getRotaDetails",
  "param": {
    "rota_id": ""
  }
}

//OK
{
  "name": "updateRota",
  "param": {
    "rota_id": "1",
    "rota": "0",
    "veiculo": "0",
    "motorista": "0",
    "datas": "0",
    "horarios": "0",
    "rota_status": "A"
  }
}

//OK
{
  "name": "deleteRota",
  "param": {
    "rota_id": "3"
  }
}





//Para gerenciar mensagens
//OK
{
  "name": "addMensagem",
  "param": {
    "usuario": "1",
    "rota": "1",
    "descricao": "a",
    "mensagem_status": "A"
  }
}

//OK
{
  "name": "getMensagemDetails",
  "param": {
    "mensagem_id": "3"
  }
}

//OK
{
  "name": "updateMensagem",
  "param": {
    "mensagem_id": "3",
    "usuario": "2",
    "rota": "2",
    "mensagem_data": "",
    "hora": "",
    "descricao": "B",
    "mensagem_status": "I"
  }
}


//OK
{
  "name": "deleteMensagem",
  "param": {
    "mensagem_id": ""
  }
}
