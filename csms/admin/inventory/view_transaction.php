<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
	$transaction_qry = $conn->query("SELECT *, concat(firstname,' ', lastname) as customer from `transaction_list` where id = '{$_GET['id']}' ");
    if($transaction_qry->num_rows > 0){
        foreach($transaction_qry->fetch_assoc() as $k => $v){
            $transaction[$k]=$v;
        }
    }
	if(isset($transaction['vehicle_id'])){
		$qry = $conn->query("SELECT * FROM `inventory` WHERE inventoryID = '{$transaction['vehicle_id']}' ");
		if($qry->num_rows > 0){
			$inventoryData = $qry->fetch_assoc();
			$modelID = $inventoryData['modelID'];
	
			foreach($inventoryData as $k => $v){
				${$k} = $v;
			}
		}
	
		if(isset($modelID)){
			$model_qry = $conn->query("SELECT m.*, b.manufacturerName as `manufacturer`, ct.carTypeName as `type` from carmodel m inner join manufacturers b on m.manufacturerID = b.manufacturerID inner join carType ct on m.carTypeID = ct.carTypeID where m.modelID = '{$modelID}'");
			if($model_qry->num_rows > 0){
				$model = $model_qry->fetch_assoc();
			}
		}
	}
	
}
?>
<style>
	legend.legend-sm {
		font-size: 1.4em;
	}
	#cimg{
		max-width: 100%;
		max-height: 20em;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="content py-5 px-3 bg-gradient-navy">
	<h4 class="font-wight-bolder">Transaction Details</h4>
</div>
<div class="row mt-n4 align-items-center justify-content-center flex-column">
	<div class="col-lg-10 col-md-11 col-sm-12 col-xs-12">
		<div class="card rounded-0 shadow">
			<div class="card-footer py-1 text-center">
				<button class="btn btn-flat btn-sm btn-success bg-gradient-success" id="print"><i class="fa fa-print"></i> Print</button>
				<a class="btn btn-flat btn-sm btn-navy bg-gradient-navy border" href="./?page=inventory/sell_vehicle&transaction_id=<?= isset($transaction['id']) ? $transaction['id'] : '' ?>"><i class="fa fa-edit"></i> Edit</a>
				<button class="btn btn-flat btn-sm btn-danger bg-gradient-danger" id="delete-transaction"><i class="fa fa-trash"></i> Delete</button>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=inventory/transactions"><i class="fa fa-angle-left"></i> Cancel</a>
			</div>
		</div>
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid" id="printout">
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Manufacturer:</div>
						<div class="col-9 mb-0 border"><?= isset($model['manufacturer']) ? $model['manufacturer'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Car Type:</div>
						<div class="col-9 mb-0 border"><?= isset($model['type']) ? $model['type'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Model:</div>
						<div class="col-9 mb-0 border"><?= isset($model['model']) ? $model['model'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Engine Type:</div>
						<div class="col-9 mb-0 border"><?= isset($model['engineType']) ? $model['engineType'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Transmission Type:</div>
						<div class="col-9 mb-0 border"><?= isset($model['transmissionType']) ? $model['transmissionType'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Description:</div>
						<div class="col-9 mb-0 border"><?= isset($model['description']) ? htmlspecialchars_decode($model['description']) : '' ?></div>
					</div>
					<div class="clear-fix my-1"></div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">VR No.</div>
						<div class="col-9 mb-0 border"><?= isset($vr_number) ? $vr_number : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Variant</div>
						<div class="col-9 mb-0 border"><?= isset($variant) ? $variant : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Colors</div>
						<div class="col-9 mb-0 border"><?= isset($colors) ? $colors : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Engine Number</div>
						<div class="col-9 mb-0 border"><?= isset($engine_number) ? $engine_number : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Chasis Number</div>
						<div class="col-9 mb-0 border"><?= isset($chasis_number) ? $chasis_number : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Price</div>
						<div class="col-9 mb-0 border"><?= isset($price) ? format_num($price, 2) : '' ?></div>
					</div>
					<div class="clear-fix my-1"></div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Transaction Date & Time</div>
						<div class="col-9 mb-0 border"><?= isset($transaction['date_created']) ? date("M d, Y h:i A", strtotime($transaction['date_created'])) : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Agent Name</div>
						<div class="col-9 mb-0 border"><?= isset($transaction['salesperson']) ? $transaction['salesperson'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Customer</div>
						<div class="col-9 mb-0 border"><?= isset($transaction['customer']) ? $transaction['customer'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Sex</div>
						<div class="col-9 mb-0 border"><?= isset($transaction['sex']) ? $transaction['sex'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Birthday</div>
						<div class="col-9 mb-0 border"><?= isset($transaction['dob']) ? date("F d, Y", strtotime($transaction['dob'])) : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Contact #</div>
						<div class="col-9 mb-0 border"><?= isset($transaction['contact']) ? $transaction['contact'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Email</div>
						<div class="col-9 mb-0 border"><?= isset($transaction['email']) ? $transaction['email'] : 'N/A' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Address</div>
						<div class="col-9 mb-0 border"><?= isset($transaction['address']) ? $transaction['address'] : 'N/A' ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<noscript id="print-header">
	<div>
		<div class="d-flex w-100 align-items-center">
			<div class="col-2 text-center">
					<img src="<?= validate_image($_settings->info('logo')) ?>" style="width:4em !important;height:4em !important;object-fit:cover;object-position:center center" class="img-thumbnail p-0 border border-dark rounded-circle" alt="">
			</div>
			<div class="col-8 text-center" style="line-height:1em">
				<h4 class="text-center mb-0"><?= $_settings->info('name') ?></h4>
				<h4 class="text-center mb-0">Transaction Details</h4>
			</div>
		</div>
		<hr>
	</div>
</noscript>
<script>
	$(document).ready(function(){
		$('#print').click(function(){
			var p = $('head').clone()
			var ph = $($('noscript#print-header').html()).clone()
			var el = $('#printout').clone()
			var s = $('#script-list').clone()

			var nw = window.open("", "_blank", "width="+($(window).width() * .8)+",left="+($(window).width() * .1)+",height="+($(window).height() * .8)+",top="+($(window).height() * .1))
			nw.document.querySelector('head').innerHTML = p.html()
			nw.document.querySelector('body').innerHTML = ph[0].outerHTML
			nw.document.querySelector('body').innerHTML += el[0].outerHTML
			nw.document.querySelector('body').innerHTML += s[0].outerHTML
			nw.document.close()
			start_loader()
			setTimeout(() => {
				nw.print()
				setTimeout(() => {
					nw.close()
					end_loader()	
				})
			}, 300);
		})
		$('#delete-transaction').click(function(){
			_conf("Are you sure to delete this transaction permanently?","delete_transaction",['<?= isset($_GET['id']) ? $_GET['id']: '' ?>'])
		})
	})
	function delete_transaction($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_transaction",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace('./?page=inventory/transactions');
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>