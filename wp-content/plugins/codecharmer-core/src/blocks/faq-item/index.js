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
					className="cc-child-editor__title"
					value={ attributes.question }
					allowedFormats={ [] }
					placeholder={ __( 'Question…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { question: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.answer }
					allowedFormats={ [] }
					placeholder={ __( 'Answer…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { answer: next } ) }
				/>
			</div>
		);
	},
	save: () => null,
} );
