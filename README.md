# The Book list

## Installation

Copy all files and folders to your directory.

Go to this dirrectory with terminal

```
cd directory_name/
```

Download all dependencies
```
composer update
```
Go to .env file and set database params (user login, pass, database name)
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
```
then run these commands
```
php bin/console doctrine:migrations:migrate
```
use your server parameters or use web symfony server
```
symfony server:start

symfony open:local
```
