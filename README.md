# Sympfony Task Management
`v1.0.0`

A simple task management project to test and learn Symfony framework.

## Composer Setup
```
$ composer install
```

## Database Setup

### Configure Connection
Edit database details in the `.env` file in your project root:
```
DATABASE_URL="mysql://root:password@127.0.0.1:3306/task_management_system?serverVersion=8.0"
```

### Create the Database
```
php bin/console doctrine:database:create
```

### Migrate Tables
```
php bin/console doctrine:migrations:migrate
```

## Run the server
To deploy the project on your web server, check out [this page](https://symfony.com/doc/current/setup/web_server_configuration.html). Or if you prefer Docker, read [this guide](https://symfony.com/doc/current/setup/docker.html).
