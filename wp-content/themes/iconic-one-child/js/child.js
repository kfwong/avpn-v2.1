jQuery(document).ready(function($) {
	$(".field_type-select select").select2({"width": "100%"});
	$(".field_type-user select").select2({"width": "100%"});
	$(".field_type-post_object select").select2({"width": "100%"});

	$("#field_3").prepend("<option value=''></option>").val('');
	$(".field_type_select_custom_post_type select").select2({"width": "90%", "placeholder":"Select an organisation", "allowClear": true});

	$('#signup_username').bind('keyup keypress blur', function(){
    	$('#signup_password').val("generated_password");
    	$('#signup_password_confirm').val("generated_password");
	});

	$('.pretty-datatable').dataTable({
		"order": [[ 1, "asc" ]]		
	});

	if($('.flexslider').length != 0){
		$('.flexslider').flexslider({
		    animation: "slide",
		    controlNav: true,
		    animationLoop: false,
		    slideshow: false,
		    smoothHeight: true
		});
	}
	if(window.location.pathname=="/membership/list-of-members/"){
		$.post(
		 	ajaxobject.ajaxurl,
	 		{
	 			action : 'get_organisation_map_data'
	 		},
	 		function( data ) {
	 			//console.log(data);
				if($('#chartdiv').length != 0){
					// svg path for target icon
					//var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";

					var map = AmCharts.makeChart("chartdiv", {
						type: "map",
					    "theme": "none",
					    pathToImages: "http://www.amcharts.com/lib/3/images/",
						imagesSettings: {
							rollOverColor: "#EE2E22",
							rollOverScale: 3,
							selectedScale: 3,
							selectedColor: "#EE2E22",
							color:"#EE2E22"
						},
						zoomControl:{buttonFillColor:"#EE2E22"},
						areasSettings:{
							unlistedAreasColor:"#AAAAAA",
							selectable: false,
						},
						dataProvider: {
							map: "worldLow",
							zoomLevel:1.94531,
							zoomLatitude:4.51775,
							zoomLongitude:78.502813,
							images: JSON.parse(data),
							areas: {
								mouseEnabled: false
							}
						}
					});
					
					map.addListener("clickMapObject", function(event){
						$('#DataTables_Table_0_filter label input[type=search]')
						    .val(event.mapObject.title)
						    .trigger($.Event("keyup", { keyCode: 13 }));
					});
				/*
				// For debugging purpose, to figure out desired zoom and position of the map
				// uncomment this block of code and press SHIFT while clicking anywhere on map
				// insert values into dataProvider to set the initialization values
				map.developerMode = true;
				map.addListener("writeDevInfo", function (event) {
				  alert('zoomLevel:'+event.zoomLevel+'\nzoomLatitude:'+event.zoomLatitude+'\nzoomLongitude:'+event.zoomLongitude);
				});
				*/
				}
			}
		);
	}
});
	
