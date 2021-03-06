<?php
include 'template/header.php';


$pdo = connectDB();
//Verification que l'un est bien abonné à l'autre
$queryPrepared = $pdo->prepare("SELECT STATUS FROM MATCHS WHERE ID_MATCHER = :sender AND ID_MATCH = :receveur");
$queryPrepared->execute(["sender" => $_SESSION['id'], "receveur" => $_GET['id']]);
$state1 = $queryPrepared->fetch();

//vérification que l'autre est bien abonné à l'un
$queryPrepared = $pdo->prepare("SELECT STATUS FROM MATCHS WHERE ID_MATCHER = :sender AND ID_MATCH = :receveur");
$queryPrepared->execute(["receveur" => $_SESSION['id'], "sender" => $_GET['id']]);
$state2 = $queryPrepared->fetch();

//si les deux personnes se sont matchées
if ($state1[0] == 1 && $state2[0] == 1) {
    if (isConnected()) {
        echo '<p id="id-sender" hidden="hidden">' . $_SESSION['id'] . '</p>';
        echo '<p id="id-receveur" hidden="hidden">' . $_GET['id'] . '</p>';
        echo '<p id="token" hidden="hidden">' . $_SESSION['token'] . '</p>';
    }
    //on récupère le pseudo de la personne avec qui on parle
    $queryPrepared = $pdo->prepare("SELECT PSEUDO FROM USER WHERE ID = :id;");
    $queryPrepared->execute(['id' => $_GET['id']]);
    $friendName = $queryPrepared->fetch();

?>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <div class="row" height="100%">
        <div class="col-lg-2 col-md-2 col-sm-2 bg-color my-3 ml-5 arrondie ">
            <div class="row overflow-auto" height="100%">
                <?php
                //récupération des 
                $queryPrepared = $pdo->prepare("SELECT ID_MATCH AS ID FROM MATCHS WHERE ID_MATCHER = :id; AND STATUS = 1;");
                $queryPrepared->execute(['id' => $_SESSION['id']]);
                $matchs = $queryPrepared->fetchAll();

                //pour chaque personnes avec qui on a matché
                foreach ($matchs as $match) {
                    $queryPrepared = $pdo->prepare("SELECT COUNT(ID_MATCHER) FROM MATCHS WHERE ID_MATCH = :id AND ID_MATCHER = :idsub AND STATUS = 1;");
                    $queryPrepared->execute(['id' => $_SESSION['id'], 'idsub' => $match['ID']]);
                    $result = $queryPrepared->fetch();

                    //on vérifie qu'elle a bien matché avec nous
                    if ($result[0] == 1 && $match['ID'] != $_GET['id']) {
                        //récupération des données de l'ami
                        $queryPrepared = $pdo->prepare("SELECT ID, PSEUDO, PATH_AVATAR FROM USER WHERE ID = :id;");
                        $queryPrepared->execute(['id' => $match['ID']]);
                        $friend = $queryPrepared->fetch();

                        echo'<div class="row">
                                <div class="col-lg-12 my-5  py-2 pl-2">
                                    <a class="text-white" href="https://cookit.ovh/messagerie.php?id=' . $friend['ID'] . '" >
                                        <img src="' . $friend['PATH_AVATAR'] . '" height="100px" width="100px">
                                    ' . $friend['PSEUDO'] . '</a>
                                </div>
                            </div>';
                    }
                }
                ?>

            </div>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 bg-coleur">
            <div class="row d-flex justify-content-center my-5">
                <div class="col-md-10 col-lg-8 col-xl-6">

                    <div class="card" id="chat2">
                        <div class="card-header d-flex justify-content-between align-items-center p-3">
                            <h5 class="mb-0">Chat avec <?= $friendName[0] ?></h5>
                        </div>

                        <!-- section du chat -->
                        <div id="message-canva" class="card-body overflow-auto" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">
                    
                        </div>
                        <!-- section du chat -->





                        <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 3" style="width: 40px; height: 100%;">
                            <input type="text" class="form-control form-control-lg" id="message-input" placeholder="Type message">
                            <button id="send-message">envoyer</button>
                            <a class="ms-3" href="#!"><i class="fas fa-paper-plane"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="ressources/js/messagerie.js"></script>



    <?php
} else {
    echo 'vous n\'etes pas amis avec cette personnes !';
    echo '<br>';
    echo '<a href="index.php">Acceuil</a>';
}
include "template/footer.php";
    ?>