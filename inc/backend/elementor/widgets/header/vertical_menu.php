<?php

namespace Elementor; // Custom widgets must be defined in the Elementor namespace

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly (security measure)



/**

 * Widget Name: Vertical Services Menu

 */

class Restobar_Vertical_Menu extends Widget_Base{



 	public function get_name() {

		return 'vertical_services_menu';

	}



	public function get_title() {

		return __( 'XP Vertical Services Menu', 'restobar' );

	}



	public function get_icon() {

		return 'eicon-nav-menu';

	}



	public function get_categories() {

		return [ 'category_restobar_sidebar' ];

	}



	protected function register_controls() {

		// Content Section

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

				'label' => esc_html__( 'Select Services Menu', 'restobar' ),

				'type' => Controls_Manager::SELECT,

				'multiple' => false,

				'options' => $menus,

				'default' => array_keys( $menus )[0],

				'save_default' => true,

			]

		);



		$this->end_controls_section();



		// Style Section for Vertical Menu

		$this->start_controls_section(

			'style_vertical_menu_section',

			[

				'label' => __( 'Vertical Menu Style', 'restobar' ),

				'tab'   => Controls_Manager::TAB_STYLE,

			]

		);



		// Background Color for Vertical Menu

		$this->add_control(

			'vertical_menu_bg_color',

			[

				'label' => __( 'Background Color', 'restobar' ),

				'type' => Controls_Manager::COLOR,

				'selectors' => [

					'{{WRAPPER}} .vertical-services-menu' => 'background-color: {{VALUE}};',

				],

			]

		);



		// Text Color for Menu Items

		$this->add_control(

			'vertical_menu_text_color',

			[

				'label' => __( 'Text Color', 'restobar' ),

				'type' => Controls_Manager::COLOR,

				'selectors' => [

					'{{WRAPPER}} .vertical-services-menu li a' => 'color: {{VALUE}};',

				],

			]

		);



		// Hover Text Color

		$this->add_control(

			'vertical_menu_hover_color',

			[

				'label' => __( 'Hover Text Color', 'restobar' ),

				'type' => Controls_Manager::COLOR,

				'selectors' => [

					'{{WRAPPER}} .vertical-services-menu li a:hover' => 'color: {{VALUE}};',

				],

			]

		);



		// Active Menu Item Color

		$this->add_control(

			'vertical_active_menu_color',

			[

				'label' => __( 'Active Menu Item Color', 'restobar' ),

				'type' => Controls_Manager::COLOR,

				'selectors' => [

					'{{WRAPPER}} .vertical-services-menu li.current-menu-item > a' => 'color: {{VALUE}};',

				],

			]

		);



		// Typography

		$this->add_group_control(

			Group_Control_Typography::get_type(),

			[

				'name' => 'vertical_menu_typography',

				'selector' => '{{WRAPPER}} .vertical-services-menu li a',

			]

		);



		// Padding

		$this->add_responsive_control(

			'vertical_menu_item_padding',

			[

				'label' => __( 'Item Padding', 'restobar' ),

				'type' => Controls_Manager::DIMENSIONS,

				'size_units' => [ 'px', '%' ],

				'selectors' => [

					'{{WRAPPER}} .vertical-services-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

				],

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

		$active_mmenu = in_array('xp_mega-menu/xp_mega-menu.php', apply_filters('active_plugins', get_option('active_plugins')));

	?>

			<nav class="vertical-services-navigation">			

				<?php

					wp_nav_menu( array(

						'menu' 			 => $settings['nav_menu'],

						'menu_id'        => 'services-menu',

						'menu_class'     => 'vertical-services-menu',

						'container'      => 'ul',

						'theme_location' => '__no_such_location',

    					'fallback_cb'    => '__return_empty_string', 

    					'walker'         => $active_mmenu ? new \Xp_Mega_Menu_Walker() : '',

					) );

				?>

			</nav>

	    <?php

	}

}



// Register the new vertical menu widget with Elementor

Plugin::instance()->widgets_manager->register( new Restobar_Vertical_Menu() );