![LT3 theme screenshot](https://raw.github.com/beaucharman/lt3/master/screenshot.png "A slightly powerfull, intelligent and simple WordPress theme.")
## Change Log
1.0
- Changing the elegant theme over to a more modulated theme, now lt3

2.0
- Initial theme setup functionality, found in library/extensions/initial-theme-setup.php

## Roadmap [Todo list]
- Default margin issue with entry content from a type point of view
- Split up the theme-functions.php file into modules
- WordPress editor styles + instructions
- Work on default comment styles
- spacing in library / core files
- set up editor styles as a sass directory
- have conditional h1 tags
- replace most / relavent functions with hooks
- clean up shortcode.js

## Testing
Run http://codex.wordpress.org/Theme_Unit_Test thoroughly :)

## Notes for Production

- **Limit login attempts - plugin**

- **Strong Passwords**

- **Complex Database Prefix**

- **.htaccess file for install root**

- **.htaccess with Options -Indexes for wp-content**

```
  Order deny,allow
  Deny from all
  <Files ~ ".(xml|css|jpe?g|png|gif|js)$">
  Allow from all
  </Files>
```
- **Disallow Theme and Plug-in Editor Access**

Within the wp-config.php file, place the following code:

```
  define('DISALLOW_FILE_EDIT', true);
```

- **Enforce SSL Usage

Within the wp-config.php file, place the following code:

```
  /* Enable SSL Encryption */
  define(‘FORCE_SSL_LOGIN’, true);
  define(‘FORCE_SSL_ADMIN’, true);
```
