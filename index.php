<?php

    //$bdd = new PDO('mysql:host=127.0.0.1;dbname=atchandico', 'root', '');

$host = "127.0.0.1";
$user = "root";
$mdp = "";
$bd = "atchandico";
$id = mysqli_connect($host, $user, $mdp);
mysqli_select_db($id, $bd);

 $is="null";
 if(isset($_POST['search']))
 {
    $is=$_POST['search'];
 }
 $req="SELECT * FROM mots WHERE atchan LIKE '%".$is."%'";
 $ps = mysqli_query($id, $req);



    $query = "SELECT * FROM mots";
    $result = mysqli_query($id, $query);
   // $mots = $query->fetchAll();

    //$query = $bdd->prepare('SELECT atchan FROM mots WHERE atchan LIKE "b%" ORDER BY id DESC');

//    if(isset_GET(['q']) AND !empty($_GET['q'])){
//        $q = htmlspecialchars($_GET['q']);
//        $mot = $bdd->query('SELECT atchan FROM mots LIKE "%'.$q.'%" ORDER BY id DESC');
//        
//    }
    

    if(isset($_POST['insertionForm']))
    {
        if(!empty($_POST['atchan']) AND !empty($_POST['french']) AND !empty($_POST['description']))
        {
            $atchan = htmlspecialchars($_POST['atchan']);
            $french = htmlspecialchars($_POST['french']);
            $description = htmlspecialchars($_POST['description']);
            
            $atchanLenght = strlen($atchan);
            $frenchLenght = strlen($french);
            
            if($atchanLenght <= 255){
                if($frenchLenght <= 255){
                    $insertWord = $bdd->prepare("INSERT INTO mots(atchan, french, description) VALUES(?, ?, ?)");
                    $insertWord->execute(array($atchan, $french, $description));
                    $erreur = "votre mot a été inséré avec succès!";
                    
                }
                else{
                    $erreur = "le mot en français que vous avez saisi et trop long";
                }
            }
            else{
                $erreur = "le mot en atchan que vous avez saisi et trop long";
            }            
        }
        else{
            $erreur = "Veuillez remplir tous les champs correctement";
        }
    }

?>



<!DOCTYPE html>
<html>
    <head>
        <title>Dictionaire Atchan</title>
        <meta charset="UTF-8">
        
        <!------------CSS------------->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        
        <!------------JS-------------->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    </head>
    <body>
        <style>
          <?php include "css/style.css" ?>
        </style>
        <div class="container-fluid container-style">
            <div class="row d-flex justify-content-center">
                <div class="col-6 header-space">
<!--
                    <div class="row">
                        <div class="col-12">
                            <div class="image-content d-flex align-items-center">
                                <div class="image-content-row">
                                    <img class="image-header-style" width="100%" height="auto" src="imgs/iv.jpg"/>
                                </div>
                            </div>
                        </div>
                    </div>
-->
                    <div class="row">
                        <div class="col-12 mt-5">
                            <form method="GET">
                                <input class="searchInputStyle" type="search" autocomplete="off" placeholder="Rechercher..." name="search">
                                <input type="submit" value="chercher">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" action="" class="row mt-5">
                <div class="col-12 d-flex justify-content-center H6">INSERER UN MOT</div>
                <div class="col-12 d-flex justify-content-center">
                <?php 
                    if(isset($erreur))
                    {
                        echo '<font color="orangered">'.$erreur.'</font>';
                    }
                ?>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <input class="inputStyle" type="text" placeholder="Mot en Atchan..." name="atchan" id="atchan" autocomplete="off">
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <input class="inputStyle" type="text" placeholder="Mot en français..." name="french" id="french" autocomplete="off">
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <input class="inputStyle" type="text" placeholder="Explication..." name="description" id="description" autocomplete="off">
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <button class="inserBtn" type="submit" name="insertionForm">Inserer</button>
                </div>
            </form>
            
            
            <div class="row d-flex justify-content-center">
                <div class="col-6 card-content-list">
                    <?php 
                        while($mots = mysqli_fetch_array($result)){
                    ?>
                    <div class="card-row">
                        <div class="row separator-row">
                        <div class="col-8">
                            <div class="row"><div class="col-12 p-0 word-style"><b><?php echo $mots['atchan'] ?></b> <font color="gray">(Atchan)</font></div></div>
                            <div class="row"><div class="col-12 p-0 word-style"><b><?php echo $mots['french'] ?></b> <font color="gray">(Français)</font></div></div>
                            <div class="row"><div class="col-12 p-0 explain-style"><font><?php echo $mots['description'] ?></font></div></div>
                        </div>
                        <div class="col-4 d-flex align-items-center justify-content-center">
                            <audio class="audioStyle" controls>
                              <source src="music/test.mp3" type="audio/mp3">
                            Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row footer d-flex align-items-bottom">
                <div class="col-12">
                    <div class="row d-flex justify-content-center">
                        <div class="col-2 d-flex justify-content-center footer-link">VNA</div>
                        <div class="col-2 d-flex justify-content-center footer-link">AMONAK</div>
                        <div class="col-2 d-flex justify-content-center footer-link">CONTRIBUER</div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-center"><font size="2">designed by Amonak</font></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>