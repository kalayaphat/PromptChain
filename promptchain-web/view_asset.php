<?php 
    include_once("page_header.php");
    include_once("primechain_functions/config.php");
    include_once("primechain_functions/blockchain_engine.php");
    $crud_engine = new crudEngine();
    $blockchain_engine = new blockchainEngine();
    $user_id = $_SESSION['user_id'];
    $user = $crud_engine->getUserFullDetails($_SESSION['user_id'], true);
?>
                        
<div class="col-lg-8">
	<div class="row">
		<table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'>
		    <thead>
		        <tr>
		            <th>Asset name</th>
		            <th>Total</th>
		            <th>Your balance</th>
		            <th>Asset type</th>
		            <th>Re-issue</th>
		        </tr>
		    </thead>
		    <tbody>
				<?php
					$asset_name_list = $crud_engine->listAssetsNamesForUser($user_id);
					$addressBalances = $blockchain_engine->getAssetBalancesForAddress($user->user_public_address);
					$addressBalancesIndexed = array();
					foreach ($addressBalances as $balance) {
						$addressBalancesIndexed[$balance['assetref']] = $balance;
					}

					// $assets_info_list = $blockchain_engine->getAssetsFullDetails($asset_name_list);
					if ($asset_name_list === false)
						throw new Exception("Error fetching users details!", 1);
					$assets = $blockchain_engine->getAssetsFullDetails($asset_name_list);
					if ($assets === false)
						throw new Exception("Error fetching users details!", 1);

					foreach ($assets as $asset) 
					{
						echo "
						<tr class='odd gradeX'>
							<td>".$asset->name."</td>
							<td>".$asset->quantity."</td>
							<td>".$addressBalancesIndexed[$asset->asset_ref]['qty']."</td>
							<td>".$asset->type."</td>
		                    <td>";
		                    	if ($asset->type == Literals::ASSET_TYPE_CODES['OPEN']) 
	                    		{ 
	                    			echo "<a href='reissue_asset.php?asset_ref=".$asset->asset_ref."'><button type='button' class='btn btn-info'>Re-issue</button></a>";
	                    		}
		                    	else 
	                    		{
	                    			echo "<button type='button' class='btn btn-danger' disabled>Closed asset</button>";
	                    		}
	                    	echo "</td>
						</tr>";
					}
				?>
	         </tbody>
	    </table>
	</div>
	<div class="row">
	</div>
</div>

<?php include("page_footer.php");?>
