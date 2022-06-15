<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function mp_doing_it_wrong( $function, $message, $version ) {
    $message .= ' Backtrace: ' . wp_debug_backtrace_summary();

    if ( is_ajax() ) {
        do_action( 'doing_it_wrong_run', $function, $message, $version );
        error_log( "{$function} was called incorrectly. {$message}. This message was added in version {$version}." );
    } else {
        _doing_it_wrong( $function, $message, $version );
    }
}

function mp_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    if ( ! empty( $args ) && is_array( $args ) ) {
        extract( $args );
    }

    $located = mp_locate_template( $template_name, $template_path, $default_path );

    if ( ! file_exists( $located ) ) {
        mp_doing_it_wrong( __FUNCTION__, sprintf( esc_html__( '%s does not exist.', 'woocommerce' ), '<code>' . $located . '</code>' ), '2.1' );
        return;
    }

    // Allow 3rd party plugin filter template file from their plugin.
    $located = apply_filters( 'mp_get_template', $located, $template_name, $args, $template_path, $default_path );

    do_action( 'mp_before_template_part', $template_name, $template_path, $located, $args );

    include( $located );

    do_action( 'mp_after_template_part', $template_name, $template_path, $located, $args );
}

function mp_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    global $music_press_pro;
    if ( ! $template_path ) {
        $template_path = $music_press_pro->music_press_pro_template_path();
    }

    if ( ! $default_path ) {
        $default_path =$music_press_pro->music_press_pro_plugin_path() . '/templates/';
    }

    // Look within passed path within the theme - this is priority.
    $template = locate_template(
        array(
            trailingslashit( $template_path ) . $template_name,
            $template_name,
        )
    );

    // Get default template/
    if ( ! $template || TZ_MUSIC_TEMPLATE_DEBUG_MODE ) {
        $template = $default_path . $template_name;
    }

    // Return what we found.
    return apply_filters( 'music_press_pro_locate_template', $template, $template_name, $template_path );
}

/**
 * @param $url
 */
function mp_js_redirect( $url ) {
	if (headers_sent() || empty( $url )) {
		//for blank redirects
		if ('' == $url) {
			$url = set_url_scheme( '//' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] );
		}

		$funtext = "echo \"<script data-cfasync='false' type='text/javascript'>window.location = '" . $url . "'</script>\";";
		register_shutdown_function( create_function( '', $funtext ) );

		if (1 < ob_get_level()) {
			while (ob_get_level() > 1) {
				ob_end_clean();
			}
		}

		?>
		<script data-cfasync='false' type="text/javascript">
            window.location = '<?php echo $url; ?>';
		</script>
		<?php
		exit;
	} else {
		wp_redirect( $url );
	}
	exit;
}

function mp_check_current_screen() {
    return get_current_screen();
}

if ( ! function_exists( 'is_ajax' ) ) {

    /**
     * is_ajax - Returns true when the page is loaded via ajax.
     * @return bool
     */
    function is_ajax() {
        return defined( 'DOING_AJAX' );
    }
}

function mp_deprecated_function( $function, $version, $replacement = null ) {
    if ( is_ajax() ) {
        do_action( 'deprecated_function_run', $function, $replacement, $version );
        $log_string  = "The {$function} function is deprecated since version {$version}.";
        $log_string .= $replacement ? " Replace with {$replacement}." : '';
        error_log( $log_string );
    } else {
        _deprecated_function( $function, $version, $replacement );
    }
}
function music_press_pro_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    mp_deprecated_function( __FUNCTION__, '3.0', 'mp_locate_template' );
    return mp_locate_template( $template_name, $template_path, $default_path );
}