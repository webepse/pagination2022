<?php
    require "connexion.php";
    $reqcount = $bdd->query("SELECT id FROM examen");
    $count = $reqcount->rowCount();
    $limit = 10;
    $nbpage = ceil($count/$limit);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <h1>Horaire</h1>
    <?php
        if(isset($_GET['page']))
        {
            $pg=htmlspecialchars($_GET['page']);
        }else{
            $pg=1;
        }

        $offset = ($pg-1)*$limit;
                //   0 * 10 = 0
                //   1 * 10 = 10
                //   2 * 10 = 20

        echo "<div id='pagination'>";
            if($pg>1)
            {
                echo " &nbsp;<a href='index.php?page=".($pg-1)."'> < </a>";
            }
            echo "Page ".$pg." ";
            if($pg!=$nbpage)
            {
                echo " &nbsp;<a href='index.php?page=".($pg+1)."'> > </a>";
            }

        echo "</div>";

        $req = $bdd->prepare("SELECT examen AS exam, DATE_FORMAT(date, '%d/%m/%Y') AS madate FROM examen ORDER BY date DESC LIMIT :offset, :limit");
        $req->bindParam(":offset", $offset, PDO::PARAM_INT);
        $req->bindParam(":limit", $limit, PDO::PARAM_INT);
        $req->execute();
        while($don=$req->fetch())
        {
            echo "<div class='boite1'>";
                echo "<div class='date'>".$don['madate']."</div>";
                echo "<div class='exam'>".$don['exam']."</div>";
            echo "</div>";
        }
        $req->closeCursor();
    ?>
</body>
</html>