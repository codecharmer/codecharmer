/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

const toLines = ( list ) => ( list || [] ).join( '\n' );
const fromLines = ( text ) =>
	text
		.split( '\n' )
		.map( ( line ) => line.trim() )
		.filter( Boolean );

registerBlockType( metadata.name, {
	edit: function Edit( { attributes, setAttributes } ) {
		const { partnersLabel, partners, collaboratorsLabel, collaborators } =
			attributes;
		const blockProps = useBlockProps( { className: 'cc-partners-editor' } );
		return (
			<>
				<InspectorControls>
					<PanelBody title={ __( 'Lists', 'codecharmer-core' ) }>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Partners label', 'codecharmer-core' ) }
							value={ partnersLabel }
							onChange={ ( next ) =>
								setAttributes( { partnersLabel: next } )
							}
						/>
						<TextareaControl
							__nextHasNoMarginBottom
							label={ __(
								'Partners (one per line)',
								'codecharmer-core'
							) }
							value={ toLines( partners ) }
							onChange={ ( next ) =>
								setAttributes( { partners: fromLines( next ) } )
							}
						/>
						<TextControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __(
								'Collaborators label',
								'codecharmer-core'
							) }
							value={ collaboratorsLabel }
							onChange={ ( next ) =>
								setAttributes( { collaboratorsLabel: next } )
							}
						/>
						<TextareaControl
							__nextHasNoMarginBottom
							label={ __(
								'Collaborators (one per line)',
								'codecharmer-core'
							) }
							value={ toLines( collaborators ) }
							onChange={ ( next ) =>
								setAttributes( {
									collaborators: fromLines( next ),
								} )
							}
						/>
					</PanelBody>
				</InspectorControls>
				<div { ...blockProps }>
					<p className="eyebrow">{ partnersLabel }</p>
					<p>{ ( partners || [] ).join( ' · ' ) }</p>
					<p className="eyebrow">{ collaboratorsLabel }</p>
					<p>{ ( collaborators || [] ).join( ' · ' ) }</p>
				</div>
			</>
		);
	},
	save: () => null,
} );
