<?php

// $paths_to_watch is an array of paths to the files and directories
// you want monitored. Order is not important.

$paths_to_watch = array(

    './file_1.php',
    './somefolder',
    
);

// The $hash_folder_path is the path where you want HashWatcher to store all of the 
// generated hashes for comparison. For security reasons, this should be outside
// your document root. In addition, you need to make sure PHP can write to this folder.

$hash_folder_path = './hashes';