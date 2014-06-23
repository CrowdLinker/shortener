
Version
----

1.0

Tech
-----------

Crowdlinker Shortener uses a number of open source projects to work properly:

* [Laravel 4] - PHP MVC framework
* [AngularJS] - MVW javascript framework
* [Twitter Bootstrap] - great UI boilerplate for modern web apps
* [node.js] - evented I/O for the backend
* [npm] - Node package modules
* [Grunt] - Task Manager
* [Gulp] - The streaming build system. Too minify and compile SASS/SCSS.
* [jQuery] - duh 
* [Vagrant] - Development Environment.
* [Embedly] - For Extracting URL

Installation
--------------

```sh
git clone [git-repo-url] [foldername]
cd [foldername]
composer install

```

##### Create your '.env.php' (If using in production environment) or '.env.local.php' (In local) in root.

```sh
<?php
return [

    'FACEBOOK_ID' => '<facebook-id>',
    'FACEBOOK_SECRET' => '<facebook-secret>',
    'MANDRILL_KEY' => '<mandrill-key>',
    'EMBEDLY_KEY' => '<embedly-key>',
    'SHORT_DOMAIN' => '<your desired shortlink i.e samply.com (Without http)'
];

```
##### Configure Database.
* Configure app/config/database.php - For production
* Configure app/config/local/database.php - For local environment (All config for local environment goes to app/local/)

##### Migrate Database
* For production


```sh
php artisan migrate

```

* For local/dev environment


```sh
php artisan migrate --env=local

```






**Free Software, Hell Yeah!**
[Laravel 4]:http://laravel.com
[Grunt]:http://gruntjs.com/
[AngularJS]:https://angularjs.org/
[npm]:https:http://www.npmjs.org/
[node.js]:http://nodejs.org
[Twitter Bootstrap]:http://twitter.github.com/bootstrap/
[jQuery]:http://jquery.com
[Gulp]:http://gulpjs.com
[Vagrant]:http://www.vagrantup.com/
[Embedly]:http://embed.ly
