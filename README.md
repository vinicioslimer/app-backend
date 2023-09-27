# Aplicativo de Gerenciamento de Empresas

Este é um aplicativo de gerenciamento de empresas desenvolvido com Laravel e React JS.

## Requisitos do Ambiente

Aplicação desenvolvida com os seguintes requisitos:

- PHP 8.2.4
- Laravel 10
- Node.js
- Composer
- PostgreSQL

Siga estas etapas para configurar e executar o aplicativo:

1 - Instale as dependências do Composer
```bash	
composer install
```

2 - Copie o arquivo .env.example para .env e configure suas variáveis de ambiente, incluindo a configuração do banco de dados.

3 - Gere uma chave de aplicativo
```bash	
php artisan key:generate
```

4 - Instale os pacotes NPM
```bash
npm install
```

5 - Execute as migrações do banco de dados para criar as tabelas e os dados de login
```bash
php artisan migrate: fresh --seed
```

6 - Crie uma chave para o token de autenticação
```bash
php artisan jwt:secret
```

7 - Inicie o servidor
```bash
php artisan serve --host=0.0.0.0
```
