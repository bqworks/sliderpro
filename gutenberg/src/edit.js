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

	// Create a global object to store the slider data, so
	// that it needs to be fetched only once, when the first
	// block is added. Additional blocks will use the slider
	// data stored in the global object.
	if ( typeof window.sliderpro === 'undefined' ) {
		window.sliderpro = {
			sliders: [],
			loadingSlidersData: false
		};
	}

	// Load the slider data and store the slider name and id,
	// as 'label' and 'value' to be used in the SelectControl.
	const getSlidersData = () => new Promise( ( resolve ) => {
		wp.apiFetch({
			path: 'sliderpro/v1/get_sliders'
		}).then( function( responseData ) {
			let slidersData = [
				{ label: __( 'None', 'sliderpro'), value: -1 }
			];
			
			for ( const key in responseData ) {
				slidersData.push({
					label: `${ responseData[ key ] } (${ key })`,
					value: parseInt( key )
				});
			}

			resolve( slidersData );
		});
	});

	// Get a slider by its id.
	const getSlider = ( sliderId ) => {
		const slider = sliders.find( ( slider ) => {
			return slider.value === sliderId;
		});

		return typeof slider !== 'undefined' ? slider : false;
	};

	// Get the slider's label by its id.
	const getSliderLabel = ( sliderId ) => {
		const slider = getSlider( sliderId );

		return slider !== false ? slider.label: '';
	};

	// Initialize the component by setting the 'sliders' property
	// which will trigger the rendering of the component.
	//
	// If the sliders data is already globally available, set the 'sliders'
	// immediately. If the sliders data is currently loading, wait for it
	// to load and then set the 'sliders'. If it's not currently loading,
	// start the loading process.
	const init = () => {
		if ( window.sliderpro.sliders.length !== 0 ) {
			setSliders( window.sliderpro.sliders );
		} else if ( window.sliderpro.loadingSlidersData === true ) {
			const checkApiFetchInterval = setInterval( function() {
				if ( window.sliderpro.loadingSlidersData !== true ) {
					clearInterval( checkApiFetchInterval );
					setSliders( window.sliderpro.sliders );
				}
			}, 100 );
		} else {
			window.sliderpro.loadingSlidersData = true;

			getSlidersData().then( ( slidersData ) => {
				window.sliderpro.loadingSlidersData = false;
				window.sliderpro.sliders = slidersData;

				setSliders( slidersData );
			});
		}
	}

	useEffect( () => {
		init();
	}, [] );

	return (
		<div { ...useBlockProps() }>
			<Placeholder label='Slider Pro' icon={ sliderIcon }>
				{
					typeof window.sliderpro === 'undefined' || window.sliderpro.loadingSlidersData === true ?
						<div className='sp-gutenberg-slider-placeholder-content'> { __( 'Loading Slider Pro data...', 'sliderpro' ) } </div>
					: (
						window.sliderpro.sliders.length === 0 ?
							<div className='sp-gutenberg-slider-placeholder-content'> { __( 'You don\'t have any created sliders yet.', 'sliderpro' ) } </div>
						: (
							attributes.sliderId === -1 || getSlider( attributes.sliderId ) === false ?
								<div className='sp-gutenberg-slider-placeholder-content'> { __( 'Select a slider from the Block settings.', 'sliderpro' ) } </div>
							: (
								<div className='sp-gutenberg-slider-placeholder-content'>
									<p className='sp-gutenberg-slider-identifier'> { getSliderLabel( attributes.sliderId ) } </p>
									<a className='sp-gutenberg-edit-slider' href={`${ sp_gutenberg_js_vars.admin_url }?page=sliderpro&id=${ attributes.sliderId }&action=edit`} target='_blank'> { __( 'Edit Slider', 'sliderpro' ) } </a>
								</div>
							)
						)
					)
				}
			</Placeholder>

			<InspectorControls>
				<SelectControl
					className='sp-gutenberg-select-slider'
					label={ __( 'Select a slider from the list:', 'sliderpro' ) }
					options={ sliders }
					value={ attributes.sliderId }
					onChange={ ( newSlider ) => setAttributes( { sliderId: parseInt( newSlider ) } ) }
				/>
				{
					window.sliderpro.sliders.length === 0 &&
					<p 
						className='sp-gutenberg-no-sliders-text'
						dangerouslySetInnerHTML={{
							__html: sprintf( __( 'You don\'t have any created sliders yet. You can create and manage sliders in the <a href="%s" target="_blank">dedicated area</a>, and then use the block to load the sliders.', 'sliderpro' ), `${ sp_gutenberg_js_vars.admin_url }?page=sliderpro` )
						}}>
					</p>
				}
			</InspectorControls>
		</div>
	);
}
