<?php 
	include_once("page_header.php");
	include_once("primechain_functions/config.php");
	include_once("primechain_functions/blockchain_engine.php");
	$crud_engine = new crudEngine();
	$blockchain_engine = new blockchainEngine();

	// Get full details of the current user
	$user = $crud_engine->getUserFullDetails($_SESSION['user_id'], true);
?>
	<script type="text/javascript" src="js/assets.js"></script>
	<script type="text/javascript">
		window.onload = function() {
			assetNameElement = document.getElementById('asset_name');
			balanceElement = document.getElementById('qty_balance');
			getUserAssetBalance(assetNameElement, balanceElement);
        	setInterval(function(){ getUserAssetBalance(assetNameElement, balanceElement); },3000);
		}
	</script>

	<div class="row">
		<div class="col-md-8">
			<form role="form" action="send_asset_process.php" method="post">
				<div class="alert alert-info">  
					<div class="form-group">
						<label>1. Asset name</label>
						<div class="row">
							<div class="col-sm-3">
								<select id="asset_name" name="asset_name" class="form-control" onchange="getUserAssetBalance(this, qty_balance);">
									<?php
										$asset_name_list = $blockchain_engine->getAssetNamesForAddress($user->user_public_address);
										$assets = $blockchain_engine->getAssetsFullDetails($asset_name_list);

										foreach ($assets as $asset) 
										{
											echo "<option value='".$asset->name."'>".$asset->name."</option>";
										}
									?>
								</select>
							</div>

							<div class="col-sm-4">
								<div style="color:green;"><strong>Balance: <span id="qty_balance"></span></strong></div>
							</div>
						</div>
					</div>
				</div>

				<div class="alert alert-info">  
					<div class="form-group">
						<label>2. Quantity </label>
						<input id="quantity" name="quantity" type="number" class="form-control" value=1>
					</div>
				</div>

				<div class="alert alert-info">  
					<div class="form-group">
						<label>3. Recipient Email </label>
						<input name="recipient" id="recipient" type="text" class="form-control" />
					</div>
				</div>
																	
				<button type="submit" class="btn btn-primary">Send</button>
				<button type="reset" class="btn btn-danger">Reset</button>
			</form>
		</div>
	</div>

<?php include("page_footer.php");?>