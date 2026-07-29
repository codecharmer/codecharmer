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
import { PanelBody, RangeControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

const ALLOWED_BLOCKS = [ 'codecharmer/belief-item' ];
const TEMPLATE = [
	[ 'codecharmer/belief-item' ],
	[ 'codecharmer/belief-item' ],
	[ 'codecharmer/belief-item' ],
];

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const { heading, intro, columns } = attributes;
		const blockProps = useBlockProps( {
			className: 'cc-beliefs-editor band-ink',
		} );
		return (
			<>
				<InspectorControls>
					<PanelBody title={ __( 'Layout', 'codecharmer-core' ) }>
						<RangeControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __(
								'Columns (wide screens)',
								'codecharmer-core'
							) }
							value={ columns }
							min={ 2 }
							max={ 4 }
							onChange={ ( next ) =>
								setAttributes( { columns: next } )
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
							'Section heading…',
							'codecharmer-core'
						) }
						onChange={ ( next ) =>
							setAttributes( { heading: next } )
						}
					/>
					<RichText
						tagName="p"
						className="lead"
						value={ intro }
						allowedFormats={ [] }
						placeholder={ __(
							'Intro (optional)…',
							'codecharmer-core'
						) }
						onChange={ ( next ) =>
							setAttributes( { intro: next } )
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
