/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const { version, date, title, summary, items } = attributes;
		const blockProps = useBlockProps( { className: 'cc-child-editor' } );
		return (
			<>
				<InspectorControls>
					<PanelBody title={ __( 'Release', 'codecharmer-core' ) }>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Version', 'codecharmer-core' ) }
							value={ version }
							onChange={ ( next ) =>
								setAttributes( { version: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Date', 'codecharmer-core' ) }
							value={ date }
							onChange={ ( next ) =>
								setAttributes( { date: next } )
							}
						/>
						<TextareaControl
							__nextHasNoMarginBottom
							label={ __(
								'Notable changes (one per line)',
								'codecharmer-core'
							) }
							value={ items }
							onChange={ ( next ) =>
								setAttributes( { items: next } )
							}
						/>
					</PanelBody>
				</InspectorControls>
				<div { ...blockProps }>
					<p className="cc-child-editor__title">
						{ version || __( 'v?…', 'codecharmer-core' ) } ·{ ' ' }
						{ date || __( 'date…', 'codecharmer-core' ) }
					</p>
					<RichText
						tagName="p"
						className="cc-child-editor__title"
						value={ title }
						allowedFormats={ [] }
						placeholder={ __(
							'Release title…',
							'codecharmer-core'
						) }
						onChange={ ( next ) =>
							setAttributes( { title: next } )
						}
					/>
					<RichText
						tagName="p"
						className="cc-child-editor__body"
						value={ summary }
						allowedFormats={ [] }
						placeholder={ __( 'Summary…', 'codecharmer-core' ) }
						onChange={ ( next ) =>
							setAttributes( { summary: next } )
						}
					/>
				</div>
			</>
		);
	},
	save: () => null,
} );
