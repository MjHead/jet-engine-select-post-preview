<?php
/**
 * Plugin Name: JetEngine - select post preview
 * Description: Allow to select post for preview for JetEngine listing item
 * Plugin URI:
 * Author: Crocoblock
 * Version: 1.0.0
 */
add_filter( 
	'jet-engine/elementor-views/listing-document/preview-args',
	'jet_engine_select_post_preview_apply', 10, 2 
);

add_filter( 
	'jet-engine/listings/document/preview-args',
	'jet_engine_select_post_preview_apply', 10, 2 
);

add_filter( 
	'jet-engine/listings/document/post-preview-query-args',
	'jet_engine_select_post_preview_apply', 10, 2 
);

add_action(
	'jet-engine/listings/document/custom-source-control', 
	'jet_engine_select_post_preview_control' 
);

function jet_engine_select_post_preview_apply( $args, $listing_item ) {

	$preview_id = $listing_item->get_settings( '_jet_custom_preview_id' );

	if ( $preview_id ) {
		if ( ! empty( $args['p'] ) ) {
			$args = [
				'post_type' => 'any',
				'p'         => [ $preview_id ],
			];
		} else {
			$args = [
				'post_type' => 'any',
				'post__in'  => [ $preview_id ],
			];
		}
	}

	return $args;

}

function jet_engine_select_post_preview_control( $listing_item ) {
	$listing_item->add_control(
		'_jet_custom_preview_id',
		array(
			'label'           => 'Select post for preview',
			'description'     => 'Note! You need to reload the page after applying new post for preview',
			'type'            => 'jet-query',
			'query_type'      => 'post',
			'prevent_looping' => true,
		)
	);
}
