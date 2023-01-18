<?php
// print html components to render the entire cart grid rowXcol
function printCells($numRow, $numCol)
{
}
// print
function printInstructions($title, $instructions)
{
    echo '<div id="ins-container">';
    $titleH3 =  "<h3 id='ins-title'>" . $title . " </h3>";
    echo $titleH3;
    echo '<div id="ins-det">';
    foreach ($instructions as $index => $ins) {
        $line = "<p id= p-ins-" . $index . " class = inst> " . $ins . "</p>";
        echo $line;
    }
    
    echo '<form action="" method="POST">';
    echo  '<input type="button" value="Escuchar" class="btn-Blue hidden" id="btnListen">';
    echo '<p id="errorListen" class="hidden"></p>';
    echo '<div id="scoreDiv" class="hidden">';
    echo '<div class="optDiv">';
    echo '<p class="lblAcierto">Aciertos</p>';
    echo '<p id="pScore"></p>';
    echo '</div>';
    echo '</div>';
    echo "</form>" ;
    echo "</div></div>";
}

?>
