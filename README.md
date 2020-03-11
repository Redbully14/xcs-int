<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## About AntelopePHP

AntelopePHP is the name of the Civilian Department Digital System, which is a comprehensive website that allow us to streamline our day-to-day operations and be more efficient as a department. It has been designed to the highest quality standards to deliver optimal performance through powerful user interfaces. AntelopePHP uses Laravel as it's base functioning framework.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library. Did I mention it's completely free?

## Documentation

The AntelopePHP Development Wiki can be accessed through [this](https://github.com/Redbully14/xcs-int/wiki) link.

## Setting up AntelopePHP

Clone the repository somewhere on your local drive (if using windows, go into your xampp folder and clone it in the root folder of htdocs -- the folder must be empty prior to cloning it).

Open up your terminal afterwards and cd into that folder

Run the following command to install all the repository dependancies:
```bash
$ composer install
```

Once that is finished create a .env file in the root directory of the application and paste the following into the directory:
```bash
FRAMEWORK_NAME=xcs-int

APP_NAME=Antelope
APP_SUBNAME=PHP
APP_FOOTER="Department of Justice RP"
APP_ENV=local
APP_KEY=base64:FGwRL2VvWImG3kPyO4coNAwZ9Kmf9tl7gkiL9fTotwA=
APP_DEBUG=true
APP_URL=http://localhost
APP_COLOR=white

DEPARTMENT_NAME="Civilian Operations"
DEPARTMENT_SHORT_NAME=Civilians
DEPARTMENT_UNIT_NAME=Civilian
DEPARTMENT_CALLSIGN="Civilian Number"
DEPARTMENT_DIRECTOR="Ryan S. Civ-1"

SUPERADMIN_USERNAME=antelope
SUPERADMIN_PASSWORD=password

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=xcs-int
DB_USERNAME=root
DB_PASSWORD=

ROUTE_INVESTIGATIVE_SEARCH_KEY=NO_KEY_SET

LOG_CHANNEL=stack
LOG_DISCORD_WEBHOOK_URL=https://discordapp.com/api/webhooks/abcd/1234
LOG_DB_CONNECTION='default'
LOG_DB_DETAILED=false
LOG_DB_MAX=100
LOG_DB_QUEUE=true
LOG_DB_QUEUE_NAME='logToDBQueue'
LOG_DB_QUEUE_CONNECTION='default'
LOG_DB_MAX_COUNT=false
LOG_DB_MAX_HOURS=false

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

Afterwards, create a database with the name **xcs-int**.

Now, build the database by running the migration:
```bash
$ php artisan migrate
```

Once the database has been built, run the following command to seed the roles table:
```bash
$ php artisan db:seed
```

Finally, start the development server:
```bash
$ php artisan serve
```

### Logging in:

As of the official release of 1.0.0 of this application, making the first two accounts on the website has been deleted for security reasons.

If you have done everything above correctly, simply use the following information below to login:
```
Username: antelope
Password: password
```

## License

AntelopePHP is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).