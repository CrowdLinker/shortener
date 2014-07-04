
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/CrowdLinker/shortener/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/CrowdLinker/shortener/?branch=master)

Version
---- 
1.3

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
* [jVectorMap] - For Analytics geo visualizaton.
* [freegeoip] - REST Api for searching geolocation by ipaddress.
* [Mandrill] - SMTP server.


Features
-----------

* Generate Shortlink. Ability to use any custom domain of your choice.
* Single Sign On - Currently supports Facebook,Twitter and username/password.
* Track clicks (Including unique clicks)
* Track Location - Countries and City
* SafeBrowsing


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
    'FACEBOOK_ID' => '<facebook-key>',
    'FACEBOOK_SECRET' => '<facebook-secret>',
    'TWITTER_KEY' => '<twitter-key>',
    'TWITTER_SECRET' => '<twitter-secret>',
    'TWITTER_CALLBACK_URI' => '<your-domain>/auth/twitter/callback',
    'MANDRILL_USERNAME' => '<mandrill-username>',
    'MANDRILL_KEY' => '<mandrill-key>',
    'EMBEDLY_KEY' => '<embedly-key>',
    'SHORT_DOMAIN' => '<your-short-domain e.g sample.com>',
    'COMPANY_NAME' => '<company-name>',
    'COMPANY_SITE' => '<company-site>',
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
##### Setup cronjob
* Setup cronjob to run at midnight for following command (used for to analyze unique clicks):

```sh
0 0 * * * 1,2,3,4,5 /usr/bin/php /public_html/shortener/artisan crowdlinker:updatecount

```





**Free Software, Hell Yeah! Feel free to contribute or suggest any issues or new features.**
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
[jVectorMap]:http://jvectormap.com/
[freegeoip]:http://freegeoip.net
[Mandrill]:http://mandrillapp.com
