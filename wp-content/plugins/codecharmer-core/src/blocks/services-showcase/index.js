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
				<strong>
					{ __( 'Services Showcase', 'codecharmer-core' ) }
				</strong>
				<span>
					{ __(
						'Alternating split sections rendered from the pages under /services (name, thesis, capabilities).',
						'codecharmer-core'
					) }
				</span>
			</div>
		);
	},
	save: () => null,
} );
