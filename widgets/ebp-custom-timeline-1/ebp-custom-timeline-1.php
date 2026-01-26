<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Timeline_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_timeline_1';
    }

    public function get_title()
    {
        return __('EBP Custom Timeline 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-time-line';
    }

    public function get_categories()
    {
        return ['ebp-custom-widgets'];
    }

    // Enqueue widget assets
    public function get_script_depends()
    {
        return ['ebp-custom-timeline-1-script'];
    }

    public function get_style_depends()
    {
        return ['ebp-custom-timeline-1-style'];
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

        // Background color control
        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-timeline-1' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Font color control
        $this->add_control(
            'font_color',
            [
                'label' => __('Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-timeline-1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .nav-button--container__line' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Query to get all history posts
        $history_query = new WP_Query([
            'post_type' => 'history',
            'posts_per_page' => -1, // Get all posts
            'post_status' => 'publish', // Only published posts
            'orderby' => 'title',
            'order' => 'ASC'
        ]);

        ?>
<!-- Timeline Slider -->
<div class="ebp-custom-timeline-1 padding-block-end-large ">
    <div class="wrapper">
        <div class="ebp-custom-timeline-1__slider-container">

            <div class="nav-button--container">
                <div class="nav-button--container__line"></div>
                <!-- Navigation Buttons -->
                <button class="ebp-custom-timeline-1__nav-btn ebp-custom-timeline-1__nav-btn--prev"
                    aria-label="Previous">
                    <span> <img src="/wp-content/uploads/2025/11/llm-triangle-light.svg" alt="Previous"></span>
                </button>
                <button class="ebp-custom-timeline-1__nav-btn ebp-custom-timeline-1__nav-btn--next" aria-label="Next">
                    <span> <img src="/wp-content/uploads/2025/11/llm-triangle-light.svg" alt="Next"></span>
                </button>

            </div>

            <!-- Swiper Slider -->
            <div class="swiper ebp-custom-timeline-1__slider-track">
                <div class="swiper-wrapper">
                    <?php if ($history_query->have_posts()): ?>
                    <?php while ($history_query->have_posts()):
                                    $history_query->the_post(); ?>
                    <div class="swiper-slide">
                        <div class="ebp-custom-timeline-1__content-item">
                            <?php if (get_the_title()): ?>
                            <!-- Title -->
                            <h3 class="ebp-custom-timeline-1__title">
                                <span><?php echo esc_html(get_the_title()); ?></span>
                                <span><img src="/wp-content/uploads/2025/11/llm-triangle-light.svg"
                                        alt="Previous"></span>
                            </h3>
                            <?php endif; ?>

                            <?php if (get_the_content()): ?>
                            <!-- Content -->
                            <div class="ebp-custom-timeline-1__content-text">
                                <?php echo wp_kses_post(get_the_content()); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); // Reset post data after custom query ?>
                    <?php else: ?>
                    <div class="swiper-slide">
                        <p>No history items found.</p>
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