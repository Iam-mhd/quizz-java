<?php
require_once("./functions.php");
$users = getData();
$players = [];
foreach ($users as $key => $user) {
    if ($user["profil"]==="joueur") {
        array_push($players,$user);
    } 
}
for ($i=0; $i <count($players) ; $i++) { 
    $score[$i]=$players[$i]['score'];
}
array_multisort($score,SORT_DESC,$players);
?>
<div class="liste-form">
    <table class="table">
        <tbody>
        <?php for ($i=0; $i <5 ; $i++) {?>
            <tr>
                <td class="efa"><?= $players[$i]['prenom']." ". $players[$i]['nom']?></td>
                <td class="point"><?= $players[$i]['score']?> pts</td>
            </tr>
       <?php } ?>
        </tbody>
    </table>
</div>














