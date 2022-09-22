/*
Name: 			Dashboard - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	4.0.0
*/

(function($) {

	'use strict';

	/*
	Sales Selector
	*/
	$('#salesSelector').themePluginMultiSelect().on('change', function() {
		var rel = $(this).val();
		$('#salesSelectorItems .chart').removeClass('chart-active').addClass('chart-hidden');
		$('#salesSelectorItems .chart[data-sales-rel="' + rel + '"]').addClass('chart-active').removeClass('chart-hidden');
	});

	$('#salesSelector').trigger('change');

	$('#salesSelectorWrapper').addClass('ready');

	/*
	Flot: Sales 1
	*/
	if( $('#flotDashSales1').get(0) ) {
		var flotDashSales1 = $.plot('#flotDashSales1', flotDashSales1Data, {
			series: {
				lines: {
					show: true,
					lineWidth: 2
				},
				points: {
					show: true
				},
				shadowSize: 0
			},
			grid: {
				hoverable: true,
				clickable: true,
				borderColor: 'rgba(0,0,0,0.1)',
				borderWidth: 1,
				labelMargin: 15,
				backgroundColor: 'transparent'
			},
			yaxis: {
				min: 0,
				color: 'rgba(0,0,0,0.1)'
			},
			xaxis: {
				mode: 'categories',
				color: 'rgba(0,0,0,0)'
			},
			legend: {
				show: false
			},
			tooltip: true,
			tooltipOpts: {
				content: '%x: %y',
				shifts: {
					x: -30,
					y: 25
				},
				defaultTheme: false
			}
		});

		}

	/*
	Flot: Sales 2
	*/
	if( $('#flotDashSales2').get(0) ) {
		var flotDashSales2 = $.plot('#flotDashSales2', flotDashSales2Data, {
			series: {
				lines: {
					show: true,
					lineWidth: 2
				},
				points: {
					show: true
				},
				shadowSize: 0
			},
			grid: {
				hoverable: true,
				clickable: true,
				borderColor: 'rgba(0,0,0,0.1)',
				borderWidth: 1,
				labelMargin: 15,
				backgroundColor: 'transparent'
			},
			yaxis: {
				min: 0,
				color: 'rgba(0,0,0,0.1)'
			},
			xaxis: {
				mode: 'categories',
				color: 'rgba(0,0,0,0)'
			},
			legend: {
				show: false
			},
			tooltip: true,
			tooltipOpts: {
				content: '%x: %y',
				shifts: {
					x: -30,
					y: 25
				},
				defaultTheme: false
			}
		});
	}

	/*
	Flot: Sales 3
	*/
	if( $('#flotDashSales3').get(0) ) {
		var flotDashSales3 = $.plot('#flotDashSales3', flotDashSales3Data, {
			series: {
				lines: {
					show: true,
					lineWidth: 2
				},
				points: {
					show: true
				},
				shadowSize: 0
			},
			grid: {
				hoverable: true,
				clickable: true,
				borderColor: 'rgba(0,0,0,0.1)',
				borderWidth: 1,
				labelMargin: 15,
				backgroundColor: 'transparent'
			},
			yaxis: {
				min: 0,
				color: 'rgba(0,0,0,0.1)'
			},
			xaxis: {
				mode: 'categories',
				color: 'rgba(0,0,0,0)'
			},
			legend: {
				show: false
			},
			tooltip: true,
			tooltipOpts: {
				content: '%x: %y',
				shifts: {
					x: -30,
					y: 25
				},
				defaultTheme: false
			}
		});
	}

	/*
	Liquid Meter
	*/
	if( $('#meterSales').get(0) ) {
		$('#meterSales').liquidMeter({
			shape: 'circle',
			color: '#0088cc',
			background: '#F9F9F9',
			fontSize: '24px',
			fontWeight: '600',
			stroke: '#F2F2F2',
			textColor: '#333',
			liquidOpacity: 0.9,
			liquidPalette: ['#333'],
			speed: 3000,
			animate: !$.browser.mobile
		});
	}

	if( $('#meterSalesSel').get(0) ) {
		$('#meterSalesSel a').on('click', function( ev ) {
			ev.preventDefault();

			var val = $(this).data("val"),
				selector = $(this).parent(),
				items = selector.find('a');

			items.removeClass('active');
			$(this).addClass('active');

			// Update Meter Value
			$('#meterSales').liquidMeter('set', val);
		});

		}



	/*
	Sparkline: Bar
	*/
	if( $('#sparklineBarDash').get(0) ) {
		var sparklineBarDashOptions = {
			type: 'bar',
			width: '80',
			height: '55',
			barColor: '#0088cc',
			negBarColor: '#B20000'
		};

		$("#sparklineBarDash").sparkline(sparklineBarDashData, sparklineBarDashOptions);

		}

	/*
	Sparkline: Line
	*/
	if( $('#sparklineLineDash').get(0) ) {
		var sparklineLineDashOptions = {
			type: 'line',
			width: '80',
			height: '55',
			lineColor: '#0088cc'
		};

		$("#sparklineLineDash").sparkline(sparklineLineDashData, sparklineLineDashOptions);
	}

	/*
	Map
	*/
	if( $('#vectorMapWorld').get(0) ) {
		var vectorMapDashOptions = {
			map: 'world_en',
			backgroundColor: null,
			color: '#FFF',
			hoverOpacity: 0.7,
			selectedColor: '#0088CC',
			selectedRegions: ['US'],
			enableZoom: true,
			borderWidth:1,
			showTooltip: true,
			values: sample_data,
			scaleColors: ['#0088cc'],
			normalizeFunction: 'polynomial'
		};

		$('#vectorMapWorld').vectorMap(vectorMapDashOptions);
	}

}).apply(this, [jQuery]);