/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, RichText, useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

const ALLOWED_BLOCKS = [ 'codecharmer/approach-step' ];
const TEMPLATE = [
	[ 'codecharmer/approach-step' ],
	[ 'codecharmer/approach-step' ],
	[ 'codecharmer/approach-step' ],
];

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const { eyebrow, heading, intro } = attributes;
		const blockProps = useBlockProps( {
			className: 'cc-approach-editor band-ink',
		} );
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
					placeholder={ __( 'Heading…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { heading: next } ) }
				/>
				<RichText
					tagName="p"
					className="lead"
					value={ intro }
					allowedFormats={ [] }
					placeholder={ __(
						'Intro (optional)…',
						'codecharmer-core'
					) }
					onChange={ ( next ) => setAttributes( { intro: next } ) }
				/>
				<InnerBlocks
					allowedBlocks={ ALLOWED_BLOCKS }
					template={ TEMPLATE }
				/>
			</div>
		);
	},
	save: () => <InnerBlocks.Content />,
} );
