<?php
namespace Elementor; // Custom widgets must be defined in the Elementor namespace
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly (security measure)

/**
 * Widget Name: Projects Carousel
 */
class Restobar_Portfolio_Slider extends Widget_Base{

 	// The get_name() method is a simple one, you just need to return a widget name that will be used in the code.
	public function get_name() {
		return 'ipcarousel';
	}

	// The get_title() method, which again, is a very simple one, you need to return the widget title that will be displayed as the widget label.
	public function get_title() {
		return __( 'XP Portfolio Carousel', 'restobar' );
	}

	// The get_icon() method, is an optional but recommended method, it lets you set the widget icon. you can use any of the eicon or font-awesome icons, simply return the class name as a string.
	public function get_icon() {
		return 'eicon-slider-push';
	}

	// The get_categories method, lets you set the category of the widget, return the category name as a string.
	public function get_categories() {
		return [ 'category_restobar' ];
	}

	protected function register_controls() {

		//Content
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Projects', 'restobar' ),
			]
		);
		$this->add_control(
			'project_cat',
			[
				'label' => __( 'Select Categories', 'restobar' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->select_param_cate_project(),
				'multiple' => true,
				'label_block' => true,
				'placeholder' => __( 'All Categories', 'restobar' ),
			]
		);
		$this->add_control(
			'project_num',
			[
				'label' => __( 'Show Number Projects', 'restobar' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '5',
			]
		);	
		$this->add_control(
			'heading_slider',
			[
				'label' => __( 'Slider', 'restobar' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$slides_show = range( 1, 6 );
		$slides_show = array_combine( $slides_show, $slides_show );

		$this->add_responsive_control(
			'tshow',
			[
				'label' => __( 'Slides to Show', 'restobar' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Default', 'restobar' ),
				] + $slides_show,
				'default' => ''
			]
		);
		$this->add_control(
			'center_mode',
			[
				'label' => __( 'Center Mode', 'restobar' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true' => __( 'Yes', 'restobar' ),
					'false' => __( 'No', 'restobar' ),
				]
			]
		);
		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'restobar' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true' => __( 'Yes', 'restobar' ),
					'false' => __( 'No', 'restobar' ),
				]
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'restobar' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true' => __( 'Yes', 'restobar' ),
					'false' => __( 'No', 'restobar' ),
				]
			]
		);
		$this->add_control(
			'timeout',
			[
				'label' => __( 'Autoplay Timeout', 'restobar' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1000,
						'max'  => 20000,
						'step' => 1000,
					],
				],
				'default' => [
					'size' => 7000,
				],
				'condition' => [
					'autoplay' => 'true',
				]
			]
		);
		$this->add_control(
			'arrows',
			[
				'label' => __( 'Arrows', 'restobar' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'true'   => __( 'Yes', 'restobar' ),
					'false'  => __( 'No', 'restobar' ),
				],
			]
		);
		$this->add_control(
			'dots',
			[
				'label' => __( 'Dots', 'restobar' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true'   => __( 'Yes', 'restobar' ),
					'false'  => __( 'No', 'restobar' ),
				],
			]
		);
		$this->add_responsive_control(
			'w_gaps',
			[
				'label' => __( 'Gap Width', 'restobar' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'overlay_style_section',
			[
				'label' => __( 'Project Items', 'restobar' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'heading_general',
			[
				'label' => __( 'General', 'restobar' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'overlay_align',
			[
				'label' => __( 'Alignment Info', 'restobar' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'restobar' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'restobar' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'restobar' ),
						'icon' => 'eicon-text-align-right',
					],
				],				
				'selectors' => [
					'{{WRAPPER}} .projects-box .portfolio-info .portfolio-info-inner' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'info_padding',
			[
				'label' => 'Padding Info',
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'radius_thumb',
			[
				'label' => __( 'Border Radius Image', 'restobar' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .projects-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'scale_thumb',
			[
				'label' => __( 'Animation Image Hover', 'restobar' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'restobar' ),
				'label_off' => __( 'No', 'restobar' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		/* title */
		$this->add_control(
			'heading_title',
			[
				'label' => __( 'Title', 'restobar' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => __( 'Spacing', 'restobar' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .projects-box .portfolio-info h5' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .projects-box .portfolio-info h5 a' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'title_hcolor',
			[
				'label' => __( 'Hover Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .projects-box .portfolio-info h5 a:hover' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .projects-box .portfolio-info h5 a',
			]
		);

		/* category */
		$this->add_control(
			'heading_overlay',
			[
				'label' => __( 'Category', 'restobar' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'show_cat',
			[
				'label' => __( 'Show Category', 'restobar' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'restobar' ),
				'label_off' => __( 'Hide', 'restobar' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'cat_color',
			[
				'label' => __( 'Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .projects-box .portfolio-info .portfolio-cates a' => 'color: {{VALUE}}; background-image: linear-gradient(0deg, {{VALUE}}, {{VALUE}});',
					'{{WRAPPER}} .projects-box .portfolio-info .portfolio-cates'   => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_cat' => 'yes',
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cat_typography',
				'selector' => '{{WRAPPER}} .projects-box .portfolio-info .portfolio-cates a, {{WRAPPER}} .projects-box .portfolio-info .portfolio-cates span',
				'condition' => [
					'show_cat' => 'yes',
				]
			]
		);
		$this->end_controls_section();	

		// Dots.
		$this->start_controls_section(
			'navigation_section',
			[
				'label' => __( 'Dots', 'restobar' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'dots' => 'true',
				],
			]
		);

		$this->add_responsive_control(
			'dots_spacing',
			[
				'label' => __( 'Spacing', 'restobar' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .owl-dots' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
            'dots_bgcolor',
            [
                'label' => __( 'Color', 'restobar' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .owl-dots button.owl-dot span' => 'background: {{VALUE}};',
				],
            ]
        );

        $this->add_control(
            'dots_active_bgcolor',
            [
                'label' => __( 'Color Active', 'restobar' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .owl-dots button.owl-dot.active span' => 'background: {{VALUE}};',
				],
            ]
        );

        $this->end_controls_section();

        // Arrow.
		$this->start_controls_section(
			'style_nav',
			[
				'label' => __( 'Arrows', 'restobar' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'arrows' => 'true',
				],
			]
		);
		$this->add_control(
			'arrow_color',
			[
				'label' => __( 'Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .owl-nav button' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'arrow_hcolor',
			[
				'label' => __( 'Color Hover', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .owl-nav button:hover' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'arrow_bg_color',
			[
				'label' => __( 'Background', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .owl-nav button' => 'background: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'arrow_bg_hcolor',
			[
				'label' => __( 'Background Hover', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .owl-nav button:hover' => 'background: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'radius_arrow',
			[
				'label' => __( 'Border Radius', 'restobar' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .owl-nav button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$shows  = !empty( $settings['tshow'] ) ? $settings['tshow'] : 3;
		$tshows = !empty( $settings['tshow_tablet'] ) ? $settings['tshow_tablet'] : $shows;
		$mshows = !empty( $settings['tshow_mobile'] ) ? $settings['tshow_mobile'] : $tshows;
		$gaps   = isset( $settings['w_gaps']['size'] ) && is_numeric( $settings['w_gaps']['size'] ) ? $settings['w_gaps']['size'] : 30;
		$tgaps  = isset( $settings['w_gaps_tablet']['size'] ) && is_numeric( $settings['w_gaps_tablet']['size'] ) ? $settings['w_gaps_tablet']['size'] : $gaps;
		$mgaps  = isset( $settings['w_gaps_mobile']['size'] ) && is_numeric( $settings['w_gaps_mobile']['size'] ) ? $settings['w_gaps_mobile']['size'] : $tgaps;

		?>
		<div class="project-slider <?php if ( $settings['scale_thumb'] ) echo esc_attr( ' img-scale' ); if ( !$settings['show_cat'] ) echo esc_attr( ' no-cat' ); ?>" data-loop="<?php echo esc_attr( $settings['loop'] ); ?>" 
data-auto="<?php echo esc_attr( $settings['autoplay'] ); ?>" 
data-time="<?php echo esc_attr( $settings['timeout']['size'] ); ?>" 
data-center="<?php echo esc_attr( $settings['center_mode'] ); ?>" 
data-arrows="<?php echo esc_attr( $settings['arrows'] ); ?>" 
data-dots="<?php echo esc_attr( $settings['dots'] ); ?>" 
data-show="<?php echo esc_attr( $shows ); ?>" 
data-tshow="<?php echo esc_attr( $tshows ); ?>" 
data-mshow="<?php echo esc_attr( $mshows ); ?>" 
data-gaps="<?php echo esc_attr( $gaps ); ?>" 
data-tgaps="<?php echo esc_attr( $tgaps ); ?>" 
data-mgaps="<?php echo esc_attr( $mgaps ); ?>">
			<div class="owl-carousel owl-theme">
				<?php 
					if( $settings['project_cat'] ){
		                $args = array(	                    
		                    'post_type' => 'xp_portfolio',
		                    'post_status' => 'publish',
		                    'posts_per_page' => $settings['project_num'],
		                    'tax_query' => array(
		                        array(
		                            'taxonomy' => 'portfolio_cat',
		                            'field' => 'slug',
		                            'terms' => $settings['project_cat'],
		                        ),
		                    ),              
		                );
		            }else{
		                $args = array(
		                    'post_type' => 'xp_portfolio',
		                    'post_status' => 'publish',
		                    'posts_per_page' => $settings['project_num'],
		                );
		            }			
					$wp_query = new \WP_Query($args);					
					while ($wp_query -> have_posts()) : $wp_query -> the_post(); 

					get_template_part( 'template-parts/content', 'project-carousel' );

					endwhile; wp_reset_postdata(); 
				?>
			</div>
	    </div>
	    <?php
	}

	public function get_keywords() {
		return [ 'slider', 'carousel', 'project' ];
	}

	protected function select_param_cate_project() {
	  	$category = get_terms( 'portfolio_cat' );
	  	$cat = array();
	  	foreach( $category as $item ) {
	     	if( $item ) {
	        	$cat[$item->slug] = $item->name;
	     	}
	  	}
	  	return $cat;
	}
}
// After the Restobar_Portfolio_Slider class is defined, I must register the new widget class with Elementor:
Plugin::instance()->widgets_manager->register( new Restobar_Portfolio_Slider() );