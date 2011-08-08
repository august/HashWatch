<?php

// for security reasons, we recommend you keep this file outside the Document Root

require_once('../HashWatch.php');

// the config file is best stored outside the Document Root
// but we're cheating here
$hw = new HashWatch('./config.HashWatch.php'); 

$hw->buildHashes();