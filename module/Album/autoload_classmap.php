<?php
// As we are in development, we donױt need to load files via the classmap, so we provide an empty array for the classmap autoloader. 
// As this is an empty array, whenever the autoloader looks for a class within the Album namespace, it will fall back to the to StandardAutoloader for us.
// Note**
// Note that as we are using Composer, as an alternative, you could not implement getAutoloaderConfig() and instead 
// add "Application": "module/Application/src" to the psr-0 key in composer.json. If you go this way, then you need 
// to run php composer.phar update to update the composer autoloading files.
return array();