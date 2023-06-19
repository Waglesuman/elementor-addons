<?php
/**
 * Plugin Name: Elementor Addons
 * Description: Simple hello world widgets for Elementor.
 * Version:     1.0.0
 * Author:      Elementor Developer
 * Author URI:  https://developers.elementor.com/
 * Text Domain: elementor-addon
 */

function register_hello_world_widget($widgets_manager)
{
  require_once(__DIR__ . '/widgets/hello-world-widget-1.php');
  require_once(__DIR__ . '/widgets/hello-world-widget-2.php');
  require_once(__DIR__ . '/widgets/login-form.php');
  require_once(__DIR__ . '/widgets/repeater.php');
  require_once(__DIR__ . '/widgets/repeater2.php');

  $widgets_manager->register(new \Elementor_Hello_World_Widget_1());
  $widgets_manager->register(new \Elementor_Hello_World_Widget_2());
  $widgets_manager->register(new \Elementor_login_form());
  $widgets_manager->register(new \Elementor_Test_Widget);
  $widgets_manager->register(new \Elementor_Repeater_Widget);

}
add_action('elementor/widgets/register', 'register_hello_world_widget');

// Register style sheet.
function register_widget_styles()
{
  wp_register_style('repeater-widget', plugins_url('assets/css/repeater-widget.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'register_widget_styles');

// Register script.
function register_widget_scripts()
{
  wp_register_script('repeater-widget', plugins_url('assets/js/repeater-widget.js', __FILE__));
}
add_action('wp_enqueue_scripts', 'register_widget_scripts');