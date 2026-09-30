<?php
namespace SirstoneHero\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit;

/**
 * Style tab: layout, eyebrow, title, description, buttons, specs.
 */
trait Style_Controls {

	/** fields_options for a typography group with sensible defaults. */
	private static function typo( $family, $size, $weight = '400', array $extra = [] ) {
		return array_merge( [
			'typography'  => [ 'default' => 'custom' ],
			'font_family' => [ 'default' => $family ],
			'font_size'   => [ 'default' => [ 'unit' => 'px', 'size' => $size ] ],
			'font_weight' => [ 'default' => $weight ],
		], $extra );
	}

	private static function box( $top, $right, $bottom, $left ) {
		return [
			'top'      => (string) $top,
			'right'    => (string) $right,
			'bottom'   => (string) $bottom,
			'left'     => (string) $left,
			'unit'     => 'px',
			'isLinked' => false,
		];
	}

	/* ------------------------------------------------------------------ */
	/* Layout                                                              */
	/* ------------------------------------------------------------------ */

	private function register_layout_style() {
		$this->start_controls_section( 'section_style_layout', [
			'label' => esc_html__( 'چیدمان و قاب اسلایدر', 'sirstone-hero' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'slider_height', [
			'label'          => esc_html__( 'ارتفاع', 'sirstone-hero' ),
			'type'           => Controls_Manager::SLIDER,
			'size_units'     => [ 'px', 'vh', 'em', 'custom' ],
			'range'          => [
				'px' => [ 'min' => 240, 'max' => 1400 ],
				'vh' => [ 'min' => 20, 'max' => 100 ],
			],
			'default'        => [ 'unit' => 'vh', 'size' => 100 ],
			'mobile_default' => [ 'unit' => 'vh', 'size' => 93 ],
			'selectors'      => [ self::R => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'slider_min_height', [
			'label'          => esc_html__( 'حداقل ارتفاع', 'sirstone-hero' ),
			'type'           => Controls_Manager::SLIDER,
			'size_units'     => [ 'px', 'vh', 'custom' ],
			'range'          => [
				'px' => [ 'min' => 0, 'max' => 1200 ],
				'vh' => [ 'min' => 0, 'max' => 100 ],
			],
			'default'        => [ 'unit' => 'px', 'size' => 680 ],
			'mobile_default' => [ 'unit' => 'px', 'size' => 480 ],
			'selectors'      => [ self::R => 'min-height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'slider_max_height', [
			'label'      => esc_html__( 'حداکثر ارتفاع', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vh', 'custom' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 1800 ],
				'vh' => [ 'min' => 0, 'max' => 100 ],
			],
			'default'    => [ 'unit' => 'px', 'size' => 980 ],
			'selectors'  => [ self::R => 'max-height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'slider_bg', [
			'label'     => esc_html__( 'رنگ پس‌زمینه (زیر تصاویر)', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#171310',
			'selectors' => [ self::R => 'background-color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'      => 'slider_border',
			'selector'  => self::R,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'slider_radius', [
			'label'      => esc_html__( 'گردی گوشه‌ها', 'sirstone-hero' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ self::R => self::dims( 'border-radius' ) ],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'slider_shadow',
			'selector' => self::R,
		] );

		/* ---- content box ---- */
		$this->add_control( 'content_box_heading', [
			'label'     => esc_html__( 'جعبه محتوا', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'content_width', [
			'label'      => esc_html__( 'حداکثر عرض', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'vw', 'custom' ],
			'range'      => [
				'px' => [ 'min' => 240, 'max' => 1600 ],
				'%'  => [ 'min' => 20, 'max' => 100 ],
			],
			'default'    => [ 'unit' => 'px', 'size' => 960 ],
			'selectors'  => [ self::R . ' .ssh-content' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'content_padding', [
			'label'          => esc_html__( 'فاصله داخلی', 'sirstone-hero' ),
			'type'           => Controls_Manager::DIMENSIONS,
			'size_units'     => [ 'px', '%', 'em', 'vw' ],
			'default'        => self::box( 0, 200, 90, 200 ),
			'tablet_default' => self::box( 0, 100, 100, 120 ),
			'mobile_default' => self::box( 0, 28, 100, 28 ),
			'selectors'      => [ self::R . ' .ssh-content' => self::dims( 'padding' ) ],
		] );

		$this->add_responsive_control( 'content_align', [
			'label'                => esc_html__( 'تراز محتوا', 'sirstone-hero' ),
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => self::align_choices(),
			'default'              => 'start',
			'toggle'               => false,
			'selectors_dictionary' => self::align_dictionary(),
			'selectors'            => [ self::R . ' .ssh-content' => '{{VALUE}}' ],
		] );

		$this->add_responsive_control( 'content_valign', [
			'label'     => esc_html__( 'موقعیت عمودی محتوا', 'sirstone-hero' ),
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
			'selectors' => [ self::R . ' .ssh-content' => 'justify-content: {{VALUE}};' ],
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Eyebrow                                                             */
	/* ------------------------------------------------------------------ */

	private function register_eyebrow_style() {
		$sel = self::R . ' .ssh-eyebrow';

		$this->start_controls_section( 'section_style_eyebrow', [
			'label' => esc_html__( 'متن کوچک بالای عنوان', 'sirstone-hero' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'eyebrow_color', [
			'label'     => esc_html__( 'رنگ متن', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#d1b689',
			'selectors' => [ $sel => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'           => 'eyebrow_typo',
			'selector'       => $sel,
			'fields_options' => self::typo( 'Manrope', 12, '500', [
				'text_transform' => [ 'default' => 'uppercase' ],
				'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 2.9 ] ],
			] ),
		] );

		$this->add_group_control( Group_Control_Text_Shadow::get_type(), [
			'name'     => 'eyebrow_text_shadow',
			'selector' => $sel,
		] );

		$this->add_control( 'eyebrow_line', [
			'label'     => esc_html__( 'خط کنار متن', 'sirstone-hero' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'separator' => 'before',
		] );

		$this->add_control( 'eyebrow_line_width', [
			'label'      => esc_html__( 'طول خط', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 4, 'max' => 160 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 22 ],
			'selectors'  => [ $sel . '::before' => 'width: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'eyebrow_line' => 'yes' ],
		] );

		$this->add_control( 'eyebrow_line_height', [
			'label'      => esc_html__( 'ضخامت خط', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 1, 'max' => 8 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1 ],
			'selectors'  => [ $sel . '::before' => 'height: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'eyebrow_line' => 'yes' ],
		] );

		$this->add_control( 'eyebrow_line_color', [
			'label'     => esc_html__( 'رنگ خط (خالی = رنگ متن)', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ $sel . '::before' => 'background: {{VALUE}};' ],
			'condition' => [ 'eyebrow_line' => 'yes' ],
		] );

		$this->add_control( 'eyebrow_gap', [
			'label'      => esc_html__( 'فاصله خط و متن', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 12 ],
			'selectors'  => [ $sel => 'gap: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'eyebrow_line' => 'yes' ],
		] );

		$this->add_control( 'eyebrow_box_heading', [
			'label'     => esc_html__( 'قاب متن', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'eyebrow_bg', [
			'label'     => esc_html__( 'رنگ پس‌زمینه', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ $sel => 'background-color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'eyebrow_border',
			'selector' => $sel,
		] );

		$this->add_responsive_control( 'eyebrow_radius', [
			'label'      => esc_html__( 'گردی گوشه‌ها', 'sirstone-hero' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ $sel => self::dims( 'border-radius' ) ],
		] );

		$this->add_responsive_control( 'eyebrow_padding', [
			'label'      => esc_html__( 'فاصله داخلی', 'sirstone-hero' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ $sel => self::dims( 'padding' ) ],
		] );

		$this->add_responsive_control( 'eyebrow_margin', [
			'label'      => esc_html__( 'فاصله بیرونی', 'sirstone-hero' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ $sel => self::dims( 'margin' ) ],
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Title                                                               */
	/* ------------------------------------------------------------------ */

	private function register_title_style() {
		$sel = self::R . ' .ssh-title';

		$this->start_controls_section( 'section_style_title', [
			'label' => esc_html__( 'عنوان', 'sirstone-hero' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#F7F3E9',
			'selectors' => [ $sel => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'           => 'title_typo',
			'selector'       => $sel,
			'fields_options' => self::typo( 'Marcellus', 60, '500', [
				'font_size'      => [
					'default'        => [ 'unit' => 'px', 'size' => 60 ],
					'tablet_default' => [ 'unit' => 'px', 'size' => 48 ],
					'mobile_default' => [ 'unit' => 'px', 'size' => 38 ],
				],
				'line_height'    => [ 'default' => [ 'unit' => 'em', 'size' => 1.06 ] ],
				'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 1.2 ] ],
			] ),
		] );

		$this->add_group_control( Group_Control_Text_Shadow::get_type(), [
			'name'     => 'title_text_shadow',
			'selector' => $sel,
		] );

		$this->add_control( 'title_stroke_width', [
			'label'      => esc_html__( 'ضخامت خط دور حروف', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 6, 'step' => 0.1 ] ],
			'separator'  => 'before',
			'selectors'  => [ $sel => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'title_stroke_color', [
			'label'     => esc_html__( 'رنگ خط دور حروف', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ $sel => '-webkit-text-stroke-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'title_max_width', [
			'label'      => esc_html__( 'حداکثر عرض', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'em', 'custom' ],
			'range'      => [ 'px' => [ 'min' => 120, 'max' => 1400 ] ],
			'separator'  => 'before',
			'selectors'  => [ $sel => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'title_margin', [
			'label'      => esc_html__( 'فاصله بیرونی', 'sirstone-hero' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'default'    => self::box( 22, 0, 20, 0 ),
			'selectors'  => [ $sel => self::dims( 'margin' ) ],
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Description                                                         */
	/* ------------------------------------------------------------------ */

	private function register_description_style() {
		$sel = self::R . ' .ssh-desc';

		$this->start_controls_section( 'section_style_desc', [
			'label' => esc_html__( 'توضیحات', 'sirstone-hero' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'desc_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(242, 236, 222, 0.78)',
			'selectors' => [ $sel => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'           => 'desc_typo',
			'selector'       => $sel,
			'fields_options' => self::typo( 'Manrope', 16.5, '400', [
				'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.7 ] ],
			] ),
		] );

		$this->add_group_control( Group_Control_Text_Shadow::get_type(), [
			'name'     => 'desc_text_shadow',
			'selector' => $sel,
		] );

		$this->add_responsive_control( 'desc_max_width', [
			'label'      => esc_html__( 'حداکثر عرض', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'em', 'custom' ],
			'range'      => [ 'px' => [ 'min' => 160, 'max' => 1000 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 480 ],
			'separator'  => 'before',
			'selectors'  => [ $sel => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'desc_margin', [
			'label'      => esc_html__( 'فاصله بیرونی', 'sirstone-hero' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'default'    => self::box( 0, 0, 36, 0 ),
			'selectors'  => [ $sel => self::dims( 'margin' ) ],
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Buttons                                                             */
	/* ------------------------------------------------------------------ */

	private function register_buttons_style() {
		$this->start_controls_section( 'section_style_buttons', [
			'label' => esc_html__( 'دکمه‌ها (عمومی)', 'sirstone-hero' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'btn_hover_fx', [
			'label'   => esc_html__( 'افکت هاور', 'sirstone-hero' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'none',
			'options' => [
				'none'  => esc_html__( 'بدون افکت', 'sirstone-hero' ),
				'lift'  => esc_html__( 'بالا آمدن', 'sirstone-hero' ),
				'glow'  => esc_html__( 'درخشش', 'sirstone-hero' ),
				'sweep' => esc_html__( 'عبور نور', 'sirstone-hero' ),
			],
		] );

		$this->add_responsive_control( 'buttons_gap', [
			'label'      => esc_html__( 'فاصله بین دکمه‌ها', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 16 ],
			'selectors'  => [ self::R . ' .ssh-actions' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'btn_transition', [
			'label'      => esc_html__( 'سرعت تغییر حالت (میلی‌ثانیه)', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 1200, 'step' => 10 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 250 ],
			'selectors'  => [ self::R . ' .ssh-btn' => 'transition-duration: {{SIZE}}ms;' ],
		] );

		$this->add_control( 'btn_icon_position', [
			'label'     => esc_html__( 'جای آیکن', 'sirstone-hero' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'row',
			'separator' => 'before',
			'options'   => [
				'row'         => esc_html__( 'بعد از متن', 'sirstone-hero' ),
				'row-reverse' => esc_html__( 'قبل از متن', 'sirstone-hero' ),
			],
			'selectors' => [ self::R . ' .ssh-btn' => 'flex-direction: {{VALUE}};' ],
		] );

		$this->add_control( 'btn_icon_size', [
			'label'      => esc_html__( 'اندازه آیکن', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 14 ],
			'selectors'  => [ self::R . ' .ssh-btn__icon' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'btn_icon_gap', [
			'label'      => esc_html__( 'فاصله آیکن و متن', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 10 ],
			'selectors'  => [ self::R . ' .ssh-btn' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->register_single_button_style( 1 );
		$this->register_single_button_style( 2 );
	}

	private function register_single_button_style( $n ) {
		$primary = 1 === $n;
		$sel     = self::R . ' .ssh-btn--' . ( $primary ? 'primary' : 'secondary' );
		$hover   = $sel . ':hover, ' . $sel . ':focus-visible';
		$p       = "btn{$n}_";

		$this->start_controls_section( "section_style_btn{$n}", [
			'label' => $primary
				? esc_html__( 'دکمه ۱ (توپر)', 'sirstone-hero' )
				: esc_html__( 'دکمه ۲ (خطی)', 'sirstone-hero' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'           => $p . 'typo',
			'selector'       => $sel,
			'fields_options' => self::typo( 'Manrope', 13, '400', [
				'text_transform' => [ 'default' => 'uppercase' ],
				'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.65 ] ],
			] ),
		] );

		$this->start_controls_tabs( $p . 'tabs' );

		/* ---- normal ---- */
		$this->start_controls_tab( $p . 'tab_normal', [
			'label' => esc_html__( 'عادی', 'sirstone-hero' ),
		] );

		$this->add_control( $p . 'color', [
			'label'     => esc_html__( 'رنگ متن', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => $primary ? '#171310' : '#F7F3E9',
			'selectors' => [ $sel => 'color: {{VALUE}};' ],
		] );

		$bg_options = [
			'background' => [ 'default' => 'classic' ],
			'color'      => [ 'default' => $primary ? '#d1b689' : 'rgba(0,0,0,0)' ],
		];
		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'           => $p . 'bg',
			'types'          => [ 'classic', 'gradient' ],
			'exclude'        => [ 'image' ],
			'selector'       => $sel,
			'fields_options' => $bg_options,
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'           => $p . 'border',
			'selector'       => $sel,
			'fields_options' => [
				'border' => [ 'default' => 'solid' ],
				'width'  => [ 'default' => self::box( 1, 1, 1, 1 ) ],
				'color'  => [ 'default' => $primary ? '#d1b689' : 'rgba(242, 236, 222, 0.5)' ],
			],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => $p . 'shadow',
			'selector' => $sel,
		] );

		$this->end_controls_tab();

		/* ---- hover ---- */
		$this->start_controls_tab( $p . 'tab_hover', [
			'label' => esc_html__( 'هاور', 'sirstone-hero' ),
		] );

		$this->add_control( $p . 'color_h', [
			'label'     => esc_html__( 'رنگ متن', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => $primary ? '#171310' : '#e3cda3',
			'selectors' => [ $hover => 'color: {{VALUE}};' ],
		] );

		$hover_bg = [];
		if ( $primary ) {
			$hover_bg = [
				'background' => [ 'default' => 'classic' ],
				'color'      => [ 'default' => '#e3cda3' ],
			];
		}
		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'           => $p . 'bg_h',
			'types'          => [ 'classic', 'gradient' ],
			'exclude'        => [ 'image' ],
			'selector'       => $hover,
			'fields_options' => $hover_bg,
		] );

		$this->add_control( $p . 'border_h', [
			'label'     => esc_html__( 'رنگ کادر', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#e3cda3',
			'selectors' => [ $hover => 'border-color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => $p . 'shadow_h',
			'selector' => $hover,
		] );

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control( $p . 'radius_heading', [
			'label'     => esc_html__( 'ابعاد', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( $p . 'radius', [
			'label'      => esc_html__( 'گردی گوشه‌ها', 'sirstone-hero' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => self::box( 1, 1, 1, 1 ),
			'selectors'  => [ $sel => self::dims( 'border-radius' ) ],
		] );

		$this->add_responsive_control( $p . 'padding', [
			'label'      => esc_html__( 'فاصله داخلی', 'sirstone-hero' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'default'    => self::box( 16, 32, 16, 32 ),
			'selectors'  => [ $sel => self::dims( 'padding' ) ],
		] );

		$this->add_responsive_control( $p . 'min_width', [
			'label'      => esc_html__( 'حداقل عرض', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 500 ] ],
			'selectors'  => [ $sel => 'min-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Specs strip                                                         */
	/* ------------------------------------------------------------------ */

	private function register_specs_style() {
		$sel = self::R . ' .ssh-specs';

		$this->start_controls_section( 'section_style_specs', [
			'label' => esc_html__( 'نوار مشخصات', 'sirstone-hero' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'specs_margin_top', [
			'label'      => esc_html__( 'فاصله از بالا', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 38 ],
			'selectors'  => [ $sel => 'margin-top: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'specs_padding_top', [
			'label'      => esc_html__( 'فاصله خط بالا تا محتوا', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 22 ],
			'selectors'  => [ $sel => 'padding-top: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'specs_line_color', [
			'label'     => esc_html__( 'رنگ خط بالا', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(242, 236, 222, 0.22)',
			'selectors' => [ $sel => 'border-top-color: {{VALUE}};' ],
		] );

		$this->add_control( 'specs_line_width', [
			'label'      => esc_html__( 'ضخامت خط بالا', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 8 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1 ],
			'selectors'  => [ $sel => 'border-top-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'specs_divider_heading', [
			'label'     => esc_html__( 'خط‌های جداکننده', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'specs_divider_hide', [
			'label'     => esc_html__( 'مخفی کردن خط‌های جداکننده', 'sirstone-hero' ),
			'type'      => Controls_Manager::SWITCHER,
			'selectors' => [ $sel . ' .ssh-spec + .ssh-spec' => 'border-left-width: 0;' ],
		] );

		$this->add_control( 'specs_divider_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(242, 236, 222, 0.18)',
			'selectors' => [ $sel => '--ssh-spec-div-c: {{VALUE}};' ],
			'condition' => [ 'specs_divider_hide' => '' ],
		] );

		$this->add_control( 'specs_divider_width', [
			'label'      => esc_html__( 'ضخامت', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 1, 'max' => 6 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1 ],
			'selectors'  => [ $sel => '--ssh-spec-div-w: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'specs_divider_hide' => '' ],
		] );

		$this->add_responsive_control( 'specs_gap', [
			'label'      => esc_html__( 'فاصله هر مورد تا خط جداکننده', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 34 ],
			'selectors'  => [ $sel => '--ssh-spec-gap: {{SIZE}}{{UNIT}};' ],
		] );

		/* ---- label ---- */
		$this->add_control( 'spec_k_heading', [
			'label'     => esc_html__( 'عنوان هر مورد', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'spec_k_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(242, 236, 222, 0.5)',
			'selectors' => [ $sel . ' .ssh-spec__k' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'           => 'spec_k_typo',
			'selector'       => $sel . ' .ssh-spec__k',
			'fields_options' => self::typo( 'Manrope', 10, '400', [
				'text_transform' => [ 'default' => 'uppercase' ],
				'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 1 ] ],
			] ),
		] );

		$this->add_control( 'spec_k_gap', [
			'label'      => esc_html__( 'فاصله تا مقدار', 'sirstone-hero' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 5 ],
			'selectors'  => [ $sel . ' .ssh-spec__k' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		/* ---- value ---- */
		$this->add_control( 'spec_v_heading', [
			'label'     => esc_html__( 'مقدار هر مورد', 'sirstone-hero' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'spec_v_color', [
			'label'     => esc_html__( 'رنگ', 'sirstone-hero' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#F0E8D2',
			'selectors' => [ $sel . ' .ssh-spec__v' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'           => 'spec_v_typo',
			'selector'       => $sel . ' .ssh-spec__v',
			'fields_options' => self::typo( 'Marcellus', 15.5, '400' ),
		] );

		$this->end_controls_section();
	}
}
