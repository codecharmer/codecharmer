/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
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
				<InspectorControls>
					<PanelBody title={ __( 'Rail', 'codecharmer-core' ) }>
						<RangeControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __(
								'Rail weight (relative width)',
								'codecharmer-core'
							) }
							value={ attributes.weight }
							min={ 0.5 }
							max={ 5 }
							step={ 0.1 }
							onChange={ ( next ) =>
								setAttributes( { weight: next } )
							}
						/>
					</PanelBody>
				</InspectorControls>
				<RichText
					tagName="p"
					className="cc-child-editor__title"
					value={ attributes.title }
					allowedFormats={ [] }
					placeholder={ __( 'Step title…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { title: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.body }
					allowedFormats={ [] }
					placeholder={ __( 'Step body…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { body: next } ) }
				/>
			</div>
		);
	},
	save: () => null,
} );
