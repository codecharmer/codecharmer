/**
 * WordPress dependencies
 */
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

export default function Edit( { attributes, setAttributes } ) {
	const {
		kicker,
		titleBefore,
		charm,
		sub,
		primaryLabel,
		primaryUrl,
		secondaryLabel,
		secondaryUrl,
		trust,
	} = attributes;

	const blockProps = useBlockProps( {
		className: 'cc-hero-editor band-ink',
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
						label={ __( 'Secondary label', 'codecharmer-core' ) }
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
					value={ kicker }
					allowedFormats={ [] }
					placeholder={ __( 'Kicker…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { kicker: next } ) }
				/>
				<h1 className="cc-hero-editor__title">
					<RichText
						tagName="span"
						value={ titleBefore }
						allowedFormats={ [] }
						placeholder={ __( 'Headline…', 'codecharmer-core' ) }
						onChange={ ( next ) =>
							setAttributes( { titleBefore: next } )
						}
					/>{ ' ' }
					<RichText
						tagName="span"
						className="cc-hero-editor__charm"
						value={ charm }
						allowedFormats={ [] }
						placeholder={ __(
							'Charmed words…',
							'codecharmer-core'
						) }
						onChange={ ( next ) =>
							setAttributes( { charm: next } )
						}
					/>
				</h1>
				<RichText
					tagName="p"
					className="cc-hero-editor__sub"
					value={ sub }
					allowedFormats={ [ 'core/italic' ] }
					placeholder={ __( 'Lead paragraph…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { sub: next } ) }
				/>
				<RichText
					tagName="p"
					className="cc-hero-editor__trust"
					value={ trust }
					allowedFormats={ [] }
					placeholder={ __( 'Trust line…', 'codecharmer-core' ) }
					onChange={ ( next ) => setAttributes( { trust: next } ) }
				/>
				<p className="cc-hero-editor__note">
					{ __(
						'The animated system diagram renders on the live site.',
						'codecharmer-core'
					) }
				</p>
			</div>
		</>
	);
}

export { metadata };
