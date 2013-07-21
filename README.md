![LT3 theme screenshot](https://raw.github.com/beaucharman/lt3/master/screenshot.png "A slightly powerful, intelligent and simple WordPress theme.")

> A slightly powerful, intelligent and simple WordPress theme.



### Documentation

https://github.com/beaucharman/lt3/wiki/_pages



### Todo, and issues

https://github.com/beaucharman/lt3/issues



### Testing

Run http://codex.wordpress.org/Theme_Unit_Test thoroughly :)



### Notes for Production

- **Limit login attempts - plugin**

- **Strong Passwords**

- **Complex Database Prefix**

- **Place the .htaccess file currently in this directory, in the root directory**

- **.htaccess with Options -Indexes for wp-content folder**

```
  Order deny,allow
  Deny from all
  <Files ~ ".(xml|css|jpe?g|png|gif|js)$">
  Allow from all
  </Files>
```
- **Disallow Theme and Plug-in Editor Access [If used, remove reference from library/project/config]**

Within the wp-config.php file, place the following code:

```
  define('DISALLOW_FILE_EDIT', true);
```

- **Enforce SSL Usage**

Within the wp-config.php file, place the following code:

```
  /* Enable SSL Encryption */
  define(‘FORCE_SSL_LOGIN’, true);
  define(‘FORCE_SSL_ADMIN’, true);
```
