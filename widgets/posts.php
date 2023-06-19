<?php
class Elementor_Post_Widget extends \Elementor\Widget_Base
{
  public function get_name()
  {
    return 'elementor_Post_widget';
  }

  public function get_title()
  {
    return esc_html__('Posts', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-plus-circle';
  }
  // loads style.css in the header
  public function get_style_depends()
  {
    return ['repeater-widget'];
  }
  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['repeater', 'post', 'posts'];
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

    $this->add_control(
      'list_title',
      [
        'label' => esc_html__('Title', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('List Title', 'elementor-addon'),
        'label_block' => true,
      ]
    );

    $this->add_control(
      'list_post_type',
      [
        'label' => esc_html__('Post Type', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'post',
        'options' => $post_types_options,
      ]
    );

    $this->add_control(
      'list_category',
      [
        'label' => esc_html__('Category', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '',
        'options' => $categories_options,
      ]
    );

    $this->add_control(
      'list_count',
      [
        'label' => esc_html__('Number of Posts', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => -1,
        'default' => -1,
      ]
    );

    $this->add_control(
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

    $this->add_control(
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

    $this->add_control(
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

    $this->add_control(
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

    $this->add_control(
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

    $this->add_control(
      'background_color',
      [
        'label' => esc_html__('Background Color', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .elementor-repeater-item' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_section();
  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();

    if ($settings['list_title']) {
      echo '<h3 class="elementor-repeater-item-title">' . esc_html($settings['list_title']) . '</h3>';
    }

    $args = [
      'posts_per_page' => $settings['list_count'],
      'order' => $settings['list_order'],
    ];

    if (!empty($settings['list_post_type'])) {
      $args['post_type'] = $settings['list_post_type'];
    }

    if (!empty($settings['list_category'])) {
      $args['cat'] = $settings['list_category'];
    }

    $query = new WP_Query($args);
    if ($query->have_posts()) {
      echo '<div class="elementor-repeater-items">';
      $item_index = 1;
      while ($query->have_posts()) {
        $query->the_post();
        $style = '';
        if (!empty($settings['background_color'])) {
          $style .= 'background-color: ' . $settings['background_color'] . ';';
        }

        // Add a unique class for each item
        echo '<div class="' . $settings['item_per_row'] . ' item-' . $item_index . '" style="' . $style . '">';

        echo '<h3 class="elementor-repeater-item-title">' . get_the_title() . '</h3>';

        if ($settings['show_featured_image'] === 'yes' && has_post_thumbnail()) {
          $featured_image_position = $settings['featured_image_position'];

          if ($featured_image_position === 'above_content') {
            echo '<div class="elementor-repeater-item-image">';
            the_post_thumbnail($settings['featured_image_size']);
            echo '</div>';
          }
        }

        $content = get_the_content();
        $trimmed_content = wp_trim_words($content, 50);

        echo '<div class="elementor-repeater-item-content">' . $trimmed_content . '</div>';

        if ($settings['show_featured_image'] === 'yes' && has_post_thumbnail()) {
          $featured_image_position = $settings['featured_image_position'];

          if ($featured_image_position === 'below_content') {
            echo '<div class="elementor-repeater-item-image">';
            the_post_thumbnail($settings['featured_image_size']);
            echo '</div>';
          }
        }

        if (str_word_count($content) > 50) {
          echo '<a href="' . get_permalink() . '" target="_blank" class="elementor-repeater-item-seemore">See More...</a>';
        }

        echo '</div>';
        $item_index++;
      }
      echo '</div>';
      wp_reset_postdata();
    }
  }
}