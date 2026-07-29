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

const ALLOWED_BLOCKS = [ 'codecharmer/value-point' ];
const TEMPLATE = [
	[ 'codecharmer/value-point' ],
	[ 'codecharmer/value-point' ],
	[ 'codecharmer/value-point' ],
];

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const { lead } = attributes;
		const blockProps = useBlockProps( { className: 'cc-value-editor' } );
		return (
			<div { ...blockProps }>
				<RichText
					tagName="p"
					className="cc-value-editor__lead"
					value={ lead }
					allowedFormats={ [ 'core/italic' ] }
					placeholder={ __( 'Value statement…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { lead: next } ) }
				/>
				<div className="cc-value-editor__points">
					<InnerBlocks
						allowedBlocks={ ALLOWED_BLOCKS }
						template={ TEMPLATE }
					/>
				</div>
			</div>
		);
	},
	save: () => <InnerBlocks.Content />,
} );
