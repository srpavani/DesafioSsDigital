
# Sistema de login SS Digital

Este projeto consiste em um sistema de autenticação com registro, login e ativação de conta via email. O sistema foi construído utilizando PHP no backend, com PostgreSQL como banco de dados rodando no linux, e React no frontend com TypeScript.


#### Requirements

```http
  PHP 7 ou superior
  PostgreSQL 
  Servidor Web: XAMPP, Laragon ou qualquer outro ambiente similar que suporte PHP
  Node.js: para o frontend
  Optei por não usar o composer
  Envio de e-mail: Necessário ter uma API Key da Mailjet (para facilitar, deixei minhas credenciais configuradas no projeto)
```

## Primeiro: clonar o repositório
  git clone https://github.com/srpavani/DesafioSsDigital.git

## Segundo: preparar o banco de dados
   com o PostgreSQL instalado, dentro da pasta backend/database. crie uma .env e coloque: 

`DB_HOST=127.0.0.1`
`DB_NAME=diogo`
`DB_PASSWORD=diogo`
`DB_USER=postgres`

no arquivo datab.php, procure a variavel `$port` e coloque a porta do seu PostgreSQL

dentro da pasta database tem um arquivo chamado testarconn.php, com seu servidor funcionando pode usar para testar sua conexao com o banco de dados. 








## ROTAS API BACK-END 

#### Para registrar um usuario

```http
  POST /Back-end/registrar.php
```

| Parameter | Type     | 
| :-------- | :------- | 
| `email` | `string` |
| `password` | `string` | 

#### Para fazer login

```http
  POST /Back-end/login.php
```

| Parameter | Type     | 
| :-------- | :------- | 
| `email` | `string` |
| `password` | `string` |


#### Para fazer logout(session destroy)

```http
/Back-end/logout.php
```

### Dentro da pasta API existe o arquivo enviar_email_ativacao.php, que já contém minhas credenciais para simplificar o funcionamento da API. No futuro, uma boa prática seria colocar essas credenciais em um arquivo .env 

### Para testar o backend de forma automática, na pasta Teste na raiz do diretório, há um arquivo chamado test.py, que está programado para realizar o registro de 100 usuários e gerar um gráfico com o número de sucessos e erros.
## Instalação

Para instalar a aplicação é necessário um ambiente de desenvolvimento, na pasta da aplicação e no seu terminal digite:

se for windowns = `python -m venv venv`

Depois é necessário ativar o ambiente virtual, digite:

`.\venv\Scripts\activate`

Depois do ambiente ativado instale os requirements.txt
`.pip install -r requirements.txt`

Para executar o arquivo de tests:
`python test.py`


# FRONT-END

#### Para o Modelo 2 funcionar corretamente, é necessário configurar a rota do backend no arquivo main.js. Siga os passos abaixo:
#### Navegue até o caminho modelo2/assets/js/main.js.
#### Na linha 2, substitua a variável API_URL pela URL do seu servidor backend.
#### Exemplo:
`const API_URL = 'http://localhost:8080/ProjetoSSdigital/DesafioSsDigital/Back-end';`

##para o modelo 1 seguir os passos abaixo:

#### Primeiro passo: instalar dependências.
`cd/Front-End/sistemalogin/`
dentro dela digite o comando:
`npm install`

#### depois de instalado todos os modulos, será nescessario criar uma .env 
crie uma .env e dentro dela coleque a url do seu servidor, segue a minha como exemplo: `REACT_APP_API_URL=http://localhost:8080/ProjetoSSdigital/DesafioSsDigital/Back-end`


### apos setado a .env agora é só rodar o servidor front end com o comando `npm start`
