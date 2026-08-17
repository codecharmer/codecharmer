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
		const blockProps = useBlockProps( {
			className: 'cc-landing-chrome-editor',
		} );
		return (
			<div { ...blockProps }>
				<p>
					<strong>
						{ __( 'Landing footer', 'codecharmer-core' ) }
					</strong>{ ' ' }
					{ __(
						'(email, privacy, copyright from site settings)',
						'codecharmer-core'
					) }
				</p>
			</div>
		);
	},
	save: () => null,
} );
