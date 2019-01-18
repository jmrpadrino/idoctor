<?php
function idoctor_show_ads(){
    echo '<a href="https://www.pfizer.com.ec/" target="_blank"><img src="' . IDOCTOR_PLUGIN_URI . '/img/ads-placeholder.jpg" class="idoctor-ad-img-placeholder" title="iDoctor - Advertising"></a>';
}
function idoctor_register_meta_boxes() {
    add_meta_box( 'idoctor_ads', 'iDoctor - Advertising', 'idoctor_show_ads', 'paciente', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'idoctor_register_meta_boxes' );

/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'idoctor_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category iDoctor for WordPress
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 $cmb CMB2 object.
 *
 * @return bool      True if metabox should show
 */
function idoctor_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template.
	if ( get_option( 'page_on_front' ) !== $cmb->object_id ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field $field Field object.
 *
 * @return bool              True if metabox should show
 */
function idoctor_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category.
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function idoctor_render_row_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo esc_attr( $classes ); ?>">
		<p><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></p>
		<p><input id="<?php echo esc_attr( $id ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>"/></p>
		<p class="description"><?php echo esc_html( $description ); ?></p>
	</div>
	<?php
}

/**
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function idoctor_display_text_small_column( $field_args, $field ) {
	?>
	<div class="custom-column-display <?php echo esc_attr( $field->row_classes() ); ?>">
		<p><?php echo $field->escaped_value(); ?></p>
		<p class="description"><?php echo esc_html( $field->args( 'description' ) ); ?></p>
	</div>
	<?php
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array      $field_args Array of field parameters.
 * @param  CMB2_Field $field      Field object.
 */
function idoctor_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

add_action( 'cmb2_admin_init', 'idoctor_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function idoctor_register_demo_metabox() {
	$prefix = 'idoctor_';
    
    /**
     * DATOS PERSONALES
     */
    
    $cmb_identificacion = new_cmb2_box( array(
		'id'            => $prefix . 'identificacion',
		'title'         => esc_html__( 'Identificación', 'idoctor' ),
		'object_types'  => array( 'paciente' ), // Post type
        'context'       => 'side',
        'priority'      => 'high'
        )
    );
    
    $cmb_identificacion->add_field( array(
		'name'       => esc_html__( 'Número de Seguro Social (IESS)', 'idoctor' ),
		'desc'       => esc_html__( 'ejm. 1758930001', 'idoctor' ),
		'id'         => $prefix . 'idiess',
		'type'       => 'text',
	) );
    
    $cmb_datos_personales = new_cmb2_box( array(
		'id'            => $prefix . 'datos_personales',
		'title'         => esc_html__( 'Datos Personales', 'idoctor' ),
		'object_types'  => array( 'paciente' ), // Post type
        )
    );
    
    $cmb_datos_personales->add_field( array(
		'name'       => esc_html__( 'Apellidos', 'idoctor' ),
		'id'         => $prefix . 'papellidos',
		'type'       => 'text',
	) );
    $cmb_datos_personales->add_field( array(
		'name'       => esc_html__( 'Nombres', 'idoctor' ),
		'id'         => $prefix . 'pnombres',
		'type'       => 'text',
	) );
    $cmb_datos_personales->add_field( array(
		'name'       => esc_html__( 'Fecha de Nacimiento', 'idoctor' ),
		'id'         => $prefix . 'fnac',
		'type'       => 'text_date',
	) );
    $cmb_datos_personales->add_field( array(
		'name'       => esc_html__( 'Lugar de Nacimiento', 'idoctor' ),
		'id'         => $prefix . 'lnac',
		'type'       => 'text',
	) );
    $cmb_datos_personales->add_field( array(
		'name'       => esc_html__( 'Nacionalidad', 'idoctor' ),
		'id'         => $prefix . 'nacionalidad',
		'type'       => 'text',
	) );
    $cmb_datos_personales->add_field( array(
		'name'       => esc_html__( 'Idioma', 'idoctor' ),
		'id'         => $prefix . 'idioma',
		'type'             => 'select',
		'show_option_none' => 'Seleccione',
		'options'          => array(
			'esp' => esc_html__( 'Español', 'idoctor' ),
			'eng'   => esc_html__( 'Ingles', 'idoctor' ),
			'otro'     => esc_html__( 'Otro', 'idoctor' ),
		),
	) );
    $cmb_datos_personales->add_field( array(
		'name'       => esc_html__( 'Sexo', 'idoctor' ),
		'id'         => $prefix . 'sexo',
		'type'             => 'select',
		'show_option_none' => 'Seleccione',
		'options'          => array(
			'masculino' => esc_html__( 'Masculino', 'idoctor' ),
			'femenino'   => esc_html__( 'Femenino', 'idoctor' ),
			'otro'     => esc_html__( 'Otro', 'idoctor' ),
		),
	) );
    $cmb_datos_personales->add_field( array(
		'name'       => esc_html__( 'Estado Civil', 'idoctor' ),
		'id'         => $prefix . 'ecivil',
		'type'             => 'select',
		'show_option_none' => 'Seleccione',
		'options'          => array(
			'soltero' => esc_html__( 'Soltero/a', 'idoctor' ),
			'casado'   => esc_html__( 'Casado/a', 'idoctor' ),
			'pareja'   => esc_html__( 'Pareja de Hecho Registrada', 'idoctor' ),
			'separado'     => esc_html__( 'Separado/a', 'idoctor' ),
			'divorciado'     => esc_html__( 'Divorciado/a', 'idoctor' ),
			'viudo'     => esc_html__( 'Viudo/a', 'idoctor' ),
		),
	) );
    $cmb_datos_personales->add_field( array(
		'name'       => esc_html__( 'Profesión', 'idoctor' ),
		'id'         => $prefix . 'profesion',
		'type'       => 'text',
	) );

	/**
     * DOMICILO FISCAL / DIRECCIONES
     */
    $cmb_domicilio_fiscal = new_cmb2_box( array(
		'id'            => $prefix . 'domicilio_fiscal',
		'title'         => esc_html__( 'Información de Contacto / Domicilio Fiscal', 'idoctor' ),
		'object_types'  => array( 'paciente' ), // Post type
        )
    );
    $cmb_domicilio_fiscal->add_field( array(
		'name'       => esc_html__( 'Calle / Número', 'idoctor' ),
		'id'         => $prefix . 'dpcalle',
		'type'       => 'text',
	) );
    $cmb_domicilio_fiscal->add_field( array(
		'name'       => esc_html__( 'Código Postal', 'idoctor' ),
		'id'         => $prefix . 'dppostal',
		'type'       => 'text',
	) );
    $cmb_domicilio_fiscal->add_field( array(
		'name'       => esc_html__( 'Ciudad', 'idoctor' ),
		'id'         => $prefix . 'dpciudad',
		'type'       => 'text',
	) );
    $cmb_domicilio_fiscal->add_field( array(
		'name'       => esc_html__( 'Provincia', 'idoctor' ),
		'id'         => $prefix . 'dpprovincia',
		'type'       => 'text',
	) );
    $cmb_domicilio_fiscal->add_field( array(
		'name'       => esc_html__( 'País', 'idoctor' ),
		'id'         => $prefix . 'dppais',
		'type'       => 'text',
	) );
    $cmb_domicilio_fiscal->add_field( array(
		'name'       => esc_html__( 'Teléfono', 'idoctor' ),
		'id'         => $prefix . 'dptelefono',
		'type'       => 'text',
	) );
    $cmb_domicilio_fiscal->add_field( array(
		'name'       => esc_html__( 'Móvil', 'idoctor' ),
		'id'         => $prefix . 'dpmovil',
		'type'       => 'text',
	) );
    $cmb_domicilio_fiscal->add_field( array(
		'name'       => esc_html__( 'Correo Electrónico', 'idoctor' ),
		'id'         => $prefix . 'dpemail',
		'type'       => 'text_email',
	) );
    $cmb_domicilio_fiscal->add_field( array(
		'name' => esc_html__( 'Otro Domicilio', 'cmb2' ),
		'id'   => $prefix . 'title',
		'type' => 'title',
	) );
    $cmb_domicilio_fiscal->add_field( array(
		//'name' => esc_html__( 'Publicidad', 'cmb2' ),
		'desc' => '<a href="https://www.pfizer.com.ec/" target="_blank"><img src="' . IDOCTOR_PLUGIN_URI . '/img/ads-placeholder-2.jpg" class="idoctor-ad-img-placeholder" title="iDoctor - Advertising"></a>',
		'id'   => $prefix . 'banner_ad',
		'type' => 'title',
	) );
    /**
     * INFORMACION LABORAL
     */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Domiciio Fiscal / Dirección', 'idoctor' ),
		'object_types'  => array( 'paciente' ), // Post type
		// 'show_on_cb' => 'idoctor_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'idoctor_add_some_classes', // Add classes through a callback.

		/*
		 * The following parameter is any additional arguments passed as $callback_args
		 * to add_meta_box, if/when applicable.
		 *
		 * CMB2 does not use these arguments in the add_meta_box callback, however, these args
		 * are parsed for certain special properties, like determining Gutenberg/block-editor
		 * compatibility.
		 *
		 * Examples:
		 *
		 * - Make sure default editor is used as metabox is not compatible with block editor
		 *      [ '__block_editor_compatible_meta_box' => false/true ]
		 *
		 * - Or declare this box exists for backwards compatibility
		 *      [ '__back_compat_meta_box' => false ]
		 *
		 * More: https://wordpress.org/gutenberg/handbook/extensibility/meta-box/
		 */
		// 'mb_callback_args' => array( '__block_editor_compatible_meta_box' => false ),
	) );

	$cmb_demo->add_field( array(
		'name'       => esc_html__( 'Test Text', 'cmb2' ),
		'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => $prefix . 'text',
		'type'       => 'text',
		'show_on_cb' => 'idoctor_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
		// 'column'          => true, // Display field value in the admin post-listing columns
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Small', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textsmall',
		'type' => 'text_small',
		// 'repeatable' => true,
		// 'column' => array(
		// 	'name'     => esc_html__( 'Column Title', 'cmb2' ), // Set the admin column title
		// 	'position' => 2, // Set as the second column.
		// );
		// 'display_cb' => 'idoctor_display_text_small_column', // Output the display of the column values through a callback.
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Medium', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textmedium',
		'type' => 'text_medium',
	) );

	$cmb_demo->add_field( array(
		'name'       => esc_html__( 'Read-only Disabled Field', 'cmb2' ),
		'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => $prefix . 'readonly',
		'type'       => 'text_medium',
		'default'    => md5(current_time('Y-m-d H:m:s')),
		'save_field' => true, // Disables the saving of this field.
		'attributes' => array(
			'disabled' => 'disabled',
			'readonly' => 'readonly',
		),
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Custom Rendered Field', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'render_row_cb',
		'type' => 'text',
		'render_row_cb' => 'idoctor_render_row_cb',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Website URL', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'url',
		'type' => 'text_url',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Email', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'email',
		'type' => 'text_email',
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Time', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'time',
		'type' => 'text_time',
		// 'time_format' => 'H:i', // Set to 24hr format
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Time zone', 'cmb2' ),
		'desc' => esc_html__( 'Time zone', 'cmb2' ),
		'id'   => $prefix . 'timezone',
		'type' => 'select_timezone',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Date Picker', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textdate',
		'type' => 'text_date',
		// 'date_format' => 'Y-m-d',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Date Picker (UNIX timestamp)', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textdate_timestamp',
		'type' => 'text_date_timestamp',
		// 'timezone_meta_key' => $prefix . 'timezone', // Optionally make this field honor the timezone selected in the select_timezone specified above
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Date/Time Picker Combo (UNIX timestamp)', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'datetime_timestamp',
		'type' => 'text_datetime_timestamp',
	) );

	// This text_datetime_timestamp_timezone field type
	// is only compatible with PHP versions 5.3 or above.
	// Feel free to uncomment and use if your server meets the requirement
	// $cmb_demo->add_field( array(
	// 	'name' => esc_html__( 'Test Date/Time Picker/Time zone Combo (serialized DateTime object)', 'cmb2' ),
	// 	'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
	// 	'id'   => $prefix . 'datetime_timestamp_timezone',
	// 	'type' => 'text_datetime_timestamp_timezone',
	// ) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Money', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textmoney',
		'type' => 'text_money',
		// 'before_field' => '£', // override '$' symbol if needed
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Test Color Picker', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'colorpicker',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
		// 'options' => array(
		// 	'alpha' => true, // Make this a rgba color picker.
		// ),
		// 'attributes' => array(
		// 	'data-colorpicker' => json_encode( array(
		// 		'palettes' => array( '#3dd0cc', '#ff834c', '#4fa2c0', '#0bc991', ),
		// 	) ),
		// ),
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Area', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textarea',
		'type' => 'textarea',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Area Small', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textareasmall',
		'type' => 'textarea_small',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Area for Code', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'textarea_code',
		'type' => 'textarea_code',
		// 'attributes' => array(
		// 	// Optionally override the code editor defaults.
		// 	'data-codeeditor' => json_encode( array(
		// 		'codemirror' => array(
		// 			'lineNumbers' => false,
		// 			'mode' => 'css',
		// 		),
		// 	) ),
		// ),
		// To keep the previous formatting, you can disable codemirror.
		// 'options' => array( 'disable_codemirror' => true ),
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Title Weeeee', 'cmb2' ),
		'desc' => esc_html__( 'This is a title description', 'cmb2' ),
		'id'   => $prefix . 'title',
		'type' => 'title',
	) );

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Test Select', 'cmb2' ),
		'desc'             => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'               => $prefix . 'select',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'standard' => esc_html__( 'Option One', 'cmb2' ),
			'custom'   => esc_html__( 'Option Two', 'cmb2' ),
			'none'     => esc_html__( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Test Radio inline', 'cmb2' ),
		'desc'             => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'               => $prefix . 'radio_inline',
		'type'             => 'radio_inline',
		'show_option_none' => 'No Selection',
		'options'          => array(
			'standard' => esc_html__( 'Option One', 'cmb2' ),
			'custom'   => esc_html__( 'Option Two', 'cmb2' ),
			'none'     => esc_html__( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Test Radio', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'radio',
		'type'    => 'radio',
		'options' => array(
			'option1' => esc_html__( 'Option One', 'cmb2' ),
			'option2' => esc_html__( 'Option Two', 'cmb2' ),
			'option3' => esc_html__( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'     => esc_html__( 'Test Taxonomy Radio', 'cmb2' ),
		'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'text_taxonomy_radio',
		'type'     => 'taxonomy_radio', // Or `taxonomy_radio_inline`/`taxonomy_radio_hierarchical`
		'taxonomy' => 'category', // Taxonomy Slug
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name'     => esc_html__( 'Test Taxonomy Select', 'cmb2' ),
		'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'taxonomy_select',
		'type'     => 'taxonomy_select',
		'taxonomy' => 'category', // Taxonomy Slug
	) );

	$cmb_demo->add_field( array(
		'name'     => esc_html__( 'Test Taxonomy Multi Checkbox', 'cmb2' ),
		'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'multitaxonomy',
		'type'     => 'taxonomy_multicheck', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`
		'taxonomy' => 'post_tag', // Taxonomy Slug
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Checkbox', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'checkbox',
		'type' => 'checkbox',
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Test Multi Checkbox', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'multicheckbox',
		'type'    => 'multicheck',
		// 'multiple' => true, // Store values in individual rows
		'options' => array(
			'check1' => esc_html__( 'Check One', 'cmb2' ),
			'check2' => esc_html__( 'Check Two', 'cmb2' ),
			'check3' => esc_html__( 'Check Three', 'cmb2' ),
		),
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Test wysiwyg', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'wysiwyg',
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 5,
		),
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Image', 'cmb2' ),
		'desc' => esc_html__( 'Upload an image or enter a URL.', 'cmb2' ),
		'id'   => $prefix . 'image',
		'type' => 'file',
	) );

	$cmb_demo->add_field( array(
		'name'         => esc_html__( 'Multiple Files', 'cmb2' ),
		'desc'         => esc_html__( 'Upload or add multiple images/attachments.', 'cmb2' ),
		'id'           => $prefix . 'file_list',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'oEmbed', 'cmb2' ),
		'desc' => sprintf(
			/* translators: %s: link to codex.wordpress.org/Embeds */
			esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at %s.', 'cmb2' ),
			'<a href="https://codex.wordpress.org/Embeds">codex.wordpress.org/Embeds</a>'
		),
		'id'   => $prefix . 'embed',
		'type' => 'oembed',
	) );

	$cmb_demo->add_field( array(
		'name'         => 'Testing Field Parameters',
		'id'           => $prefix . 'parameters',
		'type'         => 'text',
		'before_row'   => 'idoctor_before_row_if_2', // callback.
		'before'       => '<p>Testing <b>"before"</b> parameter</p>',
		'before_field' => '<p>Testing <b>"before_field"</b> parameter</p>',
		'after_field'  => '<p>Testing <b>"after_field"</b> parameter</p>',
		'after'        => '<p>Testing <b>"after"</b> parameter</p>',
		'after_row'    => '<p>Testing <b>"after_row"</b> parameter</p>',
	) );

}

add_action( 'cmb2_admin_init', 'idoctor_register_about_page_metabox' );
/**
 * Hook in and add a metabox that only appears on the 'About' page
 */
function idoctor_register_about_page_metabox() {
	$prefix = 'idoctor_about_';

	/**
	 * Metabox to be displayed on a single page ID
	 */
	$cmb_about_page = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => esc_html__( 'About Page Metabox', 'cmb2' ),
		'object_types' => array( 'paciente' ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left
		'show_on'      => array(
			'id' => array( 2 ),
		), // Specific post IDs to display this metabox
	) );

	$cmb_about_page->add_field( array(
		'name' => esc_html__( 'Test Text', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'text',
		'type' => 'text',
	) );

}

add_action( 'cmb2_admin_init', 'idoctor_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function idoctor_register_repeatable_group_field_metabox() {
	$prefix = 'idoctor_group_';

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => esc_html__( 'Repeating Field Group', 'cmb2' ),
		'object_types' => array( 'paciente' ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'demo',
		'type'        => 'group',
		'description' => esc_html__( 'Generates reusable form entries', 'cmb2' ),
		'options'     => array(
			'group_title'    => esc_html__( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'     => esc_html__( 'Add Another Entry', 'cmb2' ),
			'remove_button'  => esc_html__( 'Remove Entry', 'cmb2' ),
			'sortable'       => true,
			// 'closed'      => true, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Entry Title', 'cmb2' ),
		'id'         => 'title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => esc_html__( 'Description', 'cmb2' ),
		'description' => esc_html__( 'Write a short description for this entry', 'cmb2' ),
		'id'          => 'description',
		'type'        => 'textarea_small',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => esc_html__( 'Entry Image', 'cmb2' ),
		'id'   => 'image',
		'type' => 'file',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => esc_html__( 'Image Caption', 'cmb2' ),
		'id'   => 'image_caption',
		'type' => 'text',
	) );

}

add_action( 'cmb2_admin_init', 'idoctor_register_user_profile_metabox' );
/**
 * Hook in and add a metabox to add fields to the user profile pages
 */
function idoctor_register_user_profile_metabox() {
	$prefix = 'idoctor_user_';

	/**
	 * Metabox for the user profile screen
	 */
	$cmb_user = new_cmb2_box( array(
		'id'               => $prefix . 'edit',
		'title'            => esc_html__( 'User Profile Metabox', 'cmb2' ), // Doesn't output for user boxes
		'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
		'show_names'       => true,
		'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
	) );

	$cmb_user->add_field( array(
		'name'     => esc_html__( 'Extra Info', 'cmb2' ),
		'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'       => $prefix . 'extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );

	$cmb_user->add_field( array(
		'name'    => esc_html__( 'Avatar', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => $prefix . 'avatar',
		'type'    => 'file',
	) );

	$cmb_user->add_field( array(
		'name' => esc_html__( 'Facebook URL', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'facebookurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => esc_html__( 'Twitter URL', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'twitterurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => esc_html__( 'Google+ URL', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'googleplusurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => esc_html__( 'Linkedin URL', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'linkedinurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => esc_html__( 'User Field', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix . 'user_text_field',
		'type' => 'text',
	) );

}


 

/**
 * Callback to define the optionss-saved message.
 *
 * @param CMB2  $cmb The CMB2 object.
 * @param array $args {
 *     An array of message arguments
 *
 *     @type bool   $is_options_page Whether current page is this options page.
 *     @type bool   $should_notify   Whether options were saved and we should be notified.
 *     @type bool   $is_updated      Whether options were updated with save (or stayed the same).
 *     @type string $setting         For add_settings_error(), Slug title of the setting to which
 *                                   this error applies.
 *     @type string $code            For add_settings_error(), Slug-name to identify the error.
 *                                   Used as part of 'id' attribute in HTML output.
 *     @type string $message         For add_settings_error(), The formatted message text to display
 *                                   to the user (will be shown inside styled `<div>` and `<p>` tags).
 *                                   Will be 'Settings updated.' if $is_updated is true, else 'Nothing to update.'
 *     @type string $type            For add_settings_error(), Message type, controls HTML class.
 *                                   Accepts 'error', 'updated', '', 'notice-warning', etc.
 *                                   Will be 'updated' if $is_updated is true, else 'notice-warning'.
 * }
 */
function idoctor_options_page_message_callback( $cmb, $args ) {
	if ( ! empty( $args['should_notify'] ) ) {

		if ( $args['is_updated'] ) {

			// Modify the updated message.
			$args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'cmb2' ), $cmb->prop( 'title' ) );
		}

		add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
	}
}



