# Seting-up a New Sympfony Project
This is a step-by-step guide on how to set-up a new Symfony project.

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
Create `Task` and `Log` entities with `make` command:
```
php bin/console make:entity
```
> Note that you should use PascalCase for class names and camelCase for property names.

Create `User` entity with its special command:
```
php bin/console make:user
```

Update entity and repository classes if needed and when you're done, make the migrations:
```
php bin/console make:migration
```

Update the new created migration class if needed, for example in this project, `created_at` and `updated_at` columns were edited like this:
```
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
```

And finally, execute the migration to create tables in the database:
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
> Note that if your Symfony installation is configured properly, you can execute `bin/console` commands without the `php` prefix.

Or if you don't want to lose your data:
```
bin/console doctrine:fixtures:load --append
```

### Check the newly added rows in the database
You can use a visual database explorer (like phpMyAdmin) for this, or you use Symfony's `dbal`:
```
bin/console dbal:run-sql "SELECT * FROM user;"
```

## Add controllers
```
bin/console make:controller
```

## Add form types
To insert/update data to the databases, you can use Symfony's built-in forms:
```
bin/console make:form
```

Then create a new method in the controller that'll pass the `$form` (`$this->createForm(...)`) to the desired Twig template, and then saves the returned values in the database using `$form->isSubmitted()` and `$entityManager->persist(...)` and `$entityManager->flush()`. [More info](https://symfony.com/doc/current/forms.html#creating-form-classes)

And here's how you can render the form in the Twig template:
```
{{ form(form) }}
```
To have more control on the form elements, check out [this page](https://symfony.com/doc/current/form/form_customization.html).

> Don't forget to use validation rules (Constraints/Assert) in your entities (check out the "Attributes" tab [here](https://symfony.com/doc/current/validation.html#properties)).

## Add Tailwind
Install the bundle & initialize your app:
```
composer require symfonycasts/tailwind-bundle
php bin/console tailwind:init
```

Include the input file (`assets/styles/app.css` by default) in `base.html.twig`:
```
{# templates/base.html.twig #}

{% block stylesheets %}
	<link rel="stylesheet" href="{{ asset('styles/app.css') }}">
{% endblock %}
```

Run the watch command that will automatically recompile your CSS file:
```
php bin/console tailwind:build --watch
```

> More Tailwind commands and details can be found in [Symfony documentation](https://Symfony.com/bundles/TailwindBundle/current/index.html).

## Add CRUD
To have CRUD functionality in your project, you can either create a controller and form type and their Twig templates manually like above, or you can just create an entity and then simply use this generator command:
```
bin/console make:crud
```

## Register/Login/Logout functionalities
If you have already added the `security-bundle` to your project, you can add a simple login, logout and register functionalities using these generator commands:
```
bin/console make:registration-form

bin/console make:security:form-login
```
> If you want to create these forms manually instead, check out [this detailed guide](https://symfony.com/doc/current/security.html).

After you've added user authentication, you can update the `access_control` section in your `security.yaml` file and choose with wildcard paths can be accessed publicly, which ones require login and which ones are admin only.

> Note: If you have already created a sample/test user manually in the database, you should hash their password so that they can log in without any problems. (You can use `bin/console security:hash-password` command to hash passwords, then you should manually replace the result with the one you have in your database table)

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
