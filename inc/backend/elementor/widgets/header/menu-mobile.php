<?php
namespace Elementor; // Custom widgets must be defined in the Elementor namespace
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly (security measure)

/**
 * Widget Name: Menu_Mobile
 */
class Restobar_Menu_Mobile extends Widget_Base{

 	// The get_name() method is a simple one, you just need to return a widget name that will be used in the code.
	public function get_name() {
		return 'imenu_mobile';
	}

	// The get_title() method, which again, is a very simple one, you need to return the widget title that will be displayed as the widget label.
	public function get_title() {
		return __( 'XP Menu Mobile', 'restobar' );
	}

	// The get_icon() method, is an optional but recommended method, it lets you set the widget icon. you can use any of the eicon or font-awesome icons, simply return the class name as a string.
	public function get_icon() {
		return 'eicon-select';
	}

	// The get_categories method, lets you set the category of the widget, return the category name as a string.
	public function get_categories() {
		return [ 'category_restobar_header' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Menu', 'restobar' ),
			]
		);

		$menus = $this->get_available_menus();
		$this->add_control(
			'nav_menu',
			[
				'label' => esc_html__( 'Select Menu', 'restobar' ),
				'type' => Controls_Manager::SELECT,
				'multiple' => false,
				'options' => $menus,
				'default' => array_keys( $menus ),
				'save_default' => true,

			]
		);

		$this->add_control(
			'pos_menu',
			[
				'label' => __( 'Position', 'restobar' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'on-right',
				'options' => [
					'on-left' 	=> __( 'On Left', 'restobar' ),
					'on-right'  => __( 'On Right', 'restobar' ),
				]
			]
		);

		$this->end_controls_section();
		
		/*** Style ***/
		$this->start_controls_section(
			'style_icon_section',
			[
				'label' => __( 'Icon', 'restobar' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mmenu-toggle button' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'restobar' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mmenu-toggle i:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_mmenu_section',
			[
				'label' => __( 'Menu', 'restobar' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'bg_mmenu',
			[
				'label' => __( 'Background', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mmenu-wrapper' => 'background: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'color_mmenu',
			[
				'label' => __( 'Text Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mmenu-wrapper .mobile_mainmenu li a, {{WRAPPER}} .mmenu-wrapper .mobile_mainmenu > li.menu-item-has-children .arrow i' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'bcolor_mmenu',
			[
				'label' => __( 'Border Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mmenu-wrapper .mobile_mainmenu li a' => 'border-color: {{VALUE}};',
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mmenu_typography',
				'selector' => '{{WRAPPER}} .mmenu-wrapper .mobile_mainmenu li a',
			]
		);
		$this->add_control(
			'color_back',
			[
				'label' => __( 'Back Button Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mmenu-wrapper .mmenu-close' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();
	}

	protected function get_available_menus(){

		$menus = wp_get_nav_menus();
		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
   }

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
			
	    	<div class="xptf-menu-mobile xptf-cta-header">
				<div id="mmenu-toggle" class="mmenu-toggle">
					<button><i class="xp-webicon-menu"></i></button>
				</div>
				<div class="site-overlay mmenu-overlay"></div>
				<div id="mmenu-wrapper" class="mmenu-wrapper <?php echo esc_attr( $settings['pos_menu'] ); ?>">
					<div class="mmenu-inner">
						<a class="mmenu-close" href="#"><i class="xp-webicon-arrowsoutline"></i></a>
						<div class="mobile-nav">
							<?php
								wp_nav_menu( array(
									'menu' 			 => $settings['nav_menu'],
									'theme_location' => 'primary',
									'menu_class'     => 'mobile_mainmenu none-style',
									'container'      => '',
								) );
							?>
						</div>   	
					</div>   	
				</div>
			</div>
	    <?php
	}

}
// After the Restobar_Menu_Mobile class is defined, I must register the new widget class with Elementor:
Plugin::instance()->widgets_manager->register( new Restobar_Menu_Mobile() );