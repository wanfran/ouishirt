jQuery(function($){






//ON LOAD
	$(document).ready(function(){
		//Initialize product module
			var ouihirtDesigner = $('#ouishirtDesigner').fancyProductDesigner({
	    		editorMode: false,
	    		fonts: ['Arial'],
	    		customTextParameters: {colors: "#3086e7", removable: true, resizable: true, draggable: true, rotatable: true, autoCenter: true, autoCenter: true,  boundingBox: "limit"},
	    		uploadedDesignsParameters: {draggable: true, removable: true, colors: '#000', autoCenter: true, boundingBox: "limit"},
	    		templatesDirectory: basePath+'/php/template/',
	    		phpDirectory: basePath+'/php/script/',
	    		centerInBoundingbox: true,
	    	}).data('fancy-product-designer');

		//STEP MANAGEMENT
		//Step 1
		$(".statusStep1, .statusStepText1").click(function(){
			$("#configDesign").css("display", "block");
			$("#configGoal").css("display", "none");
			$("#configCampaign").css("display", "none");

			$(".statusStep2").removeClass("statusStepActive");
			$(".statusStep3").removeClass("statusStepActive");
			$(".statusBarProgress").animate({
				width : "5%",
			},{
				duration : 500
			});
		});
		//Step 2
		$(".statusStep2, .statusStepText2, .nextStep1").click(function(){
			$("#configDesign").css("display", "none");
			$("#configGoal").css("display", "block");
			$("#configCampaign").css("display", "none");

			$(".statusStep2").addClass("statusStepActive");
			$(".statusStep3").removeClass("statusStepActive");
			$(".statusBarProgress").animate({
				width : "50%",
			},{
				duration : 500
			});
		});
		//Step 3
		$(".statusStep3, .statusStepText3, .nextStep2").click(function(){
			$("#configDesign").css("display", "none");
			$("#configGoal").css("display", "none");
			$("#configCampaign").css("display", "block");

			$(".statusStep2").addClass("statusStepActive");
			$(".statusStep3").addClass("statusStepActive");
			$(".statusBarProgress").animate({
				width : "100%",
			},{
				duration : 500
			});
		});

		// Goal settings

		//global vars
		//var basePrice = 
		var shirtNumber=20; // Number of shirts
		var shirtPrice=10; // Price of one shirt

		//Tshirt number

		$("#productNumberSlider").slider({
			range: "min",
			animate: false,
			min: 10,
			max : 1000,
			value: 20,
			slide: function(event, ui) {
				shirtNumber = $("#productNumberSlider").slider("option", "value");
				$("input[name=shirtNumber]").attr("value",shirtNumber);
				$("input[name=shirtNumber]").val(shirtNumber);
				$(".productNumber").text(shirtNumber);

				//profit global
				var profitGlobal = (shirtPrice * shirtNumber).toFixed(2);
				var profitGlobalS = String(profitGlobal);
				profitGlobalS = profitGlobalS.replace(".",",");
				$(".profit").text(profitGlobalS+"€")
			}
		});
		$("input[name=shirtNumber]").change(function(){
			shirtNumber = $(this).val();
			$("#productNumberSlider").slider("option", "value", $(this).val());
			$(".productNumber").text($(this).val());
		});

		//Tshirt price

		$("#productPriceSlider").slider({
			range: "min",
			step: 0.01,
			animate: false,
			min: 10,
			max : 100,
			value: 15,
			slide: function(event, ui) {
				//shirtPrice
				shirtPrice = $("#productPriceSlider").slider("option", "value");
				var priceS = String(shirtPrice);
				priceS = priceS.replace(".",",");
				$(".productPrice").text(priceS);

				//profit per shirt
				//var profitPerShirt = shirtPrice - basePrice
				//$(".profitPerShirt").text(profitPerShirt);

				//profit global
				var profitGlobal = (shirtPrice * shirtNumber).toFixed(2);
				var profitGlobalS = String(profitGlobal);
				profitGlobalS = profitGlobalS.replace(".",",");
				$(".profit").text(profitGlobalS+"€")
			}
		});

		
	});
	$(window).resize(function() {
		
	});

});//jQuery END