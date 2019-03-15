<?php
/*
Plugin Name: ACF Converter
Description: Plugin to ACF, baixar campos personalizados já salvos e converter novamente para Json
Author: Marcelo Menezes
Version: 0.1
*/
add_action('admin_menu', 'acf_converter_init');
 
function acf_converter_init(){
    if(  current_user_can('administrator') ) { 
        add_submenu_page( 'tools.php', 'ACF Converter Page', 'ACF Converter', 'manage_options', 'acf_converter', 'acf_conveter' );
    }
}
 
function acf_conveter(){
        $groups = acf_get_local_field_groups();
        if($_GET['group']){
            $json = $groups[$_GET['group']];
            $file = '"'.$json['title'].'__'.$_GET['group'].'"';
            $fields = acf_get_local_fields($_GET['group']);
            $json['fields'] = $fields;
            $json = json_encode($json, JSON_PRETTY_PRINT);
        }
        unset($groups['group_form_settings']);
        unset($groups['group_entry_data']);
        $view = include "admin-view.php";
        echo $view;
}

wp_enqueue_style( 'ACFConverter', plugins_url( '/includes/acf-converter.css' , __FILE__ ), array(), NULL,  $media = 'all' );
?>