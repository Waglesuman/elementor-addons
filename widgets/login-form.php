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
		return 'eicon-preferences';
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
		<div class="elem-login-form">
			<?php echo wp_login_form(); ?>
		</div>
		<?php
	}
}