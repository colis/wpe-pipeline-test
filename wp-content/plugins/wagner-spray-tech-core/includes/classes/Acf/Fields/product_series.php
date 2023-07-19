<?php
/**
 * ACF fields for Product Series CPT.
 *
 * @package WagnerSprayTech\Core
 */

$fields = [
	[
		'key'               => 'field_6499c51cd92b7',
		'label'             => 'Series color',
		'name'              => 'series_color',
		'aria-label'        => '',
		'type'              => 'color_picker',
		'instructions'      => '',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'default_value'     => '',
		'enable_opacity'    => 0,
		'return_format'     => 'string',
	],
	[
		'key'               => 'field_649ada018a01f',
		'label'             => 'Card Subtitle',
		'name'              => 'card_subtitle',
		'aria-label'        => '',
		'type'              => 'text',
		'instructions'      => 'This field adds a subtitle to the card UI for this post.',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'default_value'     => '',
		'maxlength'         => '',
		'placeholder'       => '',
		'prepend'           => '',
		'append'            => '',
	],
];

$location = [
	[
		[
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'product-series',
		],
	],
];

acf_add_local_field_group(
	[
		'key'                   => 'group_6499c51c4117b',
		'title'                 => 'Product Series Fields',
		'fields'                => $fields,
		'location'              => $location,
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	]
);
