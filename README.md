## Country Encyclopedia

Requirements:

- Docker

To get started

- Copy `.env.example` and rename it to `.env`.

Then execute this command

```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

Now run `./vendor/bin/sail up`. Add `-d` to run in background.

> However, instead of repeatedly typing vendor/bin/sail to execute Sail commands, you may wish to configure a shell
> alias that allows you to execute Sail's commands more easily:
>```
>alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
>```  
>To make sure this is always available, you may add this to your shell configuration file in your home directory, such
> as ~/.zshrc or ~/.bashrc, and then restart your shell.
>
>More info about [Laravel Sail](https://laravel.com/docs/10.x/sail)

Then run these commands:

- `sail artisan migrate --seed`
  P.S. It takes a while

Command PopulateDatabase (app:populate-database) will be called through seeder automatically and a default user will be
created

> Email: `test@example.com`
>
>Password: `password`
