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
								'Rail weight (decision leverage)',
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
					value={ attributes.name }
					allowedFormats={ [] }
					placeholder={ __( 'Stage name…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { name: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.body }
					allowedFormats={ [] }
					placeholder={ __(
						'Stage body (timeline only)…',
						'codecharmer-core'
					) }
					onChange={ ( next ) => setAttributes( { body: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-child-editor__body"
					value={ attributes.deliverable }
					allowedFormats={ [] }
					placeholder={ __(
						'Deliverable ("you get…")',
						'codecharmer-core'
					) }
					onChange={ ( next ) =>
						setAttributes( { deliverable: next } )
					}
				/>
			</div>
		);
	},
	save: () => null,
} );
