# framework
In the application using this framework make sure that the file /public/index.php contains these constants definitons:<br><br>
define('PUB_PATH', __DIR__.'/');<br>
define('APP_PATH', dirname(__DIR__) . '/src/');

Also make src/cache directory writable for your server.