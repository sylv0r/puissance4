<?php
session_start();
require_once 'includes/database.inc.php'
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/CSS/scores.css">
    <link rel="shortcut icon" href="assets/images/icone.png" type="image/x-icon">
    <title>Scores</title>
</head>
<body>
    
    <div id="mainblock">

        <!--Début du header avec l'image de fond-->

        <div id="bg_image">
        <?php
            include_once 'view/header.inc.php'
            ?>

            <!--Fin du header-->

            <!--Début de l'intro-->

            <div id="intro">

            <h1>Tableau des scores</h1>

            <p>Venez vous comparer aux meilleurs !</p>
        
            </div>

        </div>

            <!--Fin de l'intro-->

            <!--Début du tableau-->

            <div id="center_part">

                <div class="side">
                    
                </div>

                <div id="tables">
                    
                    <!--L'entête du tableau-->
                    <table id="what">
                        <tr>
                            <th class="classement">Classement</th>
                            <th class="gamename">Nom du Jeu</th>
                            <th class="pseudo">Pseudo</th>
                            <th class="difficulty">Difficulté</th>
                            <th class="score">Score</th>
                            <th class="datetime">Date et Heure</th>
                        </tr>
                    </table>

                    <?php
                        $classement = 1;

                        //On va récupérer les infos de la base de données
                        //--> nom du jeu, pseudo de l'utilisateur, niveau de difficulté, score
                        $scores = $mysqlClient->prepare('SELECT `game`.`game_name`, `user`.pseudo, `difficulty`.`level`, `score`, `score`.date_game AS `datetime` 
                                                         FROM `score` INNER JOIN `user` INNER JOIN `game` INNER JOIN difficulty 
                                                         ON score.id_user=user.id AND score.id_game=game.id AND score.id_difficulty=difficulty.id 
                                                         ORDER BY id_game, id_difficulty DESC, score');
                        $scores->execute();
                        $scores = $scores->fetchAll();

                        foreach ($scores as $case) { 

                            $date = $case['datetime'];

                            //On formate la date pour respecter un meilleur format
                            $theDate = new DateTime($date);
                            $theDate = $theDate->format('d/m/Y H:i');
                            
                            //On ne garde que les 10 premiers du classement
                            if ($classement <11) {
                              ?>

                        <table 
                        <?php 
                        
                        switch ($classement) {
                            //Si ce joueur est premier
                            case 1 : ?>
                                id="first" class="podium"
                    <?php       break;
                            //Si ce joueur est deuxième     
                            case 2 : ?>
                                id="second" class="podium"
                    <?php       break;
                            //Troisième
                            case 3 : ?>
                                id="third" class="podium"
                    <?php       break;
                            //Le reste du classement (jusqu'à 10)
                            default : ?>
                                class="therest"
                    <?php       break;
                                
                        }
                        
                        ?>>
                            <tr>
                                <td class="classement"><?php echo $classement; $classement++; ?></td>
                                <td class="gamename"><?php echo $case['game_name']; ?></td>
                                <td class="pseudo"><?php echo $case['pseudo']; ?></td>
                                <td class="difficulty"><?php echo $case['level']; ?></td>
                                <td class="score"><?php echo $case['score'].' sec'; ?></td>
                                <td class="datetime"><?php echo $theDate; ?></td>
                            </tr>
                        </table>

                    <?php
                        }}
                    ?>

                    <!--Ici on affichera le classement de l'utilisateur actuel pour qu'il puisse se comparer aux autres
                        même s'il n'est pas dans le top 10
                    -->
                    
                </div>

                <div class="side">
                    
                </div>
        
            </div>

            <!--Fin du tableau-->

            <?php

        include_once 'view/footer.inc.php';
        ?>
    
            <!--Fin du footer-->


    </div>

</body>
</html>