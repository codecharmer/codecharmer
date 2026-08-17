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
		const { quote, name, role, company, sourceUrl } = attributes;
		const blockProps = useBlockProps( {
			className: 'cc-testimonial-editor',
		} );
		return (
			<>
				<InspectorControls>
					<PanelBody
						title={ __( 'Attribution', 'codecharmer-core' ) }
					>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Name', 'codecharmer-core' ) }
							value={ name }
							onChange={ ( next ) =>
								setAttributes( { name: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Role', 'codecharmer-core' ) }
							value={ role }
							onChange={ ( next ) =>
								setAttributes( { role: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Company', 'codecharmer-core' ) }
							value={ company }
							onChange={ ( next ) =>
								setAttributes( { company: next } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Source URL', 'codecharmer-core' ) }
							value={ sourceUrl }
							onChange={ ( next ) =>
								setAttributes( { sourceUrl: next } )
							}
						/>
					</PanelBody>
				</InspectorControls>
				<div { ...blockProps }>
					<RichText
						tagName="p"
						value={ quote }
						allowedFormats={ [] }
						placeholder={ __(
							'Permissioned client quote… (renders nothing while empty)',
							'codecharmer-core'
						) }
						onChange={ ( next ) =>
							setAttributes( { quote: next } )
						}
					/>
				</div>
			</>
		);
	},
	save: () => null,
} );
