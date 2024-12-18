<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Xhub_Dynamic_Title extends Widget_Base {

    public function get_name() {
        return 'xhub_dynamic_title';
    }

    public function get_title() {
        return __( 'Dynamic Title', 'xhub' );
    }

    public function get_icon() {
        return 'eicon-post-title';
    }

    public function get_categories() {
        return [ 'category_xhub' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Title', 'xhub' ),
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label' => __( 'HTML Tag', 'xhub' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'p' => 'p',
                    'span' => 'span',
                ],
                'default' => 'h1',
            ]
        );

        $this->add_control(
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .xhub-dynamic-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => __( 'Text Color', 'xhub' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xhub-dynamic-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __( 'Typography', 'xhub' ),
                'selector' => '{{WRAPPER}} .xhub-dynamic-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $tag = $settings['html_tag'];
        $title = get_the_title();
        
        echo "<{$tag} class='xhub-dynamic-title'>{$title}</{$tag}>";
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Xhub_Dynamic_Title() );
