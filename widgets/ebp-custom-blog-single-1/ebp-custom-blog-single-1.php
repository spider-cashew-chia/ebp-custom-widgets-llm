<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Blog_Single_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_blog_single_1';
    }

    public function get_title()
    {
        return __('EBP Custom Blog Single 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-hero';
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
        return ['ebp-custom-blog-single-1-style'];
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

        // Start content section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Blog title rich text control
        $this->add_control(
            'blog_title',
            [
                'label' => __('Blog Title', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('Blog Title', 'ebp-custom-widgets'),
                'placeholder' => __('Enter blog title', 'ebp-custom-widgets'),
            ]
        );

        // Image control
        $this->add_control(
            'blog_image',
            [
                'label' => __('Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Image alt text
        $this->add_control(
            'blog_image_alt',
            [
                'label' => __('Image Alt Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Enter image alt text', 'ebp-custom-widgets'),
            ]
        );

        // Excerpt rich text control
        $this->add_control(
            'blog_excerpt',
            [
                'label' => __('Excerpt', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('Blog excerpt content', 'ebp-custom-widgets'),
                'placeholder' => __('Enter blog excerpt', 'ebp-custom-widgets'),
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

        // Get blog title
        $blog_title = !empty($settings['blog_title']) ? $settings['blog_title'] : '';

        // Get image settings - use featured image as fallback if empty
        $blog_image_url = !empty($settings['blog_image']['url']) ? $settings['blog_image']['url'] : '';
        $blog_image_alt = !empty($settings['blog_image_alt']) ? esc_attr($settings['blog_image_alt']) : '';

        // If no image is set, try to use the post's featured image
        if (empty($blog_image_url)) {
            $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            if ($featured_image_url) {
                $blog_image_url = $featured_image_url;
                // If no alt text is set, try to get it from the featured image
                if (empty($blog_image_alt)) {
                    $featured_image_id = get_post_thumbnail_id(get_the_ID());
                    if ($featured_image_id) {
                        $blog_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);
                    }
                }
            }
        }

        // Get excerpt
        $blog_excerpt = !empty($settings['blog_excerpt']) ? $settings['blog_excerpt'] : '';

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
        <!-- Blog Single  -->
        <div class="ebp-custom-blog-single-1">
            <div class="wrapper <?php echo esc_attr($wrapper_class_string); ?>">
                <div class="<?php echo esc_attr($div_class); ?>">
                    <?php if ($show_icon && !empty($icon_url)): ?>
                        <div class="icon <?php echo esc_attr($icon_padding_block_end); ?>">
                            <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo $icon_alt; ?>">
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($blog_title)): ?>
                        <!-- blog title rich text -->
                        <div class="ebp-custom-blog-single-1__title">
                            <?php echo wp_kses_post($blog_title); ?>
                        </div>

                    <?php endif; ?>
                    <div class="ebp-custom-blog-single-1__inner grid equal-grid gap">
                        <?php if (!empty($blog_image_url)): ?>
                            <div class="ebp-custom-blog-single-1__image">
                                <!-- image control - uses featured image if empty -->
                                <img src="<?php echo esc_url($blog_image_url); ?>" alt="<?php echo esc_attr($blog_image_alt); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="ebp-custom-blog-single-1__content">
                            <?php if (!empty($blog_excerpt)): ?>
                                <div class="ebp-custom-blog-single-1__excerpt">
                                    <!-- rich text -->
                                    <?php echo wp_kses_post($blog_excerpt); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php
    }
}