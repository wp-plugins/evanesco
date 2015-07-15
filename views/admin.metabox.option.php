<input type="hidden" value="update" name="action">

<h3><?php _e('Menus', EVNSCO_PLUGIN_NAME); ?></h3>

<section id="btns_menus">
	<?php
	foreach ( EVNSCO_Menus_Widgets::$default_menus as $val ) {
		$hide = ( isset( EVNSCO_Menus_Widgets::$menus[$val[5]] ) && EVNSCO_Menus_Widgets::$menus[$val[5]] == "hide" ) ? "hide" : 'show';

		printf( '<button id="%s" class="%s" onclick="return false;"><i></i> %s</button>', $val[5], $hide, __( $val[0], EVNSCO_PLUGIN_NAME ) );
		printf( '<input id="%s-input" name="%s" type="hidden" value="%s" />', $val[5], $val[5], $hide );
	}
	?>
</section>

<br class="clear" />
<h3><?php _e('Widgets', EVNSCO_PLUGIN_NAME); ?></h3>

<section id="btns_widgets">
	<?php
	foreach ( EVNSCO_Menus_Widgets::$default_widgets as $val ) {
		$hide = (isset( EVNSCO_Menus_Widgets::$widgets[$val->id_base] ) && EVNSCO_Menus_Widgets::$widgets[$val->id_base] == "hide") ? "hide" : "show";

		printf( '<button id="widget-%s" class="%s" onclick="return false;"><i></i> %s</button>', $val->id_base, $hide,  __( $val->name, EVNSCO_PLUGIN_NAME ) );
		printf( '<input id="widget-%s-input" name="widget-%s" type="hidden" value="%s" />', $val->id_base, $val->id_base, $hide );
	}
	?>
</section>
