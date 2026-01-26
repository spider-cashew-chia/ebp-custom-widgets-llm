<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Accordion_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_accordion_1';
    }

    public function get_title()
    {
        return __('EBP Custom Accordion 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-accordion';
    }

    public function get_categories()
    {
        return ['ebp-custom-widgets'];
    }

    // Enqueue widget assets
    public function get_script_depends()
    {
        return ['ebp-custom-accordion-1-script'];
    }

    public function get_style_depends()
    {
        return ['ebp-custom-accordion-1-style'];
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

        // Rich text control for content above accordion
        $this->add_control(
            'intro_text',
            [
                'label' => __('Intro Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter intro text', 'ebp-custom-widgets'),
            ]
        );

        // Dropdown so editors can resize intro headings without HTML edits
        $this->add_control(
            'intro_heading_size',
            [
                'label' => __('Intro Heading Size', 'ebp-custom-widgets'),
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

        // Start of Accordion Items section
        $this->start_controls_section(
            'accordion_items_section',
            [
                'label' => __('Accordion Items', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Create repeater for accordion items
        $repeater = new \Elementor\Repeater();

        // Heading control for each accordion item
        $repeater->add_control(
            'item_heading',
            [
                'label' => __('Heading', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Accordion Heading', 'ebp-custom-widgets'),
                'placeholder' => __('Enter heading text', 'ebp-custom-widgets'),
            ]
        );

        // Rich text content for each accordion item
        $repeater->add_control(
            'item_content',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('Accordion content goes here', 'ebp-custom-widgets'),
                'placeholder' => __('Enter accordion content', 'ebp-custom-widgets'),
            ]
        );

        // Let each accordion panel pick its own heading size
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
            ]
        );

        // Add repeater to widget
        $this->add_control(
            'accordion_items',
            [
                'label' => __('Accordion Items', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_heading' => __('Accordion Heading', 'ebp-custom-widgets'),
                        'item_content' => __('Accordion content goes here', 'ebp-custom-widgets'),
                    ],
                ],
                'title_field' => '{{{ item_heading }}}',
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
                    '{{WRAPPER}} .ebp-custom-accordion-1' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .ebp-custom-accordion-1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-accordion-1 h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get accordion items from settings
        $accordion_items = !empty($settings['accordion_items']) ? $settings['accordion_items'] : [];
        $intro_heading_size = !empty($settings['intro_heading_size']) ? $settings['intro_heading_size'] : 'fs-32';

        ?>
<!-- Accordion  -->
<div class="ebp-custom-accordion-1 padding-block-large">
    <div class="wrapper">
        <?php if (!empty($settings['intro_text'])): ?>
        <!-- Rich text intro content -->
        <div class="ebp-custom-accordion-1__intro <?php echo esc_attr($intro_heading_size); ?>">
            <?php echo wp_kses_post($settings['intro_text']); ?>
        </div>
        <?php endif; ?>
        <div class="ebp-custom-accordion-1__items">
            <?php if (!empty($accordion_items)): ?>
            <?php foreach ($accordion_items as $index => $item): ?>
            <!-- Individual accordion item -->
            <!-- First item (index 0) is open by default -->
            <?php
                            // Get heading size for this item so we can apply it to both title and content
                            $item_heading_size = !empty($item['item_heading_size']) ? $item['item_heading_size'] : 'fs-32';
                            ?>
            <div class="ebp-custom-accordion-1__item <?php echo ($index === 0) ? 'is-open' : ''; ?>">
                <!-- Button that toggles the accordion open/closed -->
                <button class="ebp-custom-accordion-1__item-title <?php echo esc_attr($item_heading_size); ?>"
                    type="button" aria-expanded="<?php echo ($index === 0) ? 'true' : 'false'; ?>">
                    <?php if (!empty($item['item_heading'])): ?>
                    <h3><?php echo esc_html($item['item_heading']); ?></h3>
                    <?php endif; ?>
                </button>
                <!-- Content that shows/hides when accordion is toggled -->
                <div class="ebp-custom-accordion-1__item-content">
                    <?php if (!empty($item['item_content'])): ?>
                    <div class="accordion-item-text <?php echo esc_attr($item_heading_size); ?>">
                        <?php echo wp_kses_post($item['item_content']); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="ebp-custom-accordion-1__icon">^</div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php
    }
}