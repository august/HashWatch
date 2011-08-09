HashWatch PHP Class
===================

The HashWatch class is designed to let you monitor files and folders on your website for tampering from hackers. HashWatch will watch the hashes of any file you choose, and you can then take action if any of those files change without your knowledge.

This most often happens with .htaccess and index.php files, but HashWatch can monitor any file or folder you feel is important to maintain the integrity of. Adding more files to be monitored is as easy as updating the config file.

Obviously, you don't want to watch folders that intentionally change (upload folders, cache folders, etc.).

This class was originally inspired by Sameer Borate in his post [Checking your site for malicious changes](http://www.codediesel.com/security/checking-your-site-for-malicious-changes/).


Copyright 2011, August Trometer, [@August](http://twitter.com/august)

Licensed under the MIT License.
Redistributions of files must retain the above copyright notice.


Getting started
---------------

Setup is simple:

1. Create a folder to store the hashed values. This must be writable by PHP
2. Create a config file (example included)

<br/>
To create and store the hashes:

    <?php
    
    $hw = new HashWatch('path/to/config.HashWatch.php');
    $hw->buildHashes();
    
    
<br/>
To check the current files agains the stored hashes:

    <?php
    
    $hw = new HashWatch('path/to/config.HashWatch.php');
    $warnings = $hw->compareHashes();
    
    if (!empty($warnings)) {
    
        // Send emails, text messages, etc.
        
    }


Configuration
-------------

Configuration is easy. The config file has only two parameters, *$paths\_to\_watch* and *$hash\_folder\_path*. A sample config file is included in this repository.


Usage
-----

Every time you update your site, simply run a script that builds the hashes for your files. This could be done either manually or as part of a deploy script. Then, set up a cron process that runs a script to check the stored hashes against the ones of your files.

Example scripts in the **example** folder included in this repository.


Security
--------

Obviously, if a hacker can access your Document Root, they can disable any hash checking you are doing. For that reason, we recommend you keep all HashWatch documents outside the Document Root. This includes the Class itself, the config file, the hashes folder, and any scripts you're using to build or check the hashes.


Other Notes
-----------
Certainly, this isn't a perfect solution, and it's not 100% secure. But it should be enough to thwart all but the most persistent hacker and alert you if something has changed on your site. 

Contributions are more than welcome, so please fork, improve, and merge. Thanks!