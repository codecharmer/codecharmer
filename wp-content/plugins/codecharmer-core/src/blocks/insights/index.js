/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const blockProps = useBlockProps( {
			className: 'cc-insights-editor',
		} );
		return (
			<>
				<InspectorControls>
					<PanelBody title={ __( 'Listing', 'codecharmer-core' ) }>
						<RangeControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __(
								'Maximum articles',
								'codecharmer-core'
							) }
							value={ attributes.count }
							min={ 1 }
							max={ 50 }
							onChange={ ( next ) =>
								setAttributes( { count: next } )
							}
						/>
					</PanelBody>
				</InspectorControls>
				<div { ...blockProps }>
					<p>
						<strong>
							{ __( 'Insights hub', 'codecharmer-core' ) }
						</strong>
					</p>
					<p>
						{ __(
							'Published articles render here as cards with date, reading time, and excerpt. Shows an honest empty state until the first article exists.',
							'codecharmer-core'
						) }
					</p>
				</div>
			</>
		);
	},
	save: () => null,
} );
