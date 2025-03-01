# Sympfony Task Management
`v1.0.0`

---

## The initial setup steps

### Create a New Symfony Project:
`symfony new symfony-task-management --webapp`
> The `--webapp` flag installs additional packages for a full-stack web application (e.g., Twig, Doctrine, etc.).
>
> Or you can use the `--full` option installs a Symfony skeleton with the most commonly used packages.

### Navigate to Your Project Directory
```
cd symfony-task-management
```

### Essential Packages to Install
<details>
	<summary>Install these if not already present in composer.json:</summary>

Basic web functionality:
```
composer require symfony/webapp-pack
```

Security for authentication:
```
composer require symfony/security-bundle
```

Forms and validation:
```
composer require symfony/form
composer require symfony/validator
```

Twig:
```
composer require twig
```

Database related:
```
composer require symfony/orm-pack
composer require doctrine/doctrine-migrations-bundle
```

For API development:
```
composer require symfony/serializer-pack
composer require api
```

#### Development Tools
Symfony Maker Bundle: 
```
composer require symfony/maker-bundle --dev
```

Debug toolbar and debugging tools:
```
composer require symfony/debug-pack --dev
```

For testing:
```
composer require symfony/test-pack --dev
```

#### Symfony Webpack Encore (Optional, for Asset Management)
If you plan to use CSS/JS bundling and want to integrate tools like Webpack, install the Webpack Encore bundle:
```
composer require symfony/webpack-encore-bundle
```
Then, install Webpack and configure your assets.
</details>

### Configure the Database Connection
Edit database details in the `.env` file in your project root:
```
DATABASE_URL="mysql://root:password@127.0.0.1:3306/task_management_system?serverVersion=8.0"
```

### Update .env for Development
Set `APP_ENV=dev` and `APP_DEBUG=1` in `.env` for development mode.

## Create the Database
```
php bin/console doctrine:database:create
```

## Create entities and migrations
Create `User`, `Task` and `Log` entities with `make` command:
```
php bin/console make:entity
```

Update entity and repository classes if needed and when you're done, make the migrations:
```
php bin/console make:migration
```

Update the new created migration class if needed, and finally, execute the migration to create tables in the database:
```
php bin/console doctrine:migrations:migrate
```

## Add dummy/fake data to the database
First, install `DoctrineFixturesBundle` package bundle:
```
composer require orm-fixtures --dev
```

<details>
	<summary>Then update the newly created AppFixtures class and add some dummy data to it:</summary>

```
$user = new User();
$user->setEmail(...);
$user->setPassword(...);
...

$manager->persist($user);

$task = new Task();
$task->setTitle(...);
$task->setDescription(...);
...

$manager->persist($task);

...
```
</details>

Lastly, load the fixtures into your database tables:
```
bin/console doctrine:fixtures:load
```

Or if you don't want to lose your data:
```
bin/console doctrine:fixtures:load --append
```

## Check the newly added rows in the database
You can use a visual database explorer (like phpMyAdmin) for this, or you use Symfony's `dbal`:
```
bin/console dbal:run-sql "SELECT * FROM user;"
```

## Run the server
```
symfony server:start
```

## Checking Security Vulnerabilities
The symfony binary created when you installed the Symfony CLI provides a command to check whether your project's dependencies contain any known security vulnerability:
```
symfony check:security
```
A good security practice is to execute this command regularly to be able to update or replace compromised dependencies as soon as possible.
