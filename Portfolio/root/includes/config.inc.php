<?php

    /**
     * PHP Settings
     */
    // show all errors, but not the notices
    error_reporting( E_ALL & ~E_NOTICE );
    // show errors in the browser
    ini_set( 'display_errors', 1 );

    /**
     * File Upload Settings
     */

    define( 'UPLOADS_FOLDER', 'upload/' );

    define( 'SMALL_FOLDER', UPLOADS_FOLDER.'small/' );
  
    define( 'MEDIUM_FOLDER', UPLOADS_FOLDER.'medium/' );

    define( 'LARGE_FOLDER', UPLOADS_FOLDER.'large/' );

    define( 'ALLOWED_FILE_TYPES', 'image/png,image/gif,image/jpeg,image/pjpeg' );

    define('RANDOMIZE_FILENAMES','true');
    $mime_to_extension = array(
      'image/jpeg'=>'.jpg',
      'image/pjpeg'=>'jpg',
      'image/gif'=>'gif',
      'image/png'=>'png'



    );

define( 'DB_HOST',      'localhost' );
    define( 'DB_USER',      'root' );
    define( 'DB_PASSWORD',  'root' );
    define( 'DB_NAME',      'amisha-portfolio' );

    // connect to mysql server
    $db = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME )
        or die( mysqli_connect_error() );


