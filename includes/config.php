<?php
function mostrar_en_head(){
    $screen = get_current_screen();
    if( 'paciente' == $screen->post_type ){
        //elarray($screen, false);
    }
}
add_action('admin_head', 'mostrar_en_head');
/**
 * Agregar estilos a vistas de administrador de iDoctor
 */
function idoctor_admin_scripts(){
    $screen = get_current_screen();
    if( 'paciente' == $screen->post_type ){
        wp_enqueue_style('idoctor-admin', IDOCTOR_PLUGIN_URI . '/css/admin-styles.css', array('cmb2-styles'), NULL, 'screen');
    }
    
}
add_action('admin_enqueue_scripts', 'idoctor_admin_scripts');


/**
 * Cambia el placeholder del input de titulo en el CPT Paciente
 */

function idoctor_change_title_input_pllaceholder( $title ){
     $screen = get_current_screen();
     if  ( 'paciente' == $screen->post_type ) {
          $title = 'Documento de Identidad';
     }
     return $title;
}
add_filter( 'enter_title_here', 'idoctor_change_title_input_pllaceholder' );

function elarray($array, $die = false){
    echo '<pre>';
    var_dump($array);
    echo '</pre>';
    if($die == true){
        die;
    }
}

/**
 * MANEJO DE COLUMNAS PARA ADMINISTRACION EN IDOCTOR
 */

function idoctor_columns_head($defaults){
    if ( $_GET['post_type'] == 'paciente' ){
        $defaults['startdate'] = 'Startdatum';
        $defaults['expert'] = 'Experte';
        $defaults['training'] = 'Name des Trainings';
    }
    return $defaults;
}

function idoctor_columns_content($column_name, $post_ID){
    
    $prefix = 'schnell_';
    
    if ( $column_name == 'startdate'){
        echo str_replace('-', '.', get_post_meta( $post_ID, $prefix . 'startdate', true));
    }
    if ( $column_name == 'expert' ){
        $expert_id = get_post_meta( $post_ID, $prefix . 'mainexpert', true);
        $expert = get_post($expert_id);
        $expertMail = get_post_meta( $expert->ID, $prefix . 'mail', true);
        echo '<span>';
        echo (!empty($expertMail)) ? '<a href="mailto:'.$expertMail.'"><span title="Mail senden" class="dashicons dashicons-email-alt"></span></a> | ' : '';
        echo $expert->post_title . '</span>';
    }
    if ( $column_name == 'training' ){
        $training_id = get_post_meta( $post_ID, $prefix . 'training', true);
        $training = get_post($training_id);
        echo $training->post_title;
    }

}

function schnell_filter_posts_columns( $columns ) {
    if ( $_GET['post_type'] == 'schtra_events' ){
        $columns['title'] = __( 'Ereignisname' );
        $columns['date'] = __( 'Datum' );
    }
    return $columns;
}

//add_filter( 'manage_schtra_events_posts_columns', 'schnell_filter_posts_columns' );
add_filter('manage_posts_columns', 'idoctor_columns_head');
add_action('manage_posts_custom_column', 'idoctor_columns_content', 10, 2);