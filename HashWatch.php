<?php

/*

Copyright (C) 2011 by August Trometer

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

/**
 * HashWatch class
 *
 * Assists in watching the sha1 hash of files so you can 
 * monitor for hacking and intrusion attempts
 * 
 */
class HashWatch {

    private $paths_to_watch = array();
    private $hash_folder_path;

    /**
     * __construct function
     * 
     * @access public
     * @param mixed $path_to_config_file The path to the HashWatch config file
     * @return void
     */
    function __construct($path_to_config_file) {
    
        include($path_to_config_file);
        
        // store the information from the config file
        $this->paths_to_watch = $paths_to_watch;
        $this->hash_folder_path = realpath($hash_folder_path) . '/'; 
        
    } // __construct()
    
    
    /**
     * Builds the hashes of all of the specified files and directories
     * 
     * @access public
     * @return bool TRUE on success, FALSE if there was a problem
     */
    public function buildHashes($cleanup = true) {
        
        if (!is_writable($this->hash_folder_path))
            throw new Exception('Cannot write hashes to specified Hash Directory: ' . $this->hash_folder_path);
            
        $success = true;
        
        // if $cleanup is specified (the default), remove all the files in the hashes folder
        $dir = dir($this->hash_folder_path);
        while (false !== ($file = $dir->read())) {
            unlink($this->hash_folder_path . $file);
        }
        
        // loop through each of the file paths
        foreach ($this->paths_to_watch as $path) {
        
            // get the hash using the custom sha1_path function
            $hash = sha1_path($path);
        
            // get the hash of the path string itself
            // we'll use this as the stored hash filename
            $file = sha1($path);
            
            // store the hash in the hash folder
            $success = $success && file_put_contents($this->hash_folder_path . $file, $hash);
        }
    
        return $success;
        
    } // buildHashes()
    
    
    /**
     * Compares the stored hashes against the current hash values 
     * for the specified paths.
     * 
     * @access public
     * @return array An array of messages regarding any mismatched hashes
     */
    public function compareHashes() {
        
        $messages = array();
        
        foreach ($this->paths_to_watch as $path) {
        
            // get the hash of the current file/directory at this path
            $current_hash = sha1_path($path);
            
            // get the hash of the path string itself
            $file = sha1($path);
            
            // get the stored hash value
            $validation_hash = file_get_contents($this->hash_folder_path . $file);
            
            // compare the two and add a message if necessary
            if ($current_hash != $validation_hash)
                $messages[] = 'A file has been modified at the path: ' . $path;
        }
        
        return $messages;
    }

} // class HashWatch


/**
 * Generates a sha1 hash of a file or directory at the given path.
 * If the path is to a single file, it uses sha1_file. Otherwise, it 
 * recursively loops through all files in a directory to generate the hash.
 * 
 * @param string $path - the path of the folder or file
 * @return string
 */
function sha1_path($path) {

    // just sha1_file for regular files
    if (!is_dir($path))
        return sha1_file($path);
    
    $hashes = array(); // an array to store the hash values
    
    $dir = dir($path);

    // loop through the directory, recusively building an array
    // of all the hashes contained within
    while (false !== ($file = $dir->read())) {
    
        // make sure we don't use . or ..
        if (!in_array($file,array('.','..'))) {
        
            // get the hash of this path and add it to our array
            $hashes[] = sha1_path($path . '/' . $file);
        }
    }
    
    $dir->close();
    
    // combine all the hashes, then hash that for the final value
    return 'folder-' . sha1(implode('-', $hashes));

} // sha1_path()
