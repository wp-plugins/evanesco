<?php
class sjEvanesco {
	static $instance = false;
	private $text_domain = 'evanesco';
	private $plugin_name = 'Evanesco!';
	private $plugin_name_lang;
	private $debug = true;

	private $menus;
	private $widgets;

	private $default_menus;
	private $default_widgets;

	protected function __construct() {
		$this->plugin_name_lang = __($this->plugin_name, $this->text_domain);
		$this->menus = get_option('sj-evanesco-menus');
		$this->widgets = get_option('sj-evanesco-widgets');
		$this->trigger_hooks();

	}

	public static function getInstance() {
		if (!self::$instance)
			self::$instance = new self;

		return self::$instance;
	}

	private function trigger_hooks() {
		global $pagenow;

		add_action('admin_menu', array(&$this, 'trigger_admin_menu'));
		add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'));
		add_action('admin_menu', array(&$this, 'get_menu_n_widget'), 15);

		if ($pagenow == "widgets.php") {
			add_action('widgets_init', array(&$this, 'remove_widgets'));
		}
	}

	public function remove_menus() {
		global $menu;
		$menu_temp = $menu;

		foreach($menu_temp as $key => $value) {
			if ($this->menus[$value[5]] == "hide") {
				unset($menu[$key]);
			}
		}
	}

	public function remove_widgets() {
		global $wp_widget_factory;

		if (function_exists('unregister_widget')) {
			foreach ($wp_widget_factory->widgets as $key => $widget) {
				if ($this->widgets[$widget->id_base] == "hide") {
					unregister_widget($key);
				}
			}
		}
	}

	public function get_menu_n_widget() {
		global $pagenow, $wp_widget_factory, $menu;

		$this->default_widgets = $wp_widget_factory->widgets;
		$this->default_menus = $menu;

		foreach($this->default_menus as $key => $value) {
			if ($value[4] == "wp-menu-separator" || $value[5] == "menu-settings") {
				unset($this->default_menus[$key]);
			} else {
				$sep = explode("<span", $value[0]);
				$this->default_menus[$key][0] = $sep[0];
			}
		}

		$this->remove_menus();

		if ($pagenow == "options-general.php") {
			$this->remove_widgets();
		}
	}

	public function admin_enqueue_scripts() {
		wp_enqueue_style('sujin_' . $this->text_domain, plugin_dir_url( __FILE__ ) . 'style.css');
		wp_enqueue_script('sujin' . $this->text_domain, plugin_dir_url( __FILE__ ) . 'script.js');
	}

	public function trigger_admin_menu() {
		add_options_page($this->plugin_name_lang, $this->plugin_name_lang, 'manage_options', $this->text_domain, array(&$this, 'admin_menu'));
	}

	public function admin_menu() {
		if (isset($_POST['action']) && check_admin_referer($this->text_domain)) {
			foreach ($this->default_menus as $value) {
				$this->menus[$value[5]] = $_POST[$value[5]];
			}
			update_option('sj-evanesco-menus', $this->menus);

			foreach ($this->default_widgets as $value) {
				$this->widgets[$value->id_base] = $_POST["widget-" . $value->id_base];
			}
			update_option('sj-evanesco-widgets', $this->widgets);
			
			$this->redirect();
		}

		$this->print_admin_page();
	}

	private function print_admin_page() {
		?>

		<div class="wrap sj_<?php echo $this->text_domain ?>">
			<div class="icon32" id="icon-options-general"><br></div><h2><?php _e('Evanesco', $this->text_domain); ?></h2>
			<p><?php _e('You can control the visibility of Wordpress menus and widgets', $this->text_domain); ?></p>

			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="donation">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>

			<form method="post" id="<?php echo $this->text_domain ?>">
				<input type="hidden" value="<?php echo $this->text_domain ?>" name="option_page">
				<input type="hidden" value="update" name="action">

				<h3><?php _e('Menus', $this->text_domain); ?></h3>

				<section id="btns_menus">

					<?php foreach ($this->default_menus as $val) { ?>

					<button id="<?php echo $val[5] ?>" class="<?php if (isset($this->menus[$val[5]]) && $this->menus[$val[5]] == "hide") echo "hide"; ?>" onclick="return false;"><i></i> <?php _e($val[0], $this->text_domain) ?></button>
					<input id="<?php echo $val[5] ?>-input" name="<?php echo $val[5] ?>" type="hidden" value="<?php echo (isset($this->menus[$val[5]]) && $this->menus[$val[5]] == "hide") ? "hide" : "show"; ?>" />

					<?php } ?>

				</section>

				<br class="clear" />
				<h3><?php _e('Widgets', $this->text_domain); ?></h3>

				<section id="btns_widgets">

					<?php foreach ($this->default_widgets as $val) { ?>

					<button id="widget-<?php echo $val->id_base ?>" class="<?php if (isset($this->widgets[$val->id_base]) && $this->widgets[$val->id_base] == "hide") echo "hide"; ?>" onclick="return false;"><i></i> <?php _e($val->name, $this->text_domain) ?></button>
					<input id="widget-<?php echo $val->id_base ?>-input" name="widget-<?php echo $val->id_base ?>" type="hidden" value="<?php echo (isset($this->widgets[$val->id_base]) && $this->widgets[$val->id_base] == "hide") ? "hide" : "show"; ?>" />

					<?php } ?>

				</section>

				<?php wp_nonce_field($this->text_domain) ?>

				<p class="submit">
					<input type="submit" value="<?php _e('Save Changes', $this->text_domain); ?>" class="button button-primary" id="submit" name="submit">
					<a href="<?php echo $_SERVER['REQUEST_URI'] ?>" class="button"><?php _e('Cancel', $this->text_domain); ?></a>
				</p>
			</form>
		</div>

		<?php
	}

	private function redirect($url) {
		if (!$url) $url = $_SERVER['HTTP_REFERER'];

		echo '<script>window.location="' . $url . '"</script>';
		die;
	}

	private function debug($array) {
		$style = ($this->debug == false || !is_admin()) ? 'style="display:none;"' : '';
		echo '<pre ' . $style . '>';
		print_r($array);
		echo '</pre>';
	}
}

$sjEvanesco = sjEvanesco::getInstance();