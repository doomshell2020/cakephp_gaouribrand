
<?= $this->Html->script('admin/canvasjs.min.js') ?>
<script type="text/javascript">
myfunction();
function myfunction() { 

	  CanvasJS.addColorSet("blue",
                [//colorSet Array
                "#2d95e3"              
                ]);
//all
	var chart1 = new CanvasJS.Chart("test",
	{
	
		animationEnabled: true,
			height:270,
			width:850,
		zoomEnabled:false,
		colorSet: "blue",
		title:{
			text: "Project:This Year",
			fontColor: "#000",
        	fontSize: 14,
        	padding: 10,
        	fontWeight: "600",
			horizontalAlign: "left",
			fontFamily: "'Open Sans', sans-serif"
		},
		axisY: {title:"Price",
			labelFontSize: 12,
			labelFontColor: "#000",
			valueFormatString:  "#,##,##0.##",
			labelFontFamily:"'Open Sans', sans-serif",
			maximum: 10000,
			gridThickness: 1,
			lineThickness: 1,
			tickThickness: 1,
			interval: 1000
		},
		axisX: {title:"Duration",
			//valueFormatString: "MMM-YYYY",
			labelFontSize: 12,
			labelFontFamily:"'Open Sans', sans-serif",
			lineThickness: 1,
			labelFontColor: "#000",
			
			interval:1,
		},
		data: [
		{
			type: "column",
		    dataPoints:<?php echo $weeklytotal; ?> ,
		 
		    		}
		]
	});
	chart1.render();
}
	</script>

	<div class="tabs_nav_container responsive">
         
            <div class="tab-content"> 
              
              <!--tab1 start here--> 
              <div class="tab-pane fade in active" id="tabs_1">
                <div id="test" style="height: 270px; width: 100%;"></div>
              </div>                                
     
            </div>
          </div>