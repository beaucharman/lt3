![LT3 theme screenshot]('https://raw.github.com/beaucharman/lt3/master/screenshot.png' "A slightly powerfull, intelligent and simple WordPress theme.")
## Change Log

## Roadmap [Todo list]
- Style sheet - Finish setting up and add some defaults
- Finish custom post type file
- Finish custom meta field file
- Default margin issue with entry content from a type point of view
- Split up the theme-functions.php file into modules
- WordPress editor styles + instructions
- Look into theme setup functionality
- Work on default comment styles
- spacing in library / core files

## Testing

Run http://codex.wordpress.org/Theme_Unit_Test thoroughly :)

## Notes for Production

### Limit login attempts - plugin

### Strong Passwords

### Complex Database Prefix

### .htaccess file for install root

#### .htaccess with Options -Indexes for wp-content
```
  Order deny,allow
  Deny from all
  <Files ~ ".(xml|css|jpe?g|png|gif|js)$">
  Allow from all
  </Files>
```
#### Disallow Theme and Plug-in Editor Access
Within the wp-config.php file, place the following code:
```
  define('DISALLOW_FILE_EDIT', true);
```

#### Enforce SSL Usage
Within the wp-config.php file, place the following code:
```
  /* Enable SSL Encryption */
  define(‘FORCE_SSL_LOGIN’, true);
  define(‘FORCE_SSL_ADMIN’, true);
```
