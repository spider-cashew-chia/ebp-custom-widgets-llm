<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Resources_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_resources_1';
    }

    public function get_title()
    {
        return __('EBP Custom Resources 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-file-download';
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
        return ['ebp-custom-resources-1-style'];
    }


    protected function register_controls()
    {

    }


    protected function render()
    {
        // Query to get all helpful_resources posts
        $resources_query = new WP_Query([
            'post_type' => 'helpful_resources',
            'posts_per_page' => -1, // Get all posts
            'post_status' => 'publish', // Only published posts
            'orderby' => 'date',
            'order' => 'DESC'
        ]);

        ?>
<!-- Resources  -->
<div class="ebp-custom-resources-1">
    <div class="wrapper">
        <?php if ($resources_query->have_posts()): ?>
        <?php while ($resources_query->have_posts()):
                        $resources_query->the_post(); ?>
        <div class="ebp-custom-resources-1__content">
            <?php if (get_the_title()): ?>
            <!-- Title -->
            <h3 class="ebp-custom-resources-1__title">
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <?php echo esc_html(get_the_title()); ?>
                </a>
            </h3>
            <?php endif; ?>

            <?php if (get_the_excerpt()): ?>
            <!-- Excerpt -->
            <div class="ebp-custom-resources-1__excerpt">
                <p>
                    <?php echo wp_kses_post(get_the_excerpt()); ?>
                </p>
            </div>
            <?php endif; ?>

            <!-- Link to single page -->
            <a href="<?php echo esc_url(get_permalink()); ?>" class="ebp-custom-resources-1__link">
                Read the <?php the_title() ?> &#10141;
            </a>
        </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); // Reset post data after custom query ?>
        <?php else: ?>
        <p>No resources found.</p>
        <?php endif; ?>
    </div>
</div>

<?php
    }
}