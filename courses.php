<?php
/**
 * @package Courses
 * @version 1
 */
/*
Plugin Name: Nivas Courses
Description: This is Courses Management Plugin
Author: Nivas Sivanadian
Version: 1
Author URI: http://nivas.me/
License:     GPL2
 
Nivas Courses is free software: you can redistribute it and/or modify
*/
defined( 'ABSPATH' ) or die( 'err!' );
if ( ! class_exists( 'nivasCoursesClass' ) ) {
	class nivasCoursesClass {
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}
		protected function _constants() {
			define( 'COURSES_PLUGIN_SLUG', 'courses' );
			define( 'COURSESTXTDM', 'courses-table' );
		}
		protected function _hooks() {
			add_action( 'admin_menu', array( $this, 'courses_menu' ), 101 );
			add_action( 'init', array( $this, 'Courses' ));
			add_action( 'add_meta_boxes', array( $this, 'admin_add_meta_box' ) );
			add_action( 'admin_init', array( $this, 'admin_add_meta_box' ) );
			add_action('save_post', array(&$this, 'courses_save_settings'));
			
		}
		public function courses_menu() {
			
		}
		public function Courses() {
			
			register_post_type( 'Courses',
			array(
				'labels' => array(
				'name'               => __('Courses', 'bonestheme'),
				'singular_name'      => __('Course', 'bonestheme'),
				'add_new_item'       => __('Add New Course', 'bonestheme'),
				'edit_item'          => __('Edit Course', 'bonestheme'),
				'new_item'           => __('New Course', 'bonestheme'),
				'view_item'          => __('View Course', 'bonestheme'),
				'search_items'       => __('Search Courses', 'bonestheme'),
				'not_found'          => __('No Course Found', 'bonestheme'),
				'not_found_in_trash' => __('No Course found in Trash', 'bonestheme')
			),
			'description'          => 'Represents a single Course.',
			'hierarchical'         => false,
			'menu_icon'            => 'dashicons-calendar',
			'menu_position'        => 5,
			'capability_type'    => 'post',
			'public'               => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'has_archive'        => true,
			'rewrite'              => array( 'slug' => 'courses' ),
			//'hierarchical'       => true,
			'show_in_admin_bar'    => false,
			'show_in_nav_menus'    => true,
			'show_ui'              => true,
			'supports'             => array('title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes')
			));
		}
		public function admin_add_meta_box() {
			add_meta_box( __('Add Course'), __('Course Details'), array(&$this, 'courses_upload'), 'courses', 'normal', 'default' );
		}
		public function courses_upload($post) {		
			require_once('include/add-new-courses.php');
			wp_nonce_field( 'course_post_save_settings', 'course_post_save_nonce' );
		}
		public function courses_save_settings($post_id) {
			if(isset($_POST['course_post_save_nonce'])) {
				if ( !isset( $_POST['course_post_save_nonce'] ) || !wp_verify_nonce( $_POST['course_post_save_nonce'], 'course_post_save_settings' ) ) {
					print 'Sorry, your nonce did not verify.';
					exit;
				} else {
					
					$courses_table_meta_key = "courses_table_data_".$post_id;
					update_post_meta($post_id, $courses_table_meta_key, $_POST);
				}
			}
		}
	}
	$nivasCoursesClass_object = new nivasCoursesClass();
	require_once('shotcode.php');
}