<?php
namespace mp\mvc;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!class_exists('mp\mvc\MP_Controller')) {
	class MP_Controller {
		var $app        = null;
		var $classes    = array();

		function __construct() {
			preg_match('/mp_(.*?)_controller/i', get_class($this), $match);
			$this->app   =   $match[1];
		}

		function display ($vname = '') {
			$admin  =   is_admin() ? '/admin' : '';
			if ($vname) {
				if (file_exists(MUSIC_PRESS_PRO_PLUGIN_DIR . '/includes'.$admin.'/views/'.$this->app.'/'.$this->app.'_'.$vname.'.php'))
					include_once MUSIC_PRESS_PRO_PLUGIN_DIR . '/includes'.$admin.'/views/'.$this->app.'/'.$this->app.'_'.$vname.'.php';
			} else {
				if (file_exists(MUSIC_PRESS_PRO_PLUGIN_DIR . '/includes'.$admin.'/views/'.$this->app.'/'.$this->app.'.php'))
					include_once MUSIC_PRESS_PRO_PLUGIN_DIR . '/includes'.$admin.'/views/'.$this->app.'/'.$this->app.'.php';
			}
		}
	}
}
