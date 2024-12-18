<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit;

class Restobar_Membership_Options extends Widget_Base {

    public function get_name() {
        return 'membership-options';
    }

    public function get_title() {
        return __( 'Membership Options', 'restobar' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'category_restobar' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Membership Options', 'restobar' ),
            ]
        );

        $this->add_control(
            'membership_options',
            [
                'label' => __( 'Membership Options', 'restobar' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => __( 'Title', 'restobar' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Outlying Worker', 'restobar' ),
                    ],
                    [
                        'name' => 'description',
                        'label' => __( 'Description', 'restobar' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => '10 Days/Month Hot Desk Membership | Full access to our hot desking lounge | 10 access day passes per calendar month',
                    ],
                    [
                        'name' => 'price',
                        'label' => __( 'Price', 'restobar' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => '$149.99',
                    ],
                    [
                        'name' => 'period',
                        'label' => __( 'Billing Period', 'restobar' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Monthly',
                    ],
                ],
                'default' => [
                    [
                        'title' => __( 'Outlying Worker', 'restobar' ),
                        'description' => '10 Days/Month Hot Desk Membership | Full access to our hot desking lounge | 10 access day passes per calendar month',
                        'price' => '$149.99',
                        'period' => 'Monthly',
                    ],
                    [
                        'title' => __( 'Resident', 'restobar' ),
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
                'label' => __( 'Style', 'restobar' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => __( 'Alignment', 'restobar' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
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
                    '{{WRAPPER}} .restobar-membership' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => __( 'Box Background Color', 'restobar' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .restobar-membership' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'restobar' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .restobar-membership' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .restobar-membership',
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => __( 'Padding', 'restobar' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .restobar-membership' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => __( 'Margin', 'restobar' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .restobar-membership' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        ?>
        <div class="restobar-membership">
            <ul>
                <?php foreach ( $settings['membership_options'] as $option ) : ?>
                    <li>
                        <h3><?php echo esc_html( $option['title'] ); ?></h3>
                        <p><?php echo esc_html( $option['description'] ); ?></p>
                        <p class="restobar-membership-price"><?php echo esc_html( $option['price'] ); ?> / <?php echo esc_html( $option['period'] ); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Restobar_Membership_Options() );