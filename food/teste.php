<html>
    <head>
        <title>Novo Cardápio</title>
    </head>
    <body>
        <div class="wrap">
            <h2>Adicionar novo Cardápio</h2>
            <form method="post" action="options.php"> 
                <input type="text" name="cardapio">
                <p>Data de entrada:<input type="date" name="enter_date"></p>
                <p>Data de saída:<input type="date" name="exit_date"></p>
                <?php
                    $args = array('post_type' => 'food');
                    // The Query
                    $the_query = new WP_Query( $args );
                    
                    // The Loop
                    if ( $the_query->have_posts() ) {
                        echo '<ul>';
                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            echo '<li><input type="checkbox" name="' . get_the_ID() . '" value="' . get_the_ID() . '">' . get_the_title() . '</li>';
                        }
                        echo '</ul>';
                    }
                    /* Restore original Post Data */
                    wp_reset_postdata();

                ?>
            </form>
         </div>
    </body>
</html>