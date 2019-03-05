<?php

 if (isset($_SESSION['success_flash'])) {
        echo '<div class ="bg-success"><p class="text-center" style="background-color:springgreen;">'.$_SESSION['success_flash'].'</p></div>';
        unset($_SESSION['success_flash']);
}
if (isset($_SESSION['error_flash'])) {
        echo '<div class = "bg-danger"><p class = "text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
        unset($_SESSION['error_flash']);
}
?>