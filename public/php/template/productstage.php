<?php
//labels
$headline = 'Fancy Product Designer';
$save_product_tooltip = 'Save product';
$download_image_tooltip = 'Download Product Image';
$print_tooltip = 'Print';
$pdf_tooltip = 'Save As PDF';
$reset_tooltip = 'Reset Product';
?>

<section class="fpd-product-container fpd-border-color">
	<div class="fpd-menu-bar fpd-clearfix fpd-main-color">
		<h3><?php echo $headline; ?></h3>
		<!-- Menu -->
		<div class="fpd-menu">
			<ul class="fpd-clearfix">
				<li><span class="fpd-save-product fa fa-floppy-o fpd-main-color fpd-tooltip" title="<?php echo $save_product_tooltip; ?>"></span></li>
				<li><span class="fpd-download-image fa fa-cloud-download fpd-main-color fpd-tooltip" title="<?php echo $download_image_tooltip; ?>"></span></li>
				<li><span class="fpd-save-pdf fa fa-file-o fpd-tooltip" title="<?php echo $pdf_tooltip; ?>"></span></li>
				<li><span class="fpd-print fa fa-print fpd-tooltip" title="<?php echo $print_tooltip; ?>"></span></li>
				<li><span class="fpd-reset-product fa fa-undo fpd-tooltip" title="<?php echo $reset_tooltip; ?>"></span></li>
			</ul>
		</div>
	</div>
	<!-- Kinetic Stage -->
	<div class="fpd-product-stage fpd-content-color">
		<canvas></canvas>
	</div>
</section>