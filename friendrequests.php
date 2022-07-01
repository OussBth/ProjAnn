<?php 
include "template/header.php";


if (isConnected() == $_SESSION['id']){
	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT *  FROM SUBSCRIPTION,USER WHERE USER.ID = ID_SUBSCRIBER AND ID_SUBSCRIPTION = :idstion AND STATUS = 0;");
	$queryPrepared->execute(["idstion" => $_GET['id']]);
	$friends = $queryPrepared->fetchAll();

}
echo'<pre>';
print_r($friends);
echo'</pre>';
?>

<div class="container py-5">
    <div class="row">
        <?php
            foreach ($friends as $friend){
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6"> 
            <div class=" card bg-color text-center shadow p-3 mb-5 rounded">
                <div>
                    <?= $friend['PSEUDO'] ?>  
                </div>
                <button type="button" class="btn btn"><a href="https://cookit.ovh/friendRaccepted.php?id=<?=$friend['ID_SUBSCRIPTION']?>&ids=<?=$friend['ID_SUBSCRIBER']?>" class ="bg-light rounded my-3"> Accepter</a></button>
                <button type="button" class="btn btn"><a href="https://cookit.ovh/friendRrefused.php?id=<?=$friend['ID_SUBSCRIPTION']?>&ids=<?=$friend['ID_SUBSCRIBER']?>" class ="bg-light rounded my-3"> Refuser</a></button>
                
            </div>
        </div>
        <?php
            }?>
    </div>
</div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>