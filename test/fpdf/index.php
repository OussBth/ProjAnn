<?php
session_start();
?>


<a href=<?="download_log.php?id=".$_SESSION['id']?>>téléchargement des logs du user id <?=$_SESSION['id']?></a>