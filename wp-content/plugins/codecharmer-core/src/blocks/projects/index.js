/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	PanelBody,
	RangeControl,
	SelectControl,
	TextControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const { variant, count, eyebrow, heading, ctaLabel, ctaUrl } =
			attributes;
		const blockProps = useBlockProps( { className: 'cc-projects-editor' } );
		return (
			<>
				<InspectorControls>
					<PanelBody title={ __( 'Layout', 'codecharmer-core' ) }>
						<SelectControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Variant', 'codecharmer-core' ) }
							value={ variant }
							options={ [
								{
									value: 'teaser',
									label: __(
										'Teaser (with header + CTA)',
										'codecharmer-core'
									),
								},
								{
									value: 'grid',
									label: __(
										'Full grid',
										'codecharmer-core'
									),
								},
							] }
							onChange={ ( next ) =>
								setAttributes( { variant: next } )
							}
						/>
						<RangeControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __(
								'Projects to show (0 = all)',
								'codecharmer-core'
							) }
							value={ count }
							min={ 0 }
							max={ 12 }
							onChange={ ( next ) =>
								setAttributes( { count: next } )
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
					{ 'teaser' === variant && (
						<>
							<RichText
								tagName="p"
								className="eyebrow"
								value={ eyebrow }
								allowedFormats={ [] }
								placeholder={ __(
									'Eyebrow…',
									'codecharmer-core'
								) }
								onChange={ ( next ) =>
									setAttributes( { eyebrow: next } )
								}
							/>
							<RichText
								tagName="h2"
								value={ heading }
								allowedFormats={ [] }
								placeholder={ __(
									'Heading…',
									'codecharmer-core'
								) }
								onChange={ ( next ) =>
									setAttributes( { heading: next } )
								}
							/>
						</>
					) }
					<p className="cc-process-editor__note">
						{ __(
							'Project cards render from the Projects post type.',
							'codecharmer-core'
						) }
					</p>
				</div>
			</>
		);
	},
	save: () => null,
} );
