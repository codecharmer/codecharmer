/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.css';

const ALLOWED_BLOCKS = [ 'codecharmer/process-stage' ];
const TEMPLATE = [
	[ 'codecharmer/process-stage' ],
	[ 'codecharmer/process-stage' ],
	[ 'codecharmer/process-stage' ],
];

registerBlockType( metadata.name, {
	edit: function Edit() {
		const blockProps = useBlockProps( { className: 'cc-timeline-editor' } );
		return (
			<div { ...blockProps }>
				<p className="cc-process-editor__note">
					{ __(
						'Vertical instrumented rail. Each stage: name, story, deliverable. Stage extent follows its copy on the live site.',
						'codecharmer-core'
					) }
				</p>
				<InnerBlocks
					allowedBlocks={ ALLOWED_BLOCKS }
					template={ TEMPLATE }
				/>
			</div>
		);
	},
	save: () => <InnerBlocks.Content />,
} );
