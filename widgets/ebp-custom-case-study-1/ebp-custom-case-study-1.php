<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Case_Study_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_case_study_1';
    }

    public function get_title()
    {
        return __('EBP Custom Case Study 1', 'ebp-custom-widgets');
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
        return ['ebp-custom-case-study-1-style'];
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

        // Key Challenge rich text control
        $this->add_control(
            'key_challenge_content',
            [
                'label' => __('Key Challenge', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter your key challenge content', 'ebp-custom-widgets'),
            ]
        );

        // Our Approach rich text control
        $this->add_control(
            'our_approach_content',
            [
                'label' => __('Our Approach', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter your approach content', 'ebp-custom-widgets'),
            ]
        );

        // Right side heading control
        $this->add_control(
            'right_heading',
            [
                'label' => __('Right Side Heading', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Enter heading for right side', 'ebp-custom-widgets'),
            ]
        );

        // Right side rich text control
        $this->add_control(
            'right_content',
            [
                'label' => __('Right Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter your right side content', 'ebp-custom-widgets'),
            ]
        );

        // Result rich text control
        $this->add_control(
            'result_content',
            [
                'label' => __('Result Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter your result content', 'ebp-custom-widgets'),
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

        // Background color control
        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-case-study-1' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Font color control (for body text)
        $this->add_control(
            'font_color',
            [
                'label' => __('Font Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ebp-custom-case-study-1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-case-study-1 p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-case-study-1 li' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .ebp-custom-case-study-1 h1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-case-study-1 h2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-case-study-1 h3' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-case-study-1 h4' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-case-study-1 h5' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ebp-custom-case-study-1 h6' => 'color: {{VALUE}};',
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

        // Get content settings
        $key_challenge_content = !empty($settings['key_challenge_content']) ? $settings['key_challenge_content'] : '';
        $our_approach_content = !empty($settings['our_approach_content']) ? $settings['our_approach_content'] : '';
        $right_heading = !empty($settings['right_heading']) ? $settings['right_heading'] : '';
        $right_content = !empty($settings['right_content']) ? $settings['right_content'] : '';
        $result_content = !empty($settings['result_content']) ? $settings['result_content'] : '';

        // Get spacing settings
        $wrapper_margin_block = !empty($settings['wrapper_margin_block']) ? $settings['wrapper_margin_block'] : '';
        $margin_block_end = !empty($settings['margin_block_end']) ? $settings['margin_block_end'] : '';
        $margin_block_start = !empty($settings['margin_block_start']) ? $settings['margin_block_start'] : '';
        $content_padding_block_start = !empty($settings['content_padding_block_start']) ? $settings['content_padding_block_start'] : '';
        $padding_block = !empty($settings['padding_block']) ? $settings['padding_block'] : '';

        // Build wrapper classes - combine margin-block with margin-block-start and margin-block-end
        $wrapper_classes = array_filter([$wrapper_margin_block, $margin_block_start, $margin_block_end]);
        $wrapper_class_string = !empty($wrapper_classes) ? implode(' ', $wrapper_classes) : '';

        // Build content div classes - combine padding-block-start with padding-block
        $content_classes = array_filter([$content_padding_block_start, $padding_block]);
        $content_class_string = !empty($content_classes) ? implode(' ', $content_classes) : '';

        ?>
<!-- Case Study 1 -->

<div class="ebp-custom-case-study-1">
    <div class="wrapper <?php echo esc_attr($wrapper_class_string); ?>">
        <div
            class="ebp-custom-case-study-1__content grid equal-grid gap-medium <?php echo esc_attr($content_class_string); ?>">
            <!-- left side -->
            <div class="ebp-custom-case-study-1__content__left">
                <div class="ebp-custom-case-study-1__content__challenges">
                    <!-- Key Challenge rich text -->
                    <?php if (!empty($key_challenge_content)): ?>
                    <?php echo wp_kses_post($key_challenge_content); ?>
                    <?php endif; ?>
                </div>

                <div class="ebp-custom-case-study-1__content__approach">
                    <!-- Our Approach rich text -->
                    <?php if (!empty($our_approach_content)): ?>
                    <?php echo wp_kses_post($our_approach_content); ?>
                    <?php endif; ?>
                </div>

            </div>

            <!-- right side -->
            <div class="ebp-custom-case-study-1__content__right  ">
                <div class="ebp-custom-case-study-1__content__takeaways">
                    <!-- heading -->
                    <?php if (!empty($right_heading)): ?>
                    <h2><?php echo esc_html($right_heading); ?></h2>
                    <?php endif; ?>

                    <div class="ebp-custom-case-study-1__content__takeaways__container">
                        <img src="/wp-content/uploads/2025/11/llm-icon-outline-yellow.svg" alt="icon">
                        <div class="ebp-custom-case-study-1__content__takeaways__container__content">
                            <?php if (!empty($right_content)): ?>
                            <?php echo wp_kses_post($right_content); ?>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>


                <!-- result -->
                <div class="ebp-custom-case-study-1__content__result">
                    <?php if (!empty($result_content)): ?>
                    <?php echo wp_kses_post($result_content); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
    }
}