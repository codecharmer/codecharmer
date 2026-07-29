/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import {
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

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const {
			tone,
			eyebrow,
			title,
			intro,
			primaryLabel,
			primaryUrl,
			secondaryLabel,
			secondaryUrl,
			note,
		} = attributes;
		const blockProps = useBlockProps( {
			className: `cc-page-hero-editor ${
				'ink' === tone ? 'band-ink' : ''
			}`,
		} );
		return (
			<>
				<InspectorControls>
					<PanelBody
						title={ __( 'Surface & CTAs', 'codecharmer-core' ) }
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
							label={ __(
								'Primary CTA label',
								'codecharmer-core'
							) }
							value={ primaryLabel }
							onChange={ ( next ) =>
								setAttributes( { primaryLabel: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __(
								'Primary CTA URL',
								'codecharmer-core'
							) }
							value={ primaryUrl }
							onChange={ ( next ) =>
								setAttributes( { primaryUrl: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __(
								'Secondary CTA label',
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
							label={ __(
								'Secondary CTA URL',
								'codecharmer-core'
							) }
							value={ secondaryUrl }
							onChange={ ( next ) =>
								setAttributes( { secondaryUrl: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __(
								'Note (mono line)',
								'codecharmer-core'
							) }
							value={ note }
							onChange={ ( next ) =>
								setAttributes( { note: next } )
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
						tagName="h1"
						className="cc-page-hero-editor__title"
						value={ title }
						allowedFormats={ [] }
						placeholder={ __( 'Page title…', 'codecharmer-core' ) }
						onChange={ ( next ) =>
							setAttributes( { title: next } )
						}
					/>
					<RichText
						tagName="p"
						className="lead"
						value={ intro }
						allowedFormats={ [ 'core/italic' ] }
						placeholder={ __( 'Intro…', 'codecharmer-core' ) }
						onChange={ ( next ) =>
							setAttributes( { intro: next } )
						}
					/>
				</div>
			</>
		);
	},
	save: () => null,
} );
