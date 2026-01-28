<?php
/**
 * Plugin Name: EBP Custom Widgets
 * Description: Custom Elementor widgets for e-blueprint digital.
 * Version: 2.0
 * Author: e-blueprint digital
 */

if (!defined('ABSPATH'))
    exit;

// Register custom category with very early priority
function add_ebp_custom_widgets_category($elements_manager)
{
    $elements_manager->add_category(
        'ebp-custom-widgets',
        [
            'title' => __('EBP Custom Widgets', 'ebp-custom-widgets'),
            'icon' => 'fa fa-star',
        ],
        1 // Position at the top
    );
}
add_action('elementor/elements/categories_registered', 'add_ebp_custom_widgets_category', 1);

// Register menu locations
// This registers the "Primary" menu location that can be used in the header widget
function register_ebp_menu_locations()
{
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'ebp-custom-widgets'),
    ));
}
add_action('init', 'register_ebp_menu_locations');

// Automatically register all widgets from the widgets directory
// This function scans the widgets folder and registers any widget it finds
function register_all_ebp_custom_widgets($widgets_manager)
{
    // Get the widgets directory path
    $widgets_dir = __DIR__ . '/widgets';

    // Check if the directory exists
    if (!is_dir($widgets_dir)) {
        return;
    }

    // Scan the widgets directory for all widget folders
    $widget_folders = array_filter(glob($widgets_dir . '/*'), 'is_dir');

    // Loop through each widget folder
    foreach ($widget_folders as $widget_folder) {
        // Get the folder name (e.g., "ebp-custom-hero-1")
        $folder_name = basename($widget_folder);

        // Construct the PHP file path
        $widget_file = $widget_folder . '/' . $folder_name . '.php';

        // Check if the widget file exists
        if (!file_exists($widget_file)) {
            continue;
        }

        // Convert folder name to class name
        // Example: "ebp-custom-hero-1" -> "Ebp_Custom_Hero_1"
        $class_name = convert_folder_to_class_name($folder_name);

        // Require the widget file
        require_once($widget_file);

        // Check if the class exists before trying to instantiate it
        if (class_exists($class_name)) {
            // Register the widget
            $widgets_manager->register(new $class_name());
        }
    }
}
add_action('elementor/widgets/register', 'register_all_ebp_custom_widgets');

// Helper function to convert folder name to class name
// Example: "ebp-custom-hero-1" -> "Ebp_Custom_Hero_1"
function convert_folder_to_class_name($folder_name)
{
    // Remove the "ebp-custom-" prefix
    $name_without_prefix = str_replace('ebp-custom-', '', $folder_name);

    // Split by hyphens
    $parts = explode('-', $name_without_prefix);

    // Capitalize each part and join with underscores
    $capitalized_parts = array_map('ucfirst', $parts);
    $class_suffix = implode('_', $capitalized_parts);

    // Return the full class name
    return 'Ebp_Custom_' . $class_suffix;
}






// Dynamically enqueue all CSS files from assets/css directory
// This function scans the directory and automatically enqueues any CSS files found
// Now includes subdirectories like vendor/
function enqueue_dynamic_css_files()
{
    // Path to the CSS directory
    $css_dir = __DIR__ . '/assets/css';

    // Check if the directory exists
    if (!is_dir($css_dir)) {
        return;
    }

    // Get all CSS files from the directory and subdirectories
    // Using RecursiveDirectoryIterator to find all .css files recursively
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($css_dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    // Array to store CSS files with their relative paths
    $css_files = [];

    // Loop through all files found
    foreach ($iterator as $file) {
        // Only process .css files, skip .map files
        if ($file->isFile() && $file->getExtension() === 'css' && strpos($file->getFilename(), '.map') === false) {
            $css_files[] = $file->getPathname();
        }
    }

    // Loop through each CSS file and enqueue it
    foreach ($css_files as $css_file) {
        // Get the relative path from the assets/css directory
        $relative_path = str_replace($css_dir . '/', '', $css_file);

        // Get just the filename for checking skip list
        $filename = basename($css_file);

        // Skip main.css and app.min.css - these will be loaded last
        if ($filename === 'main.css' || $filename === 'app.min.css') {
            continue;
        }

        // Create a unique handle based on the relative path (replace slashes with dashes)
        $handle_name = str_replace(['/', '\\', '.css'], ['-', '-', ''], $relative_path);
        $handle = 'ebp-' . $handle_name;

        // Enqueue the CSS file
        // Using filemtime() to get file modification time for cache busting
        wp_enqueue_style(
            $handle,
            plugins_url('/assets/css/' . $relative_path, __FILE__),
            [], // No dependencies
            file_exists($css_file) ? filemtime($css_file) : '1.0.0' // Version based on file modification time
        );
    }
}

// Dynamically enqueue all JavaScript files from assets/js directory
// This function scans the directory and automatically enqueues any JS files found
// Now includes subdirectories like modules/
function enqueue_dynamic_js_files()
{
    // Path to the JS directory
    $js_dir = __DIR__ . '/assets/js';

    // Check if the directory exists
    if (!is_dir($js_dir)) {
        return;
    }

    // Manually enqueue GSAP core libraries first to ensure they're registered
    // This ensures dependencies work correctly
    $gsap_file = $js_dir . '/gsap.min.js';
    $scrolltrigger_file = $js_dir . '/ScrollTrigger.min.js';
    $splittext_file = $js_dir . '/SplitText.min.js';

    if (file_exists($gsap_file)) {
        wp_enqueue_script(
            'ebp-gsap-min',
            plugins_url('/assets/js/gsap.min.js', __FILE__),
            ['jquery'], // GSAP doesn't need jQuery, but keeping for consistency
            file_exists($gsap_file) ? filemtime($gsap_file) : '1.0.0',
            true
        );
    }

    if (file_exists($scrolltrigger_file)) {
        wp_enqueue_script(
            'ebp-ScrollTrigger-min',
            plugins_url('/assets/js/ScrollTrigger.min.js', __FILE__),
            ['ebp-gsap-min'], // ScrollTrigger depends on GSAP
            file_exists($scrolltrigger_file) ? filemtime($scrolltrigger_file) : '1.0.0',
            true
        );
    }

    if (file_exists($splittext_file)) {
        wp_enqueue_script(
            'ebp-SplitText-min',
            plugins_url('/assets/js/SplitText.min.js', __FILE__),
            ['ebp-gsap-min'], // SplitText depends on GSAP
            file_exists($splittext_file) ? filemtime($splittext_file) : '1.0.0',
            true
        );
    }

    // Get all JavaScript files from the directory and subdirectories
    // Using RecursiveDirectoryIterator to find all .js files recursively
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($js_dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    // Array to store JS files with their relative paths
    $js_files = [];

    // Loop through all files found
    foreach ($iterator as $file) {
        // Only process .js files, skip .map files
        // Skip GSAP, ScrollTrigger, and SplitText since we've already enqueued them manually
        $filename = $file->getFilename();
        if (
            $file->isFile() && $file->getExtension() === 'js' &&
            strpos($filename, '.map') === false &&
            $filename !== 'gsap.min.js' &&
            $filename !== 'ScrollTrigger.min.js' &&
            $filename !== 'SplitText.min.js'
        ) {
            $js_files[] = $file->getPathname();
        }
    }

    // Loop through each JS file and enqueue it
    foreach ($js_files as $js_file) {
        // Get the relative path from the assets/js directory
        $relative_path = str_replace($js_dir . '/', '', $js_file);

        // Get just the filename for the handle (replace slashes with dashes)
        $handle_name = str_replace(['/', '\\', '.js'], ['-', '-', ''], $relative_path);
        $handle = 'ebp-' . $handle_name;

        // Determine dependencies
        // Most scripts need jQuery, menu.js and main.js also need GSAP
        $dependencies = ['jquery'];
        // GSAP handle: gsap.min.js becomes ebp-gsap-min
        if (strpos($relative_path, 'menu.js') !== false || strpos($relative_path, 'modules/main.js') !== false) {
            $dependencies[] = 'ebp-gsap-min';
        }
        // ScrollTrigger needs GSAP
        // ScrollTrigger.min.js becomes ebp-ScrollTrigger-min
        if (strpos($relative_path, 'ScrollTrigger.min.js') !== false) {
            $dependencies[] = 'ebp-gsap-min';
        }
        // Modules that use ScrollTrigger and SplitText need GSAP, ScrollTrigger, and SplitText
        if (strpos($relative_path, 'modules/main.js') !== false) {
            $dependencies[] = 'ebp-ScrollTrigger-min';
            $dependencies[] = 'ebp-SplitText-min';
        }

        // Enqueue the JavaScript file
        // Using filemtime() to get file modification time for cache busting
        // Scripts load in the footer (true) for better page load performance
        wp_enqueue_script(
            $handle,
            plugins_url('/assets/js/' . $relative_path, __FILE__),
            $dependencies,
            file_exists($js_file) ? filemtime($js_file) : '1.0.0', // Version based on file modification time
            true // Load in footer
        );
    }
}

// Enqueue widget assets only on frontend
function my_widget_assets()
{
    // Only load on frontend, not in admin or Elementor editor
    if (is_admin() || (defined('ELEMENTOR_VERSION') && \Elementor\Plugin::$instance->editor->is_edit_mode())) {
        return;
    }

    // Dynamically enqueue all CSS files from assets/css directory
    // This will automatically include animate.css and any other CSS files
    enqueue_dynamic_css_files();

    // Dynamically enqueue all JavaScript files from assets/js directory
    // This will automatically include aos.js and any other JS files
    enqueue_dynamic_js_files();



    // Automatically enqueue assets for all widgets
    // This scans the widgets directory and enqueues CSS and JS files for each widget
    $widgets_dir = __DIR__ . '/widgets';

    // Check if the directory exists
    if (is_dir($widgets_dir)) {
        // Scan the widgets directory for all widget folders
        $widget_folders = array_filter(glob($widgets_dir . '/*'), 'is_dir');

        // Loop through each widget folder
        foreach ($widget_folders as $widget_folder) {
            // Get the folder name (e.g., "ebp-custom-hero-1")
            $folder_name = basename($widget_folder);

            // Construct asset file paths
            $style_file = $widget_folder . '/assets/style.css';
            $script_file = $widget_folder . '/assets/script.js';

            // Enqueue CSS if it exists
            if (file_exists($style_file)) {
                wp_enqueue_style(
                    $folder_name . '-style',
                    plugins_url('/widgets/' . $folder_name . '/assets/style.css', __FILE__),
                    [],
                    file_exists($style_file) ? filemtime($style_file) : '1.0.0'
                );
            }

            // Enqueue JS if it exists
            if (file_exists($script_file)) {
                // Determine dependencies based on widget
                $dependencies = ['jquery'];

                // Widgets that use GSAP and ScrollTrigger
                if (
                    $folder_name === 'ebp-custom-blog-hub-1' ||
                    $folder_name === 'ebp-custom-team-1' ||
                    $folder_name === 'ebp-custom-timeline-1' ||
                    $folder_name === 'ebp-custom-stats-1'
                ) {
                    $dependencies[] = 'ebp-gsap-min';
                    $dependencies[] = 'ebp-ScrollTrigger-min';
                }

                // Hero uses GSAP + SplitText for word reveal
                if ($folder_name === 'ebp-custom-hero-1') {
                    $dependencies[] = 'ebp-gsap-min';
                    $dependencies[] = 'ebp-SplitText-min';
                }

                wp_enqueue_script(
                    $folder_name . '-script',
                    plugins_url('/widgets/' . $folder_name . '/assets/script.js', __FILE__),
                    $dependencies,
                    file_exists($script_file) ? filemtime($script_file) : '1.0.0',
                    true
                );
            }
        }
    }

    // Enqueue main.css and app.min.css last, after all other CSS files
    // These files need to load after everything else to override or extend other styles
    $main_css_path = __DIR__ . '/assets/css/main.css';
    $app_min_css_path = __DIR__ . '/assets/css/app.min.css';

    if (file_exists($main_css_path)) {
        wp_enqueue_style(
            'main-css',
            plugins_url('/assets/css/main.css', __FILE__),
            [], // No dependencies - WordPress will load it after previously enqueued styles
            filemtime($main_css_path)
        );
    }

    if (file_exists($app_min_css_path)) {
        wp_enqueue_style(
            'app-min-css',
            plugins_url('/assets/css/app.min.css', __FILE__),
            [], // No dependencies - WordPress will load it after previously enqueued styles
            filemtime($app_min_css_path)
        );
    }
}
add_action('wp_enqueue_scripts', 'my_widget_assets');

// Add loading animation to page head - because we need it there from the start
function add_loading_animation_to_head()
{
    // Only add on frontend, not in admin or Elementor editor
    if (is_admin() || (defined('ELEMENTOR_VERSION') && \Elementor\Plugin::$instance->editor->is_edit_mode())) {
        return;
    }
    ?>
    <!-- <div id="ebp-loading-overlay">
        <div class="ebp-loading-content"></div>
    </div> -->
    <?php
}
add_action('wp_head', 'add_loading_animation_to_head', 1);