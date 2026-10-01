<?php
namespace SirstoneHero\Widgets;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Widget_Base;

defined( 'ABSPATH' ) || exit;

class Sirstone_Hero_Widget extends Widget_Base {

	use Content_Controls;
	use Style_Controls;
	use Effects_Controls;

	/** Selector prefix for widget-wide controls. */
	const R = '{{WRAPPER}} .ssh-hero';

	/** Selector prefix for per-slide (repeater) controls. */
	const RI = '{{WRAPPER}} {{CURRENT_ITEM}}';

	const SVG_PREV = '<svg viewBox="0 0 24 24" width="1em" height="1em" aria-hidden="true" focusable="false"><path d="M19 12H5M11 6l-6 6 6 6"/></svg>';
	const SVG_NEXT = '<svg viewBox="0 0 24 24" width="1em" height="1em" aria-hidden="true" focusable="false"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
	const SVG_PAUSE = '<svg class="ssh-ctrl__pause" viewBox="0 0 24 24" width="1em" height="1em" aria-hidden="true" focusable="false"><path d="M9 5v14M15 5v14"/></svg>';
	const SVG_PLAY = '<svg class="ssh-ctrl__play" viewBox="0 0 24 24" width="1em" height="1em" aria-hidden="true" focusable="false"><path d="M8 5l11 7-11 7z"/></svg>';

	public function get_name() {
		return 'sirstone-hero-slider';
	}

	public function get_title() {
		return esc_html__( 'اسلایدر هیرو سیرستون', 'sirstone-hero' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'sirstone', 'general' ];
	}

	public function get_keywords() {
		return [ 'slider', 'hero', 'sirstone', 'carousel', 'slides', 'اسلایدر', 'هیرو', 'سیرستون' ];
	}

	public function get_style_depends(): array {
		return [ 'ssh-hero-slider' ];
	}

	public function get_script_depends(): array {
		return [ 'ssh-hero-slider' ];
	}

	public function has_widget_inner_wrapper(): bool {
		return false;
	}

	/* -----------------------------------------------------------------
	 * Option lists
	 * -------------------------------------------------------------- */

	public static function transitions() {
		return [
			'diagonal' => esc_html__( 'پرده مورب (سیرستون)', 'sirstone-hero' ),
			'fade'     => esc_html__( 'محو شدن (Fade)', 'sirstone-hero' ),
			'slide'    => esc_html__( 'اسلاید افقی', 'sirstone-hero' ),
			'zoom'     => esc_html__( 'زوم و محو', 'sirstone-hero' ),
			'blur'     => esc_html__( 'محو با بلور', 'sirstone-hero' ),
			'circle'   => esc_html__( 'آشکارسازی دایره‌ای', 'sirstone-hero' ),
			'wipe-x'   => esc_html__( 'پرده افقی', 'sirstone-hero' ),
			'wipe-y'   => esc_html__( 'پرده عمودی', 'sirstone-hero' ),
			'split-x'  => esc_html__( 'باز شدن از وسط (افقی)', 'sirstone-hero' ),
			'split-y'  => esc_html__( 'باز شدن از وسط (عمودی)', 'sirstone-hero' ),
			'blinds'   => esc_html__( 'کرکره‌ای (Blinds)', 'sirstone-hero' ),
			'none'     => esc_html__( 'بدون افکت', 'sirstone-hero' ),
		];
	}

	public static function motions() {
		return [
			'none'      => esc_html__( 'بدون حرکت', 'sirstone-hero' ),
			'zoom-in'   => esc_html__( 'زوم آرام به داخل', 'sirstone-hero' ),
			'zoom-out'  => esc_html__( 'زوم آرام به بیرون', 'sirstone-hero' ),
			'pan-left'  => esc_html__( 'حرکت به چپ', 'sirstone-hero' ),
			'pan-right' => esc_html__( 'حرکت به راست', 'sirstone-hero' ),
			'pan-up'    => esc_html__( 'حرکت به بالا', 'sirstone-hero' ),
			'pan-down'  => esc_html__( 'حرکت به پایین', 'sirstone-hero' ),
			'rotate'    => esc_html__( 'زوم همراه با چرخش ملایم', 'sirstone-hero' ),
		];
	}

	public static function looks() {
		return [
			'none'      => esc_html__( 'بدون فیلتر', 'sirstone-hero' ),
			'grayscale' => esc_html__( 'سیاه‌وسفید', 'sirstone-hero' ),
			'noir'      => esc_html__( 'نوآر (سیاه‌وسفید کنتراست بالا)', 'sirstone-hero' ),
			'sepia'     => esc_html__( 'سپیا (قدیمی)', 'sirstone-hero' ),
			'warm'      => esc_html__( 'گرم', 'sirstone-hero' ),
			'cool'      => esc_html__( 'سرد', 'sirstone-hero' ),
			'dramatic'  => esc_html__( 'دراماتیک', 'sirstone-hero' ),
			'faded'     => esc_html__( 'محو و ملایم', 'sirstone-hero' ),
			'vivid'     => esc_html__( 'شاداب', 'sirstone-hero' ),
		];
	}

	public static function content_animations() {
		return [
			'up'    => esc_html__( 'بالا آمدن', 'sirstone-hero' ),
			'down'  => esc_html__( 'پایین آمدن', 'sirstone-hero' ),
			'left'  => esc_html__( 'ورود از چپ', 'sirstone-hero' ),
			'right' => esc_html__( 'ورود از راست', 'sirstone-hero' ),
			'zoom'  => esc_html__( 'زوم', 'sirstone-hero' ),
			'blur'  => esc_html__( 'بلور', 'sirstone-hero' ),
			'none'  => esc_html__( 'بدون انیمیشن', 'sirstone-hero' ),
		];
	}

	public static function easings() {
		return [
			'cubic-bezier(.76, 0, .24, 1)'    => esc_html__( 'نرم و سینمایی (سیرستون)', 'sirstone-hero' ),
			'cubic-bezier(.22, 1, .36, 1)'    => esc_html__( 'شروع سریع، پایان آرام', 'sirstone-hero' ),
			'cubic-bezier(.65, 0, .35, 1)'    => esc_html__( 'Ease In-Out', 'sirstone-hero' ),
			'cubic-bezier(.34, 1.56, .64, 1)' => esc_html__( 'فنری (Back Out)', 'sirstone-hero' ),
			'ease'                            => 'Ease',
			'linear'                          => 'Linear',
		];
	}

	public static function blend_modes() {
		return [
			''            => esc_html__( 'عادی', 'sirstone-hero' ),
			'multiply'    => 'Multiply',
			'screen'      => 'Screen',
			'overlay'     => 'Overlay',
			'darken'      => 'Darken',
			'lighten'     => 'Lighten',
			'color-dodge' => 'Color Dodge',
			'color-burn'  => 'Color Burn',
			'soft-light'  => 'Soft Light',
			'hard-light'  => 'Hard Light',
			'hue'         => 'Hue',
			'saturation'  => 'Saturation',
			'color'       => 'Color',
			'luminosity'  => 'Luminosity',
		];
	}

	private static function tag_options() {
		return [
			'h1'   => 'H1',
			'h2'   => 'H2',
			'h3'   => 'H3',
			'h4'   => 'H4',
			'h5'   => 'H5',
			'h6'   => 'H6',
			'div'  => 'div',
			'p'    => 'p',
			'span' => 'span',
		];
	}

	private static function valid_tag( $tag, $fallback = 'h2' ) {
		return isset( self::tag_options()[ $tag ] ) ? $tag : $fallback;
	}

	private static function image_size_options() {
		$sizes = [];
		foreach ( get_intermediate_image_sizes() as $size ) {
			$sizes[ $size ] = ucwords( str_replace( [ '_', '-' ], ' ', $size ) );
		}
		$sizes['full'] = esc_html__( 'اندازه کامل', 'sirstone-hero' );
		return $sizes;
	}

	/** Start / center / end choices with icons that follow the site direction. */
	private static function align_choices() {
		$rtl = is_rtl();
		return [
			'start'  => [
				'title' => esc_html__( 'ابتدا', 'sirstone-hero' ),
				'icon'  => $rtl ? 'eicon-text-align-right' : 'eicon-text-align-left',
			],
			'center' => [
				'title' => esc_html__( 'وسط', 'sirstone-hero' ),
				'icon'  => 'eicon-text-align-center',
			],
			'end'    => [
				'title' => esc_html__( 'انتها', 'sirstone-hero' ),
				'icon'  => $rtl ? 'eicon-text-align-left' : 'eicon-text-align-right',
			],
		];
	}

	/** Declarations applied by the alignment controls (text + flex alignment + box position). */
	private static function align_dictionary() {
		return [
			'start'  => 'text-align:start;--ssh-ai:flex-start;--ssh-jc:flex-start;margin-inline:0 auto;',
			'center' => 'text-align:center;--ssh-ai:center;--ssh-jc:center;margin-inline:auto;',
			'end'    => 'text-align:end;--ssh-ai:flex-end;--ssh-jc:flex-end;margin-inline:auto 0;',
		];
	}

	/**
	 * Normalises a saved side to 'start' / 'end'. Older versions stored the
	 * physical values 'left' / 'right', which keep their on-screen meaning.
	 */
	private static function logical_side( $value, $fallback, $rtl ) {
		if ( 'start' === $value || 'end' === $value ) {
			return $value;
		}
		if ( 'left' === $value ) {
			return $rtl ? 'end' : 'start';
		}
		if ( 'right' === $value ) {
			return $rtl ? 'start' : 'end';
		}
		return $fallback;
	}

	/** {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}} shorthand for a property. */
	private static function dims( $property ) {
		return $property . ': {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
	}

	/* -----------------------------------------------------------------
	 * Default content (two starter slides)
	 * -------------------------------------------------------------- */

	private function default_slides() {
		$base = 'https://sirstone.com/wp-content/uploads/2026/07/';

		return [
			[
				'_id'         => 'ssh0brand',
				'slide_name'  => 'Sirstone',
				'eyebrow'     => 'Sirstone',
				'title'       => 'Premium Natural Stone for Landmark Projects Worldwide',
				'title_tag'   => 'h1',
				'description' => 'From carefully selected natural stones to precision processing and reliable international logistics, Sirstone delivers premium materials for architects, contractors, developers, importers, and wholesalers.',
				'btn1_show'   => 'yes',
				'btn1_text'   => 'Explore Products',
				'btn1_link'   => [ 'url' => 'https://sirstone.com/shop/' ],
				'btn2_show'   => 'yes',
				'btn2_text'   => 'Request a Quote',
				'btn2_link'   => [ 'url' => 'https://sirstone.com/contact-us/' ],
				'specs'       => '',
				'image'       => [ 'url' => $base . 'Hero-section.webp' ],
			],
			[
				'_id'         => 'ssh1crystal',
				'slide_name'  => 'Crystal',
				'eyebrow'     => 'Collection 01 — Natural Stone',
				'title'       => 'Crystal Collection',
				'title_tag'   => 'h2',
				'description' => 'Discover the Crystal Collection, featuring premium crystal marble with refined patterns, elegant textures, and timeless beauty for luxury residential and commercial spaces.',
				'btn1_show'   => 'yes',
				'btn1_text'   => 'View Products',
				'btn1_link'   => [ 'url' => 'https://sirstone.com/product-category/crystal-collection/' ],
				'btn2_show'   => '',
				'specs'       => "Application | Interior & Exterior\nFormats | Block / Slab / Tile\nFinish | Polished, Honed",
				'image'       => [ 'url' => $base . 'Crystal.webp' ],
			],
		];
	}

	/* -----------------------------------------------------------------
	 * Controls
	 * -------------------------------------------------------------- */

	protected function register_controls() {
		// Content tab.
		$this->register_slides_controls();
		$this->register_settings_controls();
		$this->register_motion_controls();

		// Style tab.
		$this->register_layout_style();
		$this->register_eyebrow_style();
		$this->register_title_style();
		$this->register_description_style();
		$this->register_buttons_style();
		$this->register_specs_style();
		$this->register_image_fx_style();
		$this->register_overlay_style();
		$this->register_rail_style();
		$this->register_progress_style();
		$this->register_ctrls_style();
		$this->register_corners_style();
	}

	/* -----------------------------------------------------------------
	 * Render
	 * -------------------------------------------------------------- */

	protected function render() {
		$s      = $this->get_settings_for_display();
		$slides = ! empty( $s['slides'] ) && is_array( $s['slides'] ) ? array_values( $s['slides'] ) : [];
		$count  = count( $slides );

		if ( ! $count ) {
			return;
		}

		$is_editor = Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode();
		$start     = max( 0, min( $count - 1, (int) $s['start_at'] - 1 ) );
		$base      = '1' === $s['number_base'] ? 1 : 0;

		$duration  = isset( $s['transition_duration']['size'] ) && '' !== $s['transition_duration']['size'] ? (int) $s['transition_duration']['size'] : 1150;
		$par       = isset( $s['parallax_strength']['size'] ) ? (float) $s['parallax_strength']['size'] : 0;
		$mouse_fx  = $par > 0 || 'yes' === $s['spot_enable'];

		$config = [
			'autoplay'   => 'yes' === $s['autoplay'],
			'speed'      => max( 1000, (int) $s['autoplay_speed'] ),
			'pauseHover' => 'yes' === $s['pause_on_hover'],
			'pauseFocus' => 'yes' === $s['pause_on_focus'],
			'loop'       => 'yes' === $s['loop'],
			'swipe'      => 'yes' === $s['swipe'],
			'keyboard'   => 'yes' === $s['keyboard'],
			'duration'   => $duration,
			'start'      => $start,
			'editor'     => $is_editor,
			'mouseFx'    => $mouse_fx,
		];

		// The slider follows the site language direction (RTL: Persian, Arabic, … / LTR: the rest).
		$rtl = is_rtl();

		$classes = [ 'ssh-hero' ];
		if ( 'end' === self::logical_side( $s['rail_position'], 'start', $rtl ) ) {
			$classes[] = 'ssh-hero--rail-end';
		}
		if ( 'start' === self::logical_side( $s['ctrl_position'], 'end', $rtl ) ) {
			$classes[] = 'ssh-hero--ctrl-start';
		}

		$this->add_render_attribute( 'root', [
			'class'                => $classes,
			'dir'                  => $rtl ? 'rtl' : 'ltr',
			'data-settings'        => wp_json_encode( $config ),
			'data-anim'            => $s['content_anim'],
			'data-btn-fx'          => $s['btn_hover_fx'],
			'data-dir'             => 'next',
			'role'                 => 'region',
			'aria-roledescription' => 'carousel',
			'aria-label'           => $s['aria_label'],
		] );

		$show_ctrls = 'yes' === $s['show_nav'] || 'yes' === $s['show_playpause'];
		?>
		<section <?php $this->print_render_attribute_string( 'root' ); ?>>

			<?php if ( 'yes' === $s['show_corners'] ) : ?>
				<span class="ssh-corner ssh-corner--tl" aria-hidden="true"></span>
				<span class="ssh-corner ssh-corner--tr" aria-hidden="true"></span>
				<span class="ssh-corner ssh-corner--bl" aria-hidden="true"></span>
				<span class="ssh-corner ssh-corner--br" aria-hidden="true"></span>
			<?php endif; ?>

			<?php if ( 'yes' === $s['show_rail'] ) : ?>
				<nav class="ssh-rail" aria-label="<?php echo esc_attr__( 'فهرست اسلایدها', 'sirstone-hero' ); ?>">
					<?php foreach ( $slides as $i => $item ) : ?>
						<button type="button" class="ssh-rail__btn<?php echo $i === $start ? ' is-active' : ''; ?>" aria-label="<?php echo esc_attr( sprintf( '%d / %d — %s', $i + 1, $count, $this->slide_name( $item, $i ) ) ); ?>">
							<span class="ssh-rail__n"><?php echo esc_html( sprintf( '%02d', $i + $base ) ); ?></span>
							<span class="ssh-rail__tick"></span>
						</button>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>

			<?php
			foreach ( $slides as $i => $item ) {
				$this->render_slide( $item, $i, $count, $start, $s );
			}
			?>

			<?php if ( $show_ctrls ) : ?>
				<div class="ssh-ctrls">
					<?php if ( 'yes' === $s['show_nav'] ) : ?>
						<button type="button" class="ssh-ctrl ssh-ctrl--prev" aria-label="<?php echo esc_attr__( 'اسلاید قبلی', 'sirstone-hero' ); ?>">
							<?php $this->render_nav_icon( $s['nav_prev_icon'], self::SVG_PREV ); ?>
						</button>
					<?php endif; ?>
					<?php if ( 'yes' === $s['show_playpause'] ) : ?>
						<button type="button" class="ssh-ctrl ssh-ctrl--play" aria-pressed="false" aria-label="<?php echo esc_attr__( 'توقف / پخش خودکار', 'sirstone-hero' ); ?>">
							<?php echo self::SVG_PAUSE . self::SVG_PLAY; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</button>
					<?php endif; ?>
					<?php if ( 'yes' === $s['show_nav'] ) : ?>
						<button type="button" class="ssh-ctrl ssh-ctrl--next" aria-label="<?php echo esc_attr__( 'اسلاید بعدی', 'sirstone-hero' ); ?>">
							<?php $this->render_nav_icon( $s['nav_next_icon'], self::SVG_NEXT ); ?>
						</button>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( 'yes' === $s['show_progress'] ) : ?>
				<div class="ssh-progress">
					<?php foreach ( $slides as $i => $item ) : ?>
						<button type="button" class="ssh-progress__btn<?php echo $i === $start ? ' is-active' : ''; ?>" aria-label="<?php echo esc_attr( sprintf( '%d / %d — %s', $i + 1, $count, $this->slide_name( $item, $i ) ) ); ?>">
							<span class="ssh-progress__fill"></span>
							<span class="ssh-progress__label">
								<?php if ( 'yes' === $s['progress_show_dot'] ) : ?>
									<span class="ssh-progress__dot"></span>
								<?php endif; ?>
								<?php if ( 'yes' === $s['progress_show_number'] ) : ?>
									<span class="ssh-progress__num"><?php echo esc_html( sprintf( '%02d', $i + $base ) ); ?></span>
								<?php endif; ?>
								<?php if ( 'yes' === $s['progress_show_name'] ) : ?>
									<span class="ssh-progress__name"><?php echo esc_html( $this->slide_name( $item, $i ) ); ?></span>
								<?php endif; ?>
							</span>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</section>
		<?php
	}

	private function slide_name( $item, $i ) {
		if ( ! empty( $item['slide_name'] ) ) {
			return $item['slide_name'];
		}
		if ( ! empty( $item['title'] ) ) {
			return wp_strip_all_tags( $item['title'] );
		}
		/* translators: %d: slide number */
		return sprintf( __( 'اسلاید %d', 'sirstone-hero' ), $i + 1 );
	}

	private function render_nav_icon( $icon, $fallback_svg ) {
		if ( ! empty( $icon['value'] ) ) {
			Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
			return;
		}
		echo $fallback_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	private function render_slide( $item, $i, $count, $start, $s ) {
		$id = ! empty( $item['_id'] ) ? $item['_id'] : 'ssh' . $i;

		$fx   = ! empty( $item['slide_transition'] ) ? $item['slide_transition'] : $s['transition_effect'];
		$kb   = ! empty( $item['kb_effect'] ) ? $item['kb_effect'] : $s['kb_effect'];
		$look = ! empty( $item['image_look'] ) ? $item['image_look'] : $s['image_look_default'];

		$key = 'slide_' . $id;
		$this->add_render_attribute( $key, [
			'class'                => [ 'ssh-slide', 'elementor-repeater-item-' . $id ],
			'data-index'           => $i,
			'data-fx'              => $fx,
			'data-kb'              => $kb,
			'data-look'            => $look,
			'role'                 => 'group',
			'aria-roledescription' => 'slide',
			'aria-label'           => sprintf( '%d / %d', $i + 1, $count ),
			'aria-hidden'          => $i === $start ? 'false' : 'true',
		] );
		if ( $i === $start ) {
			$this->add_render_attribute( $key, 'class', 'is-active' );
		} else {
			$this->add_render_attribute( $key, 'inert', '' );
		}

		$title_mode = $s['title_reveal'];
		?>
		<div <?php $this->print_render_attribute_string( $key ); ?>>

			<div class="ssh-media">
				<div class="ssh-bg"><?php $this->render_image( $item, $s, $i === $start ); ?></div>
			</div>

			<?php if ( 'yes' === $s['default_overlay'] ) : ?>
				<div class="ssh-scrim" aria-hidden="true"></div>
			<?php endif; ?>
			<?php if ( ! empty( $s['custom_overlay_background'] ) ) : ?>
				<div class="ssh-overlay" aria-hidden="true"></div>
			<?php endif; ?>
			<?php if ( 'yes' === ( isset( $item['overlay_override'] ) ? $item['overlay_override'] : '' ) ) : ?>
				<div class="ssh-overlay-slide" aria-hidden="true"></div>
			<?php endif; ?>
			<?php if ( ! empty( $item['tint_color'] ) ) : ?>
				<div class="ssh-tint" aria-hidden="true"></div>
			<?php endif; ?>
			<?php if ( 'yes' === $s['vignette_enable'] ) : ?>
				<div class="ssh-vignette" aria-hidden="true"></div>
			<?php endif; ?>
			<?php if ( 'yes' === $s['spot_enable'] ) : ?>
				<div class="ssh-spot" aria-hidden="true"></div>
			<?php endif; ?>
			<?php if ( 'yes' === $s['shine_enable'] ) : ?>
				<div class="ssh-shine" aria-hidden="true"></div>
			<?php endif; ?>
			<?php if ( 'yes' === $s['grain_enable'] ) : ?>
				<div class="ssh-grain<?php echo 'yes' === $s['grain_animate'] ? ' ssh-grain--animate' : ''; ?>" aria-hidden="true"></div>
			<?php endif; ?>

			<div class="ssh-content">
				<?php if ( ! empty( $item['eyebrow'] ) ) : ?>
					<span class="ssh-eyebrow ssh-a<?php echo 'yes' === $s['eyebrow_line'] ? '' : ' ssh-no-line'; ?>"><?php echo esc_html( $item['eyebrow'] ); ?></span>
				<?php endif; ?>

				<?php
				if ( ! empty( $item['title'] ) ) {
					$tag        = self::valid_tag( isset( $item['title_tag'] ) ? $item['title_tag'] : 'h2' );
					$split      = in_array( $title_mode, [ 'words', 'letters' ], true );
					$title_html = $split
						? '<span class="ssh-sr">' . esc_html( $item['title'] ) . '</span><span aria-hidden="true">' . $this->split_title( $item['title'], $title_mode ) . '</span>'
						: nl2br( esc_html( $item['title'] ) );

					printf(
						'<%1$s class="ssh-title ssh-a%2$s">%3$s</%1$s>',
						esc_attr( $tag ),
						$split ? ' ssh-title--split' : '',
						$title_html // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					);
				}
				?>

				<?php if ( ! empty( $item['description'] ) ) : ?>
					<div class="ssh-desc ssh-a"><?php echo wpautop( wp_kses_post( $item['description'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<?php endif; ?>

				<?php
				$btn1 = $this->render_button( $item, 1, $id );
				$btn2 = $this->render_button( $item, 2, $id );
				if ( '' !== $btn1 . $btn2 ) {
					echo '<div class="ssh-actions ssh-a">' . $btn1 . $btn2 . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}

				$specs = $this->parse_specs( isset( $item['specs'] ) ? $item['specs'] : '' );
				if ( $specs ) :
					?>
					<div class="ssh-specs ssh-a">
						<?php foreach ( $specs as $spec ) : ?>
							<div class="ssh-spec">
								<?php if ( '' !== $spec[0] ) : ?>
									<div class="ssh-spec__k"><?php echo esc_html( $spec[0] ); ?></div>
								<?php endif; ?>
								<div class="ssh-spec__v"><?php echo esc_html( $spec[1] ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/** Builds the word / letter spans used by the title reveal effect. */
	private function split_title( $text, $mode ) {
		$lines = preg_split( '/\r\n|\r|\n/', trim( $text ) );
		$i     = 0;
		$out   = [];

		foreach ( $lines as $line ) {
			$words = preg_split( '/\s+/u', trim( $line ), -1, PREG_SPLIT_NO_EMPTY );
			$parts = [];
			foreach ( (array) $words as $word ) {
				if ( 'letters' === $mode ) {
					$inner = '';
					foreach ( (array) preg_split( '//u', $word, -1, PREG_SPLIT_NO_EMPTY ) as $ch ) {
						$inner .= '<span class="ssh-ch" style="--i:' . (int) $i++ . '">' . esc_html( $ch ) . '</span>';
					}
					$parts[] = '<span class="ssh-w">' . $inner . '</span>';
				} else {
					$parts[] = '<span class="ssh-w"><span class="ssh-wi" style="--i:' . (int) $i++ . '">' . esc_html( $word ) . '</span></span>';
				}
			}
			$out[] = implode( ' ', $parts );
		}

		return implode( '<br>', $out );
	}

	/** "Label | Value" per line → [ [label, value], … ]. */
	private function parse_specs( $raw ) {
		$out = [];
		foreach ( preg_split( '/\r\n|\r|\n/', (string) $raw ) as $line ) {
			$line = trim( $line );
			if ( '' === $line ) {
				continue;
			}
			$parts = explode( '|', $line, 2 );
			$k     = trim( $parts[0] );
			$v     = isset( $parts[1] ) ? trim( $parts[1] ) : '';
			if ( '' === $v ) {
				$v = $k;
				$k = '';
			}
			$out[] = [ $k, $v ];
		}
		return $out;
	}

	private function render_button( $item, $n, $slide_id ) {
		if ( 'yes' !== ( isset( $item[ "btn{$n}_show" ] ) ? $item[ "btn{$n}_show" ] : '' ) ) {
			return '';
		}

		$text = isset( $item[ "btn{$n}_text" ] ) ? trim( $item[ "btn{$n}_text" ] ) : '';
		$icon = isset( $item[ "btn{$n}_icon" ] ) ? $item[ "btn{$n}_icon" ] : [];
		$link = isset( $item[ "btn{$n}_link" ] ) ? $item[ "btn{$n}_link" ] : [];

		if ( '' === $text && empty( $icon['value'] ) ) {
			return '';
		}

		$key = 'btn' . $n . '_' . $slide_id;
		$this->add_render_attribute( $key, 'class', [ 'ssh-btn', 1 === $n ? 'ssh-btn--primary' : 'ssh-btn--secondary' ] );

		$tag = 'span';
		if ( ! empty( $link['url'] ) ) {
			$tag = 'a';
			$this->add_link_attributes( $key, $link );
		}

		ob_start();
		echo '<' . $tag . ' ' . $this->get_render_attribute_string( $key ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( '' !== $text ) {
			echo '<span class="ssh-btn__text">' . esc_html( $text ) . '</span>';
		}
		if ( ! empty( $icon['value'] ) ) {
			echo '<span class="ssh-btn__icon">';
			Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
			echo '</span>';
		}
		echo '</' . $tag . '>';

		return ob_get_clean();
	}

	private function render_image( $item, $s, $is_start ) {
		$image  = isset( $item['image'] ) && is_array( $item['image'] ) ? $item['image'] : [];
		$mobile = isset( $item['image_mobile'] ) && is_array( $item['image_mobile'] ) ? $item['image_mobile'] : [];
		$size   = ! empty( $s['image_size'] ) ? $s['image_size'] : 'full';
		$alt    = isset( $item['image_alt'] ) ? trim( $item['image_alt'] ) : '';

		$attr = [
			'class'    => 'ssh-img',
			'decoding' => 'async',
			'loading'  => $is_start ? 'eager' : 'lazy',
			'sizes'    => '100vw',
		];
		if ( $is_start ) {
			$attr['fetchpriority'] = 'high';
		}
		if ( '' !== $alt ) {
			$attr['alt'] = $alt;
		}

		$html = '';
		if ( ! empty( $image['id'] ) ) {
			$html = wp_get_attachment_image( (int) $image['id'], $size, false, $attr );
		}
		if ( '' === $html && ! empty( $image['url'] ) ) {
			$html = sprintf(
				'<img class="ssh-img" src="%1$s" alt="%2$s" decoding="async" loading="%3$s"%4$s>',
				esc_url( $image['url'] ),
				esc_attr( $alt ),
				$is_start ? 'eager' : 'lazy',
				$is_start ? ' fetchpriority="high"' : ''
			);
		}
		if ( '' === $html ) {
			return;
		}

		$mobile_url = '';
		if ( ! empty( $mobile['id'] ) ) {
			$mobile_url = wp_get_attachment_image_url( (int) $mobile['id'], $size );
		}
		if ( ! $mobile_url && ! empty( $mobile['url'] ) ) {
			$mobile_url = $mobile['url'];
		}

		if ( $mobile_url ) {
			$breakpoint = 767;
			$bp_manager = isset( Plugin::$instance->breakpoints ) ? Plugin::$instance->breakpoints : null;
			if ( $bp_manager && method_exists( $bp_manager, 'get_breakpoints' ) ) {
				$bps = $bp_manager->get_breakpoints();
				if ( isset( $bps['mobile'] ) && method_exists( $bps['mobile'], 'get_value' ) ) {
					$breakpoint = (int) $bps['mobile']->get_value();
				}
			}
			echo '<picture><source media="(max-width: ' . (int) $breakpoint . 'px)" srcset="' . esc_url( $mobile_url ) . '">' . $html . '</picture>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
