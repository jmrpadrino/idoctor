<?php
/**
 * REGISTRO DE POST TYPE PARA PACIENTES
 */

if ( ! function_exists('idoctor_paciente') ) {

function idoctor_paciente() {

	$labels = array(
		'name'                  => _x( 'Pacientes', 'Post Type General Name', 'idoctor' ),
		'singular_name'         => _x( 'Paciente', 'Post Type Singular Name', 'idoctor' ),
		'menu_name'             => __( 'Pacientes', 'idoctor' ),
		'name_admin_bar'        => __( 'Paciente', 'idoctor' ),
		'archives'              => __( 'Archivo de pacientes', 'idoctor' ),
		'attributes'            => __( 'Atributos del paciente', 'idoctor' ),
		'parent_item_colon'     => __( 'Paciente Padre', 'idoctor' ),
		'all_items'             => __( 'Todos los pacientes', 'idoctor' ),
		'add_new_item'          => __( 'Agregar nuevo paciente', 'idoctor' ),
		'add_new'               => __( 'Agregar nuevo', 'idoctor' ),
		'new_item'              => __( 'Nuevo paciente', 'idoctor' ),
		'edit_item'             => __( 'Editar paciente', 'idoctor' ),
		'update_item'           => __( 'Actualizar paciente', 'idoctor' ),
		'view_item'             => __( 'Ver paciente', 'idoctor' ),
		'view_items'            => __( 'Ver pacientes', 'idoctor' ),
		'search_items'          => __( 'Buscar paciente', 'idoctor' ),
		'not_found'             => __( 'Paciente no encontrado', 'idoctor' ),
		'not_found_in_trash'    => __( 'Paciente no encontrado en papelera', 'idoctor' ),
		'featured_image'        => __( 'Foto del paciente', 'idoctor' ),
		'set_featured_image'    => __( 'Colocar foto del paciente', 'idoctor' ),
		'remove_featured_image' => __( 'Quitar foto del paciente', 'idoctor' ),
		'use_featured_image'    => __( 'Usar como foto del paciente', 'idoctor' ),
		'insert_into_item'      => __( 'Insertar', 'idoctor' ),
		'uploaded_to_this_item' => __( 'Cargar', 'idoctor' ),
		'items_list'            => __( 'Lista de pacientes', 'idoctor' ),
		'items_list_navigation' => __( 'navegacion de lista de pacientes', 'idoctor' ),
		'filter_items_list'     => __( 'Filtrar lista de pacientes', 'idoctor' ),
	);
	$rewrite = array(
		'slug'                  => 'paciente',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$capabilities = array(
		'edit_post'             => 'edit_paciente',
		'read_post'             => 'read_pacientes',
		'delete_post'           => 'delete_paciente',
		'edit_posts'            => 'edit_pacientes',
		'edit_others_posts'     => 'edit_others_pacientes',
		'publish_posts'         => 'publish_pacientes',
		'read_private_posts'    => 'read_private_pacientes',
	);
	$args = array(
		'label'                 => __( 'Paciente', 'idoctor' ),
		'description'           => __( 'Información General del Paciente', 'idoctor' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'pacientes',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'query_var'             => 'paciente',
		'rewrite'               => $rewrite,
		//'capabilities'          => $capabilities,
		'capabilities_type'     => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'pacientes',
	);
	register_post_type( 'paciente', $args );

}
add_action( 'init', 'idoctor_paciente', 0 );

}