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
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

const ALLOWED_BLOCKS = [ 'codecharmer/process-stage' ];
const TEMPLATE = [
	[ 'codecharmer/process-stage' ],
	[ 'codecharmer/process-stage' ],
	[ 'codecharmer/process-stage' ],
];

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const { tone, eyebrow, heading, intro, ctaLabel, ctaUrl } = attributes;
		const blockProps = useBlockProps( {
			className: `cc-process-editor ${
				'ink' === tone ? 'band-ink' : ''
			}`,
		} );
		return (
			<>
				<InspectorControls>
					<PanelBody
						title={ __( 'Surface & CTA', 'codecharmer-core' ) }
					>
						<SelectControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Surface', 'codecharmer-core' ) }
							value={ tone }
							options={ [
								{
									value: 'light',
									label: __( 'Light', 'codecharmer-core' ),
								},
								{
									value: 'ink',
									label: __( 'Deep ink', 'codecharmer-core' ),
								},
							] }
							onChange={ ( next ) =>
								setAttributes( { tone: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'CTA label', 'codecharmer-core' ) }
							value={ ctaLabel }
							onChange={ ( next ) =>
								setAttributes( { ctaLabel: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'CTA URL', 'codecharmer-core' ) }
							value={ ctaUrl }
							onChange={ ( next ) =>
								setAttributes( { ctaUrl: next } )
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
					<RichText
						tagName="h2"
						value={ heading }
						allowedFormats={ [] }
						placeholder={ __( 'Heading…', 'codecharmer-core' ) }
						onChange={ ( next ) =>
							setAttributes( { heading: next } )
						}
					/>
					<RichText
						tagName="p"
						className="lead"
						value={ intro }
						allowedFormats={ [] }
						placeholder={ __( 'Intro…', 'codecharmer-core' ) }
						onChange={ ( next ) =>
							setAttributes( { intro: next } )
						}
					/>
					<p className="cc-process-editor__note">
						{ __(
							'Stages below drive the instrumented rail. Weight = relative segment width (decision leverage).',
							'codecharmer-core'
						) }
					</p>
					<InnerBlocks
						allowedBlocks={ ALLOWED_BLOCKS }
						template={ TEMPLATE }
					/>
				</div>
			</>
		);
	},
	save: () => <InnerBlocks.Content />,
} );
