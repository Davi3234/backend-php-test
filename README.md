# Teste PHP Backend

## Sistema de Contatos

---

Foi desenvolvido um sistema de gerenciamento de pessoas e contatos.

### Tecnologias utilizadas

- **Back-end**: PHP com ORM Doctrine
- **Frontend**: JavaScript, HTML, CSS
- **Banco de Dados**: PostgreSQL
- **Ambiente**: Docker
- **Gerenciamento das Dependências**: Composer

---

## Escopo do Projeto

---

- O escopo da arquitetura das pastas foi dividida em:
    - **bin** => Parte do gerenciamento do doctrine.
    - **collection** => Uma collection POSTMAN para entendimento dos endpoints do backend.
    - **public** => Local onde as requisições do backend vão ser iniciadas.
    - **src** => Código fonte do projeto

### Src

#### Core

Dentro do código fonte do projeto, optei por separar a responsabilidade da parte principal do sistema na pasta
**Core**, onde possuo:

- **Exception** personalizada(somente uma pois optei por algo mais simples)
- **Enum** => Onde possui os ENUMS do sistema.
- **Server** => Possui duas classes para gerenciar a resposta e a requisição do backend.
- **Singleton** => Fiz um singleton para instanciar somente uma vez o entityManager a cada requisição.

#### Model

A pasta **Model** acabei optando por utilizar um padrão de entidade e _repository_, onde possuo as entidades de **Pessoa
** e **Contato** e os **_Repositories_** para contato e pessoa.

#### Controller

Na pasta **Controller** é o local onde está a lógica da aplicação, com todos os métodos que irão ser acessados pelo
index.php.

#### Test

Optei por utilizar um padrão de desenvolvimento (TDD) onde realizei primeiramente os testes unitários para depois
desenvolver a parte lógica do sistema, os testes unitários estão na pasta **Test**.

#### View

Optei por manter as views dentro do src para simplificar o escopo, embora saiba que em um projeto real a separação entre
frontend e backend seria mais adequada.

---

## Docker

---
Na parte de containerização utilizando docker, optei por inicializar 3 containers:

- Backend. (**localhost:8080**)
- Frontend. (**localhost:8081**)
- Banco de dados. (**localhost:5433**) <- Foi utilizado a porta 5433 para não conflitar com a porta de outro postgreSQL
  local.

---

## Rodando o projeto

---

OBS: É necessário possuir docker instalado.

1. Primeira etapa para rodar o projeto é necessário cloná-lo:

```bash
    git clone https://github.com/Davi3234/backend-php-test.git
```

2. Segunda etapa seria entrar na pasta do projeto:

```bash
    cd backend-php-test
```

3. Terceira etapa seria copiar o arquivo .env.example ou renomear para somente .env
4. Quarta etapa seria subir a rede de containers docker:

```bash
    docker compose up --build -d
```

5. Após a rede de containers ter sido inicializada corretamente, basta entrar na url **localhost:8081** e realizar os
   testes no frontend.

- Caso queira executar os testes unitários poderá ser executado de duas formas:
  - Entrar no bash do container docker e rodar o comando
  ```bash
        ./vendor/bin/phpunit
    ```
  - Instalar as dependências do composer com ```composer install``` e depois rodar o mesmo comando de cima na raíz do projeto.

---

## Minhas considerações

--- 

Particularmente, achei que foi um desafio interessante de desenvolver, principalmente o gerenciamento dos endpoints do
backend, Inicialmente utilizei attributes do PHP para gerenciar os endpoints, mas optei por removê-los e adotar uma
abordagem mais simples, adequada ao escopo reduzido do desafio. Também pude abordar uma estratégia de desenvolvimento
que hoje em dia não abordo tanto, que seria o Test Driven Development, porém depois de um tempo vai acostumando e fica
interessante pensar nessa engenharia reversa.

---
Qualquer dúvida entre em contato.