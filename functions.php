<?php

//Hacemos la llamada a la funcion js
function add_ajax_scripts() {
		 wp_enqueue_script( 'ajaxp', '/wp-content/themes/childtheme/js/functions.js', array(), '1.0.0', true );

		 wp_localize_script( 'ajaxp', 'ajax_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'ajaxnonce' => wp_create_nonce( 'ajax_post_validation' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'add_ajax_scripts' );


// Creamos un shortcode con el formulario de creacion de post ejemplo basico y pasamos datos a la funcion ajax
function shortcode_mostrar_addptest() {
	global $current_user;
		
if (is_user_logged_in() ){	
$form = "<div class='uk-container uk-container-xsmall uk-margin'>
<ul uk-accordion>
    <li class='uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-large'>
        <a class='uk-accordion-title uk-text-default uk-text-bold' href='#'><span uk-icon='icon: plus-circle'></span> Agregar Nuevo Post</a>
        <div class='uk-accordion-content'>

<form action='' method='post' enctype='multipart/form-data' class='ajax uk-form-stacked'>

	 <div class='uk-margin'>
	 <label style='color:#128395' class='uk-form-label uk-text-bold' for='form-stacked-text'>Titulo Post:</label>
        <div class='uk-form-controls'>
            <input name='post_titleart' class='uk-input titulo' type='text' placeholder='' maxlength='25' required>
        </div>
	</div>

    <div class='uk-margin'>
    <label style='color:#128395' class='uk-form-label uk-text-bold' for='form-stacked-text'>Descripción Post:</label>
       <div class='uk-form-controls'>
           <input name='post_titleart' class='uk-input descripcion' type='text' placeholder='' maxlength='200' required>
       </div>
   </div>

	<div class='error_msg' style='display: none'></div>
<input type='submit' class='submitbtn' value='Agregar' >
</form>
       </div>
    </li>
</ul>
</div>";

}	
	return $form;

}
add_shortcode('addpost', 'shortcode_mostrar_addptest');

//recibimos los datos desde la funcion ajax para la creacion del post

function custom_submit_post() {	
    global $user_ID;
        $userid  = get_current_user_id();
        
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
           
       $post_information = array(
            'post_title' => $titulo,
            'post_content' => $descripcion,
            'post_status' => 'publish',
            'post_author' => $userid,
            'post_type' => 'post',
        );
        
    $post_id = wp_insert_post( $post_information );
    if ( $post_id ) {
        update_post_meta( $post_id, 'info', 'informacion' ); //Para Agregar postmeta luego de la inserccion del post
    }
    
    wp_die();
    }
    
    add_action( 'wp_ajax_custom_submit_post', 'custom_submit_post' );
    add_action( 'wp_ajax_nopriv_custom_submit_post', 'custom_submit_post' ); //Necesario para usuarios no registrados


?>
