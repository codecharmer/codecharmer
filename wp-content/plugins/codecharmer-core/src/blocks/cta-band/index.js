/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { RichText, useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const { heading, body } = attributes;
		const blockProps = useBlockProps( {
			className: 'cc-cta-editor band-ink',
		} );
		return (
			<div { ...blockProps }>
				<RichText
					tagName="h2"
					className="cc-cta-editor__heading"
					value={ heading }
					allowedFormats={ [] }
					placeholder={ __( 'CTA heading…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { heading: next } ) }
				/>
				<RichText
					tagName="p"
					value={ body }
					allowedFormats={ [ 'core/italic' ] }
					placeholder={ __( 'Supporting line…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { body: next } ) }
				/>
				<p className="cc-cta-editor__note">
					{ __(
						'Buttons render from site settings (CTA + email).',
						'codecharmer-core'
					) }
				</p>
			</div>
		);
	},
	save: () => null,
} );
