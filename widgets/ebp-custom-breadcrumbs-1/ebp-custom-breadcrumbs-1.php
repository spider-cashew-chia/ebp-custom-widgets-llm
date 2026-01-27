<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Breadcrumbs_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_breadcrumbs_1';
    }

    public function get_title()
    {
        return __('EBP Custom Breadcrumbs 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-breadcrumbs';
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
        return ['ebp-custom-breadcrumbs-1-style'];
    }


    protected function register_controls()
    {
        // Start of Style section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Font color control (body color)
        $this->add_control(
            'font_color',
            [
                'label' => __('Font Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-breadcrumbs-1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-breadcrumbs-1 p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-breadcrumbs-1 a' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Heading color control
        $this->add_control(
            'heading_color',
            [
                'label' => __('Heading Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-breadcrumbs-1 h1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-breadcrumbs-1 h2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-breadcrumbs-1 h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color control
        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-breadcrumbs-1' => 'background-color: {{VALUE}};',
                ],
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

        // Margin top control
        $this->add_control(
            'margin_top',
            [
                'label' => __('Margin Top', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'ebp-custom-widgets'),
                    'margin-block-start' => __('Small', 'ebp-custom-widgets'),
                    'margin-block-start-medium' => __('Medium', 'ebp-custom-widgets'),
                    'margin-block-start-large' => __('Large', 'ebp-custom-widgets'),
                ],
                'default' => '',
                'description' => __('Controls top margin using CSS variables', 'ebp-custom-widgets'),
            ]
        );

        // Margin bottom control
        $this->add_control(
            'margin_bottom',
            [
                'label' => __('Margin Bottom', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'ebp-custom-widgets'),
                    'margin-block-end' => __('Small', 'ebp-custom-widgets'),
                    'margin-block-end-medium' => __('Medium', 'ebp-custom-widgets'),
                    'margin-block-end-large' => __('Large', 'ebp-custom-widgets'),
                ],
                'default' => '',
                'description' => __('Controls bottom margin using CSS variables', 'ebp-custom-widgets'),
            ]
        );

        // Padding top control
        $this->add_control(
            'padding_top',
            [
                'label' => __('Padding Top', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'ebp-custom-widgets'),
                    'padding-block-start' => __('Small', 'ebp-custom-widgets'),
                    'padding-block-start-medium' => __('Medium', 'ebp-custom-widgets'),
                    'padding-block-start-large' => __('Large', 'ebp-custom-widgets'),
                ],
                'default' => 'padding-block-start',
                'description' => __('Controls top padding using CSS variables', 'ebp-custom-widgets'),
            ]
        );

        // Padding bottom control
        $this->add_control(
            'padding_bottom',
            [
                'label' => __('Padding Bottom', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'ebp-custom-widgets'),
                    'padding-block-end' => __('Small', 'ebp-custom-widgets'),
                    'padding-block-end-medium' => __('Medium', 'ebp-custom-widgets'),
                    'padding-block-end-large' => __('Large', 'ebp-custom-widgets'),
                ],
                'default' => '',
                'description' => __('Controls bottom padding using CSS variables', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();
    }


    /**
     * Get the hub page URL and label for a custom post type
     * Tries to find a custom page that serves as the hub for this CPT
     * 
     * @param string $post_type The post type slug
     * @return array Array with 'url' and 'label' keys, or false if not found
     */
    private function get_cpt_hub_info($post_type)
    {
        // Try to auto-detect by matching post type name to page slug
        // Convert post type slug to page slug format (e.g., 'case_study' -> 'case-study' or 'case-studies')
        $possible_slugs = [
            str_replace('_', '-', $post_type), // case_study -> case-study
            str_replace('_', '-', $post_type) . 's', // case_study -> case-studies
        ];
        
        foreach ($possible_slugs as $slug) {
            $page = get_page_by_path($slug);
            if ($page) {
                return [
                    'url' => get_permalink($page->ID),
                    'label' => get_the_title($page->ID)
                ];
            }
        }
        
        return false;
    }

    /**
     * Generate custom breadcrumbs
     * 
     * @return array Array of breadcrumb items with 'text' and 'url' keys
     */
    private function generate_breadcrumbs()
    {
        $breadcrumbs = [];
        
        // Always start with Home
        $breadcrumbs[] = [
            'text' => __('Home', 'ebp-custom-widgets'),
            'url' => home_url('/')
        ];
        
        // Handle different page types
        if (is_singular()) {
            $post_type = get_post_type();
            $post_type_obj = get_post_type_object($post_type);
            $current_post = get_queried_object();
            
            // For custom post types, always add the CPT label before the single post
            if ($post_type_obj && $post_type !== 'post' && $post_type !== 'page') {
                // Try to get hub page info (custom page that serves as archive)
                $hub_info = $this->get_cpt_hub_info($post_type);
                
                // If hub page found, use it
                if ($hub_info) {
                    $breadcrumbs[] = [
                        'text' => $hub_info['label'],
                        'url' => $hub_info['url']
                    ];
                } else {
                    // No hub page, try archive URL
                    $archive_url = get_post_type_archive_link($post_type);
                    
                    // Always show CPT label, link to archive if available
                    $breadcrumbs[] = [
                        'text' => $post_type_obj->labels->name,
                        'url' => $archive_url ? $archive_url : ''
                    ];
                }
            }
            
            // For regular posts, add blog page if set
            if ($post_type === 'post') {
                $blog_page_id = get_option('page_for_posts');
                if ($blog_page_id) {
                    $breadcrumbs[] = [
                        'text' => get_the_title($blog_page_id),
                        'url' => get_permalink($blog_page_id)
                    ];
                }
            }
            
            // For pages, add parent pages
            if ($post_type === 'page' && $current_post->post_parent) {
                $ancestors = get_post_ancestors($current_post->ID);
                $ancestors = array_reverse($ancestors);
                
                foreach ($ancestors as $ancestor_id) {
                    $breadcrumbs[] = [
                        'text' => get_the_title($ancestor_id),
                        'url' => get_permalink($ancestor_id)
                    ];
                }
            }
            
            // Add current post/page (not linked)
            $breadcrumbs[] = [
                'text' => get_the_title(),
                'url' => ''
            ];
        } elseif (is_category() || is_tag() || is_tax()) {
            // Taxonomy archive
            $term = get_queried_object();
            $breadcrumbs[] = [
                'text' => $term->name,
                'url' => ''
            ];
        } elseif (is_post_type_archive()) {
            // Post type archive
            $post_type = get_query_var('post_type');
            $post_type_obj = get_post_type_object($post_type);
            if ($post_type_obj) {
                $breadcrumbs[] = [
                    'text' => $post_type_obj->labels->name,
                    'url' => ''
                ];
            }
        } elseif (is_search()) {
            $breadcrumbs[] = [
                'text' => sprintf(__('Search Results for "%s"', 'ebp-custom-widgets'), get_search_query()),
                'url' => ''
            ];
        } elseif (is_404()) {
            $breadcrumbs[] = [
                'text' => __('404 - Page Not Found', 'ebp-custom-widgets'),
                'url' => ''
            ];
        }
        
        return $breadcrumbs;
    }

    protected function render()
    {
        // Get settings from Elementor controls
        $settings = $this->get_settings_for_display();

        // Get spacing settings
        $margin_top = !empty($settings['margin_top']) ? $settings['margin_top'] : '';
        $margin_bottom = !empty($settings['margin_bottom']) ? $settings['margin_bottom'] : '';
        $padding_top = !empty($settings['padding_top']) ? $settings['padding_top'] : '';
        $padding_bottom = !empty($settings['padding_bottom']) ? $settings['padding_bottom'] : '';

        // Build wrapper classes - combine all spacing classes
        $wrapper_classes = array_filter([$margin_top, $margin_bottom, $padding_top, $padding_bottom]);
        $wrapper_class_string = !empty($wrapper_classes) ? implode(' ', $wrapper_classes) : '';

        // Generate breadcrumbs
        $breadcrumbs = $this->generate_breadcrumbs();
        $separator = apply_filters('ebp_breadcrumb_separator', ' > ');

        ?>
<!-- Breadcrumbs  -->
<div class="ebp-custom-breadcrumbs-1 <?php echo esc_attr($wrapper_class_string); ?>">
    <div class="wrapper">
        <div class="ebp-custom-breadcrumbs-1__inner">
            <p id="breadcrumbs">
                <?php
                foreach ($breadcrumbs as $index => $crumb) {
                    if ($index > 0) {
                        echo '<span class="breadcrumb-separator">' . esc_html($separator) . '</span>';
                    }
                    
                    if (!empty($crumb['url'])) {
                        echo '<a href="' . esc_url($crumb['url']) . '">' . esc_html($crumb['text']) . '</a>';
                    } else {
                        echo '<span>' . esc_html($crumb['text']) . '</span>';
                    }
                }
                ?>
            </p>
        </div>
    </div>

</div>

<?php
    }
}