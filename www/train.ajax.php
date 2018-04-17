<?php include('_head.nooutput.php');

    if($_GET['result']==1){

        $stmt = $PDO->prepare('update word set learned = true where word = :word');
        $stmt->bindParam(':word',$_GET['word']);
        $stmt->execute();

    }else{

        $stmt = $PDO->prepare('update word set learned = false where word = :word');
        $stmt->bindParam(':word',$_GET['word']);
        $stmt->execute();

    }

?>
