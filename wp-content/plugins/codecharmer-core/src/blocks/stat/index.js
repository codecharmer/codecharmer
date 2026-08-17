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
					value={ attributes.value }
					allowedFormats={ [] }
					placeholder={ __( 'Value, e.g. 8…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { value: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.label }
					allowedFormats={ [] }
					placeholder={ __( 'Label…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { label: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.note }
					allowedFormats={ [] }
					placeholder={ __(
						'Context note (optional)…',
						'codecharmer-core'
					) }
					onChange={ ( next ) => setAttributes( { note: next } ) }
				/>
			</div>
		);
	},
	save: () => null,
} );
