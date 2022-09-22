## Follow these steps to install this system

**Clone the repo**

**To add php dependencies(vendor)**

    composer install

**To add javascript dependencies(node modules)**

    npm install

**Copy Environment file**

    cp .env.example .env

**Generate Key**

    php artisan key:generate

**After the database is setup in env; Migrate table and seed data**

    php artisan migrate --seed

**Run the server**

    php artisan serve

**To make file system work (optional)**

    php artisan storage:link

**To run tests**

    php vendor/phpunit/phpunit/phpunit

** Credentials **

- Admin

  `` username: admin@admin.com
  password: 123@admin
  ``

- User

  `` username: user@mail.com
  password: password
  ``