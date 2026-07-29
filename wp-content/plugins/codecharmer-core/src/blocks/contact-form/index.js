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
				<strong>{ __( 'Contact Section', 'codecharmer-core' ) }</strong>
				<span>
					{ __(
						'Inquiry form (name, email, project type, budget, timeline, message) plus the what-happens-next and scheduling cards. Submissions email the site inbox.',
						'codecharmer-core'
					) }
				</span>
			</div>
		);
	},
	save: () => null,
} );
