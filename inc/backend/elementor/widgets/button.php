<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Widget Name: Button with Icon
 */
class Xhub_Button extends Widget_Base {

    public function get_name() {
        return 'ibutton';
    }

    public function get_title() {
        return __( 'XP Button', 'xhub' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return [ 'category_xhub' ];
    }

    public static function get_button_color() {
        return [
            'main'   => __( 'Main Color', 'xhub' ),
            'dark'   => __( 'Dark Color', 'xhub' ),
            'light'  => __( 'Light Color', 'xhub' ),
            'border' => __( 'Border Color', 'xhub' ),
        ];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'button_section',
            [
                'label' => __( 'Button', 'xhub' ),
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'xhub' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left', 'xhub' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'xhub' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'xhub' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'xhub' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default' => '',
            ]
        );

        $this->add_control(
            'btn_style',
            [
                'label' => __( 'Style Color', 'xhub' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'main',
                'options' => self::get_button_color(),
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __( 'Label', 'xhub' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Click here', 'xhub' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        // Icon Controls
        $this->add_control(
            'selected_icon',
            [
                'label' => __( 'Icon', 'xhub' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin' => 'inline',
                'label_block' => false,
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => __( 'Icon Position', 'xhub' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => __( 'Before', 'xhub' ),
                    'right' => __( 'After', 'xhub' ),
                ],
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_spacing',
            [
                'label' => __( 'Icon Spacing', 'xhub' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .xptf-btn .btn-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .xptf-btn .btn-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'xhub' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'xhub' ),
                'default' => [
                    'url' => '#',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'General', 'xhub' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'btn_padding',
            [
                'label' => 'Padding',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .xptf-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_radius',
            [
                'label' => __( 'Border Radius', 'xhub' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .xptf-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typography',
                'selector' => '{{WRAPPER}} .xptf-btn',
            ]
        );

        // Icon Style
        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'xhub' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .xptf-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .xptf-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );

        // Hover tabs
        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'xhub' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Text Color', 'xhub' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xptf-btn' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}} .xptf-btn svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_bg',
            [
                'label' => __( 'Background Color', 'xhub' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptf-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .xptf-btn',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'xhub' ),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __( 'Text Color', 'xhub' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptf-btn:hover, {{WRAPPER}} .xptf-btn:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .xptf-btn:hover svg, {{WRAPPER}} .xptf-btn:focus svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __( 'Background Color', 'xhub' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptf-btn:hover, {{WRAPPER}} .xptf-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_hover_color',
            [
                'label' => __( 'Border Color', 'xhub' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xptf-btn:hover, {{WRAPPER}} .xptf-btn:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'xhub' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_render_attribute( 'button', 'href', $settings['link']['url'] );

            if ( $settings['link']['is_external'] ) {
                $this->add_render_attribute( 'button', 'target', '_blank' );
            }

            if ( $settings['link']['nofollow'] ) {
                $this->add_render_attribute( 'button', 'rel', 'nofollow' );
            }
        }

        $this->add_render_attribute( 'button', 'class', 'xptf-btn' );
        $this->add_render_attribute( 'button', 'class', 'xptf-btn-' . $settings['btn_style'] );

        if ( $settings['hover_animation'] ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
        }

        ?>
        <div class="xp-button">
            <a <?php echo wp_kses_post($this->get_render_attribute_string( 'button' )); ?>>
                <?php if ( ! empty( $settings['selected_icon']['value'] ) && $settings['icon_position'] === 'left' ) : ?>
                    <span class="btn-icon-left">
                        <?php Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </span>
                <?php endif; ?>
                
                <span class="btn-text"><?php echo esc_html( $settings['text'] ); ?></span>
                
                <?php if ( ! empty( $settings['selected_icon']['value'] ) && $settings['icon_position'] === 'right' ) : ?>
                    <span class="btn-icon-right">
                        <?php Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Xhub_Button() );