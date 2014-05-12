<?php

/* Best Practice: keep database connection and other authentication information in a separate file
Allows it to be excluded from version control, and also makes it easy to supply alternate
configs as needed for dev/qa/production versions */

$db['dsn'] = 'mysql:host=localhost;dbname=videos';
$db['username'] = 'root';
$db['password'] = 'root';