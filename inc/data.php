<?php

if(!function_exists('ba_nhco_catalog_data')){
	function ba_nhco_catalog_data($site = '') {

	    $apiurl = sprintf('%s/edd-api/products/?number=-1',$site);

	    $transientKey = 'nhCoCatalog-1118131101';

	    $cached = get_transient($transientKey);

	    if (false !== $cached) {
	       	return $cached;
	    }

	    $remote = wp_remote_get($apiurl);

	    if (is_wp_error($remote)) {
	        return '256';
	    }

	    $data = json_decode( $remote['body'],true);
	    $total = isset($data['products']) ? count($data['products']) : false;

		$getexcluded = 'billable-hours';

	    // action
	    do_action('edd_catalog_before');

	    // start output
	    $output = sprintf('<div class="ba-nhco-catalog-wrapper">');

		//action
	    do_action('edd_catalog_inside_top'); // action

		    for($i=0; $i<$total; $i++) {

		    	$exclude 	= $getexcluded == $data['products'][$i]['info']['slug'];

			   	if ( !in_array($exclude, $data) ):

			   		// get some vars ready
				    $getname 		= isset($data['products'][$i]['info']['title']) ? $data['products'][$i]['info']['title'] : false;
				    $getprice 		= isset($data['products'][$i]['pricing']['amount']) ? $data['products'][$i]['pricing']['amount'] : false;
				    $getimg 		= isset($data['products'][$i]['info']['thumbnail']) ? $data['products'][$i]['info']['thumbnail'] : false;
				    $getlink 		= isset($data['products'][$i]['info']['link']) ? $data['products'][$i]['info']['link'] : false;
				    $slug 			= isset($data['products'][$i]['info']['slug']) ? $data['products'][$i]['info']['slug'] : false;

				    // get plugin path check if installed
					$plugin 		= sprintf('%s/%s.php',$slug,$slug);
				    $isinstalled 	= is_plugin_active($plugin);

				    $image 			= true == $isinstalled ? sprintf('<a class="ba-nhco-catalog-img-link" target="_blank"><img src="%s"></a>',$getimg) : sprintf('<a class="ba-nhco-catalog-img-link" href="%s" target="_blank"><img src="%s"></a>',$getlink,$getimg);
				    $link 			= true == $isinstalled ? sprintf('<a class="ba-nhco-catalog-notify installed">installed</a>') : sprintf('<a class="ba-nhco-catalog-notify" href="%s">Buy Now %s</a>',$getlink,$getprice);
				    $installclass   = true == $isinstalled ? 'is-installed' : false;

				    // title
				    $title 			= sprintf('<h3 class="ba-nhco-catalog-item-title">%s</h3>',$getname);

				    // output
				    $output 		.= sprintf('<div class="ba-nhco-catalog-item-wrap"><div class="ba-nhco-catalog-item %s">%s<div class="ba-nhco-catalog-item-inner">%s%s</div></div></div>',$installclass,$title,$image,$link);

			    endif;
			}

		do_action('edd_catalog_inside_bottom'); // action

		$output .= sprintf('</div>');

	    set_transient($transientKey, $output, 12 * HOUR_IN_SECONDS);

	    return apply_filters('ba-nhco_catalog_output',$output);
	}
}