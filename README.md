![LT3 theme screenshot](https://raw.github.com/beaucharman/lt3/lt3/master/screenshot.png "A slightly powerful, intelligent and simple WordPress theme.")

> A slightly powerful, intelligent and simple WordPress theme.



### Documentation

https://github.com/beaucharman/lt3/wiki/_pages



### Todo and issues

https://github.com/beaucharman/lt3/issues



### Testing

Run http://codex.wordpress.org/Theme_Unit_Test thoroughly :)



### Notes for Production

- **Please don't use 'admin' as a user**

- **Strong passwords, people.**

- **Complex database prefix, none of this wp_ stuff**

- **Place the `.htaccess` file currently in this directory, in the root directory**

- **Use elements from the `wp-config-sample.php` in this directory as needed... or just the whole thing**

- **.htaccess with Options -Indexes for wp-content folder**

```
  Order deny,allow
  Deny from all
  <Files ~ ".(xml|css|jpe?g|png|gif|js)$">
  Allow from all
  </Files>
```

- **Enforce SSL Usage**

Within the wp-config.php file, place the following code:

```
  /* Enable SSL Encryption */
  define(‘FORCE_SSL_LOGIN’, true);
  define(‘FORCE_SSL_ADMIN’, true);
```
