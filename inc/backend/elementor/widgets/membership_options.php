<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit;

class Xhub_Membership_Options extends Widget_Base {

    public function get_name() {
        return 'membership-options';
    }

    public function get_title() {
        return __( 'Membership Options', 'xhub' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'category_xhub' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Membership Options', 'xhub' ),
            ]
        );

        $this->add_control(
            'membership_options',
            [
                'label' => __( 'Membership Options', 'xhub' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => __( 'Title', 'xhub' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Outlying Worker', 'xhub' ),
                    ],
                    [
                        'name' => 'description',
                        'label' => __( 'Description', 'xhub' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => '10 Days/Month Hot Desk Membership | Full access to our hot desking lounge | 10 access day passes per calendar month',
                    ],
                    [
                        'name' => 'price',
                        'label' => __( 'Price', 'xhub' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => '$149.99',
                    ],
                    [
                        'name' => 'period',
                        'label' => __( 'Billing Period', 'xhub' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Monthly',
                    ],
                ],
                'default' => [
                    [
                        'title' => __( 'Outlying Worker', 'xhub' ),
                        'description' => '10 Days/Month Hot Desk Membership | Full access to our hot desking lounge | 10 access day passes per calendar month',
                        'price' => '$149.99',
                        'period' => 'Monthly',
                    ],
                    [
                        'title' => __( 'Resident', 'xhub' ),
                        'description' => 'Unlimited Hot Desk Membership | Full access to our hot desking lounge | Unlimited uncapped access',
                        'price' => '$349.99',
                        'period' => 'Monthly',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Style', 'xhub' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => __( 'Alignment', 'xhub' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .xhub-membership' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => __( 'Box Background Color', 'xhub' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xhub-membership' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'xhub' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xhub-membership' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .xhub-membership',
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => __( 'Padding', 'xhub' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .xhub-membership' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => __( 'Margin', 'xhub' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .xhub-membership' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        ?>
        <div class="xhub-membership">
            <ul>
                <?php foreach ( $settings['membership_options'] as $option ) : ?>
                    <li>
                        <h3><?php echo esc_html( $option['title'] ); ?></h3>
                        <p><?php echo esc_html( $option['description'] ); ?></p>
                        <p class="xhub-membership-price"><?php echo esc_html( $option['price'] ); ?> / <?php echo esc_html( $option['period'] ); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Xhub_Membership_Options() );