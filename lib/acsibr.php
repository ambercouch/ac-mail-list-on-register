<?php

function acsibr() {

   if(isset($_POST['register_terms_agree'])){
       echo "I've read the terms";
       die();
   }

}

add_action( 'user_register', 'acsibr', 10, 1 );


function acsm_enqueue_scripts(){
    wp_register_script('acsibr_script', plugins_url('../assets/js/scripts-acsibr.js', __FILE__), array('jquery'), '1.1', true);
    wp_enqueue_script('acsibr_script');
}

//add_action( 'wp_enqueue_scripts', 'acsm_enqueue_scripts' );

function acsm_enqueue_styles() {
    wp_register_style('acsibr_styles', plugins_url('../assets/css/styles-acsibr.css', __FILE__));
    wp_enqueue_style('acsibr_styles');
}
//add_action( 'get_footer', 'acsm_enqueue_styles' );
