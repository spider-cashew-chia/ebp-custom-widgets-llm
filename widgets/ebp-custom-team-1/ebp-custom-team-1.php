<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Team_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_team_1';
    }

    public function get_title()
    {
        return __('EBP Custom Team 1', 'ebp-custom-widgets');
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
        return ['ebp-custom-team-1-style'];
    }


    protected function register_controls()
    {
        // Start content section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Team Members', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Repeater control for team members
        $repeater = new \Elementor\Repeater();

        // Image control for team member photo
        $repeater->add_control(
            'member_image',
            [
                'label' => __('Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Text control for team member name
        $repeater->add_control(
            'member_name',
            [
                'label' => __('Name', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Team Member Name', 'ebp-custom-widgets'),
                'placeholder' => __('Enter team member name', 'ebp-custom-widgets'),
            ]
        );

        // Text control for team member role
        $repeater->add_control(
            'member_role',
            [
                'label' => __('Role', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Team Member Role', 'ebp-custom-widgets'),
                'placeholder' => __('Enter team member role', 'ebp-custom-widgets'),
            ]
        );

        // Add the repeater to the main control
        $this->add_control(
            'team_members',
            [
                'label' => __('Team Members', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'member_name' => __('Team Member Name', 'ebp-custom-widgets'),
                        'member_role' => __('Team Member Role', 'ebp-custom-widgets'),
                    ],
                ],
                'title_field' => '{{{ member_name }}}',
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get the team members from the repeater control
        $settings = $this->get_settings_for_display();
        $team_members = $settings['team_members'];

        ?>
<!-- Team  -->
<div class="ebp-custom-team-1 margin-block-end-large">
    <div class="wrapper">
        <div class="ebp-custom-team-1__inner grid-masonry">
            <?php if (!empty($team_members)): ?>
            <?php foreach ($team_members as $member): ?>
            <!-- Team member item -->
            <div class="ebp-custom-team-1__item">
                <div class="ebp-custom-team-1__item-inner">
                    <?php if (!empty($member['member_image']['url'])): ?>
                    <!-- Team member image -->
                    <div class="ebp-custom-team-1__item-image">
                        <img src="<?php echo esc_url($member['member_image']['url']); ?>"
                            alt="<?php echo esc_attr($member['member_name']); ?>">
                    </div>
                    <?php endif; ?>

                    <div class="animated-text">
                        <?php if (!empty($member['member_name'])): ?>
                        <!-- Team member name -->
                        <div class="ebp-custom-team-1__item-name">
                            <h3>
                                <?php echo esc_html($member['member_name']); ?>
                            </h3>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($member['member_role'])): ?>
                        <!-- Team member role -->
                        <div class="ebp-custom-team-1__item-role">
                            <?php echo esc_html($member['member_role']); ?>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    }
}