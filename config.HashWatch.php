<?php

// $paths_to_watch is an array of paths to the files and directories
// you want monitored. Order is not important.

$paths_to_watch = array(

    '/path/to/file/1',
    '/path/to/file/2',
    '/path/to/file/3',
    
);

// The $hash_folder_path is the path where you want HashWatcher to store all of the 
// generated hashes for comparison. For security reasons, it is recommended that this is
// outside your Document Root. In addition, you need to make sure PHP has permission to write
// to this 

$hash_folder_path = '/path/to/some/folder';