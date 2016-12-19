
<div id="ckan-stats-taxonomy"
  <?php
  if (isset($atts['type'])):
    echo 'data-type="' . $atts['type'] . '"';
  endif; ?>
  data-current-country-code="<?php echo odm_country_manager()->get_current_country_code(); ?>"
  data-ckan-domain="<?php echo wpckan_get_ckan_domain(); ?>" style="width: 100%; height: 200px;"
  style="width: 100%; height: 200px;">
</div>

<div id="ckan-stats-filter"></div>

<script type="text/javascript">
  
	google.charts.load("current", {packages:["treemap"]});
	google.charts.setOnLoadCallback(drawChart);
  
	function drawChart() {
    
    var taxonomy_definition_url = "stats/records_by_taxonomy.json";  
        
    $.ajax({
       type: 'GET',
       url: taxonomy_definition_url,
       dataType:'json',
       success: function(data) { 
                
        var chartData = new google.visualization.DataTable();
        chartData.addColumn('string', 'Topic');
        chartData.addColumn('string', 'Parent');
        chartData.addColumn('number', 'Number of records');
        chartData.addRows(data["config"]);
       
     		var options = {
          legend: { position: "none" },
          highlightOnMouseOver: true
        };

     		var chart = new google.visualization.TreeMap(document.getElementById('ckan-stats-taxonomy'));     		
        
        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var value = chartData.getValue(selectedItem.row, 0);            
            $('#ckan-stats-filter').html('<a href="?query=&taxonomy=' + encodeURIComponent(value) + '">Filter only records about ' + value + '</a>')
          }
        }
        
        google.visualization.events.addListener(chart, 'select', selectHandler);
        chart.draw(chartData, options);
      
       },
       error: function(error){
         console.log("error", error);
       },
       async: false
   }); 
  	
	};

</script>
