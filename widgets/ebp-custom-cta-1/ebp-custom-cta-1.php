<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_CTA_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_cta_1';
    }

    public function get_title()
    {
        return __('EBP Custom CTA 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-button';
    }

    public function get_categories()
    {
        return ['ebp-custom-widgets'];
    }

    // Enqueue widget assets
    public function get_script_depends()
    {
        return ['jquery'];
    }

    public function get_style_depends()
    {
        return ['ebp-custom-cta-1-style'];
    }


    protected function register_controls()
    {
        // Start of Content section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Rich text control for CTA content
        $this->add_control(
            'rich_text',
            [
                'label' => __('Rich Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter your CTA content', 'ebp-custom-widgets'),
            ]
        );

        // Dropdown so editors can resize headings without HTML edits
        $this->add_control(
            'heading_size',
            [
                'label' => __('Heading Size', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'fs-48' => __('Large (48px)', 'ebp-custom-widgets'),
                    'fs-32' => __('Medium (32px)', 'ebp-custom-widgets'),
                    'fs-24' => __('Small (24px)', 'ebp-custom-widgets'),
                ],
                'default' => 'fs-32',
                'description' => __('Maps to the .fs-48/.fs-32/.fs-24 utility classes', 'ebp-custom-widgets'),
            ]
        );

        // Border top toggle
        $this->add_control(
            'show_border_top',
            [
                'label' => __('Show Top Border', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ebp-custom-widgets'),
                'label_off' => __('No', 'ebp-custom-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => __('Add a top border to the content section', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();

        // Start of Style section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Background color control
        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-cta-1 .ebp-custom-cta-1__content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Font color control
        $this->add_control(
            'font_color',
            [
                'label' => __('Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-cta-1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-cta-1 h1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-cta-1 h2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-cta-1 h3' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-cta-1 h4' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get rich text content
        $rich_text = !empty($settings['rich_text']) ? $settings['rich_text'] : '';

        // Get heading size, default to fs-32 if not set
        $heading_size = !empty($settings['heading_size']) ? $settings['heading_size'] : 'fs-32';

        // Get border top setting and build content class
        $show_border_top = !empty($settings['show_border_top']) && $settings['show_border_top'] === 'yes';
        $content_class = ' padding-block-large';
        if ($show_border_top) {
            $content_class .= ' border-top';
        }

        ?>
<!-- CTA  -->

<div class="ebp-custom-cta-1 ">
    <div class="wrapper">
        <div class="<?php echo esc_attr($content_class); ?>">
            <div class="ebp-custom-cta-1__content">
                <div class="ebp-custom-cta-1__content__text <?php echo esc_attr($heading_size); ?>">
                    <?php if (!empty($rich_text)): ?>
                    <?php echo wp_kses_post($rich_text); ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

</div>
<?php
    }
}