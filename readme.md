## Installation:-

``` bash
1.) Take checkout from master branch
2.) Create .env file and paste the codes from .env.example
3.) Run command composer install
4.) Run command php artisan migrate
4.) Run command php artisan passport:install
5.) Run command php artisan db:seed

```

```````
At last you can manage this command on scheduling task, you have to add a single entry to your server’s crontab file:

``` bash
* * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1

OR

* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

```````