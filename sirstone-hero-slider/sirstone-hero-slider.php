<?php
/**
 * Plugin Name:       Sirstone Hero Slider for Elementor
 * Plugin URI: https://github.com/saeedamini144/sirstone-hero-slider
 * Description:       ویجت اسلایدر هیرو سیرستون برای المنتور؛ هر اسلاید یک تب مستقل با تنظیمات محتوا، تصویر و استایل کامل، به‌همراه افکت‌های متنوع تصویر و انتقال.
 * Author: Saeed Amini
 * Author URI: https://github.com/saeedamini144
 * Version:           1.0.0
 * Requires PHP:      7.4
 * Requires at least: 6.0
 * Requires Plugins:  elementor
 * Text Domain:       sirstone-hero
 * Elementor tested up to: 4.3.2
 */

defined( 'ABSPATH' ) || exit;

define( 'SSH_HERO_VERSION', '1.0.0' );
define( 'SSH_HERO_FILE', __FILE__ );
define( 'SSH_HERO_PATH', plugin_dir_path( __FILE__ ) );
define( 'SSH_HERO_URL', plugin_dir_url( __FILE__ ) );
define( 'SSH_HERO_MIN_ELEMENTOR', '3.20.0' );

final class SSH_Hero_Slider_Plugin {

	public static function init() {
		add_action( 'plugins_loaded', [ __CLASS__, 'boot' ] );
	}

	public static function boot() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'notice_missing_elementor' ] );
			return;
		}

		if ( ! defined( 'ELEMENTOR_VERSION' ) || version_compare( ELEMENTOR_VERSION, SSH_HERO_MIN_ELEMENTOR, '<' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'notice_old_elementor' ] );
			return;
		}

		add_action( 'elementor/elements/categories_registered', [ __CLASS__, 'register_category' ] );
		add_action( 'elementor/frontend/after_register_styles', [ __CLASS__, 'register_styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ __CLASS__, 'register_scripts' ] );
		add_action( 'elementor/widgets/register', [ __CLASS__, 'register_widgets' ] );
	}

	public static function register_category( $elements_manager ) {
		$elements_manager->add_category( 'sirstone', [
			'title' => esc_html__( 'سیرستون', 'sirstone-hero' ),
			'icon'  => 'eicon-slider-push',
		] );
	}

	public static function register_styles() {
		wp_register_style(
			'ssh-hero-slider',
			SSH_HERO_URL . 'assets/css/sirstone-hero.css',
			[],
			SSH_HERO_VERSION
		);
	}

	public static function register_scripts() {
		wp_register_script(
			'ssh-hero-slider',
			SSH_HERO_URL . 'assets/js/sirstone-hero.js',
			[],
			SSH_HERO_VERSION,
			true
		);
	}

	public static function register_widgets( $widgets_manager ) {
		require_once SSH_HERO_PATH . 'includes/traits/trait-content-controls.php';
		require_once SSH_HERO_PATH . 'includes/traits/trait-style-controls.php';
		require_once SSH_HERO_PATH . 'includes/traits/trait-effects-controls.php';
		require_once SSH_HERO_PATH . 'includes/class-sirstone-hero-widget.php';

		$widgets_manager->register( new \SirstoneHero\Widgets\Sirstone_Hero_Widget() );
	}

	public static function notice_missing_elementor() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		echo '<div class="notice notice-warning is-dismissible"><p>';
		echo esc_html__( 'افزونه «Sirstone Hero Slider for Elementor» برای کار کردن به افزونه المنتور نیاز دارد. لطفاً المنتور را نصب و فعال کنید.', 'sirstone-hero' );
		echo '</p></div>';
	}

	public static function notice_old_elementor() {
		if ( ! current_user_can( 'update_plugins' ) ) {
			return;
		}
		echo '<div class="notice notice-warning is-dismissible"><p>';
		printf(
			/* translators: %s: minimum Elementor version */
			esc_html__( 'افزونه «Sirstone Hero Slider for Elementor» به المنتور نسخه %s یا بالاتر نیاز دارد.', 'sirstone-hero' ),
			esc_html( SSH_HERO_MIN_ELEMENTOR )
		);
		echo '</p></div>';
	}
}

SSH_Hero_Slider_Plugin::init();
