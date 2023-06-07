
# API de produtos

Api de cadastro de produtos, feita dentro da arquitetura MVC, com repository pattern


## Stack utilizada

**Back-end:** Laravel 9, MYSQL, PHP 8.1

**Arquitetura:** Routes, Controllers, Interfaces, Repositories



## Funcionalidades

- Cadastro de produtos
- Upload de imagens
- Autenticação


## Instalação

Para rodar o projeto siga os seguintes comandos

**Projeto:**
```bash
  git clone 
```
Após o projeto clonado, entre na pasta do projeto

```bash
  cd api-products
```
Instale as dependencias usando composer
```bash
  composer install 
```


**Banco de dados:**

Dentro do arquivo .env, insira as credenciais de sua base de dados, recomendo criar uma base chamada ecommerce.
```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ecommerce
    DB_USERNAME={seu_user}
    DB_PASSWORD={sua_senha}
```
Execute as migrações do sistema, para criar as tabelas
```bash
  php artisan migrate
```
Execute os seeders para popular as tabelas do banco de dados:
```bash
  php artisan db:seed
```
**Usuário padrão:** 

email: john.doe@example.com

password: password123

**Servidor:**

Faça o link da pasta publica, para poder exibir as imagens:
```bash
  php artisan storage:link
```

Execute o servidor para ver o projeto em execução:
```bash
  php artisan serve
```

**Testes:**

Para executar os testes das rotas:
```bash
  php artisan test
```


## Documentação da API

#### Login

```http
  POST /api/login
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email` | `string` | **Obrigatório**. |
| `password` | `string` | **Obrigatório**. |

#### Retorna todos os itens

```http
  GET /api/products
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `headers/authorization` | `string` | **Obrigatório**. Bearer {{token}} |
| `?page={{pageNumber}}` | `string` | **Opcional**.|

#### Cadastra itens

```http
  POST /api/products
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `headers/authorization` | `string` | **Obrigatório**. Bearer {{token}} |
| `name` | `string` | **Obrigatório**.  |
| `isbn` | `string` | **Obrigatório**.  |
| `price` | `decimal` | **Obrigatório**.  |
| `image_id` | `number` | **Opcional**.  |

#### Atualiza itens

```http
  PUT /api/products/{id}
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `headers/authorization` | `string` | **Obrigatório**. Bearer {{token}} |
| `name` | `string` | **Obrigatório**.  |
| `isbn` | `string` | **Obrigatório**.  |
| `price` | `decimal` | **Obrigatório**.  |
| `image_id` | `number` | **Opcional**.  |

#### Deleta itens

```http
  DELETE /api/products/{id}
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `headers/authorization` | `string` | **Obrigatório**. Bearer {{token}} |

#### Publica imagens

```http
  POST /api/upload-image
```

| Parâmetro   | Name       |                   Tipo         |
| :---------- | :--------- | :---------------------------------- |
| `miltipartform` | `image` | `File`|  



