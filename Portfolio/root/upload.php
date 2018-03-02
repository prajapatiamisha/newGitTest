<?php

    require( 'includes/config.inc.php' );
    require( 'includes/function.php' );

    /*echo '<pre>';
    print_r( $_FILES );
    echo '</pre>'; */
    $errors = array();
    if( isset( $_POST[ 'upload-started' ] ) ){
        // form has been submitted
        
        if( strlen( $_POST[ 'project_name' ] ) < 1 ){
            $errors[ 'project_name' ] = '<p class="error">Please enter a project name for the project</p>';
        }

        //  if( strlen( $_POST[ 'project_live_url' ] ) < 1 ){
        //     $errors[ 'project_live_url' ] = '<p class="error">Please enter a project live url for the project.</p>';
        // }
        //  if( strlen( $_POST[ 'project_description' ] ) < 1 ){
        //     $errors[ 'project_description' ] = '<p class="error">Please enter a project descriptin  for the project</p>';
        // }
        //  if( strlen( $_POST[ 'project_technology' ] ) < 1 ){
        //     $errors[ 'project_technology' ] = '<p class="error">Please enter a project technology for the project</p>';
        // }
        //  if( strlen( $_POST[ 'project_category' ] ) < 1 ){
        //     $errors[ 'project_category' ] = '<p class="error">Please enter a project category for the project</p>';
        // }
        




        else {
            if( $_FILES[ 'user-upload' ][ 'error' ] == UPLOAD_ERR_OK ){
                // the file uploaded successfully to the temp folder

                // current location of the file (temporary folder and filename)
                $temp_location = $_FILES[ 'user-upload' ][ 'tmp_name' ];

                // retrieve image-specific information about the uploaded file
                // Note: if you want to upload non-images, this needs to be
                // changed to mime_content_type()
                $info = getimagesize( $temp_location );

                if( strpos( ALLOWED_FILE_TYPES, $info[ 'mime' ] ) !== false ){
                // the file's MIME type matched one of the types in our
                // ALLOWED_FILE_TYPES constant

                    if( RANDOMIZE_FILENAMES ){
                        // generate a filename, based on time and original filename
                        // use a hash to get a filename-safe string
                        $filename 
                            = sha1( microtime() . $_FILES[ 'user-upload' ][ 'name' ] );
                        // get the correct extension for the file, from MIME type
                        $extension = $mime_to_extension[ $info[ 'mime' ] ];
                        // assemble into a complete file path to the new file
                        $destination = UPLOADS_FOLDER . $filename . $extension;
                    } else {
                        // new folder combined with original filename
                        $destination = UPLOADS_FOLDER . $_FILES[ 'user-upload' ][ 'name' ];
                    }

                    // attempt to move the file from the temp folder to the
                    // new file path that was generated above
                    if( move_uploaded_file( $temp_location, $destination ) ){

                        $small  = resize_to_fit( $destination, 150, SMALL_FOLDER );
                        $medium = resize_to_fit( $destination, 500, MEDIUM_FOLDER );
                        $large  = resize_to_fit( $destination, 940, LARGE_FOLDER );

                        // file was moved successfully
                        $preview = 
                            "<h2>Your image was Successfully Uploaded.</h2>
                             <a href=\"$destination\">
                                <img src=\"$medium\" alt=\"medium preview\" />
                             </a>";
                        
                        // gather the needed info
                        $project_name =  $_POST[ 'project_name' ];
                        $project_live_url = $_POST['project_live_url'];
                        $project_description =$_POST['project_description'];
                        $project_technology =$_POST['project_technology'];
                        $project_category=$_POST['project_category'];
                        $project_site_url = $_POST['project_site_url'];







                    
                        $filename       = str_replace( UPLOADS_FOLDER, 
                                                       '', 
                                                       $destination );
                        
                        // sanitize the info
                        $project_name   = sanitize( $db, $project_name);
                        $project_live_url = sanitize( $db, $project_live_url);
                        $project_description = sanitize( $db, $project_description);
                        $project_technology= sanitize( $db, $project_technology);
                        $project_category= sanitize( $db,$project_category);
                        $project_site_url = sanitize($db,$project_site_url);
 





$filename    = sanitize( $db, $filename );
$query="INSERT INTO projects(project_name,project_live_url,project_image,project_description,project_technology,project_category,project_site_url)
            VALUES('$project_name','$project_live_url','$filename','$project_description','$project_technology','$project_category','$project_site_url')";
$result = mysqli_query( $db, $query )
                            or die( mysqli_error( $db ) 
                                    . '<br>' 
                                    . $query ) ;
                        
                        // $statement = $db->prepare( 'INSERT INTO 
                        //                                 (
                        //                                     , 
                        //                                     description, 
                        //                                     filename
                        //                                 ) VALUES(?,?,?)' );
                        // $statement->bind_param( 'sss', 
                        //                         $title, 
                        //                         $description, 
                        //                         $filename );
                        
                        // if( $statement->execute() ){
                        //     $_POST[ 'title' ]       = '';
                        //     $_POST[ 'description' ] = '';
                        // } else {
                        //     // an error occurred, probably due to
                        //     // the parameters
                        // }
                        
                        // $statement->close();
                        
                    } else {
                        // likely causes:
                        // - missing uploads folder
                        // - permissions of folder are wrong
                        // - destination filename is garbled up somehow
                        $errors[ 'upload' ] = '<p class="error">
                            There was a problem saving the file;
                            please contact the administrator.
                        </p>';
                    }

                } else {

                    $errors[ 'upload' ] = '<p class="error">
                            The file uploaded is not one of the allowed
                            file types: gif, jpeg or png.
                        </p>';
                }

            } else {

                // there was some kind of server error

                switch( $_FILES[ 'user-upload' ][ 'error' ] ){
                    case UPLOAD_ERR_INI_SIZE:
                        $errors[ 'upload' ] = '<p class="error">
                            The uploaded file exceeds the
                            maximum allowed file size of ' 
                            . ini_get( 'upload_max_filesize' ) 
                            . ' </p>';
                    break;
                    case UPLOAD_ERR_NO_FILE:
                        $errors[ 'upload' ] = '<p class="error">
                            Please select a file to upload.</p>';
                    break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $errors[ 'upload' ] = '<p class="error">
                            The server was unable to save the uploaded file.</p>';
                    break;
                    case UPLOAD_ERR_PARTIAL:
                        $errors[ 'upload' ] = '<p class="error">
                            The file was only partially uploaded.</p>';
                    break;
                    default:
                        $errors[ 'upload' ] = '<p class="error">
                            There was a server issue in uploading the file.</p>';
                    break;
                }
            }
        }
    }

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Upload Portfolio</title>
        
        <!-- link to the main stylesheet -->
        <link rel="stylesheet" href="css/upload-style.css" />
        
        <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav>
            <ul>
              
               <li><a href="index.php">< Back</a></li>
            </ul>
        </nav>


        
        <?php 
            if( isset( $preview ) ){
                echo $preview;
            }
        ?>
        <p>Maximum file size for upload: 
            <?php echo ini_get( 'upload_max_filesize' ); ?>
        </p>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" 
              method="post"
              enctype="multipart/form-data">

            <?php echo $errors[ 'upload' ]; ?>

            <input type="hidden" name="upload-started" value="true" />

            <ol>
                <li>
                    <label>project name</label>
                    <?php echo $errors[ 'project_name' ]; ?>
                    <input type="text" name="project_name" size="80" 
                           value="<?php echo $_POST[ 'project_name' ]; ?>" />
                </li>
                <li>
                    <label>project live url</label>
                    <?php echo $errors['project_live_url']; ?>
                    <input type="text" name="project_live_url" value="<?php echo $_POST[ 'project_live_url' ]; ?>"/>
                </li>
                
                 <li>
                    <label>Description</label>
                    <textarea name="project_description" rows="6" cols="80"><?php 
                        echo $_POST[ 'project_description' ];
                    ?></textarea>
                </li>
                <li>
                    <label>project technology</label>
                    <?php echo $errors[ 'project_technology' ]; ?>
                    <input type="text" name="project_technology" size="80" 
                           value="<?php echo $_POST[ 'project_technology' ]; ?>" />


                </li>
                <li>
                    <label>project category</label>
                    <?php echo $errors[ 'project_technology' ]; ?>
                    <input type="text" name="project_technology" size="80" 
                           value="<?php echo $_POST[ 'project_technology' ]; ?>" />





                </li>
                 <li>
                    <label>project description page url</label>
                    <?php echo $errors[ 'project_site_url' ]; ?>
                    <input type="text" name="project_site_url" size="80" 
                           value="<?php echo $_POST[ 'project_site_url' ]; ?>" />





                </li>



                


                
                <li>
                    <input type="file" name="user-upload" />
                </li>
                <li>
                    <input type="submit" value="Upload" />
                </li>
            </ol>
        </form>
    </body>
</html>
