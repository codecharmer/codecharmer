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
		const { eyebrow, heading, intro } = attributes;
		const blockProps = useBlockProps( { className: 'cc-proof-editor' } );
		return (
			<div { ...blockProps }>
				<RichText
					tagName="p"
					className="eyebrow"
					value={ eyebrow }
					allowedFormats={ [] }
					placeholder={ __( 'Eyebrow…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { eyebrow: next } ) }
				/>
				<RichText
					tagName="h2"
					value={ heading }
					allowedFormats={ [] }
					placeholder={ __( 'Claim…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { heading: next } ) }
				/>
				<RichText
					tagName="p"
					className="lead"
					value={ intro }
					allowedFormats={ [] }
					placeholder={ __( 'Supporting line…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { intro: next } ) }
				/>
			</div>
		);
	},
	save: () => null,
} );
