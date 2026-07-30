/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

const ALLOWED_BLOCKS = [ 'codecharmer/feature-item' ];
const TEMPLATE = [
	[ 'codecharmer/feature-item' ],
	[ 'codecharmer/feature-item' ],
	[ 'codecharmer/feature-item' ],
];

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const {
			eyebrow,
			name,
			tagline,
			description,
			stackLine,
			primaryLabel,
			primaryUrl,
			secondaryLabel,
			secondaryUrl,
		} = attributes;
		const blockProps = useBlockProps( {
			className: 'cc-flagship-editor band-ink',
		} );
		return (
			<>
				<InspectorControls>
					<PanelBody
						title={ __( 'Calls to action', 'codecharmer-core' ) }
					>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Primary label', 'codecharmer-core' ) }
							value={ primaryLabel }
							onChange={ ( next ) =>
								setAttributes( { primaryLabel: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Primary URL', 'codecharmer-core' ) }
							value={ primaryUrl }
							onChange={ ( next ) =>
								setAttributes( { primaryUrl: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __(
								'Secondary label',
								'codecharmer-core'
							) }
							value={ secondaryLabel }
							onChange={ ( next ) =>
								setAttributes( { secondaryLabel: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Secondary URL', 'codecharmer-core' ) }
							value={ secondaryUrl }
							onChange={ ( next ) =>
								setAttributes( { secondaryUrl: next } )
							}
						/>
					</PanelBody>
				</InspectorControls>
				<div { ...blockProps }>
					<RichText
						tagName="p"
						className="eyebrow"
						value={ eyebrow }
						allowedFormats={ [] }
						placeholder={ __( 'Eyebrow…', 'codecharmer-core' ) }
						onChange={ ( next ) =>
							setAttributes( { eyebrow: next } )
						}
					/>
					<h2 className="cc-flagship-editor__name">
						<RichText
							tagName="span"
							value={ name }
							allowedFormats={ [] }
							placeholder={ __(
								'Product name…',
								'codecharmer-core'
							) }
							onChange={ ( next ) =>
								setAttributes( { name: next } )
							}
						/>
					</h2>
					<RichText
						tagName="p"
						className="cc-flagship-editor__tagline"
						value={ tagline }
						allowedFormats={ [] }
						placeholder={ __( 'Tagline…', 'codecharmer-core' ) }
						onChange={ ( next ) =>
							setAttributes( { tagline: next } )
						}
					/>
					<RichText
						tagName="p"
						className="lead"
						value={ description }
						allowedFormats={ [ 'core/italic' ] }
						placeholder={ __( 'Description…', 'codecharmer-core' ) }
						onChange={ ( next ) =>
							setAttributes( { description: next } )
						}
					/>
					<InnerBlocks
						allowedBlocks={ ALLOWED_BLOCKS }
						template={ TEMPLATE }
					/>
					<RichText
						tagName="p"
						className="cc-flagship-editor__stack"
						value={ stackLine }
						allowedFormats={ [] }
						placeholder={ __(
							'Stack line (mono)…',
							'codecharmer-core'
						) }
						onChange={ ( next ) =>
							setAttributes( { stackLine: next } )
						}
					/>
				</div>
			</>
		);
	},
	save: () => <InnerBlocks.Content />,
} );
