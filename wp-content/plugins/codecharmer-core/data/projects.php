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
		'name'       => 'Pacífica Panadería',
		'url'        => 'https://pacificapanaderia.com',
		'descriptor' => 'The full commerce system for an artisan sourdough bakery in Cuernavaca: reserve-and-pickup storefront, a customer app with Apple Wallet loyalty, and a tablet POS for the counter, all on one WordPress engine.',
		'tags'       => array( 'E-commerce', 'Mobile apps', 'POS & operations' ),
		'image'      => 'pacifica-panaderia',
		'case'       => '/work/pacifica',
	),
	array(
		'name'       => 'Haramara Café',
		'url'        => 'https://haramara.cafe',
		'descriptor' => 'A dark, bilingual home for a specialty coffee and sourdough café: the same commerce engine as its sister bakery, re-branded end to end, with customer and POS apps and self-refreshing Apple Wallet loyalty.',
		'tags'       => array( 'E-commerce', 'Mobile apps', 'Bilingual' ),
		'image'      => 'haramara-cafe',
		'case'       => '/work/haramara',
	),
	array(
		'name'       => 'Gramo Café',
		'url'        => 'https://gramo.cafe',
		'descriptor' => 'The digital home of a specialty coffee brand with eight cafés across Cuernavaca and Mexico City: bilingual, headless WordPress + Gatsby, with pay-on-delivery commerce and SMS-driven operations.',
		'tags'       => array( 'Headless WordPress', 'E-commerce', 'Bilingual' ),
		'image'      => 'gramo-cafe',
		'case'       => '/work/gramo',
	),
	array(
		'name'       => 'Pura Capoeira',
		'url'        => 'https://puracapoeira.com',
		'descriptor' => 'The home of an international capoeira school spanning Mexico, Brazil, Angola and the USA: locations, professors, events and gallery, in three languages.',
		'tags'       => array( 'Community platform', 'Multi-location', 'Multilingual' ),
		'image'      => 'pura-capoeira',
	),
	array(
		'name'       => 'Capoeira is Life',
		'url'        => 'https://capoeirais.life',
		'descriptor' => 'A multilingual apparel brand and store for the global capoeira community, built to sell the culture, not just the merch.',
		'tags'       => array( 'Brand & identity', 'E-commerce', 'Multilingual' ),
		'image'      => 'capoeirais',
	),
	array(
		'name'       => 'Kenia Navarro',
		'url'        => 'https://kenianavarro.com.mx',
		'descriptor' => 'A quiet, editorial portfolio for a contemporary dancer and movement researcher: works, workshops and a practice journal, in two languages.',
		'tags'       => array( 'Portfolio', 'Art direction', 'Bilingual' ),
		'image'      => 'keni-navarro',
	),
	array(
		'name'       => 'Pura Capoeira Cuernavaca',
		'url'        => 'https://capoeiracuernavaca.com',
		'descriptor' => 'A local capoeira school in Cuernavaca: classes, enrollment, a shop and WhatsApp booking for a growing community.',
		'tags'       => array( 'Community platform', 'E-commerce', 'Booking' ),
		'image'      => 'capoeira-cuernavaca',
	),
);
