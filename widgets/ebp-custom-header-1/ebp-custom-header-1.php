<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Header_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_header_1';
    }

    public function get_title()
    {
        return __('EBP Custom Header 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-header';
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
        return ['ebp-custom-header-1-style'];
    }


    protected function register_controls()
    {
        // Start of Logo section
        $this->start_controls_section(
            'logo_section',
            [
                'label' => __('Logo', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Logo image control
        $this->add_control(
            'logo_image',
            [
                'label' => __('Logo Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_template_directory_uri() . '/assets/images/logo.png',
                ],
                'description' => __('Select or upload the logo image', 'ebp-custom-widgets'),
            ]
        );

        // Logo link control
        $this->add_control(
            'logo_link',
            [
                'label' => __('Logo Link', 'ebp-custom-widgets'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'ebp-custom-widgets'),
                'show_external' => true,
                'default' => [
                    'url' => home_url(),
                    'is_external' => false,
                ],
            ]
        );

        // Alt text control for accessibility
        $this->add_control(
            'logo_alt',
            [
                'label' => __('Alt Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => get_bloginfo('name'),
                'placeholder' => __('Enter alt text for the logo', 'ebp-custom-widgets'),
                'description' => __('Important for accessibility and SEO', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get logo image URL
        $logo_url = !empty($settings['logo_image']['url']) ? $settings['logo_image']['url'] : get_template_directory_uri() . '/assets/images/logo.png';

        // Get logo link settings
        $logo_link = !empty($settings['logo_link']['url']) ? $settings['logo_link']['url'] : home_url();
        $logo_link_target = !empty($settings['logo_link']['is_external']) ? 'target="_blank"' : '';
        $logo_link_nofollow = !empty($settings['logo_link']['nofollow']) ? 'rel="nofollow"' : '';

        // Get alt text
        $logo_alt = !empty($settings['logo_alt']) ? esc_attr($settings['logo_alt']) : get_bloginfo('name');

        ?>
<!-- Header  -->

<div class="ebp-custom-header-1">
    <div class="header-wrapper flex">
        <div class="site-branding">
            <a href="<?php echo esc_url($logo_link); ?>" <?php echo $logo_link_target; ?>
                <?php echo $logo_link_nofollow; ?>>
                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo $logo_alt; ?>">
            </a>
        </div>
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="custom-menu__container">
            <div class="custom-menu__inner-wrap">

                <?php
                    wp_nav_menu([
                        'menu' => 'quick-links',
                        'container' => false,
                        'menu_class' => 'footer-menu',
                        'fallback_cb' => false,
                    ]);
                    ?>

            </div>
        </div>
        <div class="side-ctas">
            <a href="/contact" class="side-ctas__book">
                <svg id="Layer_1" data-name="Layer 1" xmlns="www.w3.org/2000/svg" viewBox="0 0 36 36">
                    <path id="Path_1302" data-name="Path 1302" d="M36,0l-18,18L0,0v36h36V0Z" fill="#e2a23d"
                        stroke-width="0" />
                </svg>
                <span>Book An Appointment</span>

            </a>
            <a href="/contact" class="side-ctas__talk">
                <svg id="Group_1074" data-name="Group 1074" xmlns="www.w3.org/2000/svg"
                    xmlns:xlink="www.w3.org/1999/xlink" viewBox="0 0 26.18 25.64">
                    <defs>
                        <clipPath id="clippath">
                            <rect width="26.18" height="25.64" fill="none" stroke-width="0" />
                        </clipPath>
                    </defs>
                    <g clip-path="url(#clippath)">
                        <g id="Group_1073" data-name="Group 1073">
                            <path id="Path_1223" data-name="Path 1223"
                                d="M25.74,21.63l-1.43,1.4c-3.55,3.43-9.18,3.43-12.74,0L2.67,14.3C-.78,10.94-.84,5.42,2.52,1.98c.05-.05.1-.1.15-.15l1.43-1.4c.53-.52,1.38-.52,1.91,0l5.37,5.27c.52.5.53,1.32.03,1.84-.01.01-.02.02-.03.03l-2.1,2.05c-.22.22-.35.51-.35.82h0c0,.31.13.61.35.83l5.38,5.27c.23.22.53.35.85.34h.07c.29-.02.57-.14.78-.34l2.09-2.05c.53-.51,1.38-.51,1.91,0l5.37,5.26c.51.5.51,1.33.01,1.85,0,0-.01.01-.01.03Z"
                                fill="#002e36" stroke-width="0" />
                        </g>
                    </g>
                </svg>

                <span>Talk to a Solicitor 24/7</span>
            </a>
        </div>
    </div>
</div>
<?php
}
}