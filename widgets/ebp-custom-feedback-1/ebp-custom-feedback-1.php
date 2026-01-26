<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Feedback_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_feedback_1';
    }

    public function get_title()
    {
        return __('EBP Custom Feedback', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-rating';
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
        return ['ebp-custom-feedback-1-style'];
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

        // Simple dropdown so non-devs can resize headings inside the rich text
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

        // Repeater control for feedback items
        $repeater = new \Elementor\Repeater();

        // Rich text content control for each item
        $repeater->add_control(
            'rich_text',
            [
                'label' => __('Rich Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter your content', 'ebp-custom-widgets'),
            ]
        );

        // Heading size control for each item
        $repeater->add_control(
            'item_heading_size',
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

        // Background color control for each item
        $repeater->add_control(
            'item_background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Font color control for each item
        $repeater->add_control(
            'item_font_color',
            [
                'label' => __('Font Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Heading color control for each item (also used for border)
        $repeater->add_control(
            'item_heading_color',
            [
                'label' => __('Heading Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'description' => __('Also applies to border color', 'ebp-custom-widgets'),
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} h1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} h2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} h3' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} h4' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ebp-custom-feedback-1__content__author' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ebp-custom-feedback-1__content__text' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Image control for each item
        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        // Image alt text for each item
        $repeater->add_control(
            'image_alt',
            [
                'label' => __('Image Alt Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        // Author rich text control for each item
        $repeater->add_control(
            'author_text',
            [
                'label' => __('Author', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter author information', 'ebp-custom-widgets'),
            ]
        );

        // Add the repeater to the widget
        $this->add_control(
            'feedback_items',
            [
                'label' => __('Feedback Items', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ rich_text }}}',
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

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get heading size (applies to all items)
        $heading_size = !empty($settings['heading_size']) ? $settings['heading_size'] : 'fs-32';

        // Get repeater items
        $feedback_items = !empty($settings['feedback_items']) ? $settings['feedback_items'] : [];

        ?>
<!-- Feedback  -->

<div class="ebp-custom-feedback-1">
    <?php if (!empty($feedback_items)): ?>
    <?php foreach ($feedback_items as $index => $item): ?>
    <?php
                    // Get item data
                    $rich_text = !empty($item['rich_text']) ? $item['rich_text'] : '';
                    // Get heading size for this item, fallback to global if not set
                    $item_heading_size = !empty($item['item_heading_size']) ? $item['item_heading_size'] : $heading_size;
                    // Unique repeater class so Elementor selectors can target this item
                    $item_unique_class = 'elementor-repeater-item-' . (isset($item['_id']) ? $item['_id'] : $index);
                    $image_url = !empty($item['image']['url']) ? $item['image']['url'] : '';
                    $image_alt = !empty($item['image_alt']) ? esc_attr($item['image_alt']) : '';
                    // Get author text for this item
                    $author_text = !empty($item['author_text']) ? $item['author_text'] : '';
                    ?>
    <div class="ebp-custom-feedback-1__content <?php echo esc_attr($item_unique_class); ?>">
        <div class="ebp-custom-feedback-1__content__padding">
            <div class="ebp-custom-feedback-1__content__border">
                <?php if (!empty($rich_text)): ?>
                <div class="ebp-custom-feedback-1__content__text <?php echo esc_attr($item_heading_size); ?>">

                    <?php echo wp_kses_post($rich_text); ?>

                    <?php if (!empty($author_text)): ?>
                    <div class="ebp-custom-feedback-1__content__author">
                        <?php echo wp_kses_post($author_text); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>


        <?php if (!empty($image_url)): ?>
        <div class="ebp-custom-feedback-1__content__image">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo $image_alt; ?>">
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
    }
}