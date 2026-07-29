/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

registerBlockType( metadata.name, {
	edit: function Edit() {
		return (
			<div { ...useBlockProps( { className: 'cc-editor-placeholder' } ) }>
				<strong>{ __( 'Site Footer', 'codecharmer-core' ) }</strong>
				<span>
					{ __(
						'Brand lockup, service/company columns and the legal line. Rendered from site structure.',
						'codecharmer-core'
					) }
				</span>
			</div>
		);
	},
	save: () => null,
} );
