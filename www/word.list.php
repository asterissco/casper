<?php require('_head.php'); ?>

    <?php

        $arrWord = $PDO->query('select * from word');

    ?>

    <script>

        function eliminar(id){
            if(confirm("Seguro?")){
                window.location.replace("word.delete.php?id="+id);
            }
        }

    </script>

    <div class="page-header">
        <h1>Palabras <small>lista</small></h1>
    </div>

    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Palabra</th>
            <th>Traducción</th>
            <th>Aprendida</th>
            <th>Puntuación</th>
            <th>Acción</th>
        </tr>
        <?php

            foreach($arrWord as $word){

                echo '<tr>';
                echo    '<td>'.$word['id'].'</td>';
                echo    '<td>'.$word['word'].'</td>';
                echo    '<td>'.$word['translate'].'</td>';

                if($word['learned']){
                    echo '<td>Si</td>';
                }else{
                    echo '<td>No</td>';
                }

                echo    '<td>'.$word['score'].'</td>';

                echo    '<td> <a href="word.update.php?id='.$word['id'].'">Actualizar</a> / <a onclick="eliminar('.$word['id'].')">Eliminar</a> </td>';
                echo '</tr>';

            }

        ?>
    </table>
<?php require('_botton.php'); ?>
