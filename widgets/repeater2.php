<?php
class Elementor_Repeater_Widget extends \Elementor\Widget_Base
{
  public function get_name()
  {
    return 'elementor_test_widget1';
  }

  public function get_title()
  {
    return esc_html__('Repeater2', 'elementor-addon');
  }

  // loads style.css in the header
  public function get_style_depends()
  {
    return ['repeater-widget'];
  }

  // loads script in the footer
  public function get_script_depends()
  {
    return ['repeater-widget'];
  }

  // displays icon in the sidebar panel
  public function get_icon()
  {
    return 'eicon-theme-builder';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  // useful while searching for the widget in the panel
  public function get_keywords()
  {
    return ['repeater1', 'repeater'];
  }

  protected function register_controls()
  {
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
      'list_link',
      [
        'label' => esc_html__('Link', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::URL,
        'default' => [
          'url' => '',
        ],
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'list_image',
      [
        'label' => esc_html__('Image', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => '',
        ],
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'list_content',
      [
        'label' => esc_html__('Content', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => esc_html__('List Content', 'elementor-addon'),
        'show_label' => false,
      ]
    );

    $repeater->add_control(
      'list_color',
      [
        'label' => esc_html__('Color', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
        ],
      ]
    );

    $this->add_control(
      'list',
      [
        'label' => esc_html__('Repeater List', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'list_title' => esc_html__('Title #1', 'elementor-addon'),
            'list_content' => esc_html__('Item content. Click the edit button to change this text.', 'elementor-addon'),
          ],
        ],
        'title_field' => '{{{ list_title }}}',
      ]
    );

    $this->end_controls_section();
  }
  protected function render()
  {
    $settings = $this->get_settings_for_display();

    if ($settings['list']) {
      echo '<div class="elementor-repeater-items">';

      echo '<div class="elementor-repeater-container">'; // Add a container element

      foreach ($settings['list'] as $item) {
        echo '<div class="elementor-repeater-item">';
        echo '<h3 class="elementor-repeater-item-title">' . $item['list_title'] . '</h3>';
        if ($item['list_image']['url']) {
          echo '<img src="' . $item['list_image']['url'] . '" alt="' . $item['list_title'] . '" class="elementor-repeater-item-image">';
        }
        echo '<div class="elementor-repeater-item-content">' . $item['list_content'] . '</div>';

        // if ($item['list_link']['url']) {
        //   echo '<a href="' . $item['list_link']['url'] . '" class="elementor-repeater-item-link">' . esc_html__('button', 'elementor-addon') . '</a>';
        // }

        echo '<a href="' . $item['list_link']['url'] . '" class="elementor-repeater-item-link">' . esc_html__('button', 'elementor-addon') . '</a>';


        echo '</div>';
      }

      echo '</div>'; // Close the container element

      echo '</div>';
    ?>
    <?php
    }
  }

  protected function content_template()
  {
    ?>
    <# if ( settings.list.length ) { #>
      <div class="elementor-repeater-items">
        <div class="elementor-repeater-container"> <!-- Add a container element -->
          <# _.each( settings.list, function( item ) { #>
            <div class="elementor-repeater-item">
              <h3 class="elementor-repeater-item-title">{{{ item.list_title }}}</h3>
              <# if ( item.list_image && item.list_image.url ) { #>
                <img src="{{ item.list_image.url }}" alt="{{ item.list_title }}" class="elementor-repeater-item-image">
                <# } #>
                  <div class="elementor-repeater-item-content">{{{ item.list_content }}}</div>
                  <!-- <# if ( item.list_link && item.list_link.url ) { #>
                    <a href="{{ item.list_link.url }}" class="elementor-repeater-item-link">
                      <?php // esc_html_e('button', 'elementor-addon'); ?>
                    </a>
                    <# } #> -->
                  <a href="{{ item.list_link.url }}" class="elementor-repeater-item-link">
                    <?php esc_html_e('button', 'elementor-addon'); ?>
                  </a>
            </div>
            <# }); #>
        </div> <!-- Close the container element -->
      </div>
      <# } #>
        <?php
  }

}