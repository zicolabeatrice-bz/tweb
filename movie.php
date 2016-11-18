<!DOCTYPE html>

  <head>
    <title>Rancid Tomatoes</title>
    <meta charset="utf-8" />
    <link href="http://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/rotten.gif" type="image/gif" rel="shortcut icon" />
    <link href="movie.css" type="text/css" rel="stylesheet" />
  </head>

  <body>
    <?php
      $movie = $_GET["movie"];   //leggo il titolo del film inserito nella url
      $info = "$movie/info.txt";    //ottengo così il path per aprire i vari file
      $overview = "$movie/overview.txt";
      list($title, $year, $val) = file($info);  //la funzione file legge il file riga per riga, ogni riga viene salvata in una variabile definita in list
      $overview = file($overview);  //il risultato di file viene salvato in un aray chiamato $overview
      $year = trim($year);  //utilizzo della funzione trim per rimuovere eventuali spazi nella stringa
      $title = trim($title);
    ?>
    <div id="banner">
      <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/banner.png" alt="Rancid Tomatoes" />
    </div>
    
    <h1><?= $title ." ($year)" ?></h1>
    
    <div id="main">
      <div id="rightside">
        <div>
          <img src= <?="$movie/overview.png" ?> alt="general overview" />
        </div>

        <div id="general">
        <dl>
        <?php
          foreach($overview as $definition){
            list($dt, $dl) = explode(":", $definition);	//separa la stringa $definition in due sottostringhe $dt e $dl divise da un " : "
            ?>
              <dt> <?= trim($dt) ?> </dt>
              <dd> <?= trim($dl) ?> </dd>
         <?php
          }
         ?>        
        </dl>
        </div>
      </div>
      <div id="left-top-side">
        <div id="rating">
          <?php //l'imagine da visualizzare di fianco alla valutazione deve variare in base al valore di quest'ultima.
          if($val < 60){ ?>
          <img class="left" src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/rottenbig.png" alt="Rotten" />
          <?php ;} else { ?>
          <img class="left" src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/freshbig.png" alt="Fresh" />
          <?php ;} ?>
          <div class="left"><?= "$val%" ?></div>
        </div>

      </div>

      <div id="left-center-side">
      
            <?php
              $review = glob("$movie/review*.txt"); //glob restituisce un array contenente tutti i file il cui nome rispetta l'espressione regolare
              if(count($review) > 10){  //posso visualizzare al massimo 10 recensioni, devo quindi distinguere i due casi (maggiore di 10 o no)
                $numofreviews = 10;
              } else {
                $numofreviews = count($review);
			  }
             /* per fare in modo che la colonna sinistra abbia una recensione in più nel caso in cui il numero di recensioni 
              * sia dispari arrotondiamo il risultato della divisione del numero di recensioni per due e lo salviamo in $left.
              * Dopodiché per i che va da 0 a $left "aggiungiamo" la recensione alla colonna di sinistra.
              * Al termine del ciclo un secondo ciclo inserisce le recensioni restanti nella colonna di destra.
              */
              $left = round($numofreviews/2);
              $i = 0;
              ?>
              <div id="column-left">
            <?php
              
              for(; $i < $left; $i++){
                list($revtext, $isfresh, $author, $site) = file($review[$i]);   //leggo il contenuto dell'i-esima recensione e ne salvo i vari campi con list
                $isfresh = trim(strtolower($isfresh));  //questo mi permette di poter inserire la variabile direttamente nell'url assoluto dell'immagine
            ?>  
                <div class="review">
                  <p>
                    <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/<?= $isfresh ?>.gif" alt=<?= $isfresh ?> />
                    <q><?= trim($revtext) ?></q>
                  </p>
                </div>
                <div class="revinfo">
                  <p>
                    <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic" />
                    <?= trim($author) ?><br /><span><?= (trim($site)) ?> </span>
                  </p>
                </div>
            <?php } ?>
              </div>
              <div id="column-right">
            <?php
            //leggo e inserisco le recensioni rimanenti nella colonna di destra
              for(; $i < $numofreviews; $i++){
              list($revtext, $isfresh, $author, $site) = file($review[$i]);
              $isfresh = trim(strtolower($isfresh));
            ?>
                <div class="review">
                  <p>
                    <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/<?= $isfresh ?>.gif" alt=<?= $isfresh ?> />
                    <q><?= trim($revtext) ?></q>
                  </p>
                </div>
                <div class="revinfo">
                  <p>
                    <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic" />
                    <?= trim($author) ?><br /><span><?= (trim($site)) ?> </span>
                  </p>
                </div>
            <?php } ?>
            </div>
            
           </div>
      <footer><p><?= "(1-$i) of "?><?=count($review) //al termine del ciclo il valore di $i è il numero di recensioni visualizzate ?> </p></footer>

    </div>

    <div id="validator">
      <a href="http://validator.w3.org/check/referer"><img src="http://webster.cs.washington.edu/w3c-html.png" alt="Validate HTML" /></a> <br />
      <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" /></a>
    </div>
    
  </body>
  
</html>
