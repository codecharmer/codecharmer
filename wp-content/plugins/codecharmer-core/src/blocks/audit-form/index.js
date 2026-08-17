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
			className: 'cc-audit-form-editor',
		} );
		return (
			<div { ...blockProps }>
				<p>
					<strong>
						{ __( 'Audit request form', 'codecharmer-core' ) }
					</strong>
				</p>
				<p>
					{ __(
						'Two-step qualification form (email, site, problem → context, timing, budget). Rendered server-side; posts to the inquiry endpoint as an audit request.',
						'codecharmer-core'
					) }
				</p>
			</div>
		);
	},
	save: () => null,
} );
