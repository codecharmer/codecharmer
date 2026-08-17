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
					value={ attributes.bestFor }
					allowedFormats={ [] }
					placeholder={ __( 'Best for…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { bestFor: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__title"
					value={ attributes.name }
					allowedFormats={ [] }
					placeholder={ __( 'Model name…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { name: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.price }
					allowedFormats={ [] }
					placeholder={ __(
						'Price, e.g. Starts at US$2,500 (optional)…',
						'codecharmer-core'
					) }
					onChange={ ( next ) => setAttributes( { price: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.timeframe }
					allowedFormats={ [] }
					placeholder={ __(
						'Timeframe (optional)…',
						'codecharmer-core'
					) }
					onChange={ ( next ) =>
						setAttributes( { timeframe: next } )
					}
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.body }
					allowedFormats={ [] }
					placeholder={ __( 'Model body…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { body: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.detail }
					allowedFormats={ [] }
					placeholder={ __(
						'Detail line, e.g. what moves the price (optional)…',
						'codecharmer-core'
					) }
					onChange={ ( next ) => setAttributes( { detail: next } ) }
				/>
			</div>
		);
	},
	save: () => null,
} );
