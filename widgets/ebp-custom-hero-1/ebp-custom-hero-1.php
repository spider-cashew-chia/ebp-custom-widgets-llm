<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Hero_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_hero_1';
    }

    public function get_title()
    {
        return __('EBP Custom Hero 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        // image icon
        return 'eicon-image-box';
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
        return ['ebp-custom-hero-1-style'];
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

        // Hero image control
        $this->add_control(
            'hero_image',
            [
                'label' => __('Hero Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'description' => __('Select or upload the hero background image', 'ebp-custom-widgets'),
            ]
        );

        // Alt text control for accessibility
        $this->add_control(
            'hero_image_alt',
            [
                'label' => __('Image Alt Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Enter alt text for the image', 'ebp-custom-widgets'),
                'description' => __('Important for accessibility and SEO', 'ebp-custom-widgets'),
            ]
        );

        // Rich text editor for hero content
        $this->add_control(
            'hero_content',
            [
                'label' => __('Hero Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('Enter your hero content here', 'ebp-custom-widgets'),
                'placeholder' => __('Enter your hero content', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get hero image URL - use featured image as fallback if empty
        $hero_image_url = !empty($settings['hero_image']['url']) ? $settings['hero_image']['url'] : '';

        // If no hero image is set, try to get the featured image
        if (empty($hero_image_url)) {
            $hero_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        }

        // Get alt text for the image
        $hero_image_alt = !empty($settings['hero_image_alt']) ? esc_attr($settings['hero_image_alt']) : '';

        // If using featured image and no alt text is set, get it from the attachment
        if (empty($hero_image_alt) && !empty($hero_image_url)) {
            $thumbnail_id = get_post_thumbnail_id(get_the_ID());
            if ($thumbnail_id) {
                $hero_image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
            }
        }

        // Get hero content (rich text) - use post title as fallback if empty
        $hero_content = !empty($settings['hero_content']) ? $settings['hero_content'] : '';

        // Track if we're using the post title as fallback (so we can wrap it in H1)
        $is_using_title_fallback = false;

        // If no hero content is set, use the post title wrapped in H1
        if (empty($hero_content)) {
            $post_title = get_the_title();
            if (!empty($post_title)) {
                $hero_content = '<h1>' . esc_html($post_title) . '</h1>';
                $is_using_title_fallback = true;
            }
        }

        ?>
<!-- Hero  -->

<div class="ebp-custom-hero-1">
    <?php if (!empty($hero_image_url)): ?>
    <div class="ebp-custom-hero-1__image">

        <img src="<?php echo esc_url($hero_image_url); ?>" alt="<?php echo $hero_image_alt; ?>">
    </div>
    <?php endif; ?>
    <?php if (!empty($hero_content)): ?>
    <div class="ebp-custom-hero-1__content">
        <div class="banner-wrapper">
            <div class="absolute-wrapper">
                <div class="wrapper">
                    <?php echo wp_kses_post($hero_content); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php
    }
}