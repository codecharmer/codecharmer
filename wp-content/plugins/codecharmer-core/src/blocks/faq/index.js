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

const ALLOWED_BLOCKS = [ 'codecharmer/faq-item' ];
const TEMPLATE = [ [ 'codecharmer/faq-item' ], [ 'codecharmer/faq-item' ] ];

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const { heading } = attributes;
		const blockProps = useBlockProps( { className: 'cc-faq-editor' } );
		return (
			<div { ...blockProps }>
				<RichText
					tagName="h2"
					value={ heading }
					allowedFormats={ [] }
					placeholder={ __( 'FAQ heading…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { heading: next } ) }
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
