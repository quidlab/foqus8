<?php
function redirect($url,array $data = []){
    $_SESSION['dataBag'] = $data;
    header('Location: '.$url);
}
?>