<?php

    /**
     * Resizes any web image to fit within a bounding box, proportionally.
     * TODO: make GIF transparency work.
     *
     * @param string $original_filename The file path of the image to resize.
     * @param int $size The width and height of the bounding box.
     * @param string $destination_folder The folder to put the resized image into.
     * @param int $quality The quality/compression level, 0 being worst quality but 
     * highest compression and 10 being the best quality and lowest compression.
     *
     * @returns mixed
     */
    function resize_to_fit( $original_filename, 
                            $size, 
                            $destination_folder, 
                            $quality = 10 ){
        
        // determine original width, original height, mime type
        $info = getimagesize( $original_filename );
        
        // store the dimensions of the original image
        $original_width     = $info[ 0 ];
        $original_height    = $info[ 1 ];

        $isGIF = false;
        // read the original file into the web server's memory (RAM)
        switch( $info[ 'mime' ] ){
            case 'image/gif':
                $original = imagecreatefromgif( $original_filename );
                $isGIF = true;
            break;
            case 'image/png':
                $original = imagecreatefrompng( $original_filename );
            break;
            case 'image/jpeg':
            case 'image/pjpeg':
                $original = imagecreatefromjpeg( $original_filename );
            break;
            default:
                return false;
            break;
        }
        
        // calculate the aspect ratio (portrait/landscape/square)
        $aspect_ratio = $original_width / $original_height;
        
        // calculate the dimensions of the new image
        if( $aspect_ratio > 1 ){
            // landscape image
            $new_width  = ceil( $size );
            $new_height = ceil( $size / $aspect_ratio );
        } else {
            // portrait or square
            $new_height = ceil( $size );
            $new_width  = ceil( $size * $aspect_ratio );
        }
        
        /* echo "Width: $original_width <br />
              Height: $original_height <br />
              Aspect Ratio: $aspect_ratio <br />
              New Width: $new_width <br />
              New Height: $new_height <br />"; */
        
        // create an empty image using the new dimensions in memory
        $new_image = imagecreatetruecolor( $new_width, $new_height );
        
        if( !$isGIF ){
            // stop PHP from blending alpha channel with color channels
            // which would result in only opaque pixels (the default)
            imagealphablending( $original, false );
            imagealphablending( $new_image, false );

            // enable the alpha channel so partial transparency
            // can be stored in these images
            imagesavealpha( $original, true );
            imagesavealpha( $new_image, true );
        }
        
        // create a "transparent" colour to fill the new image with
        $transparent = imagecolorallocatealpha( $new_image, 0, 0, 0, 127 );
        
        // flood-fill (like paint bucket) the new image with transparent
        imagefill( $new_image, 0, 0, $transparent );
        
        // copy and resample pixels from original to new image in memory
        if( !imagecopyresampled( $new_image, 
                                 $original,
                                 0, 0,
                                 0, 0,
                                 $new_width,
                                 $new_height,
                                 $original_width,
                                 $original_height ) ){
            imagedestroy( $original );
            imagedestroy( $new_image );
            return false;
        }
        // write the new image to the appropriate folder
        
        // break the path apart into pieces, using '/'
        $file_parts = explode( '/', $original_filename );
        // keep the last item which is the filename
        $full_filename = array_pop( $file_parts );
        // break apart the filename using '.'
        $file_parts = explode( '.', $full_filename );
        array_pop( $file_parts );
        $final_filename = implode( '.', $file_parts );

        $final_file_path = $destination_folder . $final_filename;
        
        switch( $info[ 'mime' ] ){
            case 'image/gif':
                $final_file_path .= '.gif';
                $result = imagegif( $new_image, 
                                    $final_file_path );
            break;
            case 'image/png':
                // convert 0-10 to be 9-0 for the PNG function
                $png_quality = 9 - ( ( $quality / 10 ) * 9 );
                $final_file_path .= '.png';
                $result = imagepng( $new_image,
                                    $final_file_path,
                                    $png_quality );
            break;
            case 'image/jpeg':
            case 'image/pjpeg':
                $final_file_path .= '.jpg';
                $result = imagejpeg( $new_image, 
                                     $final_file_path,
                                     $quality * 10 );
            break;
            default:
                $result = false;
            break;
        }
        
        // release the memory used by the images
        imagedestroy( $original );
        imagedestroy( $new_image );
        
        if( !$result ){
            return false;
        }
        
        return $final_file_path;
    }

    /**
     * Sanitizes a string to make it safe for database entry.
     * 
     * @param resource $db The database connection resource.
     * @param string $string The string to process.
     * @param boolean $strip_tags A flag to disable removal of HTML tags.
     *
     * @return string
     */
    function sanitize( $db, $string, $strip_tags = true ){
        
        $string = trim( $string );
            
        if( $strip_tags ){
            $string = strip_tags( $string );
        }

        $string = mysqli_real_escape_string( $db, $string );
        
        return $string;
    }
