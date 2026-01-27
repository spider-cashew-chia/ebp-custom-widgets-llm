<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Text_Columns_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_text_columns_1';
    }

    public function get_title()
    {
        return __('EBP Custom Text Columns 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-columns';
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
        return ['ebp-custom-text-columns-1-style'];
    }


    protected function register_controls()
    {
        // Start of Icon section
        $this->start_controls_section(
            'icon_section',
            [
                'label' => __('Icon', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Icon visibility toggle
        $this->add_control(
            'show_icon',
            [
                'label' => __('Show Icon', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'ebp-custom-widgets'),
                'label_off' => __('Hide', 'ebp-custom-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Icon image control
        $this->add_control(
            'icon_image',
            [
                'label' => __('Icon Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '/wp-content/uploads/2025/11/llm-icon.svg',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        // Icon alt text
        $this->add_control(
            'icon_alt',
            [
                'label' => __('Icon Alt Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Start of Main Content section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Main Content', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Main content (rich text - can include headings and paragraphs)
        $this->add_control(
            'main_content',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('<h2>Welcome to LLM - Criminal Defence Solicitors</h2><p>LLM Solicitors is a specialised criminal defence firm that provides expert legal representation with calmness and compassion. We assist clients with care, diligence, and integrity at every stage of the criminal justice process, from initial arrest to resolution. Values, not volume, guide our work.</p><p>From trusted advice at the police station to vigorous advocacy in the Crown Court, we stand beside you at every stage. Many of our clients come through word of mouth, having experienced or witnessed our professionalism firsthand. We are here when it matters most, offering clear guidance, sound strategy, and sincere support in times of difficulty.</p>', 'ebp-custom-widgets'),
                'placeholder' => __('Enter your content', 'ebp-custom-widgets'),
            ]
        );

        // Heading size dropdown so editors can resize their headings without code
        $this->add_control(
            'main_heading_size',
            [
                'label' => __('Heading Size', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'fs-48' => __('Large (48px)', 'ebp-custom-widgets'),
                    'fs-32' => __('Medium (32px)', 'ebp-custom-widgets'),
                    'fs-24' => __('Small (24px)', 'ebp-custom-widgets'),
                ],
                'default' => 'fs-32',
                'description' => __('Matches .fs-48, .fs-32, .fs-24 utility classes', 'ebp-custom-widgets'),
            ]
        );

        // Main content button text
        $this->add_control(
            'main_button_text',
            [
                'label' => __('Button Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Enter button text', 'ebp-custom-widgets'),
            ]
        );

        // Main content button URL
        $this->add_control(
            'main_button_url',
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

        // Start of Items section
        $this->start_controls_section(
            'items_section',
            [
                'label' => __('Items', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Items visibility toggle
        $this->add_control(
            'show_items',
            [
                'label' => __('Show Items', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'ebp-custom-widgets'),
                'label_off' => __('Hide', 'ebp-custom-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Items repeater
        $repeater = new \Elementor\Repeater();

        // Item content (rich text - can include headings and paragraphs)
        $repeater->add_control(
            'item_content',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('<h3>24/7 Police Station Representation</h3><p>We\'re available 24/7 to protect your rights during arrest and questioning. We offer prompt, reliable legal advice when it matters most.</p>', 'ebp-custom-widgets'),
                'placeholder' => __('Enter item content', 'ebp-custom-widgets'),
            ]
        );

        // Same idea for every repeater item so each card can pick its own size
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

        // Item button text
        $repeater->add_control(
            'item_button_text',
            [
                'label' => __('Button Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => __('CALL NOW', 'ebp-custom-widgets'),
                'placeholder' => __('Enter button text', 'ebp-custom-widgets'),
            ]
        );

        // Item button URL
        $repeater->add_control(
            'item_button_url',
            [
                'label' => __('Button URL', 'ebp-custom-widgets'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'ebp-custom-widgets'),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                ],
            ]
        );

        // Key challenges rich text field
        $repeater->add_control(
            'item_key_challenges',
            [
                'label' => __('Key Challenges', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter key challenges content', 'ebp-custom-widgets'),
            ]
        );

        // Outcome rich text field
        $repeater->add_control(
            'item_outcome',
            [
                'label' => __('Outcome', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter outcome content', 'ebp-custom-widgets'),
            ]
        );

        // Add repeater to widget
        $this->add_control(
            'items_list',
            [
                'label' => __('Items', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_content' => __('<h3>24/7 Police Station Representation</h3><p>We\'re available 24/7 to protect your rights during arrest and questioning. We offer prompt, reliable legal advice when it matters most.</p>', 'ebp-custom-widgets'),
                        'item_button_text' => __('CALL NOW', 'ebp-custom-widgets'),
                        'item_button_url' => ['url' => '#'],
                    ],
                ],
                'title_field' => 'Item',
                'condition' => [
                    'show_items' => 'yes',
                ],
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

        // Heading color control
        $this->add_control(
            'heading_color',
            [
                'label' => __('Heading Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-text-columns-1 h2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-text-columns-1 h3' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-text-columns-1' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Body color control
        $this->add_control(
            'body_color',
            [
                'label' => __('Body Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-text-columns-1 p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-text-columns-1 li' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color control - allows editors to set background color for the widget
        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-text-columns-1' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Items gap control - allows editors to change spacing between grid items
        $this->add_control(
            'items_gap',
            [
                'label' => __('Items Gap', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'gap' => __('Small', 'ebp-custom-widgets'),
                    'gap-medium' => __('Medium', 'ebp-custom-widgets'),
                    'gap-large' => __('Large', 'ebp-custom-widgets'),
                ],
                'default' => 'gap',
                'description' => __('Controls the spacing between items in the grid', 'ebp-custom-widgets'),
            ]
        );

        // Spacing controls section
        $this->add_control(
            'spacing_heading',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __('Spacing', 'ebp-custom-widgets'),
                'separator' => 'before',
            ]
        );

        // Wrapper margin block control
        $this->add_control(
            'wrapper_margin_block',
            [
                'label' => __('Wrapper Margin Block', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'ebp-custom-widgets'),
                    'margin-block' => __('Small (3rem)', 'ebp-custom-widgets'),
                    'margin-block-medium' => __('Medium (5rem)', 'ebp-custom-widgets'),
                    'margin-block-large' => __('Large (6rem)', 'ebp-custom-widgets'),
                ],
                'default' => 'margin-block',
                'description' => __('Controls vertical margin on the wrapper', 'ebp-custom-widgets'),
            ]
        );

        // Main content padding block start control
        $this->add_control(
            'content_padding_block_start',
            [
                'label' => __('Content Padding Block Start', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'ebp-custom-widgets'),
                    'padding-block-start' => __('Small (3rem)', 'ebp-custom-widgets'),
                    'padding-block-start-medium' => __('Medium (5rem)', 'ebp-custom-widgets'),
                    'padding-block-start-large' => __('Large (6rem)', 'ebp-custom-widgets'),
                ],
                'default' => 'padding-block-start',
                'description' => __('Controls top padding on the content section', 'ebp-custom-widgets'),
            ]
        );

        // Icon padding block end control
        $this->add_control(
            'icon_padding_block_end',
            [
                'label' => __('Icon Padding Block End', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'ebp-custom-widgets'),
                    'padding-block-end' => __('Small (3rem)', 'ebp-custom-widgets'),
                    'padding-block-end-medium' => __('Medium (5rem)', 'ebp-custom-widgets'),
                    'padding-block-end-large' => __('Large (6rem)', 'ebp-custom-widgets'),
                ],
                'default' => 'padding-block-end',
                'description' => __('Controls bottom padding on the icon', 'ebp-custom-widgets'),
            ]
        );

        // Margin block end control
        $this->add_control(
            'margin_block_end',
            [
                'label' => __('Margin Block End', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'ebp-custom-widgets'),
                    'margin-block-end' => __('Small (3rem)', 'ebp-custom-widgets'),
                    'margin-block-end-medium' => __('Medium (5rem)', 'ebp-custom-widgets'),
                    'margin-block-end-large' => __('Large (6rem)', 'ebp-custom-widgets'),
                ],
                'default' => '',
                'description' => __('Controls bottom margin', 'ebp-custom-widgets'),
            ]
        );

        // Margin block start control
        $this->add_control(
            'margin_block_start',
            [
                'label' => __('Margin Block Start', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'ebp-custom-widgets'),
                    'margin-block-start' => __('Small (3rem)', 'ebp-custom-widgets'),
                    'margin-block-start-medium' => __('Medium (5rem)', 'ebp-custom-widgets'),
                    'margin-block-start-large' => __('Large (6rem)', 'ebp-custom-widgets'),
                ],
                'default' => '',
                'description' => __('Controls top margin', 'ebp-custom-widgets'),
            ]
        );

        // Padding block control (full vertical padding)
        $this->add_control(
            'padding_block',
            [
                'label' => __('Padding Block', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'ebp-custom-widgets'),
                    'padding-block' => __('Small (3rem)', 'ebp-custom-widgets'),
                    'padding-block-medium' => __('Medium (5rem)', 'ebp-custom-widgets'),
                    'padding-block-large' => __('Large (6rem)', 'ebp-custom-widgets'),
                ],
                'default' => '',
                'description' => __('Controls vertical padding (top and bottom)', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get icon settings
        $show_icon = !empty($settings['show_icon']) && $settings['show_icon'] === 'yes';
        $icon_url = !empty($settings['icon_image']['url']) ? $settings['icon_image']['url'] : '';
        $icon_alt = !empty($settings['icon_alt']) ? esc_attr($settings['icon_alt']) : '';

        // Get main content settings
        $main_content = !empty($settings['main_content']) ? $settings['main_content'] : '';
        $main_button_text = !empty($settings['main_button_text']) ? $settings['main_button_text'] : '';
        $main_button_url = !empty($settings['main_button_url']['url']) ? $settings['main_button_url']['url'] : '';
        $main_button_target = !empty($settings['main_button_url']['is_external']) ? 'target="_blank"' : '';
        $main_button_nofollow = !empty($settings['main_button_url']['nofollow']) ? 'rel="nofollow"' : '';
        $main_heading_size = !empty($settings['main_heading_size']) ? $settings['main_heading_size'] : 'fs-32';

        // Get items settings
        $show_items = !empty($settings['show_items']) && $settings['show_items'] === 'yes';
        $items_list = !empty($settings['items_list']) ? $settings['items_list'] : [];
        $items_gap = !empty($settings['items_gap']) ? $settings['items_gap'] : 'gap';

        // Get spacing settings
        $wrapper_margin_block = !empty($settings['wrapper_margin_block']) ? $settings['wrapper_margin_block'] : '';
        $margin_block_end = !empty($settings['margin_block_end']) ? $settings['margin_block_end'] : '';
        $margin_block_start = !empty($settings['margin_block_start']) ? $settings['margin_block_start'] : '';
        $content_padding_block_start = !empty($settings['content_padding_block_start']) ? $settings['content_padding_block_start'] : '';
        $padding_block = !empty($settings['padding_block']) ? $settings['padding_block'] : '';
        $icon_padding_block_end = !empty($settings['icon_padding_block_end']) ? $settings['icon_padding_block_end'] : '';

        // Build wrapper classes - combine margin-block with margin-block-start and margin-block-end
        $wrapper_classes = array_filter([$wrapper_margin_block, $margin_block_start, $margin_block_end]);
        $wrapper_class_string = !empty($wrapper_classes) ? implode(' ', $wrapper_classes) : '';

        // Build content div classes - combine padding-block-start with padding-block
        $content_classes = array_filter([$content_padding_block_start, $padding_block]);
        $div_class = !empty($content_classes) ? implode(' ', $content_classes) : '';

        // Get border top setting
        $show_border_top = !empty($settings['show_border_top']) && $settings['show_border_top'] === 'yes';
        if ($show_border_top) {
            $div_class .= ' border-top';
        }

        ?>
<!-- Text Columns  -->

<div class="ebp-custom-text-columns-1">

    <div class="wrapper <?php echo esc_attr($wrapper_class_string); ?>">
        <div class="<?php echo esc_attr($div_class); ?>">
            <?php if ($show_icon && !empty($icon_url)): ?>
            <div class="icon <?php echo esc_attr($icon_padding_block_end); ?>">
                <svg id="Layer_1" data-name="Layer 1" xmlns="www.w3.org/2000/svg" viewBox="0 0 36 36">
                    <path id="Path_1308" data-name="Path 1308" d="M36,0l-18,18L0,0v36h36V0Z" fill="currentColor"
                        stroke-width="0" />
                </svg>
            </div>
            <?php endif; ?>
            <div class="wrapper__content">
                <?php if (!empty($main_content)): ?>
                <div class="main-content <?php echo esc_attr($main_heading_size); ?>">
                    <?php echo wp_kses_post($main_content); ?>
                    <?php if (!empty($main_button_url) && !empty($main_button_text)): ?>
                    <a href="<?php echo esc_url($main_button_url); ?>" class="btn" <?php echo $main_button_target; ?>
                        <?php echo $main_button_nofollow; ?>>
                        <?php echo esc_html($main_button_text); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ($show_items && !empty($items_list)): ?>
                <div class="ebp-custom-text-columns-1__items grid equal-grid <?php echo esc_attr($items_gap); ?>">
                    <?php foreach ($items_list as $item): ?>
                    <div class="ebp-custom-text-columns-1__item">
                        <?php if (!empty($item['item_content'])): ?>
                        <?php
                                            $item_heading_size = !empty($item['item_heading_size']) ? $item['item_heading_size'] : 'fs-32';
                                            ?>
                        <div class="ebp-custom-text-columns-1__item__intro <?php echo esc_attr($item_heading_size); ?>">
                            <?php echo wp_kses_post($item['item_content']); ?>
                        </div>

                        <?php if (!empty($item['item_key_challenges'])): ?>
                        <div class="ebp-custom-text-columns-1__item_key-challenges">
                            <?php echo wp_kses_post($item['item_key_challenges']); ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($item['item_outcome'])): ?>
                        <div class="ebp-custom-text-columns-1__item_outcome">
                            <?php echo wp_kses_post($item['item_outcome']); ?>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>

                        <?php
                                        // Get button URL and settings
                                        $button_url = !empty($item['item_button_url']['url']) ? $item['item_button_url']['url'] : '';
                                        $button_text = !empty($item['item_button_text']) ? $item['item_button_text'] : '';
                                        $button_target = !empty($item['item_button_url']['is_external']) ? 'target="_blank"' : '';
                                        $button_nofollow = !empty($item['item_button_url']['nofollow']) ? 'rel="nofollow"' : '';

                                        // Only show button if both URL and text are provided
                                        if (!empty($button_url) && !empty($button_text)):
                                            ?>
                        <a href="<?php echo esc_url($button_url); ?>" class="btn" <?php echo $button_target; ?>
                            <?php echo $button_nofollow; ?>>
                            <?php echo esc_html($button_text); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>


    </div>
</div>
<?php
    }
}