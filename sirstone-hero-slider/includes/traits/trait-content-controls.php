<?php
namespace SirstoneHero\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

defined( 'ABSPATH' ) || exit;

/**
 * Content tab: slides repeater (one tab-set per slide), slider settings, motion.
 */
trait Content_Controls {

	private function register_slides_controls() {
		$this->start_controls_section( 'section_slides', [
			'label' => esc_html__( 'اسلایدها', 'sirstone-hero' ),
		] );

		$r = new Repeater();

		$r->start_controls_tabs( 'slide_tabs' );

		/* ================= Tab: content ================= */
		$r->start_controls_tab( 'slide_tab_content', [
			'label' => esc_html__( 'محتوا', 'sirstone-hero' ),
		] );

		$r->add_control( 'slide_name', [
			'label'       => esc_html__( 'نام اسلاید', 'sirstone-hero' ),
			'type'        => Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => esc_html__( 'اسلاید', 'sirstone-hero' ),
			'description' => esc_html__( 'در نوار پایین و برای صفحه‌خوان‌ها نمایش داده می‌شود.', 'sirstone-hero' ),
			'dynamic'     => [ 'active' => true ],
		] );

		$r->add_control( 'eyebrow', [
			'label'       => esc_html__( 'متن کوچک بالای عنوان', 'sirstone-hero' ),
			'type'        => Controls_Manager::TEXT,
			'label_block' => true,
			'separator'   => 'before',
			'dynamic'     => [ 'active' => true ],
		] );

		$r->add_control( 'title', [
			'label'       => esc_html__( 'عنوان', 'sirstone-hero' ),
			'type'        => Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => esc_html__( 'عنوان اسلاید', 'sirstone-hero' ),
			'description' => esc_html__( 'برای رفتن به خط بعد Enter بزنید.', 'sirstone-hero' ),
			'dynamic'     => [ 'active' => true ],
		] );

		$r->add_control( 'title_tag', [
			'label'   => esc_html__( 'تگ عنوان', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'h2',
			'options' => self::tag_options(),
		] );

		$r->add_control( 'description', [
			'label'       => esc_html__( 'توضیحات', 'sirstone-hero' ),
			'type'        => Controls_Manager::TEXTAREA,
			'rows'        => 4,
			'description' => esc_html__( 'تگ‌های ساده مثل <strong> و <br> مجاز است.', 'sirstone-hero' ),
			'dynamic'     => [ 'active' => true ],
		] );

		/* ---- button 1 ---- */
		$r->add_control( 'btn1_heading', [
			'label'     => esc_html__( 'دکمه ۱ (توپر)', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$r->add_control( 'btn1_show', [
			'label'   => esc_html__( 'نمایش دکمه ۱', 'sirstone-hero' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$r->add_control( 'btn1_text', [
			'label'       => esc_html__( 'متن دکمه', 'sirstone-hero' ),
			'type'        => Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => esc_html__( 'مشاهده محصولات', 'sirstone-hero' ),
			'condition'   => [ 'btn1_show' => 'yes' ],
			'dynamic'     => [ 'active' => true ],
		] );

		$r->add_control( 'btn1_link', [
			'label'       => esc_html__( 'لینک دکمه', 'sirstone-hero' ),
			'type'        => Controls_Manager::URL,
			'placeholder' => 'https://',
			'default'     => [ 'url' => '#' ],
			'condition'   => [ 'btn1_show' => 'yes' ],
			'dynamic'     => [ 'active' => true ],
		] );

		$r->add_control( 'btn1_icon', [
			'label'       => esc_html__( 'آیکن دکمه', 'sirstone-hero' ),
			'type'        => Controls_Manager::ICONS,
			'skin'        => 'inline',
			'label_block' => false,
			'condition'   => [ 'btn1_show' => 'yes' ],
		] );

		/* ---- button 2 ---- */
		$r->add_control( 'btn2_heading', [
			'label'     => esc_html__( 'دکمه ۲ (خطی)', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$r->add_control( 'btn2_show', [
			'label' => esc_html__( 'نمایش دکمه ۲', 'sirstone-hero' ),
			'type'  => Controls_Manager::SWITCHER,
		] );

		$r->add_control( 'btn2_text', [
			'label'       => esc_html__( 'متن دکمه', 'sirstone-hero' ),
			'type'        => Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => esc_html__( 'درخواست مشاوره', 'sirstone-hero' ),
			'condition'   => [ 'btn2_show' => 'yes' ],
			'dynamic'     => [ 'active' => true ],
		] );

		$r->add_control( 'btn2_link', [
			'label'       => esc_html__( 'لینک دکمه', 'sirstone-hero' ),
			'type'        => Controls_Manager::URL,
			'placeholder' => 'https://',
			'default'     => [ 'url' => '#' ],
			'condition'   => [ 'btn2_show' => 'yes' ],
			'dynamic'     => [ 'active' => true ],
		] );

		$r->add_control( 'btn2_icon', [
			'label'       => esc_html__( 'آیکن دکمه', 'sirstone-hero' ),
			'type'        => Controls_Manager::ICONS,
			'skin'        => 'inline',
			'label_block' => false,
			'condition'   => [ 'btn2_show' => 'yes' ],
		] );

		/* ---- specs ---- */
		$r->add_control( 'specs', [
			'label'       => esc_html__( 'نوار مشخصات', 'sirstone-hero' ),
			'type'        => Controls_Manager::TEXTAREA,
			'rows'        => 4,
			'separator'   => 'before',
			'placeholder' => "Origin | Iran\nFormats | Slab / Tile",
			'description' => esc_html__( 'هر خط یک مورد: «عنوان | مقدار». خالی بگذارید تا نوار نمایش داده نشود.', 'sirstone-hero' ),
			'dynamic'     => [ 'active' => true ],
		] );

		$r->end_controls_tab();

		/* ================= Tab: image ================= */
		$r->start_controls_tab( 'slide_tab_image', [
			'label' => esc_html__( 'تصویر', 'sirstone-hero' ),
		] );

		$r->add_control( 'image', [
			'label'   => esc_html__( 'تصویر اسلاید', 'sirstone-hero' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
			'dynamic' => [ 'active' => true ],
		] );

		$r->add_control( 'image_mobile', [
			'label'       => esc_html__( 'تصویر موبایل (اختیاری)', 'sirstone-hero' ),
			'type'        => Controls_Manager::MEDIA,
			'description' => esc_html__( 'در عرض موبایل به‌جای تصویر اصلی نمایش داده می‌شود.', 'sirstone-hero' ),
			'dynamic'     => [ 'active' => true ],
		] );

		$r->add_control( 'image_alt', [
			'label'       => esc_html__( 'متن جایگزین (Alt)', 'sirstone-hero' ),
			'type'        => Controls_Manager::TEXT,
			'label_block' => true,
			'description' => esc_html__( 'خالی بماند، از Alt خود رسانه استفاده می‌شود.', 'sirstone-hero' ),
		] );

		$r->add_responsive_control( 'image_position', [
			'label'                => esc_html__( 'محل قرارگیری تصویر', 'sirstone-hero' ),
			'type'                 => Controls_Manager::SELECT,
			'default'              => '',
			'options'              => [
				''              => esc_html__( 'پیش‌فرض (وسط)', 'sirstone-hero' ),
				'center top'    => esc_html__( 'وسط بالا', 'sirstone-hero' ),
				'center bottom' => esc_html__( 'وسط پایین', 'sirstone-hero' ),
				'left center'   => esc_html__( 'چپ وسط', 'sirstone-hero' ),
				'left top'      => esc_html__( 'چپ بالا', 'sirstone-hero' ),
				'left bottom'   => esc_html__( 'چپ پایین', 'sirstone-hero' ),
				'right center'  => esc_html__( 'راست وسط', 'sirstone-hero' ),
				'right top'     => esc_html__( 'راست بالا', 'sirstone-hero' ),
				'right bottom'  => esc_html__( 'راست پایین', 'sirstone-hero' ),
				'custom'        => esc_html__( 'سفارشی', 'sirstone-hero' ),
			],
			'selectors_dictionary' => [
				'custom' => 'var(--ssh-px, 50%) var(--ssh-py, 50%)',
			],
			'selectors'            => [
				self::RI . ' .ssh-img' => 'object-position: {{VALUE}};',
			],
		] );

		$r->add_responsive_control( 'image_position_x', [
			'label'      => esc_html__( 'موقعیت افقی (%)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'condition'  => [ 'image_position' => 'custom' ],
			'selectors'  => [
				self::RI . ' .ssh-img' => '--ssh-px: {{SIZE}}%;',
			],
		] );

		$r->add_responsive_control( 'image_position_y', [
			'label'      => esc_html__( 'موقعیت عمودی (%)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'condition'  => [ 'image_position' => 'custom' ],
			'selectors'  => [
				self::RI . ' .ssh-img' => '--ssh-py: {{SIZE}}%;',
			],
		] );

		$r->add_control( 'fx_heading', [
			'label'     => esc_html__( 'افکت‌های تصویر', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$r->add_control( 'slide_transition', [
			'label'   => esc_html__( 'افکت ورود این اسلاید', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => [ '' => esc_html__( 'پیش‌فرض (از تنظیمات ویجت)', 'sirstone-hero' ) ] + self::transitions(),
		] );

		$r->add_control( 'kb_effect', [
			'label'   => esc_html__( 'حرکت تصویر (Ken Burns)', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => [ '' => esc_html__( 'پیش‌فرض (از تب استایل)', 'sirstone-hero' ) ] + self::motions(),
		] );

		$r->add_control( 'image_look', [
			'label'   => esc_html__( 'حالت رنگی تصویر', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => [ '' => esc_html__( 'پیش‌فرض (از تب استایل)', 'sirstone-hero' ) ] + self::looks(),
		] );

		$r->add_control( 'tint_color', [
			'label'       => esc_html__( 'لایه رنگی (Tint)', 'sirstone-hero' ),
			'type'        => Controls_Manager::COLOR,
			'description' => esc_html__( 'یک رنگ روی تصویر می‌نشیند؛ با حالت ترکیب، دوتونی و رنگ‌آمیزی می‌سازد.', 'sirstone-hero' ),
			'selectors'   => [
				self::RI . ' .ssh-tint' => 'background-color: {{VALUE}};',
			],
		] );

		$r->add_control( 'tint_blend', [
			'label'     => esc_html__( 'حالت ترکیب لایه رنگی', 'sirstone-hero' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'multiply',
			'options'   => self::blend_modes(),
			'condition' => [ 'tint_color!' => '' ],
			'selectors' => [
				self::RI . ' .ssh-tint' => 'mix-blend-mode: {{VALUE}};',
			],
		] );

		$r->add_control( 'tint_opacity', [
			'label'     => esc_html__( 'شفافیت لایه رنگی', 'sirstone-hero' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
			'condition' => [ 'tint_color!' => '' ],
			'selectors' => [
				self::RI . ' .ssh-tint' => 'opacity: {{SIZE}};',
			],
		] );

		$r->add_control( 'overlay_heading', [
			'label'     => esc_html__( 'لایه تیره این اسلاید', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$r->add_control( 'overlay_override', [
			'label'       => esc_html__( 'لایه اختصاصی', 'sirstone-hero' ),
			'type'        => Controls_Manager::SWITCHER,
			'description' => esc_html__( 'لایه تیره پیش‌فرض را برای این اسلاید با لایه‌ی دلخواه شما جایگزین می‌کند.', 'sirstone-hero' ),
			'selectors'   => [
				self::RI . ' .ssh-scrim' => 'display: none;',
			],
		] );

		$r->add_group_control( Group_Control_Background::get_type(), [
			'name'      => 'slide_overlay',
			'types'     => [ 'classic', 'gradient' ],
			'exclude'   => [ 'image' ],
			'selector'  => self::RI . ' .ssh-overlay-slide',
			'condition' => [ 'overlay_override' => 'yes' ],
		] );

		$r->add_control( 'slide_overlay_opacity', [
			'label'     => esc_html__( 'شفافیت لایه', 'sirstone-hero' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
			'condition' => [ 'overlay_override' => 'yes' ],
			'selectors' => [
				self::RI . ' .ssh-overlay-slide' => 'opacity: {{SIZE}};',
			],
		] );

		$r->end_controls_tab();

		/* ================= Tab: style ================= */
		$r->start_controls_tab( 'slide_tab_style', [
			'label' => esc_html__( 'استایل', 'sirstone-hero' ),
		] );

		$r->add_control( 'style_note', [
			'type'            => Controls_Manager::RAW_HTML,
			'raw'             => esc_html__( 'هر مقداری که اینجا تنظیم شود فقط برای همین اسلاید اعمال می‌شود و روی استایل کلی (تب استایل ویجت) اولویت دارد. خالی = استایل کلی.', 'sirstone-hero' ),
			'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
		] );

		$r->add_responsive_control( 's_align', [
			'label'                => esc_html__( 'تراز محتوا', 'sirstone-hero' ),
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => self::align_choices(),
			'toggle'               => true,
			'selectors_dictionary' => self::align_dictionary(),
			'selectors'            => [
				self::RI . ' .ssh-content' => '{{VALUE}}',
			],
		] );

		/* eyebrow */
		$r->add_control( 's_eyebrow_heading', [
			'label'     => esc_html__( 'متن کوچک بالای عنوان', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );
		$r->add_control( 's_eyebrow_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ self::RI . ' .ssh-eyebrow' => 'color: {{VALUE}};' ],
		] );
		$r->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 's_eyebrow_typo',
			'selector' => self::RI . ' .ssh-eyebrow',
		] );

		/* title */
		$r->add_control( 's_title_heading', [
			'label'     => esc_html__( 'عنوان', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );
		$r->add_control( 's_title_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ self::RI . ' .ssh-title' => 'color: {{VALUE}};' ],
		] );
		$r->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 's_title_typo',
			'selector' => self::RI . ' .ssh-title',
		] );

		/* description */
		$r->add_control( 's_desc_heading', [
			'label'     => esc_html__( 'توضیحات', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );
		$r->add_control( 's_desc_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ self::RI . ' .ssh-desc' => 'color: {{VALUE}};' ],
		] );
		$r->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 's_desc_typo',
			'selector' => self::RI . ' .ssh-desc',
		] );

		/* buttons */
		foreach ( [ 1 => esc_html__( 'دکمه ۱ (توپر)', 'sirstone-hero' ), 2 => esc_html__( 'دکمه ۲ (خطی)', 'sirstone-hero' ) ] as $n => $label ) {
			$sel = self::RI . ' .ssh-btn--' . ( 1 === $n ? 'primary' : 'secondary' );

			$r->add_control( "s_btn{$n}_heading", [
				'label'     => $label,
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			] );
			$r->add_control( "s_btn{$n}_color", [
				'label'     => esc_html__( 'رنگ متن', 'sirstone-hero' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ $sel => 'color: {{VALUE}};' ],
			] );
			$r->add_control( "s_btn{$n}_bg", [
				'label'     => esc_html__( 'رنگ پس‌زمینه', 'sirstone-hero' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ $sel => 'background-color: {{VALUE}};' ],
			] );
			$r->add_control( "s_btn{$n}_border", [
				'label'     => esc_html__( 'رنگ کادر', 'sirstone-hero' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ $sel => 'border-color: {{VALUE}};' ],
			] );
			$r->add_control( "s_btn{$n}_color_h", [
				'label'     => esc_html__( 'رنگ متن (هاور)', 'sirstone-hero' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ $sel . ':hover, ' . $sel . ':focus-visible' => 'color: {{VALUE}};' ],
			] );
			$r->add_control( "s_btn{$n}_bg_h", [
				'label'     => esc_html__( 'رنگ پس‌زمینه (هاور)', 'sirstone-hero' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ $sel . ':hover, ' . $sel . ':focus-visible' => 'background-color: {{VALUE}};' ],
			] );
			$r->add_control( "s_btn{$n}_border_h", [
				'label'     => esc_html__( 'رنگ کادر (هاور)', 'sirstone-hero' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ $sel . ':hover, ' . $sel . ':focus-visible' => 'border-color: {{VALUE}};' ],
			] );
		}

		/* specs */
		$r->add_control( 's_specs_heading', [
			'label'     => esc_html__( 'نوار مشخصات', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );
		$r->add_control( 's_spec_k_color', [
			'label'     => esc_html__( 'رنگ عنوان مشخصات', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ self::RI . ' .ssh-spec__k' => 'color: {{VALUE}};' ],
		] );
		$r->add_control( 's_spec_v_color', [
			'label'     => esc_html__( 'رنگ مقدار مشخصات', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ self::RI . ' .ssh-spec__v' => 'color: {{VALUE}};' ],
		] );
		$r->add_control( 's_spec_line_color', [
			'label'     => esc_html__( 'رنگ خطوط', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				self::RI . ' .ssh-specs' => 'border-top-color: {{VALUE}}; --ssh-spec-div-c: {{VALUE}};',
			],
		] );

		$r->end_controls_tab();
		$r->end_controls_tabs();

		$this->add_control( 'slides', [
			'label'       => esc_html__( 'اسلایدها', 'sirstone-hero' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $r->get_controls(),
			'default'     => $this->default_slides(),
			'title_field' => '{{{ slide_name || title }}}',
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */

	private function register_settings_controls() {
		$this->start_controls_section( 'section_settings', [
			'label' => esc_html__( 'تنظیمات اسلایدر', 'sirstone-hero' ),
		] );

		$this->add_control( 'image_size', [
			'label'   => esc_html__( 'اندازه تصویر', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'full',
			'options' => self::image_size_options(),
		] );

		$this->add_control( 'start_at', [
			'label'       => esc_html__( 'شروع از اسلاید شماره', 'sirstone-hero' ),
			'type'        => Controls_Manager::NUMBER,
			'default'     => 1,
			'min'         => 1,
			'step'        => 1,
			'description' => esc_html__( 'در ویرایشگر، پخش خودکار متوقف است؛ با این گزینه اسلایدی را که می‌خواهید ویرایش کنید نمایش دهید.', 'sirstone-hero' ),
		] );

		$this->add_control( 'autoplay', [
			'label'     => esc_html__( 'پخش خودکار', 'sirstone-hero' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'separator' => 'before',
		] );

		$this->add_control( 'autoplay_speed', [
			'label'     => esc_html__( 'زمان هر اسلاید (میلی‌ثانیه)', 'sirstone-hero' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 6500,
			'min'       => 1500,
			'step'      => 100,
			'condition' => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'pause_on_hover', [
			'label'     => esc_html__( 'توقف هنگام هاور', 'sirstone-hero' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'condition' => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'pause_on_focus', [
			'label'     => esc_html__( 'توقف هنگام فوکوس کیبورد', 'sirstone-hero' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'condition' => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'loop', [
			'label'   => esc_html__( 'چرخش بی‌پایان', 'sirstone-hero' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_control( 'swipe', [
			'label'   => esc_html__( 'کشیدن لمسی (Swipe)', 'sirstone-hero' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_control( 'keyboard', [
			'label'   => esc_html__( 'کنترل با کیبورد', 'sirstone-hero' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		/* ---- elements ---- */
		$this->add_control( 'elements_heading', [
			'label'     => esc_html__( 'عناصر نمایشی', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'show_rail', [
			'label'   => esc_html__( 'فهرست عمودی کنار اسلایدر', 'sirstone-hero' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_control( 'show_progress', [
			'label'   => esc_html__( 'نوار پیشرفت پایین', 'sirstone-hero' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_control( 'progress_show_dot', [
			'label'     => esc_html__( 'نقطه در نوار پایین', 'sirstone-hero' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'condition' => [ 'show_progress' => 'yes' ],
		] );

		$this->add_control( 'progress_show_number', [
			'label'     => esc_html__( 'شماره در نوار پایین', 'sirstone-hero' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'condition' => [ 'show_progress' => 'yes' ],
		] );

		$this->add_control( 'progress_show_name', [
			'label'     => esc_html__( 'نام اسلاید در نوار پایین', 'sirstone-hero' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'condition' => [ 'show_progress' => 'yes' ],
		] );

		$this->add_control( 'number_base', [
			'label'     => esc_html__( 'شماره‌گذاری از', 'sirstone-hero' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '0',
			'options'   => [
				'0' => '00',
				'1' => '01',
			],
		] );

		$this->add_control( 'show_corners', [
			'label'   => esc_html__( 'علامت‌های گوشه (Crop Marks)', 'sirstone-hero' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_control( 'show_nav', [
			'label'     => esc_html__( 'دکمه‌های قبلی / بعدی', 'sirstone-hero' ),
			'type'      => Controls_Manager::SWITCHER,
			'separator' => 'before',
		] );

		$this->add_control( 'nav_prev_icon', [
			'label'       => esc_html__( 'آیکن قبلی', 'sirstone-hero' ),
			'type'        => Controls_Manager::ICONS,
			'skin'        => 'inline',
			'label_block' => false,
			'condition'   => [ 'show_nav' => 'yes' ],
		] );

		$this->add_control( 'nav_next_icon', [
			'label'       => esc_html__( 'آیکن بعدی', 'sirstone-hero' ),
			'type'        => Controls_Manager::ICONS,
			'skin'        => 'inline',
			'label_block' => false,
			'condition'   => [ 'show_nav' => 'yes' ],
		] );

		$this->add_control( 'show_playpause', [
			'label'       => esc_html__( 'دکمه توقف / پخش', 'sirstone-hero' ),
			'type'        => Controls_Manager::SWITCHER,
			'description' => esc_html__( 'برای دسترسی‌پذیری توصیه می‌شود.', 'sirstone-hero' ),
		] );

		$this->add_control( 'aria_label', [
			'label'     => esc_html__( 'برچسب دسترسی‌پذیری', 'sirstone-hero' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => esc_html__( 'Sirstone — featured collections', 'sirstone-hero' ),
			'separator' => 'before',
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */

	private function register_motion_controls() {
		$this->start_controls_section( 'section_motion', [
			'label' => esc_html__( 'انتقال و انیمیشن', 'sirstone-hero' ),
		] );

		$this->add_control( 'transition_heading', [
			'label' => esc_html__( 'انتقال بین اسلایدها', 'sirstone-hero' ),
			'type'  => Controls_Manager::HEADING,
		] );

		$this->add_control( 'transition_effect', [
			'label'   => esc_html__( 'افکت انتقال', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'diagonal',
			'options' => self::transitions(),
		] );

		$this->add_control( 'transition_duration', [
			'label'      => esc_html__( 'مدت انتقال (میلی‌ثانیه)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 3000, 'step' => 50 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1150 ],
			'selectors'  => [ self::R => '--ssh-tr-dur: {{SIZE}}ms;' ],
		] );

		$this->add_control( 'transition_easing', [
			'label'     => esc_html__( 'نرمی حرکت (Easing)', 'sirstone-hero' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'cubic-bezier(.76, 0, .24, 1)',
			'options'   => self::easings(),
			'selectors' => [ self::R => '--ssh-tr-ease: {{VALUE}};' ],
		] );

		$this->add_control( 'anim_heading', [
			'label'     => esc_html__( 'انیمیشن ورود محتوا', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'content_anim', [
			'label'   => esc_html__( 'نوع انیمیشن', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'up',
			'options' => self::content_animations(),
		] );

		$this->add_control( 'content_anim_duration', [
			'label'      => esc_html__( 'مدت (میلی‌ثانیه)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 100, 'max' => 2000, 'step' => 50 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 800 ],
			'selectors'  => [ self::R => '--ssh-a-dur: {{SIZE}}ms;' ],
			'condition'  => [ 'content_anim!' => 'none' ],
		] );

		$this->add_control( 'content_anim_step', [
			'label'      => esc_html__( 'فاصله زمانی بین عناصر (میلی‌ثانیه)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 400, 'step' => 10 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 80 ],
			'selectors'  => [ self::R => '--ssh-a-step: {{SIZE}}ms;' ],
			'condition'  => [ 'content_anim!' => 'none' ],
		] );

		$this->add_control( 'content_anim_delay', [
			'label'       => esc_html__( 'تأخیر شروع (میلی‌ثانیه)', 'sirstone-hero' ),
			'type'        => Controls_Manager::SLIDER,
			'size_units'  => [ 'px' ],
			'range'       => [ 'px' => [ 'min' => 0, 'max' => 1500, 'step' => 50 ] ],
			'default'     => [ 'unit' => 'px', 'size' => 0 ],
			'description' => esc_html__( 'برای شروع متن پس از باز شدن تصویر، عددی نزدیک به مدت انتقال بگذارید.', 'sirstone-hero' ),
			'selectors'   => [ self::R => '--ssh-a-delay: {{SIZE}}ms;' ],
			'condition'   => [ 'content_anim!' => 'none' ],
		] );

		$this->add_control( 'content_anim_distance', [
			'label'      => esc_html__( 'مسافت حرکت (px)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 20 ],
			'selectors'  => [ self::R => '--ssh-a-dist: {{SIZE}}px;' ],
			'condition'  => [ 'content_anim' => [ 'up', 'down', 'left', 'right', 'blur' ] ],
		] );

		$this->add_control( 'title_reveal', [
			'label'     => esc_html__( 'افکت ورود عنوان', 'sirstone-hero' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'none',
			'separator' => 'before',
			'options'   => [
				'none'    => esc_html__( 'مثل بقیه‌ی محتوا', 'sirstone-hero' ),
				'words'   => esc_html__( 'کلمه به کلمه (Mask)', 'sirstone-hero' ),
				'letters' => esc_html__( 'حرف به حرف (Mask)', 'sirstone-hero' ),
			],
		] );

		$this->add_control( 'title_word_step', [
			'label'      => esc_html__( 'فاصله بین کلمه‌ها (میلی‌ثانیه)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 400, 'step' => 5 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 90 ],
			'selectors'  => [ self::R => '--ssh-t-step: {{SIZE}}ms;' ],
			'condition'  => [ 'title_reveal' => 'words' ],
		] );

		$this->add_control( 'title_letter_step', [
			'label'      => esc_html__( 'فاصله بین حروف (میلی‌ثانیه)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 5, 'max' => 150, 'step' => 5 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 30 ],
			'selectors'  => [ self::R => '--ssh-t-step: {{SIZE}}ms;' ],
			'condition'  => [ 'title_reveal' => 'letters' ],
		] );

		$this->end_controls_section();
	}
}
