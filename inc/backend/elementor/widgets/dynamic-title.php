<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Restobar_Dynamic_Title extends Widget_Base {

    public function get_name() {
        return 'restobar_dynamic_title';
    }

    public function get_title() {
        return __( 'Dynamic Title', 'restobar' );
    }

    public function get_icon() {
        return 'eicon-post-title';
    }

    public function get_categories() {
        return [ 'category_restobar' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Title', 'restobar' ),
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label' => __( 'HTML Tag', 'restobar' ),
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .restobar-dynamic-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => __( 'Text Color', 'restobar' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .restobar-dynamic-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __( 'Typography', 'restobar' ),
                'selector' => '{{WRAPPER}} .restobar-dynamic-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $tag = $settings['html_tag'];
        $title = get_the_title();
        
        echo "<{$tag} class='restobar-dynamic-title'>{$title}</{$tag}>";
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Restobar_Dynamic_Title() );
