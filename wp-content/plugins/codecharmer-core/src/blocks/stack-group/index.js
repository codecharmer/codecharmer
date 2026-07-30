/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { RichText, useBlockProps } from '@wordpress/block-editor';
import { TextareaControl } from '@wordpress/components';
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
					value={ attributes.label }
					allowedFormats={ [] }
					placeholder={ __( 'Group label…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { label: next } ) }
				/>
				<TextareaControl
					__nextHasNoMarginBottom
					label={ __(
						'Technologies (one per line)',
						'codecharmer-core'
					) }
					value={ attributes.items }
					onChange={ ( next ) => setAttributes( { items: next } ) }
				/>
			</div>
		);
	},
	save: () => null,
} );
