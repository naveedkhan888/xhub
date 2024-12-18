<?php
namespace Elementor; // Custom widgets must be defined in the Elementor namespace
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly (security measure)

/**
 * Widget Name: Tab Titles
 */
class CreamPoint_Tab_Titles extends Widget_Base {

	// The get_name() method is a simple one, you just need to return a widget name that will be used in the code.
	public function get_name() {
		return 'itabtitle';
	}

	// The get_title() method, which again, is a very simple one, you need to return the widget title that will be displayed as the widget label.
	public function get_title() {
		return __( 'XP Tab Titles', 'restobar' );
	}

	// The get_icon() method, is an optional but recommended method, it lets you set the widget icon. you can use any of the eicon or font-awesome icons, simply return the class name as a string.
	public function get_icon() {
		return 'eicon-site-title';
	}

	// The get_categories method, lets you set the category of the widget, return the category name as a string.
	public function get_categories() {
		return [ 'category_restobar' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Titles', 'restobar' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'titles',
			[
				'label' => __( 'Title', 'restobar' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => 'Content Marketing',
			]
		);
		$repeater->add_control(
			'title_link',
			[
				'label' => __( 'Link to ID Content', 'restobar' ),
				'type' => Controls_Manager::TEXT,
				'default' => '#tab-1',
			]
		);

		// Add icon control to the repeater
		$repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'restobar' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
		    'title_boxes',
		    [
		        'label'       => '',
		        'type'        => Controls_Manager::REPEATER,
		        'show_label'  => false,
		        'fields'      => $repeater->get_controls(),
		        'title_field' => '{{{titles}}}',
		    ]
		);
		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'restobar' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start'  => [
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
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tab-titles' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Styling Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'restobar' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'title_space',
			[
				'label' => __( 'Spacing', 'restobar' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tab-titles .title-item' => 'margin: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .tab-titles' => 'margin: calc(-{{SIZE}}{{UNIT}}/2);',
				],
			]
		);

		$this->add_responsive_control(
			'padding_title',
			[
				'label' => __( 'Padding', 'restobar' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tab-titles a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'radius_title',
			[
				'label' => __( 'Border Radius', 'restobar' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tab-titles a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .title-item',
			]
		);

		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => __( 'Normal', 'restobar' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .title-item a' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'title_bg',
			[
				'label' => __( 'Background', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .title-item a' => 'background: {{VALUE}};',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => __( 'Active/Hover', 'restobar' ),
			]
		);

		$this->add_control(
			'title_active_color',
			[
				'label' => __( 'Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .title-item a:hover, {{WRAPPER}} .title-item a.tab-active' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'title_active_bg',
			[
				'label' => __( 'Background', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .title-item a:hover, {{WRAPPER}} .title-item a.tab-active' => 'background: {{VALUE}};',
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

		<div class="tab-titles">
			<?php foreach ( $settings['title_boxes'] as $box ) : ?>
			<div class="title-item font-second">
				<a href="<?php echo esc_url( $box['title_link'] ); ?>">
				    <?php if ( ! empty( $box['icon']['value'] ) ) : ?>
				        <span class="icon">
				            <?php Icons_Manager::render_icon( $box['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				        </span>
				    <?php endif; ?>
				    <?php echo esc_html( $box['titles'] ); ?>
				</a>
			</div>
			<?php endforeach; ?>
		</div>

	    <?php
	}

}
// After the Schedule class is defined, I must register the new widget class with Elementor:
Plugin::instance()->widgets_manager->register( new CreamPoint_Tab_Titles() );
