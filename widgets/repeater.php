<?php
class Elementor_Test_Widget extends \Elementor\Widget_Base
{
  public function get_name()
  {
    return 'elementor_test_widget';
  }

  public function get_title()
  {
    return esc_html__('Repeater', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-theme-builder';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['repeater'];
  }

  protected function register_controls()
  {
    $post_types = get_post_types(['public' => true], 'objects');
    $post_types_options = wp_list_pluck($post_types, 'label', 'name');

    $categories = get_categories(['exclude' => get_option('default_category')]);

    $categories_options = wp_list_pluck($categories, 'name', 'term_id');

    $this->start_controls_section(
      'content_section',
      [
        'label' => esc_html__('Content', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'list_title',
      [
        'label' => esc_html__('Title', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('List Title', 'elementor-addon'),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'list_post_type',
      [
        'label' => esc_html__('Post Type', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'post',
        'options' => $post_types_options,
      ]
    );

    $repeater->add_control(
      'list_category',
      [
        'label' => esc_html__('Category', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '',
        'options' => $categories_options,
      ]
    );

    $repeater->add_control(
      'list_count',
      [
        'label' => esc_html__('Number of Posts', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => -1,
        'default' => -1,
      ]
    );

    $repeater->add_control(
      'item_per_row',
      [
        'label' => esc_html__('Columns', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'elementor-repeater-item-3',
        'options' => [
          'elementor-repeater-item-1' => esc_html__('1', 'elementor-addon'),
          'elementor-repeater-item-2' => esc_html__('2', 'elementor-addon'),
          'elementor-repeater-item-3' => esc_html__('3', 'elementor-addon'),
          'elementor-repeater-item-4' => esc_html__('4', 'elementor-addon'),
          'elementor-repeater-item-5' => esc_html__('5', 'elementor-addon'),
        ],
      ]
    );


    $repeater->add_control(
      'list_order',
      [
        'label' => esc_html__('Sort Order', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'DESC',
        'options' => [
          'ASC' => esc_html__('Ascending', 'elementor-addon'),
          'DESC' => esc_html__('Descending', 'elementor-addon'),
        ],
      ]
    );

    $repeater->add_control(
      'show_featured_image',
      [
        'label' => esc_html__('Show Featured Image', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'elementor-addon'),
        'label_off' => esc_html__('Hide', 'elementor-addon'),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $repeater->add_control(
      'featured_image_position',
      [
        'label' => esc_html__('Image Position', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'above_content',
        'options' => [
          'above_content' => esc_html__('Above Content', 'elementor-addon'),
          'below_content' => esc_html__('Below Content', 'elementor-addon'),
        ],
        'condition' => [
          'show_featured_image' => 'yes',
        ],
      ]
    );

    $repeater->add_control(
      'featured_image_size',
      [
        'label' => esc_html__('Image Size', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'medium',
        'options' => [
          'full' => esc_html__('Original', 'elementor-addon'),
          'large' => esc_html__('Large', 'elementor-addon'),
          'medium' => esc_html__('Medium', 'elementor-addon'),
          'thumbnail' => esc_html__('Small', 'elementor-addon'),
        ],
      ]
    );

    $repeater->add_control(
      'background_color',
      [
        'label' => esc_html__('Background Color', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{CURRENT_ITEM}} .elementor-repeater-item' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'list',
      [
        'label' => esc_html__('Repeater List', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'title_field' => '{{{ list_title }}}',
        'separator' => 'before',
      ]
    );

    $this->end_controls_section();
  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();

    if ($settings['list']) {
      echo '<div class="elementor-repeater-items">';
      foreach ($settings['list'] as $item) {
        $args = [
          'posts_per_page' => $item['list_count'],
          'order' => $item['list_order'],
        ];

        if (!empty($item['list_post_type'])) {
          $args['post_type'] = $item['list_post_type'];
        }

        if (!empty($item['list_category'])) {
          $args['cat'] = $item['list_category'];
        }

        $query = new WP_Query($args);
        if ($query->have_posts()) {
          echo '<div class="elementor-repeater-container">';
          while ($query->have_posts()) {
            $query->the_post();
            $style = '';
            if (!empty($item['background_color'])) {
              $style .= 'background-color: ' . $item['background_color'] . ';';
            }

            echo '<div class="' . $item['item_per_row'] . '" style="' . $style . '">';
            echo '<h3 class="elementor-repeater-item-title">' . get_the_title() . '</h3>';

            if ($item['show_featured_image'] === 'yes' && has_post_thumbnail()) {
              $featured_image_position = $item['featured_image_position'];

              if ($featured_image_position === 'above_content') {
                echo '<div class="elementor-repeater-item-image">';
                the_post_thumbnail($item['featured_image_size']);
                echo '</div>';
              }
            }

            $content = get_the_content();
            $trimmed_content = wp_trim_words($content, 50);

            echo '<div class="elementor-repeater-item-content">' . $trimmed_content . '</div>';

            if ($item['show_featured_image'] === 'yes' && has_post_thumbnail()) {
              $featured_image_position = $item['featured_image_position'];

              if ($featured_image_position === 'below_content') {
                echo '<div class="elementor-repeater-item-image">';
                the_post_thumbnail($item['featured_image_size']);
                echo '</div>';
              }
            }

            
            if (str_word_count($content) > 50) {
              echo '<a href="' . get_permalink() . '" target="_blank" class="elementor-repeater-item-seemore">See More...</a>';
            }

            echo '</div>';
          }
          echo '</div>';
          wp_reset_postdata();
        }
      }
      echo '</div>';
    }
  }
}