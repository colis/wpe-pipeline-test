<?php
/**
 * ACF fields for Gallery Feature.
 *
 * @package WagnerSprayTech\Core
 */

$fields = [
	[
		'key'                  => 'wst_product_gallery',
		'label'                => 'Gallery',
		'name'                 => 'gallery',
		'type'                 => 'text',
		'instructions'         => 'Used by Digital River Sync, do not edit.',
		'required'             => 0,
		'conditional_logic'    => 0,
		'show_column_filter'   => false,
		'allow_bulkedit'       => 0,
		'allow_quickedit'      => 0,
		'show_column'          => 0,
		'show_column_weight'   => 1000,
		'show_column_sortable' => false,
		'wrapper'              => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'default_value'        => '',
		'placeholder'          => '',
		'prepend'              => '',
		'append'               => '',
		'maxlength'            => '',
	],
];


$location = [
	[
		[
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'product',
		],
		[
			'param'    => 'current_user_role',
			'operator' => '==',
			'value'    => 'administrator',
		],
	],
];


acf_add_local_field_group(
	[
		'key'                   => 'wst_product_gallery_group',
		'title'                 => 'Gallery',
		'fields'                => $fields,
		'location'              => $location,
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'hidden',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 1,
		'hide_on_screen'        => [
			0  => 'permalink',
			1  => 'the_content',
			2  => 'excerpt',
			3  => 'discussion',
			4  => 'comments',
			5  => 'revisions',
			6  => 'slug',
			7  => 'author',
			8  => 'format',
			9  => 'page_attributes',
			10 => 'featured_image',
			11 => 'categories',
			12 => 'tags',
			13 => 'send-trackbacks',
		],
	]
);
