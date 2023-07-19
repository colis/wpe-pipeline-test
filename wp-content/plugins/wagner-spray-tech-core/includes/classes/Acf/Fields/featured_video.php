<?php
/**
 * ACF fields for featured Video Embed.
 *
 * @package WagnerSprayTech\Core
 */

$fields = [
	[
		'key'               => 'wst_featured_video_embed',
		'label'             => 'Embed',
		'name'              => 'featured_video',
		'type'              => 'oembed',
		'instructions'      => '',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'width'             => '',
		'height'            => '',
	],
];

$location = [
	[
		[
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'part',
		],
	],
	[
		[
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'product',
		],
	],
	[
		[
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'how-to',
		],
	],
	[
		[
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'page',
		],
	],
	[
		[
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'page',
		],
	],
];


acf_add_local_field_group(
	[
		'key'                   => 'wst_featured_video_embed_group',
		'title'                 => 'Featured Video',
		'fields'                => $fields,
		'location'              => $location,
		'menu_order'            => 0,
		'position'              => 'side',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 1,
	]
);
