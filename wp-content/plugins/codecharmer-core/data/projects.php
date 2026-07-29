<?php
/**
 * Brand layer: the Selected Work projects.
 *
 * 'image' is a media key resolved by the MediaImporter against
 * data/media/source/<key>.<ext>.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	array(
		'name'       => 'Pura Capoeira',
		'url'        => 'https://puracapoeira.com',
		'descriptor' => 'The home of an international capoeira school spanning Mexico, Brazil, Angola and the USA — locations, professors, events and gallery, in three languages.',
		'tags'       => array( 'Community platform', 'Multi-location', 'Multilingual' ),
		'image'      => 'pura-capoeira',
	),
	array(
		'name'       => 'Capoeira is Life',
		'url'        => 'https://capoeirais.life',
		'descriptor' => 'A multilingual apparel brand and store for the global capoeira community — built to sell the culture, not just the merch.',
		'tags'       => array( 'Brand & identity', 'E-commerce', 'Multilingual' ),
		'image'      => 'capoeirais',
	),
	array(
		'name'       => 'Kenia Navarro',
		'url'        => 'https://kenianavarro.com.mx',
		'descriptor' => 'A quiet, editorial portfolio for a contemporary dancer and movement researcher — works, workshops and a practice journal, in two languages.',
		'tags'       => array( 'Portfolio', 'Art direction', 'Bilingual' ),
		'image'      => 'keni-navarro',
	),
	array(
		'name'       => 'Pura Capoeira Cuernavaca',
		'url'        => 'https://capoeiracuernavaca.com',
		'descriptor' => 'A local capoeira school in Cuernavaca — classes, enrollment, a shop and WhatsApp booking for a growing community.',
		'tags'       => array( 'Community platform', 'E-commerce', 'Booking' ),
		'image'      => 'capoeira-cuernavaca',
	),
);
