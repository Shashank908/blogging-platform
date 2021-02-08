## Installation:-
### Note:- All installations are done and tested in windows environment.

### Software Requirement
``` bash
1.) PHP > 7.3
2.) Composer
3.) MySQL 5.7
4.) ElasticSearch 7.10
5.) In PHP ini file, maximum execution time and memory should be greater than 1 GB
6.) cURL should be enabled
7.) Xdebugger Should be installed and configured for unit test check

```

``` bash
1.) Take checkout from master branch
2.) Create .env file and paste the codes from .env.example
3.) Run command composer install
4.) Run command php artisan migrate
5.) Run command php artisan db:seed
7.) Run command php artisan es:mapping

If you want to Re-index the Posts into elastic Search inorder to keep data in Sync.
Then,

Run Command php artisan es:reindexing

```

```````
At last you can manage this command on scheduling task, you have to add a single entry to your server’s crontab file:

``` bash
* * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1

OR

* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

```````