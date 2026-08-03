<?php
/**
 * Brand layer: site options seeded by the installer.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'blogname'        => 'Code Charmer',
	'blogdescription' => 'Digital systems that earn their keep.',
	'settings'        => array(
		'email'          => 'codecharmer@codecharmer.io',
		'tagline'        => 'Digital systems that earn their keep.',
		'cta_label'      => 'Book a consultation',
		'cta_url'        => '/contact',
		'response_time'  => 'within one business day',
		'scheduling_url' => '',
	),
);
