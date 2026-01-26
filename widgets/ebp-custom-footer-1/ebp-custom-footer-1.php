<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Footer_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_footer_1';
    }

    public function get_title()
    {
        return __('EBP Custom Footer 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        // footer icon
        return 'eicon-footer';
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
        return ['ebp-custom-footer-1-style'];
    }


    protected function register_controls()
    {
        // Logo Section
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
                    'url' => '',
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

        // Rich text editor for logo area
        $this->add_control(
            'logo_rich_text',
            [
                'label' => __('Logo Area Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Optional content below logo', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();

        // Quick Links Section
        $this->start_controls_section(
            'quick_links_section',
            [
                'label' => __('Quick Links', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Menu heading field
        $this->add_control(
            'quick_links_heading',
            [
                'label' => __('Menu Heading', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Quick Links', 'ebp-custom-widgets'),
                'placeholder' => __('Enter menu heading', 'ebp-custom-widgets'),
            ]
        );

        // Get all WordPress menus for dropdown
        $menus = wp_get_nav_menus();
        $menu_options = [];
        $menu_options[''] = __('Select a menu', 'ebp-custom-widgets');

        foreach ($menus as $menu) {
            $menu_options[$menu->term_id] = $menu->name;
        }

        // WP menu dropdown
        $this->add_control(
            'quick_links_menu',
            [
                'label' => __('Select Menu', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => $menu_options,
                'default' => '',
                'description' => __('Choose a WordPress menu to display', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();

        // Policies Section
        $this->start_controls_section(
            'policies_section',
            [
                'label' => __('Policies', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Menu heading field
        $this->add_control(
            'policies_heading',
            [
                'label' => __('Menu Heading', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Policies', 'ebp-custom-widgets'),
                'placeholder' => __('Enter menu heading', 'ebp-custom-widgets'),
            ]
        );

        // WP menu dropdown
        $this->add_control(
            'policies_menu',
            [
                'label' => __('Select Menu', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => $menu_options,
                'default' => '',
                'description' => __('Choose a WordPress menu to display', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();

        // Address Section
        $this->start_controls_section(
            'address_section',
            [
                'label' => __('Address', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Rich text editor for address
        $this->add_control(
            'address_content',
            [
                'label' => __('Address Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter address or contact information', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();

        // Newsletter Section
        $this->start_controls_section(
            'newsletter_section',
            [
                'label' => __('Newsletter', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Rich text editor for newsletter heading/description
        $this->add_control(
            'newsletter_content',
            [
                'label' => __('Newsletter Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter newsletter heading or description', 'ebp-custom-widgets'),
            ]
        );

        // Get Contact Form 7 forms if plugin is active
        $cf7_forms = [];
        $cf7_forms[''] = __('Select a form', 'ebp-custom-widgets');

        if (class_exists('WPCF7_ContactForm')) {
            $forms = WPCF7_ContactForm::find();
            foreach ($forms as $form) {
                $cf7_forms[$form->id()] = $form->title();
            }
        }

        // Contact Form 7 dropdown
        $this->add_control(
            'newsletter_form',
            [
                'label' => __('Contact Form 7', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => $cf7_forms,
                'default' => '',
                'description' => __('Select a Contact Form 7 form to display', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Logo settings
        $logo_url = !empty($settings['logo_image']['url']) ? $settings['logo_image']['url'] : '';
        $logo_link = !empty($settings['logo_link']['url']) ? $settings['logo_link']['url'] : home_url();
        $logo_link_target = !empty($settings['logo_link']['is_external']) ? 'target="_blank"' : '';
        $logo_link_nofollow = !empty($settings['logo_link']['nofollow']) ? 'rel="nofollow"' : '';
        $logo_alt = !empty($settings['logo_alt']) ? esc_attr($settings['logo_alt']) : get_bloginfo('name');
        $logo_rich_text = !empty($settings['logo_rich_text']) ? $settings['logo_rich_text'] : '';

        // Quick links settings
        $quick_links_heading = !empty($settings['quick_links_heading']) ? esc_html($settings['quick_links_heading']) : '';
        $quick_links_menu_id = !empty($settings['quick_links_menu']) ? intval($settings['quick_links_menu']) : 0;

        // Policies settings
        $policies_heading = !empty($settings['policies_heading']) ? esc_html($settings['policies_heading']) : '';
        $policies_menu_id = !empty($settings['policies_menu']) ? intval($settings['policies_menu']) : 0;

        // Address settings
        $address_content = !empty($settings['address_content']) ? $settings['address_content'] : '';

        // Newsletter settings
        $newsletter_content = !empty($settings['newsletter_content']) ? $settings['newsletter_content'] : '';
        $newsletter_form_id = !empty($settings['newsletter_form']) ? intval($settings['newsletter_form']) : 0;

        ?>
<!-- Footer  -->

<div class="ebp-custom-footer-1">
    <div class="wrapper">
        <div class="footer-icon">
            <img src="/wp-content/uploads/2025/11/llm-icon.svg" alt="llm icon">
        </div>
        <div class="footer-content">
            <div class="footer-content__logo">
                <?php if (!empty($logo_url)): ?>
                <a href="<?php echo esc_url($logo_link); ?>" <?php echo $logo_link_target; ?>
                    <?php echo $logo_link_nofollow; ?>>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo $logo_alt; ?>">
                </a>
                <?php endif; ?>

                <?php if (!empty($logo_rich_text)): ?>
                <div class="footer-content__logo-text">
                    <?php echo wp_kses_post($logo_rich_text); ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="footer-content__quick-links">
                <?php if (!empty($quick_links_heading)): ?>
                <h3 class="footer-content__heading"><?php echo $quick_links_heading; ?></h3>
                <?php endif; ?>

                <?php if (!empty($quick_links_menu_id)): ?>
                <?php
                            wp_nav_menu([
                                'menu' => $quick_links_menu_id,
                                'container' => false,
                                'menu_class' => 'footer-menu',
                                'fallback_cb' => false,
                            ]);
                            ?>
                <?php endif; ?>
            </div>

            <div class="footer-content__policies">
                <?php if (!empty($policies_heading)): ?>
                <h3 class="footer-content__heading"><?php echo $policies_heading; ?></h3>
                <?php endif; ?>

                <?php if (!empty($policies_menu_id)): ?>
                <?php
                            wp_nav_menu([
                                'menu' => $policies_menu_id,
                                'container' => false,
                                'menu_class' => 'footer-menu',
                                'fallback_cb' => false,
                            ]);
                            ?>
                <?php endif; ?>
            </div>

            <div class="footer-content__address">
                <?php if (!empty($address_content)): ?>
                <?php echo wp_kses_post($address_content); ?>
                <?php endif; ?>
            </div>

            <div class="footer-content__newsletter">
                <?php if (!empty($newsletter_content)): ?>
                <div class="footer-content__newsletter-text">
                    <?php echo wp_kses_post($newsletter_content); ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($newsletter_form_id) && class_exists('WPCF7_ContactForm')): ?>
                <div class="footer-content__newsletter-form">
                    <?php echo do_shortcode('[contact-form-7 id="' . esc_attr($newsletter_form_id) . '"]'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>


    </div>
    <!-- Footer bottom -->
    <div class="footer-copyright">
        <div class="wrapper">
            <div class="footer-bottom">
                <div class="footer-bottom__content">
                    <p class="footer-bottom__text">
                        &copy; COPYRIGHT <?php echo date('Y'); ?>. ALL RIGHTS RESERVED
                    </p>
                </div>
            </div>
        </div>
    </div>


</div>

<?php
    }
}