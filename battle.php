<?php
require('./Character.php');
$str = file_get_contents('characters.json');
$characters = json_decode($str, true);
session_start();
$listCharacters= array();



foreach ($characters as $character) {
    array_push($listCharacters, new Character(
        $character['id'],
        $character['name'],
        $character['puissance'],
        $character['attacks'],
        $character['type'],
    ));
}

$selectedId;
$selectedChar;
$enemyList = array();
$selectedEnemy;
if (!isset($_SESSION['fight_logs'])) {
    $_SESSION['fight_logs'] = array();
}

if (isset($_POST['selected_character_id'])) {
    $_SESSION['selected_character_id'] = $_POST['selected_character_id'];
    $selectedId = $_SESSION['selected_character_id'];
}else if(isset($_SESSION['selected_character_id'])){
    $selectedId = $_SESSION['selected_character_id'];
}else{
    echo('Erreur: Rechargez le site !');
}


foreach ($listCharacters as $character) {
    if ($character -> getId() == $selectedId) {
        $selectedChar = $character;
        $_SESSION['selected_char'] = $character;
    };
}

foreach ($listCharacters as $character) {
    if($character-> getType() != $selectedChar -> getType()){
        array_push($enemyList, $character);
    };
}

if(!isset($_SESSION['id_enemy'])){
    $_SESSION['id_enemy'] = rand(0,(count($enemyList) - 1));
    $versusChar = $_SESSION['id_enemy'];
}else{
    $versusChar = $_SESSION['id_enemy'];
}

if(isset($_POST['damage'])){
    $_SESSION['enemy_hp'] = $_SESSION['enemy_hp'] - (intval(($_POST['damage'] / $selectedChar -> getPower()) * 100));
    $idEnemyAttack = rand(0,(count($enemyList[$versusChar] -> getAttacks())));
    $enemyAttack = $enemyList[$versusChar] -> getAttacks()[$idEnemyAttack];
    $_SESSION['my_hp'] = $_SESSION['my_hp'] - (intval(($enemyAttack['damage'] / $enemyList[$versusChar] -> getPower()) * 100));

    $addArray = array(
        "name" => $selectedChar -> getName(),
        "damage" => (intval(($_POST['damage'] / $selectedChar -> getPower()) * 100)),
        "victim" => $enemyList[$versusChar] -> getName()
    );
    array_push($_SESSION['fight_logs'], $addArray);

    $addArray = array(
        "name" => $enemyList[$versusChar]  -> getName(),
        "damage" => (intval(($enemyAttack['damage'] / $enemyList[$versusChar] -> getPower()) * 100)),
        "victim" => $selectedChar -> getName()
    );
    array_push($_SESSION['fight_logs'], $addArray);

}

if($_SESSION['enemy_hp'] <= 0 || $_SESSION['my_hp'] <= 0 ){
    header("Location: endbattle.php");
}

include('./templates/header.php')
?>
<main>

    <div class="global-battle-container">
        <div class="battle-char">
            <p class="battle-char-name"><?= $selectedChar -> getName() ?> - <?= $_SESSION['my_hp']?> HP</p>
            <div id="progress-bar">
                <div id="progress" style="width: <?= $_SESSION['my_hp']?>%;"></div>
            </div>
            <img src="./img/characters/<?=$selectedChar-> getId()?>.jpg" alt="Photo du personnage <?= $selectedChar-> getName()?>" class="img-battle">
            <div class="attacks">
                <?php
                    foreach ($selectedChar-> getAttacks() as $attack) {
                        ?>
                        <form method="post" action="battle.php">
                            <button name="attack">
                                <?= $attack['name'] ?>
                                <br>
                                <?= $attack['damage'] ?>
                                <input type="hidden" name="damage" value="<?= $attack['damage'] ?>">   
                            </button>
                        </form>
                            
                        <?php
                    }
                ?>
            </div>
            
        </div>
                    
                

        <div class="combat-log">

        <?php
                    foreach ($_SESSION['fight_logs'] as $fightlog) {
                        if($fightlog['damage'] != 0){

                       ?>
                        <p><?= $fightlog['name'] ?> a infligé <?= $fightlog['damage']?> de dégat à <?= $fightlog['victim']?></p>
                       <?php
                        }else{
                            ?>
                            <p><?= $fightlog['victim'] ?> esquivé l'attaque de <?= $fightlog['name']?> !</p>
                            <?php
                        }
                    }
                    ?>

        </div>

        <div class="battle-char">
            <p class="battle-char-name"><?= $enemyList[$versusChar]-> getName() ?> - <?= $_SESSION['enemy_hp']?> HP</p>
            <div id="progress-bar">
                <div id="progress" style="width: <?= $_SESSION['enemy_hp']?>%;"></div>
            </div>
            <img src="./img/characters/<?=$enemyList[$versusChar]-> getId()?>.jpg" alt="Photo du personnage <?= $enemyList[$versusChar]-> getName()?>" class="img-battle">
        
        </div>
    </div>

    
</main>


<?php
include('./templates/footer.php')

?>