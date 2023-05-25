# rest-api
pw_t4 redo backend only

/**
* Para habilitar o modo de POST-ONLY, descomentar 'rest.api' 14-16;
*/

Para gerar um token: 
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
{
  "name": "addUsuario",
  "param": {
    "nome": "Daniel",
    "email": "daniel@email.com",
    "telefone": "1234-5678",
    "senha": "daniel",
    "is_admin": "",
    "is_driver": "",
    "ativo": "",
    "status": "",
    "created_on": ""
  }
}
{
  "name": "addUsuario",
  "param": {
    "nome": "Daniel",
    "email": "daniel@email.com",
    "telefone": "1234-5678",
    "senha": "daniel"
  }
}
{
  "name": "getUsuarioDetails",
  "param": {
    "id": "(id)"
  }
}
{
  "name": "deleteUsuario",
  "param": {
    "id": "(id)"
  }
}

//Para gerenciar rotas
{
  "name": "addRota",
  "param": {
    "rota": "",
    "veiculo": "",
    "motorista": "",
    "datas": "",
    "horarios": ""
  }
}
{
  "name": "getRotaDetails",
  "param": {
    "id": "(id)"
  }
}
{
  "name": "deleteRota",
  "param": {
    "id": "(id)"
  }
}

//Para gerenciar mensagens
{
  "name": "addMensagem",
  "param": {
    "usuario": "",
    "rota": "",
    "descricao": ""
  }
}
{
  "name": "getMensagemDetails",
  "param": {
    "id": "(id)"
  }
}
{
  "name": "deleteMensagem",
  "param": {
    "id": "(id)"
  }
}
