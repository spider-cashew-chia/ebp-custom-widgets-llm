<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Blog_Hub_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_blog_hub_1';
    }

    public function get_title()
    {
        return __('EBP Custom Blog Hub 1', 'ebp-custom-widgets');
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
        return ['ebp-custom-blog-hub-1-style'];
    }


    protected function register_controls()
    {

    }


    protected function render()
    {
        // Query posts from the 'blog' custom post type
        $blog_query = new \WP_Query([
            'post_type' => 'blog',
            'posts_per_page' => -1, // Get all blog posts
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'ASC'
        ]);

        ?>
<!-- Blog Hub  -->
<div class="ebp-custom-blog-hub-1 margin-block-end-large">
    <div class="wrapper">
        <div class="ebp-custom-blog-hub-1__inner grid-masonry">
            <?php if ($blog_query->have_posts()): ?>
            <?php while ($blog_query->have_posts()):
                            $blog_query->the_post(); ?>
            <!-- Blog post item -->
            <a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('Read more about ' . get_the_title()); ?>">
                <div class="ebp-custom-blog-hub-1__item">
                    <div class="ebp-custom-blog-hub-1__item-inner">
                        <?php if (has_post_thumbnail()): ?>
                        <!-- Blog post featured image -->
                        <div class="ebp-custom-blog-hub-1__item-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                        <?php endif; ?>
                        <div class="animated-text">
                            <!-- Blog post title -->
                            <h3 class="ebp-custom-blog-hub-1__item-title">
                                <?php the_title(); ?>
                            </h3>
                            <!-- Read more text for visual hint and context -->
                            <p class="ebp-custom-blog-hub-1__item-read-more"><?php _e('Read more', 'ebp-custom-widgets'); ?></p>
                        </div>

                    </div>
                </div>
            </a>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            <?php else: ?>
            <!-- No blog posts found message -->
            <p><?php _e('No blog posts found.', 'ebp-custom-widgets'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    }
}