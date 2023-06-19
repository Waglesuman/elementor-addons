<?php
class Elementor_login_form extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'login_form';
	}

	public function get_title()
	{
		return esc_html__('Login Form', 'elementor-addon');
	}

	public function get_icon()
	{
		// return 'eicon-code';
		return 'eicon-theme-builder';
	}

	public function get_categories()
	{
		return ['basic'];
	}

	public function get_keywords()
	{
		return ['login', 'form'];
	}

	protected function render()
	{
		?>
		<p>
			<?php echo wp_login_form(); ?>
		</p>
		<?php
	}
}