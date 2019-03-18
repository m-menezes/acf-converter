<?php
/*
Plugin Name: ACF Converter
Description: Plugin to ACF, baixar campos personalizados já salvos e converter novamente para Json
Author: Marcelo Menezes
Version: 0.2
*/
add_action('admin_menu', 'acf_converter_init');
 
function acf_converter_init(){
    if(  current_user_can('administrator') ) { 
        add_submenu_page( 'tools.php', 'ACF Converter Page', 'ACF Converter', 'manage_options', 'acf_converter', 'acf_conveter' );
    }
}
 
function acf_conveter(){
    // Verify administrative interface page and user is administrator
    if(is_admin() && current_user_can('administrator')){

        // Register CSS
        add_css_acf_converter();
        
        // Get all fields Groups
        $groups = acf_get_local_field_groups();
        
        // If exist group query, get specific group 
        if($_GET['group']){
            $json = $groups[$_GET['group']];
            $file = '"'.$json['title'].'__'.$_GET['group'].'"';
            $fields = acf_get_local_fields($_GET['group']);
            $json['fields'] = $fields;
            $json = json_encode($json, JSON_PRETTY_PRINT);
        }
        
        // Destroy acf basic group
        unset($groups['group_form_settings']);
        unset($groups['group_entry_data']);
        
        // Create View
        $view = include "admin-view.php";

        // Print View
        echo $view;
    }
}

//Register CSS
function add_css_acf_converter(){
    wp_enqueue_style( 'ACFConverter', plugins_url( '/includes/acf-converter.css' , __FILE__ ), array(), NULL,  $media = 'all' );
}

?>