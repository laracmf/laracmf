Laravel CMF
=============

# Installation

[PHP](https://php.net) 5.5+, database server, and [Composer](https://getcomposer.org) are required.

1. There is one ways of grabbing the code:
  * Use Git: `git clone git@github.com:laracmf/laracmf.git`
2. From a command line open in the folder, run `composer install` and then `npm install`.
3. Create .env file (copy entry from config/env/.env.vagrant).
4. Generate jwt secret `php artisan jwt:secret`.
5. Provide database, socials credentials and another staff in .env configuration file.
6. Enter `./vendor/bin/homestead make` in command line.
7. Let vagrant environment up in command line `vagrant up` and than `vagrant ssh`.
8. From project root (as usual you can get it by typing cd {project folder name}) under vagrant run `php artisan app:install` followed by `gulp` to setup the application. 
9. You will need to enter your mail server details into `config/mail.php`.
  * You can disable verification emails in `config/credentials.php`
  * Mail is still required for other functions like password resets and the contact form
  * You must set the contact email in `config/contact.php`
  * I'd recommend [queuing](#setting-up-queing) email sending for greater performance (see below)

To launch site type in your browser address line `192.168.10.10`

If you want launch site using specific domain look [here](https://laravel.com/docs/5.3/homestead).

**Admin credentials** admin@dsmg.co.uk/password

# Setting Up Queuing

In CMF uses Laravel's queue system to offload jobs such as sending emails so your users don't have to wait for these activities to complete before their pages load. By default, we're using the "sync" queue driver.

1. Check out Laravel's [documentation](http://laravel.com/docs/master/queues#configuration).
2. Enter your queue server details into `config/queue.php`.


# Setting Up Caching

CMF provides caching functionality, and when enabled, requires a caching server.
Note that caching will not work with Laravel's `file` or `database` cache drivers.

1. Choose your poison - I'd recommend [Redis](http://redis.io).
2. Enter your cache server details into `config/cache.php`.
3. Setting the driver to array will effectively disable caching if you don't want the overhead.


# Setting Up Themes

CMF also ships with 18 themes, 16 from [Bootswatch](http://bootswatch.com).

1. You can set your theme in `config/theme.php`.
2. You can also set your navbar style in `config/theme.php`.
3. After making theme changes, you will have to run `php artisan app:update`.


# Setting Up Google Analytics

CMF natively supports [Google Analytics](http://www.google.com/analytics).

1. Setup a web property on [Google Analytics](http://www.google.com/analytics).
2. Enter your tracking id into `config/analytics.php`.
3. Enable Google Analytics in `config/analytics.php`.


# Setting Up CloudFlare Analytics

CMF can read [CloudFlare](https://www.cloudflare.com/) analytic data through a package.

1. Follow the install instructions for my [Laravel CloudFlare](https://github.com/BootstrapCMS/CloudFlare) package.
2. CMF will auto-detect the package, only allow admin access, and add links to the navigation bar.

# Sign in and up with socials

For this needs we use [Socialite package](https://github.com/laravel/socialite).
We provide auth through github. However socialite package offer wide range of socials you can implement.
Just follow steps from the [doc](https://github.com/laravel/socialite#configuration).

# Features in admin panel

 1. Users crud.
 2. Edit configuration from admin page.
 3. Categories crud.
 4. Comments management.
 5. Media crud.
 6. Pages crud.
 
# Comments management

To enable comments approvement set `COMMENTS_MODERATION` variable to `true` in .env file.

# Dynamic grid maker

To simplify this staff we wrapped [Nayjest/Grids](https://github.com/Nayjest/Grids) package.
For advanced options look in [package]((https://github.com/Nayjest/Grids)) docs.
 
See [demo](https://github.com/Nayjest/Grids#demo).

Provided features:

 * Render fields;
 * Pagination;
 * Excel and CSV export;
 * Show/hide columns UI control;
 * Filtering;
 * Refresh;
 * Render field with filter;
 * Sorting;
 * Add callback for customizing field output;

Usage example.

 In your template render method add following:
 
 ``` 
    $grid = new GridService(); 
    $user = new User();
    $gridComponent = $grid->generateGrid($user, ['first_name' => ['filter' => 'like'], 'last_name', 'email'], ['csv', 'exel', 'recordsPerPage', 'hider', 'refresher']);
    view('your_template',  compact('gridComponent'));
 ``` 
  
 In template add following:
 
 ```
   {!! $gridComponent !!}
 ```
 
 **How to use:**
 
## Just render fields:
 
   ``` $grid->generateGrid($user, ['first_name', 'last_name', 'email']);```
   
## Render field with filter flow:
 
  Options:
   
  * **like**;
  * **eq**;
  * **n_eq**;
  * **gt**;
  * **lt**;
  * **ls_e**;
  * **gt_e**;
 
   ```$grid->generateGrid($user, ['first_name' => ['filter' => 'ls_e']); ```
     
   It will generate input for providing filter options.
  
## Set components:
 
   Available components:
   
   * **csv**;
   * **exel**;
   * **hider**;
   * **refresher**;
   
   ```$grid->generateGrid($user, ['first_name'], ['csv']);```
   
## Add callback:

   ```
      $callback = function ($val, ObjectDataRow $row) {
          if ($val) {
              return view('partials.names', ['user' =>  $row->getSrc()]);
          }
      }; 
      $grid->generateGrid($user, ['first_name' => ['callback' => $callback]);
   ```
   Example above shows how callback option delegate rights for building first_name view to partial 'names'.

## Extra 

  You can set items per page quantity `$grid->setPageSize(4);` and grid name `$grid->setGridName('Grid name')`.
  By default items per page quantity - 15, grid name - 'grid'.
  
# Breadcrumbs

Breadcrumbs feature provides by [davejamesmiller/laravel-breadcrumbs](https://github.com/davejamesmiller/laravel-breadcrumbs)package.

Here is an example how to generate breadcrumb:

``` 
    Breadcrumbs::register('account.register', function($breadcrumbs) {
       $breadcrumbs->push('Registration', route('account.register'));
    });
``` 

In template add

```{!! Breadcrumbs::renderIfExists() !!}```

For advanced usage see [docs](https://laravel-breadcrumbs.readthedocs.io/en/latest/start.html).

# Flash messages

To show flash message: `flash('Message', 'info')`;
For more options look at [this](https://github.com/laracasts/flash#usage).

# Mailer
 
We override Mailer class for headers support.
To provide headers in mails just add in .env file for `MAIL_SMTP_HEADERS` variable something like this:

```MAIL_SMTP_HEADERS='{"PROJECT":"cms", "EMAILS":"your_mail@gmail.com"}'```

# Minify css and js files

For minifying css and js files we use [gulp](https://github.com/gulpjs/gulp/tree/4.0).

# Dynamic crud maker

See [here](https://github.com/appzcoder/crud-generator) how to use package. It's already implemented. Just run
commands in command line.

# Admin panel

We use [Adminlte](https://almsaeedstudio.com/themes/AdminLTE/index2.html).

# Testing

Run in command line, from project root `./vendor/bin/phpunit`

# License

GNU AFFERO GENERAL PUBLIC LICENSE

Laravel CMF Is A PHP CMF Powered By Laravel 5.3 And Sentinel based on Graham Campbell's Bootstrap CMS 

Copyright (C) 2017 Nix Solutions

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see http://www.gnu.org/licenses/.
