<?php require('_head.php');

    //eliminar
    $stmt = $PDO->prepare('delete from word where id = :id');
    $stmt->bindParam(':id',trim($_GET['id']));
    $stmt->execute();

?>

<div class="page-header">
    <h1>Palabras <small>lista</small></h1>
</div>
