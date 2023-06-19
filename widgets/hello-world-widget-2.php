<?php
class Elementor_Hello_World_Widget_2 extends \Elementor\Widget_Base
{

  public function get_name()
  {
    return 'hello_world_widget_2';
  }

  public function get_title()
  {
    return esc_html__('Hello World 2', 'elementor-addon');
  }

  public function get_icon()
  {
    return 'eicon-code';
  }

  public function get_categories()
  {
    return ['basic'];
  }

  public function get_keywords()
  {
    return ['hello', 'world'];
  }

  protected function register_controls()
  {

    // Content Tab Start

    $this->start_controls_section(
      'section_title',
      [
        'label' => esc_html__('Title', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => esc_html__('Title', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => esc_html__('Hello world', 'elementor-addon'),
      ]
    );

    $this->end_controls_section();

    // Content Tab End


    // Style Tab Start

    $this->start_controls_section(
      'section_title_style',
      [
        'label' => esc_html__('Title', 'elementor-addon'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'title_color',
      [
        'label' => esc_html__('Text Color', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .hello-world' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'title_text_decoration',
      [
        'label' => esc_html__('Text Decoration', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
          'none' => esc_html__('None', 'elementor-addon'),
          'underline' => esc_html__('Underline', 'elementor-addon'),
          'overline' => esc_html__('Overline', 'elementor-addon'),
          'line-through' => esc_html__('Line Through', 'elementor-addon'),
        ],
        'default' => 'none',
        'selectors' => [
          '{{WRAPPER}} .hello-world' => 'text-decoration: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'title_text_transform',
      [
        'label' => esc_html__('Text Transform', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
          'none' => esc_html__('None', 'elementor-addon'),
          'uppercase' => esc_html__('Uppercase', 'elementor-addon'),
          'lowercase' => esc_html__('Lowercase', 'elementor-addon'),
          'capitalize' => esc_html__('Capitalize', 'elementor-addon'),
        ],
        'default' => 'none',
        'selectors' => [
          '{{WRAPPER}} .hello-world' => 'text-transform: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'title_alignment',
      [
        'label' => esc_html__('Alignment', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => esc_html__('Left', 'elementor-addon'),
            'icon' => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => esc_html__('Center', 'elementor-addon'),
            'icon' => 'eicon-text-align-center',
          ],
          'right' => [
            'title' => esc_html__('Right', 'elementor-addon'),
            'icon' => 'eicon-text-align-right',
          ],
        ],
        'default' => 'left',
        'selectors' => [
          '{{WRAPPER}} .hello-world' => 'text-align: {{VALUE}};',
        ],
        'condition' => [
          'title!' => '',
        ],
      ]
    );

    $this->add_control(
      'custom_css',
      [
        'label' => esc_html__('Custom CSS', 'elementor-addon'),
        'type' => \Elementor\Controls_Manager::CODE,
        'language' => 'css',
        'selectors' => [
          '{{WRAPPER}} .hello-world' => '{{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();

    // Style Tab End

  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    ?>

    <p class="hello-world">
      <?php echo $settings['title']; ?>
    </p>

    <?php
  }
}