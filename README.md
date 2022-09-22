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
  `` username: admin@admin.com  ---  password: 123@admin ``

        ADMIN's Permissions

        //blog
            'access_blogs',
            'access_my_blogs',
            'create_blog',
            'update_blog',
            'view_blog_post',
            'delete_blog',

            //users
            'access_users',

            //comments
            'create_comment',
            'delete_comment',
            'update_comment',

- Author
  `` username: author@mail.com  ---  password: password ``

        Author's Permissions

        
            //blog
            'access_blogs',
            'access_my_blogs',
            'create_blog',
            'update_blog',
            
            //comments
            'create_comment',
            'update_comment'

- User
  `` username: user@mail.com  ---  password: password ``

        USER's Permissions

        
            //blog
            'access_blogs',
           
            //comments
            'create_comment',
            'update_comment'
          
