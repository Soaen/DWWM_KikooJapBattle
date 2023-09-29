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

session_start();

function sessionAdd($char) {
    $_SESSION["char"] = $char;
    header("Location: battle.php");
}

include('./templates/header.php')
?>


<main>
    
    <div class="container">
    <?php

    foreach ($listCharacters as $character) { 
        if($character -> getType() == 'good'){
    ?>
    <div class="character-container">
        <a href="./battle.php?id=<?= $character -> getId()?>">
            <img src="./img/characters/<?=$character -> getId()?>.jpg" alt="Photo du personnage <?= $character -> getName()?>" class="img-home">
                <p class="power-paragraph good-power">
                    <img src="./img/jedisaber.svg" alt="" srcset="" class="img-svg">
                    <?= $character -> getPower()?>
                </p>
            </a>
    </div>
    <?php
        }
    }
    foreach ($listCharacters as $character) { 
        if($character -> getType() == 'bad'){
    ?>
    <div class="character-container">
    <a href="./battle.php?id=<?= $character -> getId()?>">
        <img src="./img/characters/<?=$character -> getId()?>.jpg" alt="Photo du personnage <?= $character -> getName()?>" class="img-home">
        <p class="power-paragraph bad-power">
            <img src="./img/sithsaber.svg" alt="" srcset="" class="img-svg">
            <?= $character -> getPower()?>
        </p>
        </a>

    </div>
    <?php
        }
    }
    ?>
    </div>
    

</main>


<?php
include('./templates/footer.php')
?>