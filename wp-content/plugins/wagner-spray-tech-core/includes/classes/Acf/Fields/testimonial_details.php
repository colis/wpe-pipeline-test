<?php
/**
 * ACF fields for Testimonial CPT.
 *
 * @package WagnerSprayTech\Core
 */

$fields = [
	[
		'key'               => 'wst_testimonial_details_testimonial',
		'label'             => 'Testimonial',
		'name'              => 'testimonial',
		'type'              => 'textarea',
		'instructions'      => '',
		'required'          => 1,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'default_value'     => '',
		'placeholder'       => '',
		'maxlength'         => '',
		'rows'              => '',
		'new_lines'         => '',
	],
	[
		'show_column_filter'   => false,
		'allow_bulkedit'       => false,
		'allow_quickedit'      => false,
		'show_column'          => false,
		'show_column_weight'   => 1000,
		'show_column_sortable' => false,
		'key'                  => 'wst_testimonial_details_background_color',
		'label'                => 'Background Color',
		'name'                 => 'background_color',
		'aria-label'           => '',
		'type'                 => 'color_picker',
		'instructions'         => '',
		'required'             => 0,
		'conditional_logic'    => 0,
		'wrapper'              => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'default_value'        => '',
		'enable_opacity'       => 1,
		'return_format'        => 'array',
	],
	[
		'key'               => 'wst_testimonial_details_subtitle',
		'label'             => 'Sub-Title',
		'name'              => 'subtitle',
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
		'key'               => 'wst_testimonial_details_cite',
		'label'             => 'Author / Cite',
		'name'              => 'cite',
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
		'key'               => 'wst_testimonial_details_link',
		'label'             => 'Link',
		'name'              => 'link',
		'type'              => 'link',
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
		'return_format'     => 'url',
	],
	[
		'show_column_filter'   => false,
		'allow_bulkedit'       => false,
		'allow_quickedit'      => false,
		'show_column'          => false,
		'show_column_weight'   => 1000,
		'show_column_sortable' => false,
		'key'                  => 'field_64a41cba3b1be',
		'label'                => 'Theme',
		'name'                 => 'theme',
		'aria-label'           => '',
		'type'                 => 'select',
		'instructions'         => '',
		'required'             => 0,
		'conditional_logic'    => 0,
		'wrapper'              => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'choices'              => [
			'Light' => 'light',
			'Dark'  => 'dark',
		],
		'default_value'        => 'Light',
		'return_format'        => 'value',
		'multiple'             => 0,
		'allow_null'           => 0,
		'ui'                   => 0,
		'ajax'                 => 0,
		'placeholder'          => '',
	],
	[
		'show_column_filter'   => false,
		'allow_bulkedit'       => false,
		'allow_quickedit'      => false,
		'show_column'          => false,
		'show_column_weight'   => 1000,
		'show_column_sortable' => false,
		'key'                  => 'wst_testimonial_details_background_image',
		'label'                => 'Background Image',
		'name'                 => 'background_image',
		'aria-label'           => '',
		'type'                 => 'image',
		'instructions'         => '',
		'required'             => 0,
		'conditional_logic'    => 0,
		'wrapper'              => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'return_format'        => 'id',
		'library'              => 'all',
		'min_width'            => '',
		'min_height'           => '',
		'min_size'             => '',
		'max_width'            => '',
		'max_height'           => '',
		'max_size'             => '',
		'mime_types'           => '',
		'preview_size'         => 'medium',
	],
	[
		'show_column_filter'   => false,
		'allow_bulkedit'       => false,
		'allow_quickedit'      => false,
		'show_column'          => false,
		'show_column_weight'   => 1000,
		'show_column_sortable' => false,
		'key'                  => 'wst_testimonial_details_icon',
		'label'                => 'Icon',
		'name'                 => 'icon',
		'aria-label'           => '',
		'type'                 => 'image',
		'instructions'         => '',
		'required'             => 0,
		'conditional_logic'    => 0,
		'wrapper'              => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'return_format'        => 'id',
		'library'              => 'all',
		'min_width'            => '',
		'min_height'           => '',
		'min_size'             => '',
		'max_width'            => '',
		'max_height'           => '',
		'max_size'             => '',
		'mime_types'           => '',
		'preview_size'         => 'medium',
	],
];

$location = [
	[
		[
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'testimonial',
		],
	],
];


acf_add_local_field_group(
	[
		'key'                   => 'group_645bbfb042c2d',
		'title'                 => 'Testimonial Details',
		'fields'                => $fields,
		'location'              => $location,
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	]
);
