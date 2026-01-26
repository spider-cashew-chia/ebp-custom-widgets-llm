<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Contact_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_contact_1';
    }

    public function get_title()
    {
        return __('EBP Custom Contact 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-mail';
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
        return ['ebp-custom-contact-1-style'];
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

        // Heading text control (now rich text so editors can use h2, h3, etc.)
        $this->add_control(
            'heading_text',
            [
                'label' => __('Heading', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter heading text', 'ebp-custom-widgets'),
            ]
        );

        // Heading size dropdown so editors can resize headings without code
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
                'description' => __('Controls the size of headings in the rich text above', 'ebp-custom-widgets'),
            ]
        );

        // Heading size dropdown for the ACF address content
        $this->add_control(
            'content_heading_size',
            [
                'label' => __('Address Content Heading Size', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'fs-48' => __('Large (48px)', 'ebp-custom-widgets'),
                    'fs-32' => __('Medium (32px)', 'ebp-custom-widgets'),
                    'fs-24' => __('Small (24px)', 'ebp-custom-widgets'),
                ],
                'default' => 'fs-32',
                'description' => __('Controls the size of headings in the ACF address content', 'ebp-custom-widgets'),
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

        // Background color control for .ebp-custom-contact-1
        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-contact-1' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Font color control for .ebp-custom-contact-1
        $this->add_control(
            'font_color',
            [
                'label' => __('Font Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-contact-1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get heading text (now rich text)
        $heading_text = !empty($settings['heading_text']) ? $settings['heading_text'] : '';
        $heading_size = !empty($settings['heading_size']) ? $settings['heading_size'] : 'fs-32';

        // Get content heading size for ACF address field
        $content_heading_size = !empty($settings['content_heading_size']) ? $settings['content_heading_size'] : 'fs-32';

        ?>
<!-- Contact  -->

<div class="ebp-custom-contact-1">
    <div class="wrapper padding-block-large">
        <div class="ebp-custom-contact-1__items grid equal-grid">
            <div class="ebp-custom-contact-1__item">
                <?php if (!empty($heading_text)): ?>
                <!-- Rich text heading with size class applied -->
                <div class="heading-content <?php echo esc_attr($heading_size); ?>">
                    <?php echo wp_kses_post($heading_text); ?>
                </div>
                <?php endif; ?>
                <?php echo do_shortcode('[contact-form-7 id="a1c7042" title="Contact form"]') ?>
            </div>
            <div class="ebp-custom-contact-1__item">
                <!-- ACF global options field for address with heading size class applied -->
                <div class="content-text <?php echo esc_attr($content_heading_size); ?>">
                    <?php the_field('address', 'option'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
}