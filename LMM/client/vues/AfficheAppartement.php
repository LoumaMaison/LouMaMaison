<!--
* @file         AfficheAppartement.php
* @brief        Projet WEB 2
* @details      Affichage de profil d'usager - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<?php              
    //$messagerie = (isset($_SESSION["username"]) && $_SESSION["username"] == $data["usager"]->getUsername()) ? "Messagerie" : "Contacter";
 ?>


<div class="container detailAppartement">
    
    <!-- Modal du carousel de photos -->
    <div class="modal fade" id="modalGaleriePhoto" tabindex="-1" role="dialog" aria-labelledby="modalPhotoSupp" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <div class="pull-left">Galerie de photos</div>
            <h4 class="modal-title" id="myModalLabel"><?= $data['appartement']->getTitre() ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          
          <div class="modal-body">
             
            <!--begin carousel-->
            <div id="maGalerie" class="carousel slide" data-ride="false">
                
                <ol class="carousel-indicators">                   
                <?php
                    $nbrP = 0;
					foreach($data["tab_photos"] as $photo) {
                                
                        if($nbrP==0) {
				?>                  
                        <li data-target="#maGalerie" data-slide-to="0" class="active"></li>                    
                    <?php
                        } else {
				    ?>                      
                        <li data-target="#maGalerie" data-slide-to="<?= $nbrP ?>"></li>
				<?php
                        }
                        $nbrP++;
                    }
                    reset($data["tab_photos"]);
				?>                  
                </ol>
              
              <div class="carousel-inner" role="listbox">

                <?php
                    $nbrP = 0;
					foreach($data["tab_photos"] as $photo) {
                                
                        if($nbrP==0) {
				?>
                  
                        <div class="carousel-item active"> 
                            <img src="<?= $photo['photoSupp'] ?>" class="d-block img img-fluid" alt="photoGalerie<?= $nbrP ?>">
                            <!--
                            <div class="carousel-caption">
                                <h3>Heading 3</h3>
                                <p>Photo numéro <?= $nbrP ?></p>
                            </div>
                            -->
                        </div>
                  
                    <?php
                        } else {
				    ?>    
                  
                        <div class="carousel-item"> 
                            <img src="<?= $photo['photoSupp'] ?>" class="d-block img img-fluid" alt="photoGalerie<?= $nbrP ?>">
                            <!--
                            <div class="carousel-caption">
                                <h3>Heading 3</h3>
                                <p>Photo numéro <?= $nbrP ?></p>
                            </div>
                            -->
                        </div>

				<?php
                        }
                        $nbrP++;
                    }
                    reset($data["tab_photos"]);
				?>  
                            
                <!--end carousel-inner-->
              </div>
                
              <!--Begin Previous and Next buttons-->
              <a class="carousel-control-prev" href="#maGalerie" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </a> 
              <a class="carousel-control-next" href="#maGalerie" role="button" data-slide="next"> 
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </a>
            
            <!--end carousel-->
            </div>              

          
          <!-- end modal-body -->
          </div>
          
          <div class="modal-footer">
            <div class="pull-left"><small>Photographies par le propriétaire</small></div>
            <button type="button" class="btn-sm btn-default" data-dismiss="modal">Fermer</button>
          </div>
            
        <!-- end modal-content -->
        </div>
    
      <!-- end modal-dialog -->
      </div>
    
    <!--end modal -->
    </div>
    

    <section class="row sectionAptPhoto">
        
		<!-- Affichage des messages a l'usager -->
        <div class="col-sm-12 succes_erreur">            
        </div>
        
		<!-- Affichage des photos de l'appartement -->
        <div class="col-sm-12 photo_principale">
		
			<h1>Affichage d'un appartement</h1>
		
			<!-- Affichage de la photo principale -->
			<div>
                <div id="photoPrincipale">
                    <img src="<?= $data['appartement']->getPhotoPrincipale() ?>" class="photoPrincipale img img-fluid">
                </div>
            </div>

			<!-- Affichage des photos supplementaires -->
			<div class = "row">
				<div class="text-center col-xs-2 col-md-12">
				
				<?php
                    $nbrP = 0;
					foreach($data["tab_photos"] as $photo) {
				?>
						<div class="d-inline" data-toggle="modal" data-target="#modalGaleriePhoto">
                            <a href="#maGalerie" data-slide-to="<?= $nbrP ?>">
                                <img src="<?= $photo['photoSupp'] ?>" style="width: 100px; height: 75px" class="photoSupplementaire img-thumbnail img-fluid" alt="Photo-<?= $nbrP ?>">
                            </a>
						</div>
				<?php
                    $nbrP++;
					}
				?>
				
				</div>

			</div>
			
        </div>

        <!-- Fin row -->    
    </section>
    
    
    <section class="sectionAptDetail d-flex">    
        <div class="sectionAptDetail-g col-sm-8">
            <br>
            <div class="row justify-content-between">
                <div class="d-inline">
                    <h6><?= $data['typeApt'][0]['typeApt']; ?></h6>
                    <h2><?= $data['appartement']->getTitre(); ?></h2>
                    <h4><?= $data['quartier'][0]['nomQuartier']; ?></h4>
                    <p>Montréal</p>
                </div>
                <div class="">
                    <div class="text-center align-middle">
                        <!--<img src="<?= $data['proprietaire']->getPhoto(); ?>" style="width: 100px; height: 100px" class="photoProprio rounded-circle img-fluid" alt="PhotoProprio">-->

                        <img src="./images/profil.jpg" style="width: 100px; height: 100px" class="photoProprio rounded-circle img-fluid" alt="PhotoProprio">

                        <p><?= $data['appartement']->getId_userProprio() ?></p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="iconeDescription">
                    <p><i class="fa fa-male fa-lg"></i>&nbsp<?= $data['appartement']->getNbPersonnes(); ?> personnes</p>
                </div>
                <div class="iconeDescription">
                    <p><i class="fa fa-square-o fa-lg"></i>&nbsp<?= $data['appartement']->getNbChambres(); ?> chambres</p>
                </div>
                <div class="iconeDescription">
                    <p><i class="fa fa-bed fa-lg"></i>&nbsp<?= $data['appartement']->getNbLits(); ?> lits</p>
                </div>
                <div class="iconeDescription">
                    <p><i class="fa fa-bath fa-lg"></i>&nbsp1 salle de bain</p>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <p><?= $data['appartement']->getDescriptif(); ?></p>
            </div>
            
            <div class="row">
                <button type='button' id='btnContactProprio' onclick='???' class='btnContactProprio btn btn-primary btn-lg'>Contacter l'hôte</button>
            </div>
            
            <hr>
            
            <div class="row">
                <h5>Équipement</h5>
            </div>
            
            <hr>
            
            <div class="row">
                <h5>Règlement intérieur</h5>
            </div>
            
            <hr>
            
            <div class="">
                <h5>Annulations</h5>
                <p>Strictes</p>
                <p>...</p>
            </div>
            
            <hr>
            
            <div class="row">
                <h5>Accèssibilité</h5>
            </div>
            
            <hr>
            
            <div class="row">
                <h5>Commentaires</h5>
            </div>
            
        </div>
        
        <div class="sectionAptDetail-d col-sm-4">
            <br>
            <!--
            <pre>
                <?php
                    var_dump($data['tab_dispos']);
                ?>
            </pre>
            -->
            
            <div class="reservation col-sm-12">
                <h4>$<?= $data['appartement']->getMontantParJour(); ?> CAD <small>par jour</small></h4>
                <h6>Ratings</h6>
                <hr>
                
                <!--
                <div class="afficheDisponibilites">
                    <h4 class="text-center">Disponibilités</h4>
                    
                    <?php
                        $nbrD = 0;
				        foreach($data["tab_dispos"] as $dispo) {
                            $nbrD++;
				    ?>
                            <p><?= $nbrD; ?>. Du: <?= $dispo['dateDebut'] ?>  Au: <?= $dispo['dateFin'] ?></p>
				    <?php
					   }
				    ?>
                </div>
                <hr>
                -->
                
                <div class="demandeReservation">
                    <form id="formApt" method="POST" action="index.php?Appartements&action=sauvegarderApt">

                        <!-- Date d'arrivée -->
                        <div class="form-group">
                            <div class="row">
                                <label for="dateArrivee">Date d'arrivée</label>
                                <input type="date" name="dateArrivee" id="dateArrivee" size="8" class="form-control text-muted" aria-describedby="aideDateArrivee">
                                <small class="form-text text-muted" id="aideDateArrivee"></small>
                            </div>
                        </div>

                        <!-- Date de départ -->
                        <div class="form-group">
                            <div class="row">
                                <label for="dateDepart">Date de départ</label>
                                <input type="date" name="dateDepart" id="dateDepart" size="8" class="form-control text-muted" aria-describedby="aideDateDepart">
                                <small class="form-text text-muted" id="aideDateDepart"></small>
                            </div>
                        </div>

                        <!-- Nombre de personnes -->
                        <div class="form-group">
                            <div class="row">
                                <label for="nbPersonnes">Nombre de personnes</label>
                                <select class="form-control text-muted" name="nbPersonnes" id="nbPersonnes" aria-describedby="aideNbPersonnes">
                                    <option selected>Sélectionnez</option>
                                    <?php
                                        for ($i = 1; $i <= $data['appartement']->getNbPersonnes(); $i++) {
                                            echo $i;
                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                        }
                                    ?>         
                                </select>
                                <small class="form-text text-muted" id="aideNbPersonnes"></small>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary btn-block btn-lg" id="inputSubmit" value="Demande de réservation">						
                    </form>
                </div>
                <p class="text-center"><small>Vous ne serez débité que si vous confirmez</small></p>
                <hr>
            </div>
            
        </div>
        

    
        <!-- Fin d-flex -->    
    </section>
    
    <!-- Fin container -->
</div>

 