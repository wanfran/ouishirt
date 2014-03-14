jQuery(function($){






//ON LOAD
	$(document).ready(function(){
		//var myProductDesigner = $('#ouishirtDesigner').fancyProductDesigner({templatesDirectory: basePath+'/php/template/', phpDirectory: basePath+'/php/script/'}).data('fancy-product-designer');
		//myProductDesigner.print();
		//$('#ouishirtDesigner').fancyProductDesigner({templatesDirectory: basePath+'/php/template/', phpDirectory: basePath+'/php/script/'}).data('fancy-product-designer');
		var ouihirtDesigner = $('#ouishirtDesigner').fancyProductDesigner({
	    		editorMode: false,
	    		fonts: ['Arial'],
	    		customTextParameters: {colors: "#3086e7", removable: true, resizable: true, draggable: true, rotatable: true, autoCenter: true, autoCenter: true,  boundingBox: "limit"},
	    		uploadedDesignsParameters: {draggable: true, removable: true, colors: '#000', autoCenter: true, boundingBox: "limit"},
	    		templatesDirectory: basePath+'/php/template/',
	    		phpDirectory: basePath+'/php/script/',
	    		centerInBoundingbox: true,
	    	}).data('fancy-product-designer');
		var productViews;
		//$(".fpd-elements-dropdown").children("option").html





		$('#ouishirtDesigner').on('ready', function() {
/*
		  	setInterval(function(){
				productViews = ouihirtDesigner.getProduct(true);
			},2000);
*/
		});
		$('#ouishirtDesigner').on("productCreate", function(event, title){
/*
			if (productViews) {
				ouihirtDesigner.loadProduct(productViews);
			};
*/
		});

		
	});
	$(window).resize(function() {
		
	});

});//jQuery END