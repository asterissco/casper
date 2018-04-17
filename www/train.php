<?php require('_head.php'); ?>

    <?php

        $arrWord = $PDO->query('select * from word where learned = false')->fetchAll(PDO::FETCH_ASSOC);

        // echo '<pre>';
        // print_r($arrWord);
        // echo '</pre>';

    ?>

    <script>

        //variables globales, a lo loco!!
        var index       = 0;
        var arrSize     = <?php echo count($arrWord); ?>;
        var state       = "think";
        var arrWord     = [];
        var word        = [];

        $(document).ready(function(){

            //cargamos un array en js de las palabras PHP
            <?php foreach($arrWord as $word): ?>

                word = ["<?php echo $word['word'];?>","<?php echo $word['translate'];?>"];
                arrWord.push(word);

            <?php endforeach; ?>

            //si todas las palabras han sido aprendidas me lo oculta y me da la enhorabuena
            if(index==arrSize){

                $("#word").html("No hay vocabulario, enhorabuena!!");
                $("#translate").html("");
                $("#success").hide();
                $("#fail").hide();
                $("#discover").hide();

            }else{

                $("#word").html(arrWord[index][0]);
                $("#translate").html("");
                $("#success").hide();
                $("#fail").hide();

            }

        });

        //carga la traduccion
        function loadTranslate(){

                $("#translate").html(arrWord[index][1]);

                $("#discover").hide();
                $("#success").show();
                $("#fail").show();

        }

        //guarda el resultado de lo que ha pasado en la base de datos y carga la siguiente palabra
        function setResult(result){

            //envia el resultado al otro lado
            if(result){

            //    console.log("hola que tal amigo");
                //todo un misterio porque no me contesta aunque hace la peticion
                $.ajax({
                    url: "train.ajax.php",
                    data: { "result" : 1 , "word" : arrWord[index][0] },
                    dataType: 'json',
                    success: function (data){
                        console.log("los datos son:".data);
                    }
                }).done( function(data){

                    console.log("ddsa");

                });

            }else{

                $.ajax({
                    url: "train.ajax.php",
                    data: { "result" : 0 , "word" : arrWord[index][0] },
                    dataType: 'json'
                });

            }

            console.log("size: "+arrSize+" indice: "+index);
            // console.log(arrSize);
            // console.log(index);

            if(index==(arrSize-1)){
                index = 0;
            }else{
                index = index+1;
            }

            $("#word").html(arrWord[index][0]);
            $("#translate").html("");

            $("#discover").show();
            $("#success").hide();
            $("#fail").hide();

        }

    </script>

    <div class="page-header">
        <h1>Entrenar</h1>
    </div>

    <div class="row">

      <div class="col-md-6" id="word" style="font-size:60px;border-right: 1px solid">dsds</div>
      <div class="col-md-6" id="translate" style="font-size:60px"></div>

    </div>

    <br><br><br><br><br>
<!--      <div class="col-md-4" id="word" style="font-size:60px"></div> -->
          <button type="button" id="discover" class="btn btn-default btn-lg" onclick="loadTranslate()">Descubrir</button>
          <button type="button" id="success" class="btn btn-success btn-lg" onclick="setResult(true)">Acierto</button>
          <button type="button" id="fail" class="btn btn-danger btn-lg" onclick="setResult(false)">Fallo</button>






    <div id="trash"></div>

<?php require('_botton.php'); ?>
