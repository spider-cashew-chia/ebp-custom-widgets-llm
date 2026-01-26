<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Guides_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_guides_1';
    }

    public function get_title()
    {
        return __('EBP Custom Guides 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-library-download';
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
        return ['ebp-custom-guides-1-style'];
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

        // Image control for icon
        $this->add_control(
            'icon_image',
            [
                'label' => __('Icon Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        // Alt text for icon image
        $this->add_control(
            'icon_image_alt',
            [
                'label' => __('Icon Image Alt Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        // Rich text control for title & download content
        $this->add_control(
            'title_download_content',
            [
                'label' => __('Title & Download Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter title and download content', 'ebp-custom-widgets'),
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
                'description' => __('Matches the .fs-48/.fs-32/.fs-24 utility classes', 'ebp-custom-widgets'),
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
                    '{{WRAPPER}} .ebp-custom-guides-1' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Font color control
        $this->add_control(
            'font_color',
            [
                'label' => __('Font Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-guides-1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-guides-1 h1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-guides-1 h2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-guides-1 h3' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-guides-1 p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get icon image data
        $icon_image_url = !empty($settings['icon_image']['url']) ? $settings['icon_image']['url'] : '';
        $icon_image_alt = !empty($settings['icon_image_alt']) ? esc_attr($settings['icon_image_alt']) : '';

        // Get title & download content
        $title_download_content = !empty($settings['title_download_content']) ? $settings['title_download_content'] : '';

        // Get heading size, default to fs-32 if not set
        $heading_size = !empty($settings['heading_size']) ? $settings['heading_size'] : 'fs-32';

        ?>
<!-- Guides  -->

<div class="ebp-custom-guides-1 padding-block-medium">
    <div class="ebp-custom-guides-1__content">
        <div class="wrapper">
            <div class="grid grid-24">
                <!-- icon -->
                <?php if (!empty($icon_image_url)): ?>
                <div class="icon">
                    <!-- image -->
                    <img src="<?php echo esc_url($icon_image_url); ?>" alt="<?php echo $icon_image_alt; ?>">
                </div>
                <?php endif; ?>

                <!-- title & download -->
                <?php if (!empty($title_download_content)): ?>
                <div class="title-download <?php echo esc_attr($heading_size); ?>">
                    <!-- rich text -->
                    <?php echo wp_kses_post($title_download_content); ?>
                </div>
                <?php endif; ?>
            </div>


        </div>
    </div>
</div>

<?php
    }
}