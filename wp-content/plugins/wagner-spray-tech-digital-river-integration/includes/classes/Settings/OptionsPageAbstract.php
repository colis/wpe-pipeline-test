<?php
/**
 * Wagner Spray Tech Digital River Integration Settings Functionality
 *
 * @package WagnerSprayTechDigitalRiverIntegration\Settings
 */

namespace WagnerSprayTechDigitalRiverIntegration\Settings;

use WagnerSprayTechCore\BaseAbstract;

/**
 * Abstract Options Page.
 */
abstract class OptionsPageAbstract extends BaseAbstract {

	/**
	 * Options page name.
	 *
	 * @var string
	 */
	public string $option_name = '';

	/**
	 * Add the options page to the menu.
	 */
	public function add_options_page(): void {
		\add_menu_page(
			$this->get_page_title(),
			$this->get_menu_title(),
			$this->get_capability(),
			$this->get_menu_slug(),
			[ $this, 'render' ],
			$this->get_menu_icon(),
			$this->get_menu_position()
		);
	}

	/**
	 * Get the options page title.
	 *
	 * @return string
	 */
	abstract protected function get_page_title(): string;

	/**
	 * Get the options page menu title.
	 *
	 * @return string
	 */
	protected function get_menu_title(): string {
		return $this->get_page_title();
	}

	/**
	 * Get the capability required to view the options page.
	 *
	 * @return string
	 */
	protected function get_capability(): string {
		return 'install_plugins';
	}

	/**
	 * Get the options page menu slug.
	 *
	 * This slug must be unique.
	 *
	 * @return string
	 */
	abstract protected function get_menu_slug(): string;

	/**
	 * Get the icon of the options page.
	 *
	 * @return string
	 */
	protected function get_menu_icon(): string {
		return '';
	}

	/**
	 * Get the position in the menu order this item should appear.
	 *
	 * @return int
	 */
	protected function get_menu_position(): int {
		return 59;
	}

	/**
	 * Add a submenu page.
	 */
	public function add_submenu_page(): void {
		\add_submenu_page(
			$this->get_parent_slug(),
			$this->get_page_title(),
			$this->get_menu_title(),
			$this->get_capability(),
			$this->get_menu_slug(),
			[ $this, 'render' ]
		);
	}

	/**
	 * Get the parent slug of the options page.
	 *
	 * @return string
	 */
	protected function get_parent_slug(): string {
		return '';
	}

	/**
	 * Render the options page.
	 */
	abstract public function render();

	/**
	 * Render a form field for a plugin option.
	 *
	 * @param array $args Extra arguments used when outputting the field.
	 */
	public function render_option_form_field( array $args ): void {
		// Retrieve the settings.
		$settings = self::get_plugin_settings();

		// Get settings id, name and value.
		$id          = $args['id'];
		$name        = $this->option_name . "[{$id}]";
		$value       = $settings[ $id ] ?? '';
		$description = $args['description'];
		$type        = $args['type'];
		$class       = $args['class'];

		switch ( $type ) {
			case 'checkbox':
				$this->render_checkbox( $id, $name, $description, $value, $type, $class );
				break;
			case 'number':
				$this->render_number( $id, $name, $description, $value, $type, $class );
				break;
			default:
				$this->render_form_field( $id, $name, $description, $value, $type, $class );
				break;
		}
	}

	/**
	 * Get plugin settings stored in wp_options.
	 *
	 * @return array $option_value Plugin settings array
	 */
	public function get_plugin_settings(): array {
		$option_value = \get_option( $this->option_name );

		return ( ! empty( $option_value ) ) ? $option_value : [];
	}

	/**
	 * Render a checkbox.
	 *
	 * @param string $id The field id.
	 * @param string $name The field name.
	 * @param string $description The field description.
	 * @param string $value The field value.
	 * @param string $type The field type.
	 * @param string $class_name The field class.
	 */
	protected function render_checkbox( string $id, string $name, string $description, string $value = '', string $type = 'checkbox', string $class_name = '' ): void {
		?>
		<input
			id="<?php echo \esc_attr( $id ); ?>"
			name="<?php echo \esc_attr( $name ); ?>"
			type="<?php echo \esc_attr( $type ); ?>"
			class="<?php echo \esc_attr( $class_name ); ?>"
			value="1"
			<?php checked( 1, $value ); ?>
		/>
		<label class="description"
				for="<?php echo \esc_attr( $id ); ?>"><?php echo \esc_html( $description ); ?></label>
		<?php
	}

	/**
	 * Render a number.
	 *
	 * @param string $id The field id.
	 * @param string $name The field name.
	 * @param string $description The field description.
	 * @param string $value The field value.
	 * @param string $type The field type.
	 * @param string $class_name The field class.
	 */
	protected function render_number( string $id, string $name, string $description, string $value = '', string $type = 'number', string $class_name = '' ): void {
		?>
		<input
			id="<?php echo \esc_attr( $id ); ?>"
			name="<?php echo \esc_attr( $name ); ?>"
			type="<?php echo \esc_attr( $type ); ?>"
			class="<?php echo \esc_attr( $class_name ); ?>"
			value="<?php echo \esc_attr( $value ?: 0 ); // phpcs:ignore WordPress.PHP.DisallowShortTernary.Found ?>"
			min="0"
		/>
		<p class="description"><?php echo \esc_html( $description ); ?></p>
		<?php
	}

	/**
	 * Render a form field.
	 *
	 * @param string $id The field id.
	 * @param string $name The field name.
	 * @param string $description The field description.
	 * @param string $value The field value.
	 * @param string $type The field type.
	 * @param string $class_name The field class.
	 */
	protected function render_form_field( string $id, string $name, string $description, string $value = '', string $type = 'text', string $class_name = '' ): void {
		?>
		<input
			id="<?php echo \esc_attr( $id ); ?>"
			name="<?php echo \esc_attr( $name ); ?>"
			type="<?php echo \esc_attr( $type ); ?>"
			class="<?php echo \esc_attr( $class_name ); ?>"
			value="<?php echo \esc_attr( $value ); ?>"
		/>
		<p class="description"><?php echo \esc_html( $description ); ?></p>
		<?php
	}

	/**
	 * Configure the options page.
	 */
	abstract public function configure(): void;

	/**
	 * Retrieve given key from settings.
	 *
	 * @param array  $settings Plugin settings.
	 * @param string $option_key Option key to retrieve.
	 *
	 * @return mixed|false Setting value or false.
	 */
	public function get_plugin_option( array $settings, string $option_key ): mixed {
		$parsed_key = "wst_dr_integration_{$option_key}";

		if ( array_key_exists( $parsed_key, $settings ) ) {
			return $settings[ $parsed_key ];
		}

		return false;
	}

	/**
	 * Wrapper method for the built-in add_settings_field function.
	 *
	 * @param array $args Field arguments.
	 */
	protected function add_settings_field( array $args ): void {
		\add_settings_field(
			$args['id'],
			$args['label'],
			[ $this, 'render_option_form_field' ],
			$this->get_menu_slug(),
			$args['section'],
			[
				'id'          => $args['id'],
				'description' => $args['description'],
				'type'        => $args['type'],
				'class'       => $args['class'],
			]
		);
	}

	/**
	 * Always set an option, even if it exists.
	 *
	 * @param string           $option Option name.
	 * @param mixed            $value Option value.
	 * @param string|bool|null $autoload Optional. Whether to load the option when WordPress starts up.
	 *
	 * @return void
	 */
	protected function set_option( string $option, mixed $value, string|bool $autoload = null ): void {
		if ( ! add_option( $option, $value, '', $autoload ) ) {
			update_option( $option, $value, $autoload );
		}
	}
}
