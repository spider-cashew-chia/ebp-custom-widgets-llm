<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Stats_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_stats_1';
    }

    public function get_title()
    {
        return __('EBP Custom Stats 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-counter-circle';
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
        return ['ebp-custom-stats-1-style'];
    }


    protected function register_controls()
    {
        // Start of Items section
        $this->start_controls_section(
            'items_section',
            [
                'label' => __('Stats Items', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Items repeater
        $repeater = new \Elementor\Repeater();

        // Icon/image control for each item
        $repeater->add_control(
            'item_icon',
            [
                'label' => __('Icon/Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        // Rich text content for each item
        $repeater->add_control(
            'item_text',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter item content', 'ebp-custom-widgets'),
            ]
        );

        // Let editors pick a heading size per stat without touching HTML
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
                'description' => __('Applies .fs-48/.fs-32/.fs-24 utility classes', 'ebp-custom-widgets'),
            ]
        );

        // Add repeater to widget
        $this->add_control(
            'stats_items',
            [
                'label' => __('Stats Items', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_icon' => ['url' => ''],
                        'item_text' => '',
                    ],
                ],
                'title_field' => 'Item',
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

        // Icon color control - targets SVG path inside .ebp-custom-stats-1__item__item
        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-stats-1__item__item path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-stats-1__item__item svg' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Text color control - targets .ebp-custom-stats-1__item__text
        $this->add_control(
            'text_color',
            [
                'label' => __('Text Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-stats-1__item__text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get stats items
        $stats_items = !empty($settings['stats_items']) ? $settings['stats_items'] : [];

        ?>
<!-- Stats  -->

<div class="ebp-custom-stats-1">
    <div class="wrapper margin-block">
        <div class="ebp-custom-stats-1__items grid equal-grid">
            <?php if (!empty($stats_items)): ?>
            <?php foreach ($stats_items as $item): ?>
            <div class="ebp-custom-stats-1__item">
                <?php if (!empty($item['item_icon']['url'])): ?>
                <!-- Icon/Image -->
                <div class="ebp-custom-stats-1__item__image">
                    <img src="<?php echo esc_url($item['item_icon']['url']); ?>"
                        alt="<?php echo esc_attr(!empty($item['item_icon']['alt']) ? $item['item_icon']['alt'] : ''); ?>">
                </div>
                <?php endif; ?>

                <?php if (!empty($item['item_text'])): ?>
                <!-- Rich text content -->
                <?php
                                        $item_heading_size = !empty($item['item_heading_size']) ? $item['item_heading_size'] : 'fs-32';
                                        ?>
                <div class="ebp-custom-stats-1__item__text <?php echo esc_attr($item_heading_size); ?>">
                    <?php echo wp_kses_post($item['item_text']); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
    }
}