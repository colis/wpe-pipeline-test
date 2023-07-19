<?php
/**
 * ACF fields for Document CPT.
 *
 * @package WagnerSprayTech\Core
 */

$fields = [
	[
		'key'               => 'wst_document_type',
		'label'             => 'Document Type',
		'name'              => 'type',
		'type'              => 'text',
		'instructions'      => '',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'default_value'     => '',
		'placeholder'       => '',
		'prepend'           => '',
		'append'            => '',
		'maxlength'         => '',
	],
	[
		'key'               => 'wst_document_file',
		'label'             => 'File',
		'name'              => 'file',
		'type'              => 'file',
		'instructions'      => '',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'return_format'     => 'id',
		'library'           => 'all',
		'min_size'          => '',
		'max_size'          => '',
		'mime_types'        => '',
	],
];

$location = [
	[
		[
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'document',
		],
	],
];


acf_add_local_field_group(
	[
		'key'                   => 'group_645bc48405a49',
		'title'                 => 'Document Details',
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
