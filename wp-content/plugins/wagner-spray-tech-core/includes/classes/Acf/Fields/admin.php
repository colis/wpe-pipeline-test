<?php
/**
 * ACF fields for the Site Options page.
 *
 * @package WagnerSprayTech\Core
 */

use WagnerSprayTechCore\Acf\AdvancedCustomFields;

$fields = [
	[
		'key'               => 'field_637cc1afda848',
		'label'             => 'Header',
		'name'              => '',
		'aria-label'        => '',
		'type'              => 'tab',
		'instructions'      => '',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'placement'         => 'top',
		'endpoint'          => 0,
	],
	[
		'key'               => 'field_637cc1cbda849',
		'label'             => 'Logo',
		'name'              => 'logo',
		'aria-label'        => '',
		'type'              => 'image',
		'instructions'      => 'Add the company logo to output in the header.',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'return_format'     => 'id',
		'library'           => 'all',
		'min_width'         => '',
		'min_height'        => '',
		'min_size'          => '',
		'max_width'         => '',
		'max_height'        => '',
		'max_size'          => '',
		'mime_types'        => '',
		'preview_size'      => 'medium',
	],
];


$location = [
	[
		[
			'param'    => 'options_page',
			'operator' => '==',
			'value'    => AdvancedCustomFields::SITE_OPTIONS_NAME,
		],
	],
];


acf_add_local_field_group(
	[
		'key'                   => 'group_6005a7ff0a973',
		'title'                 => __( 'Site Options', 'wagner' ),
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
	]
);
