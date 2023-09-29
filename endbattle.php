<?php
include('./templates/header.php');

session_start();


unset($_SESSION['fight_logs']);
?>
    <div class="final-screen">
        <h2>Vous avez <?= $_SESSION['my_hp'] <= 0 ? 'Perdu': 'Gagné'?> !</h2>

            <img src="<?= $_SESSION['my_hp'] <= 0 ? './img/loose.gif': './img/win.gif'?>" alt="" srcset="">

        <a href="./index.php" class="link-replay">Rejouer</a>
    </div>
    


<?php
include('./templates/footer.php')
?>

