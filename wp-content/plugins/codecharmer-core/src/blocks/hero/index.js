/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import Edit from './edit';
import './style.css';

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
