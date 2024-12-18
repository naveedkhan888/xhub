<?php

use Elementor\Controls_Stack;
use Elementor\Controls_Manager;
use Elementor\Element_Column;
use Elementor\Core\Base\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class XP_Element_Column extends Module {

	public function __construct() {

		$this->add_actions();
	}

	public function get_name() {
		return 'xp-content-align';
	}

	/**
	 * @param $element    Controls_Stack
	 * @param $section_id string
	 */
	public function register_controls( Controls_Stack $element, $section_id ) {
		if ( ! $element instanceof Element_Column ) {
			return;
		}
		$required_section_id = 'layout';

		if ( $required_section_id !== $section_id ) {
			return;
		}

		$element->add_responsive_control(
			'_xp_column_min_width',
			[
				'label'        => esc_html__( 'Min Width (px)', 'restobar' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'device_args'     => [
					Controls_Stack::RESPONSIVE_DESKTOP => [
						'selectors' => [
							'{{WRAPPER}}' => 'min-width: {{SIZE}}{{UNIT}}',
						],
					],
					Controls_Stack::RESPONSIVE_TABLET => [
						'selectors' => [
							'{{WRAPPER}}' => 'min-width: {{SIZE}}{{UNIT}}',
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'selectors' => [
							'{{WRAPPER}}' => 'min-width: {{SIZE}}{{UNIT}}',
						],
					],
				],
				'separator' => 'before',
			]
		);

		$element->add_control(
			'_xp_content_align',
			[
				'label'        => esc_html__( 'Content Align', 'restobar' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'vertical'   => [
						'title' => esc_html__( 'Vertical', 'restobar' ),
						'icon'  => 'fa fa-ellipsis-v',
					],
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'restobar' ),
						'icon'  => 'fa fa-ellipsis-h',
					],
				],
				'default'      => 'vertical',
				'prefix_class' => 'xp-flex-column-',
			]
		);

		$element->update_control(
			'content_position',
			['prefix_class' => 'xp-column-items-',]
		);
	}

	protected function add_actions() {
		add_action( 'elementor/element/before_section_end', [ $this, 'register_controls' ], 10, 2 );
	}
}

new XP_Element_Column();
