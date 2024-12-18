<?php 
namespace Elementor; // Custom widgets must be defined in the Elementor namespace
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly (security measure)

/**
 * Widget Name: Team 1
 */
class Restobar_Team extends Widget_Base{

 	// The get_name() method is a simple one, you just need to return a widget name that will be used in the code.
	public function get_name() {
		return 'imember';
	}

	// The get_title() method, which again, is a very simple one, you need to return the widget title that will be displayed as the widget label.
	public function get_title() {
		return __( 'XP Team 1', 'restobar' );
	}

	// The get_icon() method, is an optional but recommended method, it lets you set the widget icon. you can use any of the eicon or font-awesome icons, simply return the class name as a string.
	public function get_icon() {
		return 'eicon-person';
	}

	// The get_categories method, lets you set the category of the widget, return the category name as a string.
	public function get_categories() {
		return [ 'category_restobar' ];
	}

	protected function register_controls() {

		/**TAB_CONTENT**/
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Member Team', 'restobar' ),
			]
		);

		$this->add_control(
	       'member_image',
	        [
	            'label' => esc_html__( 'Photo', 'restobar' ),
	            'type'  => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
		    ]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'member_image_size',
				'exclude' => ['1536x1536', '2048x2048'],
				'include' => [],
				'default' => 'full',
			]
		);

	    $this->add_control(
		    'member_name',
	      	[
	          	'label' => esc_html__( 'Name', 'restobar' ),
	          	'type'  => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Peter Perish', 'restobar' ),
	    	]
	    );

	    $this->add_control(
		    'member_extra',
	      	[
	          	'label' => esc_html__( 'Extra/Job', 'restobar' ),
	          	'type'  => Controls_Manager::TEXTAREA,
	          	'default' => esc_html__( 'co-founder of company', 'restobar' ),
	    	]
	    );

		$repeater = new Repeater();
		$repeater->add_control(
	      	'title',
		    [
		        'label'   => esc_html__( 'Name', 'restobar' ),
		        'type'    => Controls_Manager::TEXT,
		        'default' => esc_html__( 'Social', 'restobar' ),
		    ]
	    );

        $repeater->add_control(
            'social_icon',
            [
                'label' => esc_html__( 'Icon', 'restobar' ),
                'type'  => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fab fa-twitter',
					'library' => 'fa-brand',
				],
            ]
        );

        $repeater->add_control(
            'social_link',
            [
                'label' => esc_html__( 'Link', 'restobar' ),
                'type'  => Controls_Manager::URL,
                'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://', 'restobar' ),
				'default' => [
					'url' => 'https://', 
				],
            ]
        );

		$this->add_control(
		    'social_share',
		    [
		        'label'       => esc_html__( 'Socials', 'restobar' ),
		        'type'        => Controls_Manager::REPEATER,
		        'show_label'  => true,
		        'default'     => [
		            [
		             	'title'       => esc_html__( 'Twitter', 'restobar' ),
		                'social_link' => esc_html__( 'https://www.twitter.com/', 'restobar' ),
		                'social_icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brand',
						],
		 
		            ],
		            [
		             	'title'       => esc_html__( 'Facebook', 'restobar' ),
		                'social_link' => esc_html__( 'https://www.facebook.com/', 'restobar' ),
		                'social_icon' => [
							'value' => 'fab fa-facebook-f',
							'library' => 'fa-brand',
						],
		 
		            ],
		            [
		             	'title'       => esc_html__( 'Pinterest', 'restobar' ),
		                'social_link' => esc_html__( 'https://www.pinterest.com/', 'restobar' ),
		                'social_icon' => [
							'value' => 'fab fa-pinterest-p',
							'library' => 'fa-brand',
						],

		            ]
		        ],
		        'fields'      => $repeater->get_controls(),
		        'title_field' => '{{{title}}}',
		    ]
		);
		$this->add_control(
			'link',
			[
				'label' => __( 'Link To Details', 'restobar' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://', 'restobar' ),
			]
		);

		$this->end_controls_section();

		/**TAB_STYLE**/
		$this->start_controls_section(
			'content_style',
			[
				'label' => esc_html__( 'General', 'restobar' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'restobar' ),
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
					]
				],
				'selectors' => [
					'{{WRAPPER}} .xp-team' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'padding_box',
			[
				'label' => __( 'Padding Box', 'restobar' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .team-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'radius_box',
			[
				'label' => __( 'Border Radius', 'restobar' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .xp-team' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_box_style' );
		$this->start_controls_tab(
			'tab_bg_normal',
			[
				'label' => __( 'Normal', 'restobar' ),
			]
		);
		$this->add_control(
			'bg_box',
			[
				'label' => __( 'Background Box', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .team-info' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_box_shadow',
				'selector' => '{{WRAPPER}} .xp-team',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_bg_hover',
			[
				'label' => __( 'Hover', 'restobar' ),
			]
		);
		$this->add_control(
			'bg_hover_box',
			[
				'label' => __( 'Background Box', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .xp-team:hover .team-info' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'hover_box_shadow',
				'selector' => '{{WRAPPER}} .xp-team:hover',
			]
		);
		$this->add_control(
			'box_animation',
			[
				'label' => __( 'Hover Animation', 'restobar' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);
		$this->add_control(
			'bg_hover_title_color',
			[
				'label' => __( 'Title Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .xp-team:hover h6, {{WRAPPER}} .xp-team:hover h6 a' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'bg_hover_des_color',
			[
				'label' => __( 'Extra/Job Color', 'restobar' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .xp-team:hover .team-info span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'info_style',
			[
				'label' => esc_html__( 'Info Box', 'restobar' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		/* title */
		$this->add_control(
			'heading_title',
			[
				'label' => __( 'Title', 'restobar' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'title_space',
			[
				'label' => esc_html__( 'Spacing', 'restobar' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .xp-team h6' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'restobar' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .xp-team h6, {{WRAPPER}} .xp-team h6 a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_hcolor',
			[
				'label'     => esc_html__( 'Color Hover', 'restobar' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .xp-team h6 a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'link[url]!'  => ''
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'restobar' ),
				'selector' => '{{WRAPPER}} .xp-team h6',
			]
		);

		/* extra */
		$this->add_control(
			'heading_job',
			[
				'label' => __( 'Extra/Job', 'restobar' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'job_color',
			[
				'label'     => esc_html__( 'Color', 'restobar' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .team-info span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
				[
					'name'     => 'job_typography',
					'label'    => esc_html__( 'Typography', 'restobar' ),
					'selector' => '{{WRAPPER}} .team-info span',
				]
		);

		$this->end_controls_section();

		/* socials */
		$this->start_controls_section(
			'icon_style',
			[
				'label' => esc_html__( 'Socials', 'restobar' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'plus_color',
			[
				'label'     => esc_html__( 'Plus Color', 'restobar' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .team-social > span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'plus_bg',
			[
				'label'     => esc_html__( 'Plus Background', 'restobar' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .team-social > span' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_social',
			[
				'label' => __( 'Socials', 'restobar' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'icon_social_space',
			[
				'label' => esc_html__( 'Spacing', 'restobar' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .team-social a' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'radius_socials',
			[
				'label' => __( 'Border Radius', 'restobar' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .team-social a, {{WRAPPER}} .team-social span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_social_color',
			[
				'label'     => esc_html__( 'Color', 'restobar' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .team-social a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_social_bg',
			[
				'label'     => esc_html__( 'Background', 'restobar' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .team-social a' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_hover_color',
			[
				'label'     => esc_html__( 'Color Hover', 'restobar' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .team-social a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'social_hover_bg',
			[
				'label'     => esc_html__( 'Background Hover', 'restobar' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .team-social a:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$photo = Group_Control_Image_Size::get_attachment_image_html( $settings, 'member_image_size', 'member_image' );
		$tname = $settings['member_name'];

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'm_link', 'href', $settings['link']['url'] );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'm_link', 'target', '_blank' );
			}

			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'm_link', 'rel', 'nofollow' );
			}
			$photo = '<a ' .$this->get_render_attribute_string( 'm_link' ). '>' .$photo. '</a>';
			$tname = '<a ' .$this->get_render_attribute_string( 'm_link' ). '>' .$tname. '</a>';
		}

		$this->add_render_attribute( 'team-box', 'class', 'xp-team team-1' );
		if ( $settings['box_animation'] ) {
			$this->add_render_attribute( 'team-box', 'class', 'elementor-animation-' . $settings['box_animation'] );
		}

		?>

		<div <?php echo wp_kses_post($this->get_render_attribute_string( 'team-box' )); ?>>
			<div class="team-thumb">
				<?php if ( ! empty( $settings['member_image']['url'] ) ) { echo wp_kses_post( $photo ); } ?>
				<?php if ( ! empty( $settings['social_share'] ) ) : ?>
				<div class="team-social">
					<?php foreach ( $settings['social_share'] as $key => $social ) : ?>
						<?php if ( ! empty( $social['social_link'] ) ) : ?>
							<a <?php if($social['social_link']['is_external'])
							{ echo 'target="_blank"'; }else{ echo 'rel="nofollow"';}?> 
									href="<?php echo esc_url( $social['social_link']['url'] ); ?>" class="<?php echo esc_attr( strtolower( $social['title'] ) ); ?>" style="transition-delay: <?php echo esc_attr( $key * 50 ) . 'ms'; ?>"
									<?php Icons_Manager::render_icon( $social['social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
					<span class="xp-webicon-signs"></span>
				</div>
				<?php endif; ?>
			</div>
			<div class="team-info">
				<?php if ( $settings['member_name'] ) { echo '<h6 class="tname">' .$tname. '</h6>'; } ?>
				<?php if ( $settings['member_extra'] ) { echo '<span>' .$settings['member_extra']. '</span>'; } ?>
			</div>
		</div>
	        
	    <?php
	}

}
// After the Restobar_Team class is defined, I must register the new widget class with Elementor:
Plugin::instance()->widgets_manager->register( new Restobar_Team() );