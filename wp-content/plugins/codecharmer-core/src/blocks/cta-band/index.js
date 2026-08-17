/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import {
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

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const {
			heading,
			body,
			primaryLabel,
			primaryUrl,
			secondaryLabel,
			secondaryUrl,
		} = attributes;
		const blockProps = useBlockProps( {
			className: 'cc-cta-editor band-ink',
		} );
		return (
			<>
				<InspectorControls>
					<PanelBody title={ __( 'Buttons', 'codecharmer-core' ) }>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Primary label', 'codecharmer-core' ) }
							help={ __(
								'Leave empty to use the site-wide CTA.',
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
							help={ __(
								'Leave empty to use the email button.',
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
						tagName="h2"
						className="cc-cta-editor__heading"
						value={ heading }
						allowedFormats={ [] }
						placeholder={ __( 'CTA heading…', 'codecharmer-core' ) }
						onChange={ ( next ) =>
							setAttributes( { heading: next } )
						}
					/>
					<RichText
						tagName="p"
						value={ body }
						allowedFormats={ [ 'core/italic' ] }
						placeholder={ __(
							'Supporting line…',
							'codecharmer-core'
						) }
						onChange={ ( next ) => setAttributes( { body: next } ) }
					/>
					<p className="cc-cta-editor__note">
						{ __(
							'Buttons render from these overrides, or from site settings when empty.',
							'codecharmer-core'
						) }
					</p>
				</div>
			</>
		);
	},
	save: () => null,
} );
