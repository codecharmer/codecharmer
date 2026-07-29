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
				<strong>{ __( 'Site Header', 'codecharmer-core' ) }</strong>
				<span>
					{ __(
						'Logo, primary navigation, services mega-menu and CTA. Rendered from site structure — nothing to configure here.',
						'codecharmer-core'
					) }
				</span>
			</div>
		);
	},
	save: () => null,
} );
