<?php require('_head.php'); ?>

    <?php

        if(isset($_POST['action'])){

            $error = false;

            try{

                //palabra

                    if(!isset($_POST['word'])){
                        throw new Exception("No se ha insertado la palabra", 1);
                    }

                    if(strlen(trim($_POST['word']))==0){
                        throw new Exception("La palabra no puede contener solo espacios", 1);
                    }

                    $_POST['word'] = trim($_POST['word']);

                    //comprobar que no este agregada ya
                    $stmt = $PDO->prepare('select * from word where word = :word');
                    $stmt->bindParam(':word',trim($_POST['word']));
                    $stmt->execute();

                    if(count($stmt->fetchAll(PDO::FETCH_ASSOC))>0){
                        throw new Exception("La palabra ya está agregada", 1);
                    }


                //traduccion

                    if(!isset($_POST['translate'])){
                        throw new Exception("No se ha insertado la traducción", 1);
                    }

                    if(strlen(trim($_POST['translate']))==0){
                        throw new Exception("La traducción no puede contener solo espacios", 1);
                    }

                    $_POST['translate'] = trim($_POST['translate']);

                //si llego hasta aquí la inserto

                    $stmt = $PDO->prepare('insert into word (word,translate) values (:word,:translate)');
                    $stmt->bindParam(':word',$_POST['word']);
                    $stmt->bindParam(':translate',$_POST['translate']);
                    $stmt->execute();


                // echo '<pre>';
                // print_r();
                // echo '</pre>';

            }catch(Exception $e){

                $error = $e->getMessage();

            }

        }

    ?>

    <div class="page-header">
        <h1>Palabras <small>agregar</small></h1>
    </div>

    <form anction="word.create.php" method="post">
        <div class="form-group">
            <label for="Palabra">Palabra</label>
            <input type="text" class="form-control" id="word" name="word" placeholder="">
        </div>
        <div class="form-group">
            <label for="Traduccion">Traducción</label>
            <input type="text" class="form-control" id="translate" name="translate" placeholder="">
        </div>

        <input type="hidden" name="action">

    <button type="submit" class="btn btn-default">Agregar</button>
    </form>

    <?php

        if(isset($error)){

            if($error==false){

                echo '<div class="alert alert-success" role="alert">Palabra agregada</div>';

            }else{

                echo '<div class="alert alert-danger" role="alert">ERROR: '.$error.'</div>';

            }


        }

    ?>

<?php require('_botton.php'); ?>
