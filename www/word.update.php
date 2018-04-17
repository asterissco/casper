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

                    if(!is_numeric(trim($_POST['score']))){
                        throw new Exception("La puntuación debe ser un número", 1);
                    }


                    $_POST['word'] = trim($_POST['word']);

                    //comprobar que no colisiona con otra palabra
                    $stmt = $PDO->prepare('select * from word where word = :word and id != :id');
                    $stmt->bindParam(':word',trim($_POST['word']));
                    $stmt->bindParam(':id',trim($_GET['id']));
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

                    $stmt = $PDO->prepare('update word set word = :word, translate = :translate, learned = :learned, score = :score where id = :id');
                    $stmt->bindParam(':word',$_POST['word']);
                    $stmt->bindParam(':translate',$_POST['translate']);
                    $stmt->bindParam(':learned',$_POST['learned']);
                    $stmt->bindParam(':score',$_POST['score']);
                    $stmt->bindParam(':id',$_GET['id']);
                    $stmt->execute();


                // echo '<pre>';
                // print_r();
                // echo '</pre>';

            }catch(Exception $e){

                $error = $e->getMessage();

            }


        }

        //coge los datos de la palabra
        $stmt   = $PDO->prepare('select * from word where id = :id');
        //$stmt->bindParam(':id',$_GET['id']);
        $stmt->execute(array(':id'=>$_GET['id']));
        $word   = $stmt->fetch();

        // echo "esto: ".$word['learned'];
        // exit();

    ?>

    <div class="page-header">
        <h1>Palabras <small>actualizar</small></h1>
    </div>

    <form anction="word.update.php?id=<?php echo $_GET['id']?>" method="post">

        <div class="form-group">
            <label for="Palabra">Palabra</label>
            <input type="text" class="form-control" id="word" name="word" placeholder="" value="<?php echo $word['word']?>">
        </div>

        <div class="form-group">
            <label for="Traduccion">Traducción</label>
            <input type="text" class="form-control" id="translate" name="translate" placeholder="" value="<?php echo $word['translate']?>">
        </div>

        <div class="form-group">
            <label for="Traduccion">Aprendida</label>
            <select class="form-control" name="learned" id="learned">
                <?php if($word['learned']==0): ?>
                    <option selected="selected" value="0">NO</option>
                    <option value="1">SI</option>
                <?php else: ?>
                    <option value="0">NO</option>
                    <option selected="selected" value="1" >SI</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Traduccion">Puntuación</label>
            <input type="text" class="form-control" id="score" name="score" placeholder="" value="<?php echo $word['score']?>">
        </div>


        <input type="hidden" name="action">

    <button type="submit" class="btn btn-default">Modificar</button>
    </form>

    <?php

        if(isset($error)){

            if($error==false){

                echo '<div class="alert alert-success" role="alert">Palabra modificada</div>';

            }else{

                echo '<div class="alert alert-danger" role="alert">ERROR: '.$error.'</div>';

            }


        }

    ?>

<?php require('_botton.php'); ?>
