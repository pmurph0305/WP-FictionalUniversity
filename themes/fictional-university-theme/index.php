<?php
    function greet($name, $color) {
        echo "<p>Hey, my name is $name and my favorite color is $color.</p>";
    }
    greet('Patrick', 'orange');
    greet('Jessica', 'blue');
?>
<h1><?php bloginfo('name'); ?></h1>
<p><?php bloginfo('description')?></p>