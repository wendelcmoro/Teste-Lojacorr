# teste-lojacorr

Teste Lojacorr


# Conteúdos

1. [Requisitos](#Requisitos)<br>
2. [Execução Padrão do projeto](#Execução-Padrão-do-projeto)<br>
   2.1 [Instalando Dependências e configurando variáveis de ambiente](##Instalando-Dependências-e-configurando-variáveis-de-ambiente)<br>
   2.2 [Iniciando o projeto](##Iniciando-o-projeto)<br>
   2.3 [Listagem das rotas](##Listagem-das-rotas)<br>
3. [Execução do projeto com Docker](#Execução-do-projeto-com-Docker)<br>
   3.1 [Configurando variáveis de ambiente](##Configurando-variáveis-de-ambiente)<br>
   3.2 [Montando os containers](##Montando-os-containers)<br>

## 1 Requisitos

- PHP 8.2(ou mais recente)
- Composer  2.7.7
- MariaDB 15.1
- Docker(opcional para montar o projeto em docker)
- Docker-Compose(opcional para montar o projeto em docker)

# 2. Execução Padrão do projeto

## 2.1 Instalando Dependências e configurando variáveis de ambiente

Para iniciarmos, precisamos instalar as dependências com o **composer**:

```console
composer i
```

Após isso, precisamos configurar as variáveis de ambiente, para isso executaremos o comando a seguir:

```console
cp .env.example .env
```

Em seguida, necessitamos alterar as variáveis de ambiente, no caso as variáveis de banco de dados conforme a seguir:

- DB_CONNECTION=mysql
- DB_HOST=laravel_db
- DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=laravel
- DB_PASSWORD=secret

As variáveis aqui definidas foram utilizadas na máquina local, então ao configurar o banco de dados, você pode utilizar as configurações acima, ou as configuraçõe de sua escolha.

## 2.2 Iniciando o projeto

Agora vamos executar alguns comandos para podermos iniciarmos o projeto localmente, primeiramente vamos migrar e semear nossas tabelas:

```console
php artisan migrate:fresh --seed
```

O projeto foi construído com o uso do **Swagger**, opcionalmente podemos gerar nossa documentação para acesso:

```console
php artisan l5-swagger:generate
```

Por fim, vamos executar o projeto localmente a partir do comando à seguir:

```console
php artisan serve
```

Agora nosso projeto é acessável da através da url:  
 - http://localhost:8000 
 
 Opcionalmente você pode acessar a página com a documentação do swagger da API do projeto com:  
 - http://localhost:8000/api/documentation

## 2.3 Listagem das rotas

Aqui está sendo listado as rotas da **API**:

- POST '/api/category'
- GET '/api/categories?id=1' **(o parâmetro id é opcional)**
- DELETE '/api/category'

Mais detalhes das rotas podem ser encontradas na documentação do swagger

# 3. Execução do projeto com Docker

Aqui nesta seção serão oferecidas algumas instruções para execução do projeto com docker.

## 3.1 Configurando variáveis de ambiente

Diferente do padrão, aqui só teremos de configurar nossa variável de ambiente, então executamos o seguinte comando:

```console
cp .env.example .env
```

E alteramos o conteúdo do .env:

- DB_CONNECTION=mysql
- DB_HOST=laravel_db
- DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=laravel
- DB_PASSWORD=secret

Por padrão, o docker irá montar uma imagem do MariaDB com as configurações acima, o nosso host precisa ser o nome do container para que o projeto tenha permissão de acesso ao banco na rede interna do docker.

## 3.2 Montando os containers

Agora só nos resta montar os containers, para isso executamos inicialmente o comando:

```console
sudo docker-compose up --build -d
```

Ao final do processo, teremos 2 containers: **laravel_app** e **laravel_db**. A princípio, para acessar a aplicação basta acessar a url: 

- http://localhost:8000 


Ou a página com a documentação do swagger:

- http://localhost:8000/api/documentation

**Observação**: a aplicação não vai estar disponível imediatamente, pois o comando **composer install** precisa instalar as dependências primeiro, isso pode demorar alguns instantes. Para checar o progresso da instalação das dependências pode ser utilizado o seguinte comando:

```console
sudo docker-compose logs app
```