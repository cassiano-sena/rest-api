# rest-api
pw_t4 redo backend only

/**
* Para habilitar o modo de POST-ONLY, descomentar 'rest.api' 14-16;
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
    "status": "A"
  }
}

//TODO
{
  "name": "getUsuarioDetails",
  "param": {
    "id": ""
  }
}

//TODO
{
  "name": "updateUsuario",
  "param": {
    "id": "",
    "nome": "",
    "email": "",
    "telefone": "",
    "senha": "",
    "is_admin": "",
    "is_driver": "",
    "is_active": "",
    "status": ""
  }
}

//OK
{
  "name": "deleteUsuario",
  "param": {
    "id": "(id)"
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
    "status": "A"
  }
}

//TODO
{
  "name": "getRotaDetails",
  "param": {
    "id": "(id)"
  }
}

//TODO
{
  "name": "updateRota",
  "param": {
    "id": "",
    "rota": "0",
    "veiculo": "0",
    "motorista": "0",
    "datas": "0",
    "horarios": "0",
    "status": "A"
  }
}

//OK
{
  "name": "deleteRota",
  "param": {
    "id": ""
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
    "status": "A"
  }
}

//TODO
{
  "name": "getMensagemDetails",
  "param": {
    "id": ""
  }
}

//TODO
{
  "name": "updateMensagem",
  "param": {
    "id": "",
    "usuario": "2",
    "rota": "2",
    "descricao": "B",
    "status": "I"
  }
}

//OK
{
  "name": "deleteMensagem",
  "param": {
    "id": ""
  }
}
