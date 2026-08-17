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
		const blockProps = useBlockProps( {
			className: 'cc-landing-chrome-editor',
		} );
		return (
			<div { ...blockProps }>
				<p>
					<strong>
						{ __( 'Landing header', 'codecharmer-core' ) }
					</strong>{ ' ' }
					{ __(
						'(logo + trust line, no navigation)',
						'codecharmer-core'
					) }
				</p>
				<RichText
					tagName="p"
					value={ attributes.trustLine }
					allowedFormats={ [] }
					placeholder={ __( 'Trust line…', 'codecharmer-core' ) }
					onChange={ ( next ) =>
						setAttributes( { trustLine: next } )
					}
				/>
			</div>
		);
	},
	save: () => null,
} );
