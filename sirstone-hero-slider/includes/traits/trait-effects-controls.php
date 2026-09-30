<?php
namespace SirstoneHero\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit;

/**
 * Style tab: image effects, overlays, rail, progress strip,
 * prev/next cluster and crop-mark corners.
 */
trait Effects_Controls {

	/* ------------------------------------------------------------------ */
	/* Image effects                                                       */
	/* ------------------------------------------------------------------ */

	private function register_image_fx_style() {
		$this->start_controls_section( 'section_style_image_fx', [
			'label' => esc_html__( 'افکت‌های تصویر', 'sirstone-hero' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		/* ---- Ken Burns ---- */
		$this->add_control( 'kb_heading', [
			'label' => esc_html__( 'حرکت آرام تصویر (Ken Burns)', 'sirstone-hero' ),
			'type'  => Controls_Manager::HEADING,
		] );

		$this->add_control( 'kb_effect', [
			'label'   => esc_html__( 'نوع حرکت (پیش‌فرض همه‌ی اسلایدها)', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'zoom-out',
			'options' => self::motions(),
		] );

		$this->add_control( 'kb_scale', [
			'label'       => esc_html__( 'شدت زوم', 'sirstone-hero' ),
			'type'        => Controls_Manager::SLIDER,
			'size_units'  => [ 'px' ],
			'range'       => [ 'px' => [ 'min' => 1, 'max' => 1.5, 'step' => 0.01 ] ],
			'default'     => [ 'unit' => 'px', 'size' => 1.08 ],
			'description' => esc_html__( 'در حالت‌های حرکت جانبی، مقدار بیشتر یعنی مسافت حرکت بیشتر.', 'sirstone-hero' ),
			'selectors'   => [ self::R => '--ssh-kb-scale: {{SIZE}};' ],
			'condition'   => [ 'kb_effect!' => 'none' ],
		] );

		$this->add_control( 'kb_duration', [
			'label'      => esc_html__( 'مدت حرکت (ثانیه)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 2, 'max' => 24, 'step' => 0.5 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 8 ],
			'selectors'  => [ self::R => '--ssh-kb-dur: {{SIZE}}s;' ],
			'condition'  => [ 'kb_effect!' => 'none' ],
		] );

		/* ---- look + filters ---- */
		$this->add_control( 'look_heading', [
			'label'     => esc_html__( 'فیلتر رنگی', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'image_look_default', [
			'label'   => esc_html__( 'حالت رنگی آماده (پیش‌فرض)', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'none',
			'options' => self::looks(),
		] );

		$this->start_controls_tabs( 'img_filter_tabs' );

		$this->start_controls_tab( 'img_filter_normal', [
			'label' => esc_html__( 'عادی', 'sirstone-hero' ),
		] );
		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'img_filter',
			'selector' => self::R . ' .ssh-bg',
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'img_filter_hover', [
			'label' => esc_html__( 'هاور اسلایدر', 'sirstone-hero' ),
		] );
		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'img_filter_h',
			'selector' => self::R . ':hover .ssh-bg',
		] );
		$this->add_control( 'img_filter_time', [
			'label'      => esc_html__( 'سرعت تغییر (ثانیه)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 3, 'step' => 0.1 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 0.8 ],
			'selectors'  => [ self::R . ' .ssh-bg' => 'transition-duration: {{SIZE}}s;' ],
		] );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		/* ---- pointer interaction ---- */
		$this->add_control( 'pointer_heading', [
			'label'     => esc_html__( 'واکنش به ماوس', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'parallax_strength', [
			'label'       => esc_html__( 'پارالاکس تصویر با ماوس (px)', 'sirstone-hero' ),
			'type'        => Controls_Manager::SLIDER,
			'size_units'  => [ 'px' ],
			'range'       => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'     => [ 'unit' => 'px', 'size' => 0 ],
			'description' => esc_html__( '۰ = خاموش. تصویر کمی خلاف جهت ماوس حرکت می‌کند.', 'sirstone-hero' ),
			'selectors'   => [ self::R => '--ssh-par: {{SIZE}}px;' ],
		] );

		$this->add_control( 'hover_zoom', [
			'label'       => esc_html__( 'زوم تصویر هنگام هاور', 'sirstone-hero' ),
			'type'        => Controls_Manager::SLIDER,
			'size_units'  => [ 'px' ],
			'range'       => [ 'px' => [ 'min' => 1, 'max' => 1.3, 'step' => 0.01 ] ],
			'default'     => [ 'unit' => 'px', 'size' => 1 ],
			'description' => esc_html__( '۱ = خاموش.', 'sirstone-hero' ),
			'selectors'   => [ self::R => '--ssh-hz: {{SIZE}};' ],
		] );

		/* ---- spotlight ---- */
		$this->add_control( 'spot_enable', [
			'label'       => esc_html__( 'نور دنبال‌کننده ماوس (Spotlight)', 'sirstone-hero' ),
			'type'        => Controls_Manager::SWITCHER,
			'separator'   => 'before',
			'description' => esc_html__( 'یک هاله‌ی نور که زیر ماوس روی تصویر حرکت می‌کند.', 'sirstone-hero' ),
		] );

		$this->add_control( 'spot_color', [
			'label'     => esc_html__( 'رنگ نور', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(209, 182, 137, 0.28)',
			'selectors' => [ self::R => '--ssh-spot-color: {{VALUE}};' ],
			'condition' => [ 'spot_enable' => 'yes' ],
		] );

		$this->add_control( 'spot_size', [
			'label'      => esc_html__( 'اندازه نور', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 1400, 'step' => 10 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 600 ],
			'selectors'  => [ self::R => '--ssh-spot-size: {{SIZE}}px;' ],
			'condition'  => [ 'spot_enable' => 'yes' ],
		] );

		$this->add_control( 'spot_blend', [
			'label'     => esc_html__( 'حالت ترکیب نور', 'sirstone-hero' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'screen',
			'options'   => [
				'screen'      => 'Screen',
				'overlay'     => 'Overlay',
				'soft-light'  => 'Soft Light',
				'color-dodge' => 'Color Dodge',
				'normal'      => esc_html__( 'عادی', 'sirstone-hero' ),
			],
			'selectors' => [ self::R => '--ssh-spot-blend: {{VALUE}};' ],
			'condition' => [ 'spot_enable' => 'yes' ],
		] );

		/* ---- shine ---- */
		$this->add_control( 'shine_enable', [
			'label'       => esc_html__( 'عبور نور (Light Sweep)', 'sirstone-hero' ),
			'type'        => Controls_Manager::SWITCHER,
			'separator'   => 'before',
			'description' => esc_html__( 'هر چند ثانیه یک بار، نواری از نور روی اسلاید فعال عبور می‌کند.', 'sirstone-hero' ),
		] );

		$this->add_control( 'shine_color', [
			'label'     => esc_html__( 'رنگ نور', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(255, 255, 255, 0.22)',
			'selectors' => [ self::R => '--ssh-shine-color: {{VALUE}};' ],
			'condition' => [ 'shine_enable' => 'yes' ],
		] );

		$this->add_control( 'shine_interval', [
			'label'      => esc_html__( 'فاصله بین دو عبور (ثانیه)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 2, 'max' => 20, 'step' => 0.5 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 7 ],
			'selectors'  => [ self::R => '--ssh-shine-int: {{SIZE}}s;' ],
			'condition'  => [ 'shine_enable' => 'yes' ],
		] );

		$this->add_control( 'shine_delay', [
			'label'      => esc_html__( 'تأخیر اولین عبور (ثانیه)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1.2 ],
			'selectors'  => [ self::R => '--ssh-shine-delay: {{SIZE}}s;' ],
			'condition'  => [ 'shine_enable' => 'yes' ],
		] );

		/* ---- grain ---- */
		$this->add_control( 'grain_enable', [
			'label'       => esc_html__( 'دانه‌ی فیلم (Film Grain)', 'sirstone-hero' ),
			'type'        => Controls_Manager::SWITCHER,
			'separator'   => 'before',
			'description' => esc_html__( 'نویز ظریف سینمایی روی تصویر.', 'sirstone-hero' ),
		] );

		$this->add_control( 'grain_opacity', [
			'label'      => esc_html__( 'شدت', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0.02, 'max' => 0.5, 'step' => 0.01 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 0.12 ],
			'selectors'  => [ self::R => '--ssh-grain-o: {{SIZE}};' ],
			'condition'  => [ 'grain_enable' => 'yes' ],
		] );

		$this->add_control( 'grain_animate', [
			'label'     => esc_html__( 'متحرک', 'sirstone-hero' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'condition' => [ 'grain_enable' => 'yes' ],
		] );

		/* ---- vignette ---- */
		$this->add_control( 'vignette_enable', [
			'label'       => esc_html__( 'تیرگی لبه‌ها (Vignette)', 'sirstone-hero' ),
			'type'        => Controls_Manager::SWITCHER,
			'separator'   => 'before',
			'description' => esc_html__( 'لبه‌های تصویر را تیره می‌کند تا توجه به مرکز جلب شود.', 'sirstone-hero' ),
		] );

		$this->add_control( 'vignette_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(0, 0, 0, 0.6)',
			'selectors' => [ self::R => '--ssh-vg-color: {{VALUE}};' ],
			'condition' => [ 'vignette_enable' => 'yes' ],
		] );

		$this->add_control( 'vignette_size', [
			'label'       => esc_html__( 'شروع تیرگی از مرکز (%)', 'sirstone-hero' ),
			'type'        => Controls_Manager::SLIDER,
			'size_units'  => [ '%' ],
			'range'       => [ '%' => [ 'min' => 10, 'max' => 95 ] ],
			'default'     => [ 'unit' => '%', 'size' => 55 ],
			'selectors'   => [ self::R => '--ssh-vg-start: {{SIZE}}%;' ],
			'condition'   => [ 'vignette_enable' => 'yes' ],
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Overlays                                                            */
	/* ------------------------------------------------------------------ */

	private function register_overlay_style() {
		$this->start_controls_section( 'section_style_overlay', [
			'label' => esc_html__( 'لایه‌های روی تصویر', 'sirstone-hero' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'default_overlay', [
			'label'       => esc_html__( 'لایه تیره‌ی پیش‌فرض سیرستون', 'sirstone-hero' ),
			'type'        => Controls_Manager::SWITCHER,
			'default'     => 'yes',
			'description' => esc_html__( 'گرادیان تیره از سمت چپ و پایین که خوانایی متن را بالا می‌برد.', 'sirstone-hero' ),
		] );

		$this->add_control( 'default_overlay_opacity', [
			'label'      => esc_html__( 'شفافیت لایه‌ی پیش‌فرض', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
			'selectors'  => [ self::R . ' .ssh-scrim' => 'opacity: {{SIZE}};' ],
			'condition'  => [ 'default_overlay' => 'yes' ],
		] );

		$this->add_control( 'custom_overlay_heading', [
			'label'     => esc_html__( 'لایه‌ی دلخواه (روی همه‌ی اسلایدها)', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'custom_overlay',
			'types'    => [ 'classic', 'gradient' ],
			'exclude'  => [ 'image' ],
			'selector' => self::R . ' .ssh-overlay',
		] );

		$this->add_control( 'custom_overlay_opacity', [
			'label'      => esc_html__( 'شفافیت', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
			'selectors'  => [ self::R . ' .ssh-overlay' => 'opacity: {{SIZE}};' ],
			'condition'  => [ 'custom_overlay_background!' => '' ],
		] );

		$this->add_control( 'custom_overlay_blend', [
			'label'     => esc_html__( 'حالت ترکیب', 'sirstone-hero' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => self::blend_modes(),
			'selectors' => [ self::R . ' .ssh-overlay' => 'mix-blend-mode: {{VALUE}};' ],
			'condition' => [ 'custom_overlay_background!' => '' ],
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Rail                                                                */
	/* ------------------------------------------------------------------ */

	private function register_rail_style() {
		$rail = self::R . ' .ssh-rail';
		$btn  = $rail . ' .ssh-rail__btn';

		$this->start_controls_section( 'section_style_rail', [
			'label'     => esc_html__( 'فهرست عمودی کنار اسلایدر', 'sirstone-hero' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_rail' => 'yes' ],
		] );

		$this->add_control( 'rail_position', [
			'label'   => esc_html__( 'سمت نمایش', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'left',
			'options' => [
				'left'  => esc_html__( 'چپ', 'sirstone-hero' ),
				'right' => esc_html__( 'راست', 'sirstone-hero' ),
			],
		] );

		$this->add_responsive_control( 'rail_display', [
			'label'          => esc_html__( 'نمایش', 'sirstone-hero' ),
			'type'           => Controls_Manager::SELECT,
			'default'        => 'flex',
			'tablet_default' => 'flex',
			'mobile_default' => 'none',
			'options'        => [
				'flex' => esc_html__( 'نمایش', 'sirstone-hero' ),
				'none' => esc_html__( 'مخفی', 'sirstone-hero' ),
			],
			'selectors'      => [ $rail => 'display: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'rail_width', [
			'label'      => esc_html__( 'عرض', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 40, 'max' => 240 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 84 ],
			'selectors'  => [ $rail => 'width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'rail_bg', [
			'label'       => esc_html__( 'رنگ پس‌زمینه', 'sirstone-hero' ),
			'type'        => Controls_Manager::COLOR,
			'description' => esc_html__( 'خالی = گرادیان تیره‌ی پیش‌فرض.', 'sirstone-hero' ),
			'selectors'   => [ $rail => 'background: {{VALUE}};' ],
		] );

		$this->add_control( 'rail_align', [
			'label'     => esc_html__( 'تراز عمودی دکمه‌ها', 'sirstone-hero' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => [
				'flex-start' => [
					'title' => esc_html__( 'بالا', 'sirstone-hero' ),
					'icon'  => 'eicon-v-align-top',
				],
				'center'     => [
					'title' => esc_html__( 'وسط', 'sirstone-hero' ),
					'icon'  => 'eicon-v-align-middle',
				],
				'flex-end'   => [
					'title' => esc_html__( 'پایین', 'sirstone-hero' ),
					'icon'  => 'eicon-v-align-bottom',
				],
			],
			'default'   => 'center',
			'toggle'    => false,
			'selectors' => [ $rail => 'justify-content: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'           => 'rail_typo',
			'label'          => esc_html__( 'تایپوگرافی شماره', 'sirstone-hero' ),
			'selector'       => $rail . ' .ssh-rail__n',
			'separator'      => 'before',
			'fields_options' => self::typo( 'Manrope', 11, '400', [
				'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.66 ] ],
			] ),
		] );

		$this->start_controls_tabs( 'rail_tabs' );

		$this->start_controls_tab( 'rail_tab_normal', [ 'label' => esc_html__( 'عادی', 'sirstone-hero' ) ] );
		$this->add_control( 'rail_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(242, 236, 222, 0.4)',
			'selectors' => [ $btn => 'color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'rail_tab_hover', [ 'label' => esc_html__( 'هاور', 'sirstone-hero' ) ] );
		$this->add_control( 'rail_color_h', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#e3cda3',
			'selectors' => [ $btn . ':hover' => 'color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'rail_tab_active', [ 'label' => esc_html__( 'فعال', 'sirstone-hero' ) ] );
		$this->add_control( 'rail_color_a', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#e3cda3',
			'selectors' => [ $btn . '.is-active' => 'color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'rail_tick_heading', [
			'label'     => esc_html__( 'خط کنار هر شماره', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'rail_tick_width', [
			'label'      => esc_html__( 'ضخامت', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 1, 'max' => 6 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1 ],
			'selectors'  => [ $rail . ' .ssh-rail__tick' => 'width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'rail_tick_height', [
			'label'      => esc_html__( 'طول (عادی)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 4, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 26 ],
			'selectors'  => [ $rail . ' .ssh-rail__tick' => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'rail_tick_height_a', [
			'label'      => esc_html__( 'طول (فعال)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 4, 'max' => 160 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 46 ],
			'selectors'  => [ $btn . '.is-active .ssh-rail__tick' => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'rail_gap', [
			'label'      => esc_html__( 'فاصله شماره و خط', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 8 ],
			'selectors'  => [ $btn => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'rail_spacing', [
			'label'      => esc_html__( 'فاصله بین دکمه‌ها (بالا/پایین)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 16 ],
			'selectors'  => [ $btn => 'padding: {{SIZE}}{{UNIT}} 0;' ],
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Progress strip                                                      */
	/* ------------------------------------------------------------------ */

	private function register_progress_style() {
		$bar = self::R . ' .ssh-progress';
		$btn = $bar . ' .ssh-progress__btn';

		$this->start_controls_section( 'section_style_progress', [
			'label'     => esc_html__( 'نوار پیشرفت پایین', 'sirstone-hero' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_progress' => 'yes' ],
		] );

		$this->add_responsive_control( 'progress_height', [
			'label'      => esc_html__( 'ارتفاع', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 28, 'max' => 160 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 64 ],
			'selectors'  => [ $bar => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'           => 'progress_bg',
			'types'          => [ 'classic', 'gradient' ],
			'exclude'        => [ 'image' ],
			'selector'       => $bar,
			'fields_options' => [
				'background' => [ 'default' => 'classic' ],
				'color'      => [ 'default' => 'rgba(23, 19, 16, 0.35)' ],
			],
		] );

		$this->add_control( 'progress_blur', [
			'label'      => esc_html__( 'محو پس‌زمینه (Blur)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 3 ],
			'selectors'  => [ $bar => '-webkit-backdrop-filter: blur({{SIZE}}{{UNIT}}); backdrop-filter: blur({{SIZE}}{{UNIT}});' ],
		] );

		$this->add_control( 'progress_border_color', [
			'label'     => esc_html__( 'رنگ خط بالا', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(242, 236, 222, 0.18)',
			'selectors' => [ $bar => 'border-top-color: {{VALUE}};' ],
		] );

		$this->add_control( 'progress_divider_color', [
			'label'     => esc_html__( 'رنگ خط بین بخش‌ها', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(242, 236, 222, 0.14)',
			'selectors' => [ $btn => 'border-right-color: {{VALUE}};' ],
		] );

		$this->add_control( 'progress_fill', [
			'label'       => esc_html__( 'رنگ نوار پرشونده', 'sirstone-hero' ),
			'type'        => Controls_Manager::COLOR,
			'default'     => 'rgba(209, 182, 137, 0.15)',
			'separator'   => 'before',
			'selectors'   => [ $bar . ' .ssh-progress__fill' => 'background: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'progress_padding', [
			'label'      => esc_html__( 'فاصله افقی داخل هر بخش', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 20 ],
			'selectors'  => [ $btn => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'progress_align', [
			'label'     => esc_html__( 'تراز برچسب', 'sirstone-hero' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => [
				'flex-start' => [
					'title' => esc_html__( 'ابتدا', 'sirstone-hero' ),
					'icon'  => is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
				],
				'center'     => [
					'title' => esc_html__( 'وسط', 'sirstone-hero' ),
					'icon'  => 'eicon-h-align-center',
				],
				'flex-end'   => [
					'title' => esc_html__( 'انتها', 'sirstone-hero' ),
					'icon'  => is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
				],
			],
			'default'   => 'flex-start',
			'toggle'    => false,
			'selectors' => [ $btn => 'justify-content: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'           => 'progress_typo',
			'label'          => esc_html__( 'تایپوگرافی برچسب', 'sirstone-hero' ),
			'selector'       => $bar . ' .ssh-progress__label',
			'separator'      => 'before',
			'fields_options' => self::typo( 'Manrope', 11.5, '400', [
				'text_transform' => [ 'default' => 'uppercase' ],
				'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.92 ] ],
			] ),
		] );

		$this->start_controls_tabs( 'progress_tabs' );

		$this->start_controls_tab( 'progress_tab_normal', [ 'label' => esc_html__( 'عادی', 'sirstone-hero' ) ] );
		$this->add_control( 'progress_color', [
			'label'     => esc_html__( 'رنگ متن', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(242, 236, 222, 0.55)',
			'selectors' => [ $btn . ' .ssh-progress__label' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'progress_dot_color', [
			'label'       => esc_html__( 'رنگ نقطه', 'sirstone-hero' ),
			'type'        => Controls_Manager::COLOR,
			'description' => esc_html__( 'خالی = هم‌رنگ متن.', 'sirstone-hero' ),
			'selectors'   => [ $btn . ' .ssh-progress__dot' => 'background: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'progress_tab_active', [ 'label' => esc_html__( 'فعال', 'sirstone-hero' ) ] );
		$this->add_control( 'progress_color_a', [
			'label'     => esc_html__( 'رنگ متن', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#F7F3E9',
			'selectors' => [ $btn . '.is-active .ssh-progress__label' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'progress_dot_color_a', [
			'label'     => esc_html__( 'رنگ نقطه', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#d1b689',
			'selectors' => [ $btn . '.is-active .ssh-progress__dot' => 'background: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'progress_dot_size', [
			'label'      => esc_html__( 'اندازه نقطه', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 2, 'max' => 20 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 5 ],
			'separator'  => 'before',
			'selectors'  => [ $bar . ' .ssh-progress__dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'progress_show_dot' => 'yes' ],
		] );

		$this->add_control( 'progress_label_gap', [
			'label'      => esc_html__( 'فاصله بین نقطه، شماره و نام', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 10 ],
			'selectors'  => [ $bar . ' .ssh-progress__label' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Prev / next / play-pause cluster                                    */
	/* ------------------------------------------------------------------ */

	private function register_ctrls_style() {
		$wrap = self::R . ' .ssh-ctrls';
		$btn  = $wrap . ' .ssh-ctrl';

		$this->start_controls_section( 'section_style_ctrls', [
			'label'      => esc_html__( 'دکمه‌های قبلی / بعدی / توقف', 'sirstone-hero' ),
			'tab'        => Controls_Manager::TAB_STYLE,
			'conditions' => [
				'relation' => 'or',
				'terms'    => [
					[ 'name' => 'show_nav', 'operator' => '==', 'value' => 'yes' ],
					[ 'name' => 'show_playpause', 'operator' => '==', 'value' => 'yes' ],
				],
			],
		] );

		$this->add_control( 'ctrl_position', [
			'label'   => esc_html__( 'سمت نمایش', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'right',
			'options' => [
				'right' => esc_html__( 'راست', 'sirstone-hero' ),
				'left'  => esc_html__( 'چپ', 'sirstone-hero' ),
			],
		] );

		$this->add_responsive_control( 'ctrl_offset_x', [
			'label'          => esc_html__( 'فاصله از لبه', 'sirstone-hero' ),
			'type'           => Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 240 ] ],
			'default'        => [ 'unit' => 'px', 'size' => 28 ],
			'mobile_default' => [ 'unit' => 'px', 'size' => 16 ],
			'selectors'      => [ $wrap => '--ssh-ctrl-x: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'ctrl_offset_y', [
			'label'          => esc_html__( 'فاصله از پایین', 'sirstone-hero' ),
			'type'           => Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 400 ] ],
			'default'        => [ 'unit' => 'px', 'size' => 96 ],
			'mobile_default' => [ 'unit' => 'px', 'size' => 84 ],
			'selectors'      => [ $wrap => '--ssh-ctrl-y: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'ctrl_size', [
			'label'      => esc_html__( 'اندازه دکمه', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 28, 'max' => 100 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 46 ],
			'separator'  => 'before',
			'selectors'  => [ $btn => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'ctrl_icon_size', [
			'label'      => esc_html__( 'اندازه آیکن', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 16 ],
			'selectors'  => [ $btn => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'ctrl_gap', [
			'label'      => esc_html__( 'فاصله بین دکمه‌ها', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 8 ],
			'selectors'  => [ $wrap => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'ctrl_border_width', [
			'label'      => esc_html__( 'ضخامت کادر', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 6 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1 ],
			'selectors'  => [ $btn => 'border-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'ctrl_radius', [
			'label'      => esc_html__( 'گردی گوشه‌ها', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 60 ],
				'%'  => [ 'min' => 0, 'max' => 50 ],
			],
			'default'    => [ 'unit' => '%', 'size' => 50 ],
			'selectors'  => [ $btn => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'ctrl_tabs' );

		$this->start_controls_tab( 'ctrl_tab_normal', [ 'label' => esc_html__( 'عادی', 'sirstone-hero' ) ] );
		$this->add_control( 'ctrl_color', [
			'label'     => esc_html__( 'رنگ آیکن', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#F7F3E9',
			'selectors' => [ $btn => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'ctrl_bg', [
			'label'     => esc_html__( 'رنگ پس‌زمینه', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(23, 19, 16, 0.35)',
			'selectors' => [ $btn => 'background-color: {{VALUE}};' ],
		] );
		$this->add_control( 'ctrl_border', [
			'label'     => esc_html__( 'رنگ کادر', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(242, 236, 222, 0.4)',
			'selectors' => [ $btn => 'border-color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'ctrl_tab_hover', [ 'label' => esc_html__( 'هاور', 'sirstone-hero' ) ] );
		$this->add_control( 'ctrl_color_h', [
			'label'     => esc_html__( 'رنگ آیکن', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#171310',
			'selectors' => [ $btn . ':hover, ' . $btn . ':focus-visible' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'ctrl_bg_h', [
			'label'     => esc_html__( 'رنگ پس‌زمینه', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#d1b689',
			'selectors' => [ $btn . ':hover, ' . $btn . ':focus-visible' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_control( 'ctrl_border_h', [
			'label'     => esc_html__( 'رنگ کادر', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#d1b689',
			'selectors' => [ $btn . ':hover, ' . $btn . ':focus-visible' => 'border-color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Crop-mark corners                                                   */
	/* ------------------------------------------------------------------ */

	private function register_corners_style() {
		$c = self::R . ' .ssh-corner';

		$this->start_controls_section( 'section_style_corners', [
			'label'     => esc_html__( 'علامت‌های گوشه', 'sirstone-hero' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_corners' => 'yes' ],
		] );

		$this->add_responsive_control( 'corner_display', [
			'label'          => esc_html__( 'نمایش', 'sirstone-hero' ),
			'type'           => Controls_Manager::SELECT,
			'default'        => 'block',
			'tablet_default' => 'block',
			'mobile_default' => 'none',
			'options'        => [
				'block' => esc_html__( 'نمایش', 'sirstone-hero' ),
				'none'  => esc_html__( 'مخفی', 'sirstone-hero' ),
			],
			'selectors'      => [ $c => 'display: {{VALUE}};' ],
		] );

		$this->add_control( 'corner_size', [
			'label'      => esc_html__( 'اندازه', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 26 ],
			'selectors'  => [ $c => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'corner_offset', [
			'label'      => esc_html__( 'فاصله از لبه‌ها', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 28 ],
			'selectors'  => [
				$c . '--tl' => 'top: {{SIZE}}{{UNIT}}; left: {{SIZE}}{{UNIT}};',
				$c . '--tr' => 'top: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}};',
				$c . '--bl' => 'bottom: {{SIZE}}{{UNIT}}; left: {{SIZE}}{{UNIT}};',
				$c . '--br' => 'bottom: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'corner_thickness', [
			'label'      => esc_html__( 'ضخامت خط', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 1, 'max' => 6 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1 ],
			'selectors'  => [
				$c . '::before' => 'height: {{SIZE}}{{UNIT}};',
				$c . '::after'  => 'width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'corner_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(242, 236, 222, 0.55)',
			'selectors' => [
				$c . '::before, ' . $c . '::after' => 'background: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}
}
