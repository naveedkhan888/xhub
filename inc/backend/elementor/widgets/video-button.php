<?php
namespace Elementor; // Custom widgets must be defined in the Elementor namespace
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly (security measure)

/**
 * Widget Name: Video Button
 */
class Restobar_VideoPopup extends Widget_Base{

 	// The get_name() method is a simple one, you just need to return a widget name that will be used in the code.
	public function get_name() {
		return 'ivideopopup';
	}

	// The get_title() method, which again, is a very simple one, you need to return the widget title that will be displayed as the widget label.
	public function get_title() {
		return __( 'XP Video Button', 'restobar' );
	}

	// The get_icon() method, is an optional but recommended method, it lets you set the widget icon. you can use any of the eicon or font-awesome icons, simply return the class name as a string.
	public function get_icon() {
		return 'eicon-youtube';
	}

	// The get_categories method, lets you set the category of the widget, return the category name as a string.
	public function get_categories() {
		return [ 'category_restobar' ];
	}

	protected function register_controls() {

		//Content Service box
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Button', 'restobar' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'restobar' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start'    => [
						'title' => __( 'Left', 'restobar' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'restobar' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'restobar' ),
						'icon' => 'eicon-text-align-right',
					]
				],
				'selectors' => [
					'{{WRAPPER}} .xp-video-button' => 'justify-content: {{VALUE}};',
				],
				'default' => '',
			]
		);

		$this->add_control(
			'vlink',
			[
				'label' => __( 'Video Link', 'restobar' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'https://your-link.com', 'restobar' ),
			]
		);

		$this->add_control(
			'caption',
			[
				'label' => __( 'Caption', 'restobar' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'animate',
			[
				'label' => __( 'Animation', 'restobar' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'restobar' ),
				'label_off' => __( 'No', 'restobar' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		//Style
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Button', 'restobar' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		//Button
		$this->add_responsive_control(
			'btn_width',
			[
				'label' => __( 'Size', 'restobar' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn-play' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'btn_size',
			[
				'label' => __( 'Icon Size', 'restobar' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn-play i:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_icon_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'restobar' ),
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label' => __( 'Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .btn-play' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_border_color',
			[
				'label' => __( 'Border Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .btn-play' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .btn-play span' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_bg',
			[
				'label' => __( 'Background Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .btn-play' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_circle',
			[
				'label' => __( 'Animation Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .btn-play span' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'animate'  => 'yes'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'restobar' ),
			]
		);

		$this->add_control(
			'btn_hover_color',
			[
				'label' => __( 'Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .btn-play:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .btn-play:hover span' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn__hover_border_color',
			[
				'label' => __( 'Border Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .btn-play:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_hover_bg',
			[
				'label' => __( 'Background Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .btn-play:hover' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'btn_hover_circle',
			[
				'label' => __( 'Animation Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .btn-play:hover span' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'animate'  => 'yes'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();	

		$this->end_controls_section();

		$this->start_controls_section(
			'caption_section',
			[
				'label' => __( 'Caption', 'restobar' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption!'  => ''
				]
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label' => __( 'Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .xp-video-button > span' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .xp-video-button > span',
			]
		);
		$this->add_responsive_control(
			'caption_space',
			[
				'label' => __( 'Spacing', 'restobar' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .xp-video-button > span' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'button', 'class', 'btn-play' );

		?>
		
		<div class="xp-video-button flex-middle">
	        <a <?php echo wp_kses_post($this->get_render_attribute_string( 'button' )); ?> href="<?php echo esc_url( $settings['vlink'] ); ?>">
				<i class="xp-webicon-play"></i>
				<?php if( $settings['animate'] ) { echo '<span class="circle-1"></span>'; } ?>
	        </a>
	        <?php if( $settings['caption'] ) echo '<span class="font-second">' .$settings['caption']. '</span>'; ?>
	    </div>
	    
	    <?php
	}

}
// After the Restobar_VideoPopup class is defined, I must register the new widget class with Elementor:
Plugin::instance()->widgets_manager->register( new Restobar_VideoPopup() );