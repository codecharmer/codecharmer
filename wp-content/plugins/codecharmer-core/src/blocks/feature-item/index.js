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

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const blockProps = useBlockProps( { className: 'cc-child-editor' } );
		return (
			<div { ...blockProps }>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.text }
					allowedFormats={ [] }
					placeholder={ __( 'Capability…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { text: next } ) }
				/>
			</div>
		);
	},
	save: () => null,
} );
