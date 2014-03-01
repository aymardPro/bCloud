<?php
$script = '
    $(document).ready(
    	function()
	    {
	    	
	// Pie Chart
	$("table.chart-pie").each(function() {
        var colors = [];
        $("table.chart-pie thead th:not(:first)").each(function() {
            colors.push($(this).css("color"));
        });
        $(this).graphTable({
            series			: 	"columns", 
			position		: 	"replace",
			width			: 	"100%",
			height			: 	"325px", 
			colors			:	colors
        }, {
		series: {
            pie: { 
                show: true,
				innerRadius: 0.5,
                radius: 1,
				tilt: 1,
                label: {
                    show: true,
                    radius: 1,
                    formatter: function(label, series){
                        return "<div id=\"tooltipPie\"><b>"+label+"</b> : "+Math.round(series.percent)+"%</div>";
                    },
                    background: { opacity: 0 }
                }
            }
        },
        legend: { show: false},
		grid: {
				hoverable: false,
				autoHighlight: true
			}
        });
    });
	    }
    );
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>
<br />
	<?php foreach($this->request->data as $key => $value) { ?>
<div class="row-fluid">
		<div class="widget span12 clearfix">
			
			<div class="widget-header">
				<span><i class="icon-star-empty"></i> <?php echo $key; ?> </span>
			</div><!-- End widget-header -->
			
			<div class="widget-content"><br />
				<table class="chart-pie">
					<thead>
						<tr>
							<th></th>
							<?php
							$color = array('aed741', 'bedd17', 'c3e171', '85b501');
							$i = 0;
							foreach ($value as $k1 => $v1) {
								if ($i>3) { $i = 0; }
								echo '<th style="color: #'.$color[$i].'">'.$k1.'</th>';
								$i++;
							}
							?>
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<th></th>
							<?php
							foreach ($value as $k2 => $v2) {
								echo '<th>'.count($v2[0]).'</th>';
							}
							?>
						</tr>
					</tbody>
				</table>
				
				<div class="chart-pie-shadow"></div>
				<div class="chart_title"><span>Pourcentage <?php echo $key; ?> par secteur d'activité</span></div>
			</div>
		</div>
</div>
	<?php } ?>