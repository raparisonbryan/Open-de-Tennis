<html lang="fr">

	<head>
		<link href="" rel="stylesheet">
		<meta charset="utf-8">
		<title>Billeterie</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css" />
	</head>

    <header>
        <div class="logo">
            <img id="logo__img" src="image/OPENPARC_LOGO.jpg" alt="logo tennis">
        </div>
        <nav class="navbar">
            <div class="navbar__left">
                <a href="#">Programme</a>
                <a href="#">Billeterie</a>
            </div>
            <div class="navbar__right">
                <a href="#">Se connecter</a>
            </div>

        </nav>

    </header>

	<body>
        <?php
            if (isset($_POST['submit-type'])) {
                $type=htmlspecialchars($_POST['type']);
                $nbTickets=htmlspecialchars($_POST['nbTickets']);
                $categorie=htmlspecialchars($_POST['categorie']); //mise en place de la memoire entre submits et des types pour htmlspechars
            }
        ?>
        <div class="stadium_image">
            <img class="stadium" src="image/open-parc-plan-stade-3d.png">
        </div>

		<form action="" method="post">
            <div class="billet">
                <div class="type_billet">
                    <label class="billet_text" for="type_select">Type de billet choisi :</label>
                    <p>
                        <select name="type" class="type_select">
                            <option value="billeterie_grandPublic" <?php if (isset($type) && $type=="billeterie_grandPublic") echo "selected";?>>Grand public</option>
                            <option value="billeterie_licencie" <?php if (isset($type) && $type=="billeterie_licencie") echo "selected";?>>Licencié</option>
                            <option value="billeterie_association" <?php if (isset($type) && $type=="billeterie_association") echo "selected";?>>Association</option>
                        </select>
                    </p>
                </div>

                <div class="categorie_billet">
                    <label class="billet_text" for="categorie_select">Categorie de place :</label>
                    <p>
                        <select name="categorie" class="categorie_select">
                            <option value="1" <?php if (isset($categorie) && $categorie=="1") echo "selected";?>>Categorie 3</option>
                            <option value="2" <?php if (isset($categorie) && $categorie=="2") echo "selected";?>>Categorie 2</option>
                            <option value="3" <?php if (isset($categorie) && $categorie=="3") echo "selected";?>>Categorie 1</option>
                        </select>
                    </p>
                </div>

                <div class="nombre_billet">
                    <label class="billet_text" for="nbTickets">Nombre de tickets :</label>
                        <p>
                            <input type="number" class="nbTickets" name="nbTickets"  value="<?php echo htmlspecialchars($_POST['nbTickets'], ENT_QUOTES);?>">
                        </p>
                </div>
                <?php
                //si licence choisie : envoyer un potit form
                 if (isset($_POST['submit-type']) && $type=='billeterie_licencie') {
                     echo '
                    <div class="licence_billet">
                        <label class="licencie_billet_text" for="licence_input">veuillez entrer votre numero de licence :</label>
                            <p>
                            <input class="licencie_billet_input" type="text" id="licence_input" name="licence_input">
                            </p>
                    </div>
                     ';
                    if(isset($_POST['licence_input'])){ //quand licence inseree faire le truc un peu bien
                    $licence_input=htmlspecialchars($_POST['licence_input']);
                    }
                 }
                 ?>
                <div class="valider_billet">
                    <input class="valider_billet_text" type="submit" value="Valider" name="submit-type">
                </div>
            </div>

		</form>


        <footer class="footer-basic">
            <div class="social">
                <a class="noborder" href="#"><img class="insta" src="image/instalogo.png" alt=""></img></a>
                <a class="noborder" href="#"><img class="fb" src="image/fblogo.png" alt=""></img></a>
                <a class="noborder"href="#"><img class="insta" src="image/twitterlogo.png" alt=""></img></a>
                <a class="noborder"href="#"><img class="insta" src="image/snaplogo.png" alt=""></img></a>
            </div>
            <ul class="list-inline">
                <li class="list-inline-item"><a class="noborder" href="#">Home</a></li>
                <li class="list-inline-item"><a class="noborder" href="#">Services</a></li>
                <li class="list-inline-item"><a class="noborder" href="#">About</a></li>
                <li class="list-inline-item"><a class="noborder" href="#">Terms</a></li>
                <li class="list-inline-item"><a class="noborder" href="#">Privacy Policy</a></li>
            </ul>
            <p class="copyright">Open tennis Auvergne Rhône Alpes 2022</p>
        </footer>




		<?php
		 function connectDb(){
			  $host = 'localhost'; // ou sql.hebergeur.com
			  $user = 'p2000616';      // ou login
			  $pwd = '561912';      // ou xxxxxx
			  $db = 'p2000616';
		  try {
			   $bdd = new PDO('mysql:host='.$host.';dbname='.$db.
							  ';charset=utf8', $user, $pwd,
						  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			   return $bdd;
			  } catch (Exception $e) {
			   exit('Erreur : '.$e->getMessage());
		  }
		 }
		 
		 if (isset($_POST['submit-type'])&&isset($_POST['match'])) {//gestion classique
		 $bdd = connectDb(); //connexion a la DB
			 if($type=='licence'){ //gestion licences
					 if(($type=='billeterie_licencie' && isset($licence_input)) ){ //test si licence valide a ete inseree si cat licence choisie
							  $query = $bdd->prepare("select id from licences;"); // requête SQL
							  $query->execute();
							  $verification=0;
							  
							  
							  if(($zaegyuazey=$query -> rowCount ())>0){
								while ($data = $query->fetch()) // lecture par ligne
								{
									
									if($_POST['licence_input']==$data[0]){
										$verification=1;
									}
									
									
								 }
							}
							 // fin des données
							 $query->closeCursor();
							  if ($verification!=1){
								  
								  die("met une licence valide dog + ratio");
							  }
						  }
					  else{
						  die("veuillez mettre une licence valide messir/madame </br> salutations distingués"); //si ils ont juste choisi licence ca reste poli
					  }
				}
			
			//affichage des tickets dispo
			 $query = $bdd->prepare("select * from billets where type='$type' and categorie=$categorie;"); // requête SQL
			 $query->execute(); // paramètres et exécution
			 if(($zaegyuazey=$query -> rowCount ())>0){
				 while ($data = $query->fetch()) // lecture par ligne
				 {
					
						echo "$data[0] $data[1] $data[2] $data[3]<br />";
					
					
				 }
			 }
			 // fin des données
			 $query->closeCursor();
		 }
		?>
	</body>
</html>



