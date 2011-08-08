<?php

// for security reasons, we recommend you keep this file outside the Document Root

require_once('../HashWatch.php');

// the config file is best stored outside the Document Root
// but we're cheating here
$hw = new HashWatch('./config.HashWatch.php'); 

$messages = $hw->compareHashes();

// if we have messages, we have a file that has been changed (i.e. tampered with)
if (!empty($messages)) {

    // you could email or SMS here, but we'll just echo out
    echo 'DANGER WILL ROBINSON! TAMPERING ALERT!' . PHP_EOL . PHP_EOL . (implode(PHP_EOL,$messages)) . PHP_EOL;

} else {

    echo 'No files have changed. You might want to change one to see what happens.' . PHP_EOL;
}