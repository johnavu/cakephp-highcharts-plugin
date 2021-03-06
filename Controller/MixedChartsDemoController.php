<?php

/**
 *  CakePHP Highcharts Plugin
 *
 * 	Copyright (C) 2014 Kurn La Montagne / destinydriven
 * 	<https://github.com/destinydriven>
 *
 * 	Multi-licensed under:
 * 		MPL <http://www.mozilla.org/MPL/MPL-1.1.html>
 * 		LGPL <http://www.gnu.org/licenses/lgpl.html>
 * 		GPL <http://www.gnu.org/licenses/gpl.html>
 * 		Apache License, Version 2.0 <http://www.apache.org/licenses/LICENSE-2.0.html>
 */
class MixedChartsDemoController extends HighchartsAppController {

        public $name = 'MixedChartsDemo';
        public $components = array('Highcharts.Highcharts');
        public $uses = array();
        public $layout = 'chart.demo';

/**
 * Highcharts component
 *
 * @var HighchartsComponent
 */
        public $Highcharts = null;

        public function mixed_charts() {

                $chartData1 = array(7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6);
                $chartData2 = array(-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5);

                $chartData3 = array(
                    array(
                        'name' => 'Chrome',
                        'y' => 45.0,
                        'sliced' => true,
                        'selected' => true
                    ),
                    array('IE', 26.8),
                    array('Firefox', 12.8),
                    array('Safari', 8.5),
                    array('Opera', 6.2),
                    array('Others', 0.7)
                );
                
                $chartNameOne = 'Line Chart';
                $chartNameTwo = 'Column Chart';
                $chartNameThree = 'Pie Chart';

                $mychartOne = $this->Highcharts->create($chartNameOne, 'line');

                $mychartTwo = $this->Highcharts->create($chartNameTwo, 'column');

                $mychartThree = $this->Highcharts->create($chartNameThree, 'pie');

                $this->Highcharts->setChartParams($chartNameOne, array(
                    'renderTo' => 'linewrapper', // div to display chart inside
                    'chartWidth' => 800,
                    'chartHeight' => 600,
                    'title' => 'Monthly Sales Summary - Line',
                    'yAxisTitleText' => 'Units Sold',
                    'xAxisCategories' => array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
                    'creditsEnabled' => false
                        )
                );

                $this->Highcharts->setChartParams($chartNameTwo, array(
                    'renderTo' => 'columnwrapper', // div to display chart inside
                    'chartWidth' => 800,
                    'chartHeight' => 600,
                    'title' => 'Monthly Sales Summary - Column',
                    'yAxisTitleText' => 'Y Axis Title Text',
                    'xAxisCategories' => array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
                    'creditsText' => 'Example.com',
                    'creditsURL' => 'http://example.com'
                        )
                );

                $this->Highcharts->setChartParams($chartNameThree, array(
                    'renderTo' => 'piewrapper', // div to display chart inside
                    'chartWidth' => 800,
                    'chartHeight' => 600,
                    'title' => 'Browser Usage Statistics',
                    'creditsText' => 'Example.com',
                    'creditsURL' => 'http://example.com',
                    'plotOptionsShowInLegend' => true
                        )
                );

                $seriesOne = $this->Highcharts->addChartSeries();
                $seriesTwo = $this->Highcharts->addChartSeries();
                $seriesThree = $this->Highcharts->addChartSeries();

                $seriesOne->addName('Tokyo')
                        ->addData($chartData1);
                $seriesTwo->addName('London')
                        ->addData($chartData2);
                $seriesThree->addName('New York')
                        ->addData($chartData3);

                $mychartOne->addSeries($seriesOne);
                $mychartTwo->addSeries($seriesTwo);
                $mychartThree->addSeries($seriesThree);
                
                $this->set(compact('chartNameOne', 'chartNameTwo', 'chartNameThree'));
        }

        public function spline_live() {
                $chartData = <<<EOF
(function() { var data = [], time = (new Date()).getTime(), i; for (i = -19; i <= 0; i++) { data.push({ x: time + i * 1000, y: Math.random() }); } return data; })()
EOF;

                $chartName = 'Spline Chart Live Data';

                // anonymous Callback function to format the text of the tooltip
                $tooltipFormatFunction = <<<EOF
function() { return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+ Highcharts.numberFormat(this.y, 2);}
EOF;

                // Fires when the chart is finished loading.
                $eventsLoadFunction = <<<EOF
function() { var series = this.series[0]; setInterval(function() { var x = (new Date()).getTime(), y = Math.random(); series.addPoint([x, y], true, true);}, 1000);}
EOF;

                $mychart = $this->Highcharts->create($chartName, 'spline');

                $this->Highcharts->setChartParams($chartName, array(
                    'renderTo' => 'splinewrapper', // div to display chart inside
                    'chartWidth' => 1000,
                    'chartHeight' => 750,
                    'chartMarginRight' => 10,
                    'chartEventsLoad' => $eventsLoadFunction,
                    'chartBackgroundColorLinearGradient' => array(0, 0, 0, 300),
                    'chartBackgroundColorStops' => array(array(0, 'rgb(217, 217, 217)'), array(1, 'rgb(255, 255, 255)')),
                    'title' => 'Live Random Data',
                    'legendEnabled' => false,
                    'exportingEnabled' => false,
                    'creditsEnabled' => false,
                    'tooltipEnabled' => false,
                    'tooltipBackgroundColorLinearGradient' => array(0, 0, 0, 60),
                    'tooltipBackgroundColorStops' => array(array(0, '#FFFFFF'), array(1, '#E0E0E0')),
                    'tooltipEnabled' => true,
                    'tooltipFormatter' => $tooltipFormatFunction,
                    'xAxisType' => 'datetime',
                    'xAxisTickPixelInterval' => 150,
                    'yAxisTitleText' => 'Value',
                    'yAxisPlotLines' => array(array('color' => '#808080', 'width' => 1, 'value' => 0)),
                    /* autostep options */
                    'enableAutoStep' => false
                        )
                );

                $series = $this->Highcharts->addChartSeries();

                $series->addName('Random Data')
                        ->addData($chartData);

                $mychart->addSeries($series);
                
                $this->set(compact('chartName'));
        }

        public function column_drilldown() {

                $categories = array('MSIE', 'Firefox', 'Chrome', 'Safari', 'Opera');

                $colors = array('#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE');  // custom list of colours
                // notice that we set 'renderTo' variable in this case because we want to do some dynamic stuff with it in drilldown JS function
                $renderTo = 'column_drilldown';

                $chartData = array(
                    array(
                        'y' => 55.11,
                        'color' => $colors[0],
                        'drilldown' => array(
                            'name' => 'MSIE Versions',
                            'categories' => array('MSIE 6.0', 'MSIE 7.0', 'MSIE 8.0', 'MSIE 9.0'),
                            'data' => array(10.85, 7.35, 33.06, 2.81),
                            'color' => $colors[0]
                        )
                    ),
                    array(
                        'y' => 21.63,
                        'color' => $colors[1],
                        'drilldown' => array(
                            'name' => 'Firefox Versions',
                            'categories' => array('Firefox 2.0', 'Firefox 3.0', 'Firefox 3.5', 'Firefox 3.6', 'Firefox 4.0'),
                            'data' => array(0.20, 0.83, 1.58, 13.12, 5.43),
                            'color' => $colors[1]
                        )
                    ),
                    array(
                        'y' => 11.94,
                        'color' => $colors[2],
                        'drilldown' => array(
                            'name' => 'Chrome Versions',
                            'categories' => array('Chrome 5.0', 'Chrome 6.0', 'Chrome 7.0', 'Chrome 8.0', 'Chrome 9.0', 'Chrome 10.0', 'Chrome 11.0', 'Chrome 12.0'),
                            'data' => array(0.12, 0.19, 0.12, 0.36, 0.32, 9.91, 0.50, 0.22),
                            'color' => $colors[2]
                        )
                    ),
                    array(
                        'y' => 7.15,
                        'color' => $colors[3],
                        'drilldown' => array(
                            'name' => 'Safari Versions',
                            'categories' => array('Safari 5.0', 'Safari 4.0', 'Safari Win 5.0', 'Safari 4.1', 'Safari-Maxthon', 'Safari 3.1', 'Safari 4.1'),
                            'data' => array(4.55, 1.42, 0.23, 0.21, 0.20, 0.19, 0.14),
                            'color' => $colors[3]
                        )
                    ),
                    array(
                        'y' => 2.14,
                        'color' => $colors[4],
                        'drilldown' => array(
                            'name' => 'Opera Versions',
                            'categories' => array('Opera 9.x', 'Opera 10.x', 'Opera 11.x'),
                            'data' => array(0.12, 0.37, 1.65),
                            'color' => $colors[4]
                        )
                    )
                );

                $chartName = 'Browser Brands';


                // anonymous Callback function to format the text of the tooltip
                $tooltipFormatFunction = <<<EOF
function(){var point = this.point,s = this.x +':<b>'+ this.y +'% market share</b><br/>';if (point.drilldown) {s += 'Click to view '+ point.category +' versions';} else{s += 'Click to return to browser brands';}return s;}
EOF;
                $pointEventsClick = <<<EOF
function(){var drilldown = this.drilldown; if(drilldown){setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);} else { setChart( {$renderTo}.options.series[0].name, {$renderTo}.xAxis[0].options.categories, {$renderTo}.options.series[0].data);}}
EOF;
                $dataLabelsFormatter = <<<EOF
function(){return this.y +'%'; }
EOF;

                $mychart = $this->Highcharts->create($chartName, 'column');

                $this->Highcharts->setChartParams($chartName, array(
                    'renderTo' => $renderTo, // div to display chart inside
                    'chartWidth' => 1000,
                    'chartHeight' => 750,
                    'chartMarginRight' => 10,
                    'chartBackgroundColorLinearGradient' => array(0, 0, 0, 300),
                    'chartBackgroundColorStops' => array(array(0, 'rgb(217, 217, 217)'), array(1, 'rgb(255, 255, 255)')),
                    'title' => 'Browser market share, April, 2011',
                    'subtitle' => 'Click the columns to view versions. Click again to view brands.',
                    'plotOptionsColumnCursor' => 'pointer',
                    'plotOptionsColumnPointEventsClick' => $pointEventsClick,
                    'plotOptionsColumnDataLabelsEnabled' => true,
                    'plotOptionsColumnDataLabelsColor' => $colors[0],
                    'plotOptionsColumnDataLabelsFormatter' => $dataLabelsFormatter,
                    'legendEnabled' => true,
                    'exportingEnabled' => false,
                    'creditsEnabled' => false,
                    'tooltipEnabled' => true,
                    'tooltipBackgroundColorLinearGradient' => array(0, 0, 0, 60),
                    'tooltipBackgroundColorStops' => array(array(0, '#FFFFFF'), array(1, '#E0E0E0')),
                    'tooltipEnabled' => true,
                    'tooltipFormatter' => $tooltipFormatFunction,
                    'xAxisCategories' => $categories,
                    'yAxisTitleText' => 'Total percent market share'
                        )
                );

                $series = $this->Highcharts->addChartSeries();

                $series->addName($chartName)
                        ->addData($chartData)
                        ->addColor('white');

                $mychart->addSeries($series);
                
                $this->set(compact('chartName'));
        }
        
        public function column3d() {
                
                $chartData = array(
                    29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4
                );

                $chartName = 'Column 3D Chart';

                $mychart = $this->Highcharts->create($chartName, 'column');

                $this->Highcharts->setChartParams($chartName, array(
                    'renderTo' => 'column3dwrapper', // div to display chart inside
                    'chartWidth' => 1000,
                    'chartHeight' => 750,
                    'title' => '3D Column Chart Demo',
                    'subtitle' => 'Source: World Bank',
                    'options3d' => array(
                        'enabled' => true,
                        'alpha' => 15,
                        'beta' => 15,
                        'depth' => 50,
                        'viewDistance' => 25
                    ),
                    'xAxisLabelsEnabled' => true,
                    'yAxisTitleText' => 'Units',
                    'enableAutoStep' => false,
                    'creditsEnabled' => false,
                    )
                );

                $series = $this->Highcharts->addChartSeries();

                $series->addName('3D Series')
                        ->addData($chartData);

                $mychart->addSeries($series);
                
                $this->set(compact('chartName'));
        }
        
        public function pie3d() {
                
                $chartData = array(
                    array(
                        'name' => 'Chrome',
                        'y' => 45.0,
                        'sliced' => true,
                        'selected' => true
                    ),
                    array('IE', 26.8),
                    array('Firefox', 12.8),
                    array('Safari', 8.5),
                    array('Opera', 6.2),
                    array('Others', 0.7)
                );
                
                $dataLabelsFormat = <<<EOF
function(){return this.point.name; }
EOF;
                
                $tooltipFormatFunction = <<<EOF
function(){return this.y +'%'; }
EOF;

                $chartName = 'Pie 3D Chart';

                $pie3dChart = $this->Highcharts->create($chartName, 'pie');

                $this->Highcharts->setChartParams($chartName, array(
                    'renderTo' => 'pie3dwrapper', // div to display chart inside
                    'chartWidth' => 1000,
                    'chartHeight' => 750,
                    'options3d' => array(
                        'enabled' => true,
                        'alpha' => 45,
                        'beta' => 0,
                    ),
                    'plotOptionsPieDepth' => 45,   // this is needed for the 3D effect
                    'plotOptionsShowInLegend' => true, 
                    'plotOptionsPieAllowPointSelect' => true,
                    'plotOptionsPieDataLabelsEnabled' => true,
                    'plotOptionsPieDataLabelsFormat' => $dataLabelsFormat,
                    'tooltipFormatter' => $tooltipFormatFunction,
                    'title' => 'Browser Usage Statistics',                                      
                    'creditsEnabled' => false
                        )
                );

                $series = $this->Highcharts->addChartSeries();

                $series->addName('Browser Share')
                        ->addData($chartData);

                $pie3dChart->addSeries($series);
                
                $this->set(compact('chartName'));
        }
        
        public function donut3d() {
                
                $chartData = array(
                    array('Bananas', 8),
                    array('Kiwi', 3),
                    array('Mixed Nuts', 1),
                    array('Oranges', 6),
                    array('Apples', 8),
                    array('Pears', 4),
                    array('Mangoes', 4),
                    array('Guavas', 1),
                    array('Grapes', 1)
                );
                
                $chartName = 'Donut 3D Chart';

                $donut3dChart = $this->Highcharts->create($chartName, 'pie');

                $this->Highcharts->setChartParams($chartName, array(
                    'renderTo' => 'donut3dwrapper', // div to display chart inside
                    'chartWidth' => 1024,
                    'chartHeight' => 768,
                    'options3d' => array(
                        'enabled' => true,
                        'alpha' => 45,
                    ),
                    'title' => 'Content of Highsoft\'s weekly fruit delivery',
                    'subtitle' => '3D Donut in Highcharts',
                    )
                );

                $series = $this->Highcharts->addChartSeries();

                $series->addName('Delivered amount')
                        ->addData($chartData)
                        ->addDepth(45)
                        ->addInnerSize(100)
                        ->addSize('50%');

                $donut3dChart->addSeries($series);               

                $this->set(compact('chartName'));
        }
        
        public function angular_gauge() {
                
                $chartData = array(80);
                
                $chartName = 'Speedometer';

                $angularGauge = $this->Highcharts->create($chartName, 'gauge');

                $this->Highcharts->setChartParams($chartName, array(
                    'renderTo' => 'gaugewrapper', // div to display chart inside
                    'chartWidth' => 1024,
                    'chartHeight' => 768,
                    'plotBackgroundColor' => null,
                    'plotBackgroundImage' => null,
                    'plotBorderWidth' => 0,
                    'plotShadow' => false,                    
                    'title' => 'Speedometer',
                    'subtitle' => 'Feed the Need for Speed',
                    'paneStartAngle' => -150,
                    'paneEndAngle' => 150,
                    'paneBackground' => array(
                        array(
                            'backgroundColor' => array(
                                'linearGradient' => array('x1' => 0, 'y1' => 0, 'x2' => 0, 'y2' => 1),
                                'stops' => array(0 => '#FFF', 1 => '#333'),
                                ),
                            'borderWidth' => 0,
                            'outerRadius' => '109%'
                            ),
                        array(
                            'backgroundColor' => array(
                                'linearGradient' => array('x1' => 0, 'y1' => 0, 'x2' => 0, 'y2' => 1),
                                'stops' => array(0 => '#333', 1 => '#FFF'),
                                ),
                            'borderWidth' => 1,
                            'outerRadius' => '107%'
                            ),
                        array(
                            'backgroundColor' => '#DDD',
                            'borderWidth' => 0,
                            'outerRadius' => '105%',
                            'innerRadius' => '103%'
                            )
                        ), 
                    // the value axis
                    'yAxisMin' => 0,
                    'yAxisMax' => 200,
                    'yAxisMinorTickInterval' => 'auto',
                    'yAxisMinorTickWidth' => 1,
                    'yAxisMinorTickLength' => 10,
                    'yAxisMinorTickPosition' => 'inside',
                    'yAxisMinorTickColor' => '#666',
                    
                    'yAxiTickPixelInterval' => 30,
                    'yAxisTickWidth' => 2,
                    'yAxisTickPosition' => 'inside',
                    'yAxisTickLength' => 10,
                    'yAxisTickColor' => '#666',
                    'yAxisLabels' => array('step' => 2, 'rotation' => 'auto'),
                    'yAxisTitleText' => 'km/h',
                    'yAxisPlotBands' => array(
                        array(
                            'from' => 0,
                            'to' => 120, 
                            'color' => '#55BF3B' // green
                             
                        ),
                        array(
                            'from' => 120,
                            'to' => 160, 
                            'color' => '#DDDF0D' // yellow
                        ),
                        array(
                            'from' => 160,
                            'to' => 200, 
                            'color' => '#DF5353'  // red
                        )
                     )
                    )
                   );
               

                $series = $this->Highcharts->addChartSeries();

                $series->addName('Speed')
                        ->addData($chartData);

                $angularGauge->addSeries($series);               

                $this->set(compact('chartName'));
        }

}
