<?php 
require('includes/config.inc.php');

 $query="SELECT * FROM projects";


 $result = mysqli_query($db,$query)
                 or die(mysqli_error($db)
                    .'<br>'
                    .$query);



/*
$statement = $db-> prepare('SELECT title ,filename FROM gallery_images ORDER BY uploaded_date DESC');


  $statement -> execute();
  $statement->bind_result($title,$filename);

while($statement->fetch())
*/



?>




<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Amisha Prajapati -Portfolio Site</title>
        
        <!-- link to the main stylesheet -->
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
        
        <!--[if lt IE 9]>
	    <script src="js/html5shiv.min.js"></script>
        <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

         <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

       <!-- animate -->
       <!-- animate -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>

        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    

    <link href="css/animate.css" rel="stylesheet"/>

    <link href="css/waypoints.css" rel="stylesheet"/>

    <script src="js/jquery.waypoints.min.js" type="text/javascript"></script>


    <script src="js/waypoints.js" type="text/javascript"></script>
    
    <!-- filtering -->
     <script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
 


        <script src="js/functionality.js"></script>



        <link rel="stylesheet" href="css/style.css" />
		
                <!-- Fonts CSS -->
        <link href="fonts/AvenirNext-Regular/styles.css" rel="stylesheet">
        

    </head>
    <body>

        <div class="pimg1">
<div class="ptext1 black">
             <header id="site-header" class="header">
                <div class="container">
                    <div class="row ">
                                 <div class="col-lg-2 col-md-4 logo-img">
                                   <div class="menu-icon">
                                      <i class="fa fa-bars fa-2x"></i>
                                   </div>


                                    <a href="#" >
                                        <img class="logo" src="images/logo/Logo.svg" alt="niyami media"/>
                                    </a>
                                </div>
                                <div class="col-lg-10 col-md-8 ">
                                        <nav id="site-nav">

                                          <ul>
                                            <li><a href="#">Home</a></li>
                                            <li><a href="#about">About </a></li>
                                            <li><a href="#service">Service</a></li>
                                            <li><a href="#work">Work</a></li>
                                            
                                            <li><a href="#contact">Contact</a></li>

                                 
                                            </ul>
                                        </nav> 
                                        
                               </div>
                   </div>
                   
                       
                </div>
            </header>
        </div>