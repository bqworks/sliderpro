import { useBlockProps } from '@wordpress/block-editor';

export default function save( props ) {
	const { attributes } = props;

	return (
		<div { ...useBlockProps.save() }>
			{ '[sliderpro id="' + attributes.selectedSlider + '"]' }
		</div>
	);
}
