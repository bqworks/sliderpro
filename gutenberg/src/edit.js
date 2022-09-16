import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { InspectorControls } from '@wordpress/blockEditor';
import { SelectControl, Placeholder } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import { sliderIcon } from './icons';

import './editor.scss';

export default function edit( props ) {
	const { attributes, setAttributes } = props;
	const [ sliders, setSliders ] = useState([]);

	const getSlidersData = () => {
		if ( typeof window.sliderpro === 'undefined' ) {
			window.sliderpro = {};
		}

		if ( typeof window.sliderpro.sliders === 'undefined' ) {
			window.sliderpro = {
				loadingSlidersData: true,
				sliders: []
			};

			wp.apiFetch({
				path: 'sliderpro/v1/get_sliders'
			}).then( function( data ) {
				let sliders = [
					{ label: __( 'None', 'sliderpro'), value: -1 }
				];

				for ( const slider_id in data ) {
					sliders.push({
						label: data[ slider_id ] + ' (' + slider_id + ')',
						value: slider_id
					});
				}

				window.sliderpro.loadingSlidersData = false;
				window.sliderpro.sliders = sliders;

				setSliders( sliders );
			});
		} else if ( window.sliderpro.loadingSlidersData === true ) {
			const checkApiFetchInterval = setInterval(function() {
				if ( window.sliderpro.loadingSlidersData !== true ) {
					clearInterval( checkApiFetchInterval );
					setSliders( window.sliderpro.sliders );
				}
			}, 100);
		} else {
			setSliders( window.sliderpro.sliders );
		}
	};

	const getSlider = ( sliderId ) => {
		const slider = sliders.find( slider => {
			return slider.value === sliderId;
		});

		return typeof slider !== 'undefined' ? slider : false;
	};

	const getSliderLabel = ( sliderId ) => {
		const slider = getSlider( sliderId );

		return slider !== false ? slider.label: '';
	};

	useEffect( () => {
		getSlidersData();
	}, [] );

	return (
		<div { ...useBlockProps() }>
			<Placeholder label = 'Slider Pro' icon = { sliderIcon }>
				{
					typeof window.sliderpro !== 'undefined' && window.sliderpro.loadingSlidersData === false ? 
						sliders.length !== 0 ?
							getSlider( attributes.selectedSlider ) !== false ?
								<div className='sp-gutenberg-slider-placeholder-content'>
									<p className='sp-gutenberg-slider-identifier'> { getSliderLabel( attributes.selectedSlider ) } </p>
									<a className='sp-gutenberg-edit-slider' href={ sp_gutenberg_js_vars.admin_url + '?page=sliderpro&id=' + attributes.selectedSlider + '&action=edit' } target='_blank'> { __( 'Edit Slider', 'sliderpro' ) } </a>
								</div>
							: 
								<div className='sp-gutenberg-slider-placeholder-content'> { __( 'Select a slider from the Block settings.', 'sliderpro' ) } </div>
						:
							<div className='sp-gutenberg-slider-placeholder-content'> { __( 'You don\'t have any created sliders yet.', 'sliderpro' ) } </div>
					:
						<div className='sp-gutenberg-slider-placeholder-content'> { __( 'Loading Slider Pro data...', 'sliderpro' ) } </div>
				}
			</Placeholder>

			<InspectorControls>
				{
					sliders.length === 0 &&
					<p 
						className='sp-gutenberg-no-sliders-text'
						dangerouslySetInnerHTML={{
							__html: sprintf( __( 'You don\'t have any created sliders yet. You can create and manage sliders in the <a href="%s" target="_blank">dedicated area</a>, and then use the block to load the sliders.', 'sliderpro' ), sp_gutenberg_js_vars.admin_url + '?page=sliderpro' )
						}}>
					</p>
				}
				<SelectControl
					className='sp-gutenberg-select-slider'
					label = { __( 'Select a slider from the list:', 'sliderpro' ) }
					options = { sliders }
					value = { attributes.selectedSlider }
					onChange = { ( newSlider ) => setAttributes( { selectedSlider: newSlider } ) }
				/>
			</InspectorControls>
		</div>
	);
}
