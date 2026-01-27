<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Text_Image_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_text_image_1';
    }

    public function get_title()
    {
        return __('EBP Custom Text Image 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-column';
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
        return ['ebp-custom-text-image-1-style'];
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

        // Toggle to hide image and add hide-image class to content
        $this->add_control(
            'hide_image',
            [
                'label' => __('Hide Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ebp-custom-widgets'),
                'label_off' => __('No', 'ebp-custom-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => __('Hide the image and add hide-image class to content', 'ebp-custom-widgets'),
            ]
        );

        // Image control - hidden when hide_image is enabled
        $this->add_control(
            'image',
            [
                'label' => __('Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'description' => __('Select or upload an image', 'ebp-custom-widgets'),
                'condition' => [
                    'hide_image!' => 'yes',
                ],
            ]
        );

        // Alt text control for accessibility - hidden when hide_image is enabled
        $this->add_control(
            'image_alt',
            [
                'label' => __('Image Alt Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Enter alt text for the image', 'ebp-custom-widgets'),
                'description' => __('Important for accessibility and SEO', 'ebp-custom-widgets'),
                'condition' => [
                    'hide_image!' => 'yes',
                ],
            ]
        );

        // Rich text editor for content
        $this->add_control(
            'rich_text',
            [
                'label' => __('Rich Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('Enter your content here', 'ebp-custom-widgets'),
                'placeholder' => __('Enter your content', 'ebp-custom-widgets'),
            ]
        );

        // Dropdown lets editors resize headings without editing HTML manually
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

        // Button text control
        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Enter button text', 'ebp-custom-widgets'),
            ]
        );

        // Button URL control
        $this->add_control(
            'button_url',
            [
                'label' => __('Button URL', 'ebp-custom-widgets'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'ebp-custom-widgets'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                ],
            ]
        );

        // Rich text editor for quote author
        $this->add_control(
            'quote_author',
            [
                'label' => __('Quote Author', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter quote author and role', 'ebp-custom-widgets'),
                'description' => __('Enter the quote author name and role', 'ebp-custom-widgets'),
            ]
        );

        // Reverse columns toggle
        $this->add_control(
            'reverse_columns',
            [
                'label' => __('Reverse Columns', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ebp-custom-widgets'),
                'label_off' => __('No', 'ebp-custom-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => __('Reverse the order of image and content columns', 'ebp-custom-widgets'),
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

        // Background color control for content div
        $this->add_control(
            'content_background_color',
            [
                'label' => __('Content Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-text-image-1__content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Font color control for content div
        $this->add_control(
            'content_font_color',
            [
                'label' => __('Content Font Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-text-image-1__content' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-text-image-1__content .btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .text-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Heading color control for heading, border, and button
        $this->add_control(
            'heading_color',
            [
                'label' => __('Heading Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .border' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .border .text-content h1, {{WRAPPER}} .border .text-content h2, {{WRAPPER}} .border .text-content h3, {{WRAPPER}} .border .text-content h4, {{WRAPPER}} .border .text-content h5, {{WRAPPER}} .border .text-content h6' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .border .btn' => 'color: {{VALUE}};',

                ],
            ]
        );

        // Toggle lets editors hide the decorative SVG if it is not needed
        $this->add_control(
            'hide_icon',
            [
                'label' => __('Hide Icon', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ebp-custom-widgets'),
                'label_off' => __('No', 'ebp-custom-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => __('Remove the SVG icon from the border block.', 'ebp-custom-widgets'),
            ]
        );

        // Icon color control for SVG path fill
        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .border svg path' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'hide_icon!' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get image settings
        $image_url = !empty($settings['image']['url']) ? $settings['image']['url'] : '';
        $image_alt = !empty($settings['image_alt']) ? esc_attr($settings['image_alt']) : '';

        // Get rich text content
        $rich_text = !empty($settings['rich_text']) ? $settings['rich_text'] : '';
        $heading_size = !empty($settings['heading_size']) ? $settings['heading_size'] : 'fs-32';

        // Get button settings
        $button_text = !empty($settings['button_text']) ? $settings['button_text'] : '';
        $button_url = !empty($settings['button_url']['url']) ? $settings['button_url']['url'] : '';
        $button_target = !empty($settings['button_url']['is_external']) ? 'target="_blank"' : '';
        $button_nofollow = !empty($settings['button_url']['nofollow']) ? 'rel="nofollow"' : '';

        // Get quote author content
        $quote_author = !empty($settings['quote_author']) ? $settings['quote_author'] : '';

        // Get reverse columns setting
        $reverse_columns = !empty($settings['reverse_columns']) && $settings['reverse_columns'] === 'yes';
        $wrapper_class = 'ebp-custom-text-image-1';
        if ($reverse_columns) {
            $wrapper_class .= ' reverse-columns';
        }

        // Get hide image setting and add class to content if enabled
        $hide_image = !empty($settings['hide_image']) && $settings['hide_image'] === 'yes';
        $content_class = 'ebp-custom-text-image-1__content';
        if ($hide_image) {
            $content_class .= ' hide-image';
        }

        // Decide if the decorative SVG icon should render
        $hide_icon = !empty($settings['hide_icon']) && $settings['hide_icon'] === 'yes';

        ?>
        <!-- Text Image 1 -->
        <div class="<?php echo esc_attr($wrapper_class); ?>">
            <?php if (!empty($image_url)): ?>
                <div class="ebp-custom-text-image-1__image">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo $image_alt; ?>">
                </div>
            <?php endif; ?>
            <div class="<?php echo esc_attr($content_class); ?>">
                <div class="banner-wrapper">
                    <div class="absolute-wrapper">
                        <div class="wrapper">
                            <div class="content">
                                <div class="border">
                                    <?php if (!empty($rich_text)): ?>
                                        <!-- Wrap the text so the heading size class can hook in -->
                                        <div class="text-content <?php echo esc_attr($heading_size); ?>">
                                            <?php echo wp_kses_post($rich_text); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($button_url) && !empty($button_text)): ?>
                                        <a href="<?php echo esc_url($button_url); ?>" class="btn" <?php echo $button_target; ?>
                                            <?php echo $button_nofollow; ?>>
                                            <?php echo esc_html($button_text); ?>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($quote_author)): ?>
                                        <div class="quote-author">
                                            <?php echo wp_kses_post($quote_author); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!$hide_icon): ?>
                                        <svg id="Layer_1" data-name="Layer 1" xmlns="www.w3.org/2000/svg" viewBox="0 0 36 36">
                                            <path id="Path_1319" data-name="Path 1319" d="M0,36l18-18,18,18V0H0v36Z"
                                                stroke-width="0" />
                                        </svg>
                                    <?php endif; ?>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}