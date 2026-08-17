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
import { PanelBody, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

const ALLOWED_BLOCKS = [ 'codecharmer/stat' ];
const TEMPLATE = [
	[ 'codecharmer/stat' ],
	[ 'codecharmer/stat' ],
	[ 'codecharmer/stat' ],
];

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const { heading, tone } = attributes;
		const blockProps = useBlockProps( {
			className:
				'cc-stats-editor' + ( 'ink' === tone ? ' band-ink' : '' ),
		} );
		return (
			<>
				<InspectorControls>
					<PanelBody title={ __( 'Surface', 'codecharmer-core' ) }>
						<SelectControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Tone', 'codecharmer-core' ) }
							value={ tone }
							options={ [
								{
									label: __( 'Light', 'codecharmer-core' ),
									value: 'light',
								},
								{
									label: __( 'Ink', 'codecharmer-core' ),
									value: 'ink',
								},
							] }
							onChange={ ( next ) =>
								setAttributes( { tone: next } )
							}
						/>
					</PanelBody>
				</InspectorControls>
				<div { ...blockProps }>
					<RichText
						tagName="h2"
						value={ heading }
						allowedFormats={ [] }
						placeholder={ __(
							'Heading (optional)…',
							'codecharmer-core'
						) }
						onChange={ ( next ) =>
							setAttributes( { heading: next } )
						}
					/>
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
