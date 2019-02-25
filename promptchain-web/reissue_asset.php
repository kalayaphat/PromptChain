<?php
	include("page_header.php");
	$selectedAssetRef = isset($_GET['asset_ref']) ? $_GET['asset_ref'] : "";
?>

<div class="col-lg-8">
	<form role="form" enctype="multipart/form-data" action="reissue_asset_process.php" method="post">

		<?php
			$assets_names = $crudEngine->listAssetsNamesForUser($_SESSION['user_id']);
			$assets_details = $blockchainEngine->getAssetsFullDetails($assets_names);
		?>

		<div class="alert alert-info">
			<div class="form-group">
				<label> Asset </label>
				<select name="asset_ref" class="form-control">
					<?php 
						foreach ($assets_details as $asset_details) {
							if ($asset_details->isOpen()) {
								echo "<option value='" . $asset_details->asset_ref . "' " . (($selectedAssetRef == $asset_details->asset_ref) ? "selected" : "") . ">" . $asset_details->name . "</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="alert alert-info">
			<div class="form-group">
				<label> Quantity </label>
				<input name="quantity" type="text" class="form-control">
			</div>
		</div>
															
		<button type="submit" class="btn btn-primary">Issue more </button>
		<button type="reset" class="btn btn-danger">Reset</button>
	</form>
</div>

<?php include("page_footer.php");?>
