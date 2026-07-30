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
			eyebrow,
			heading,
			intro,
			url,
			email,
			password,
			note,
			ctaLabel,
		} = attributes;
		const blockProps = useBlockProps( { className: 'cc-demo-editor' } );
		return (
			<>
				<InspectorControls>
					<PanelBody
						title={ __( 'Access details', 'codecharmer-core' ) }
					>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Demo URL', 'codecharmer-core' ) }
							value={ url }
							onChange={ ( next ) =>
								setAttributes( { url: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Demo email', 'codecharmer-core' ) }
							value={ email }
							onChange={ ( next ) =>
								setAttributes( { email: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Demo password', 'codecharmer-core' ) }
							value={ password }
							onChange={ ( next ) =>
								setAttributes( { password: next } )
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
					<p className="cc-child-editor__body">
						{ url || __( 'demo url…', 'codecharmer-core' ) } ·{ ' ' }
						{ email || __( 'demo email…', 'codecharmer-core' ) }
					</p>
					<RichText
						tagName="p"
						className="cc-child-editor__body"
						value={ note }
						allowedFormats={ [] }
						placeholder={ __(
							'Context note…',
							'codecharmer-core'
						) }
						onChange={ ( next ) => setAttributes( { note: next } ) }
					/>
				</div>
			</>
		);
	},
	save: () => null,
} );
