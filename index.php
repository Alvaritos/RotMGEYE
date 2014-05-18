<?php

// Start System -> Autoloader

require_once __DIR__.'/bootstrap/autoload.php';

// Start System -> INIT -> Load Route and map to Controller

require_once __DIR__.'/bootstrap/start.php';

$app = new App();
