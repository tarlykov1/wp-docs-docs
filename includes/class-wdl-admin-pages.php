<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Admin_Pages {
    public function __construct(){ add_action('admin_menu',array($this,'menu')); add_action('admin_enqueue_scripts',array($this,'assets')); }
    public function menu(){ add_submenu_page('edit.php?post_type=wdl_document','Настройки','Настройки','manage_options','wdl-settings',array($this,'settings_page')); add_submenu_page('edit.php?post_type=wdl_document','Инструкция','Инструкция','manage_options','wdl-help',array($this,'help_page')); }
    public function assets(){ wp_enqueue_style('wdl-admin',WDL_PLUGIN_URL.'assets/css/admin.css',array(),WDL_PLUGIN_VERSION); }
    public function settings_page(){ $opts=wp_parse_args((array)get_option(WDL_Settings::OPTION_KEY,array()),WDL_Settings::defaults()); include WDL_PLUGIN_DIR.'templates/admin-settings.php'; }
    public function help_page(){ include WDL_PLUGIN_DIR.'templates/admin-help.php'; }
}
