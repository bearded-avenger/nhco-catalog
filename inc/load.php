<?php

class baEDDCatalogLoader {

    const version = '1.0';

    function __construct() {

        $this->dir  		= plugin_dir_path( __FILE__ );
        $this->url  		= plugins_url( '', __FILE__ );

        add_action( 'admin_init', array($this,'plugin_admin_init' ));
        add_action( 'admin_menu', array($this,'menu_page' ));

    }

	function menu_page(){
	    $menu = add_menu_page( 'NH & CO Catalog', 'NH & CO Catalog', 'manage_options', 'nh-catalog', array($this,'draw_menu_page'), plugins_url( 'icon.png', __FILE__ ),100 );
		add_action( 'admin_print_styles-' . $menu, array($this,'admin_custom_css' ));
	}

	function draw_menu_page(){

		$site 	= 'http://nickhaskins.co';

		?><div class="ba-nhco-catalog-head row">

			<div class="col-md-4 ba-nhco-catalog-welcome">
				<img class="ba-nhco-catalog-logo" src="<?php echo plugins_url('../img/logo.png', __FILE__) ?>">
				<h2 class="ba-nhco-catalog-title">Product Catalog</h2>
				<p class="ba-nhco-catalog-site"><a href="http://nickhaskins.co" target="_blank">http://nickhaskins.co</a></p>
			</div>

			<div class="col-md-8 ba-nhco-catalog-news-feed">
				<h2 class="ba-nhco-news-title">Latest news</h2>
				<a class="ba-nhco-news-all" href="http://nickhaskins.co/news" target="_blank">More News &rsaquo;</a>
				<?php echo nhco_catalog_news_feed();?>
			</div>

		</div>

		<div class="ba-nhco-catalog-wrap">

	    	<?php if(function_exists('ba_nhco_catalog_data')) {
	    		echo ba_nhco_catalog_data($site);
	    	} ?>

    	</div>

    	<?php

	}

	function plugin_admin_init() {
	    wp_register_style( 'nhco-catalog-style', $this->url.'/../css/style.css', self::version, true );
	}

	function admin_custom_css() {
       wp_enqueue_style( 'nhco-catalog-style' );

   	}

}

new baEDDCatalogLoader;

