<?php
require('./Character.php');
$str = file_get_contents('characters.json');
$characters = json_decode($str, true);

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

$selectedId = $_GET["id"];
$selectedChar;

$enemyList = array();
$selectedEnemy;

foreach ($listCharacters as $character) {
    if ($character -> getId() == $selectedId) {
        $selectedChar = $character;
    };
}

foreach ($listCharacters as $character) {
    if($character-> getType() != $selectedChar -> getType()){
        array_push($enemyList, $character);
    };
}


$versusChar = rand(0,(count($enemyList) - 1));


include('./templates/header.php')
?>
<main>

    <div class="global-battle-container">
        <div class="battle-char">
            <p class="battle-char-name"><?= $selectedChar -> getName() ?></p>
            <img src="./img/characters/<?=$selectedChar-> getId()?>.jpg" alt="Photo du personnage <?= $selectedChar-> getName()?>" class="img-battle">
            <div class="attacks">
                <?php
                    foreach ($selectedChar-> getAttacks() as $attack) {
                        ?>
                            <button>
                                <?= $attack['name'] ?>
                                <br>
                                <?= $attack['damage'] ?>
                            </button>
                        <?php
                    }
                ?>
            </div>
        </div>

        <div class="battle-char">
            <p class="battle-char-name"><?= $enemyList[$versusChar]-> getName() ?></p>
            <img src="./img/characters/<?=$enemyList[$versusChar]-> getId()?>.jpg" alt="Photo du personnage <?= $enemyList[$versusChar]-> getName()?>" class="img-battle">
        </div>
    </div>

    
</main>


<?php
include('./templates/footer.php')

?>