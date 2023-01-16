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
    echo "</form>" ;
    echo "</div></div>";
}

?>
