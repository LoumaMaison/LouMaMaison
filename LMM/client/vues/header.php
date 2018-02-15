<!--
* @file       	/header.php
* @brief 		Projet WEB 2
* @details 		
* @author     	Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version    	v.1 | fevrier 2018
-->

<!DOCTYPE html>
<html lang="fr">
    
<head>
<meta charset="UTF-8">
	<title>Projet WEB 2 - Loue ma maison</title>	

	<!-- meta tags requis -->
	<meta charset="UTF-8">
  	<meta name="description" content="ProjetWEB2">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!-- Bootstrap - CSS -->
	<link rel="stylesheet" target=_blank href="http://code.jquery.com/ui/1.8.21/themes/base/jquery-ui.css" type="text/css" media="all" />
	<link rel="stylesheet" target=_blank href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
	<link rel="stylesheet" target=_blank href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" target=_blank href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="css/stylesheet.css" rel="stylesheet">

	<!-- src script js -->
	<script type= "text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="/images/general/blank1.gif" type="text/javascript"></script>
	<script src="/images/general/blank1.gif" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"> </script>
	<script src="https://use.fontawesome.com/e58c171d55.js"></script>
	<script src="./javascript/script.js" ></script>
	<script src="js/formEvt.js"></script>  

</head>
    
<header>
</header>

<body class="container">
    <nav class="navbar sticky-top navbar-toggleable-md navbar-light bg-faded">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="index.php">LE LOGO</a>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
            </li>
      		<?php

			if(isset($_SESSION["username"]) && (in_array(1,$_SESSION["role"])||in_array(2,$_SESSION["role"])) && $_SESSION["isActiv"] ==1)
            {
			?>
			 	<li class="nav-item"><a class="nav-link" href="index.php?Usagers">Usagers</a></li>
			<?php
			}
            else{
                ?>
                <li class="nav-item"><a class="nav-link" href="index.php?Usagers&action=afficherInscriptionUsager">S'inscrire</a></li>
            <?php
            }
			?>
        
	      	<li class="nav-item"><a class="nav-link" href="index.php?Usagers&action=<?=$data['log']?>"><?=$data['log']?></a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?Usagers&action=afficheUsager&idUsager=<?=$_SESSION['username']?>">Profil</a></li>

	    </ul>
          
      </div>
</nav>
	<?=$data['message']?>
	<?=$data['banni']?>
