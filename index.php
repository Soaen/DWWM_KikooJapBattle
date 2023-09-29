<?php
require('./Character.php');

unset($_SESSION['fight_logs']);
session_abort();
session_destroy();

session_start();
$_SESSION['my_hp'] = 100;
$_SESSION['enemy_hp'] = 100;

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
         <form method="post" action="battle.php" class="form-home">
            <input type="hidden" name="selected_character_id" value="<?= $character-> getId() ?>">
            <button type="submit" class="btn-home">
                <img src="./img/characters/<?= $character -> getId() ?>.jpg" alt="<?= $character -> getName() ?>" class="img-home">
                <p class="power-paragraph good-power">
                    <img src="./img/sithsaber.svg" alt="" srcset="" class="img-svg">
                    <?= $character -> getPower()?>
                </p>

            </button>
        </form>
    </div>
    <?php
        }
    }
    foreach ($listCharacters as $character) { 
        if($character -> getType() == 'bad'){
    ?>
    <div class="character-container">
         <form method="post" action="battle.php" class="form-home">
            <input type="hidden" name="selected_character_id" value="<?= $character-> getId() ?>">
            <button type="submit" class="btn-home">
                <img src="./img/characters/<?= $character -> getId() ?>.jpg" alt="<?= $character -> getName() ?>" class="img-home">
                <p class="power-paragraph bad-power">
                    <img src="./img/sithsaber.svg" alt="" srcset="" class="img-svg">
                    <?= $character -> getPower()?>
                </p>
            </button>
        </form>
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