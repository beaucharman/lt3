![LT3 theme screenshot](https://raw.github.com/beaucharman/lt3/master/lt3/screenshot.png "A slightly powerful, intelligent and simple WordPress theme.")

> A slightly powerful, intelligent and simple WordPress theme.


### Feature

- **Modulated file structure**
- **Security measures**
- Extendable and immediately useful wp-config-sample.php and .htaccess
- Thoughtful, WordPress project specific helper functions
- Clean and thought out template files, including template partials
- Powerful Custom Post Type class
- Clean functions.php reserved for use constant declarations and modular, project specific file includes
- modernizr.js, respond.js and jquery.js libraries / scripts ready to go if needed



### Documentation

https://github.com/beaucharman/lt3/wiki/_pages



### Todo and issues

https://github.com/beaucharman/lt3/issues

- Adding a controller style system and further dividing models (pre query alterations and cleaner loop calls), controllers (snippets and functions to render abstracted segments) and views (templates files and template partials).
- Remove unnecessary files and functions - general clean up.



### Testing

Run http://codex.wordpress.org/Theme_Unit_Test thoroughly :)



### Notes for Production and Security

**Remove unnecessary files**

**readme.html** found in the root directory and **install.php** (located in the /wp-admin folder) are not required, and although **readme.html** is recreated after an update of WordPress, it should be removed - .gitingnore ;) - as it contains sensitive information such as the current version on WordPress.

**Please don't use 'admin' as a user**

Anything else... at all.. even `hackmeplease` is better than `admin`

**Strong passwords, people.**

This goes for FTP, database and WordPress credentials

**Complex database prefix**

None of this wp_ stuff.

**Alter the `.htaccess` file currently in this directory**

It is inspired by the .htaccess file found in http://html5boilerplate.com/, with a few other goodies, bu not all of it is needed for every project.

**Use elements from the `wp-config-sample.php` in this directory as needed... or just the whole thing**

Some nice deployment configurations, house cleaning and security stuff in there.

**.htaccess for the wp-content folder**

Which should contain:

```
# Prevent directory browsing=
Options -Indexes

# Protect all sever side files
Order deny,allow
Deny from all
<Files ~ ".(xml|css|jpe?g|png|gif|js)$">
Allow from all
</Files>
```

**Enforce SSL Usage**

If it is necessary, within the wp-config.php file, place the following code:

```
  /* Enable SSL Encryption */
  define(‘FORCE_SSL_LOGIN’, true);
  define(‘FORCE_SSL_ADMIN’, true);
```

**Keep. WordPress. Updated**

This includes keeping Plugins updated too, maintaining the database, removing spam and even having intelligent nice .gitignore file.
