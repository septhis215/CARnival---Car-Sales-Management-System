<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	.vehicle-thumbnail{
		width:3em;
		height:3em;
		object-fit:cover;
		object-position:center center;
	}
</style>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">Car Inventory</h3>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>No.</th>
						<th>Vehicle</th>
						<th>Manufacturer</th>
						<th>Model</th>
						<th>Vehicle Registration No.</th>
						<th>Price</th>
						<th>Operation</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT v.*, m.model, m.engineType, m.transmissionType, b.manufacturerName as `manufacturer`, ct.carTypeName as `type` from `inventory` v inner join carModel m on v.modelID = m.modelID inner join manufacturers b on m.manufacturerID = b.manufacturerID inner join carType ct on m.carTypeID = ct.carTypeID where v.status = 0 and v.delete_flag = 0 order by abs(unix_timestamp(v.date_created)) asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="">
							<div style="line-height: 1em;">
								<?php if (!empty($row['imagePath'])): ?>
									<img src="<?= $row['imagePath'] ?>" alt="Vehicle Image" class="img-fluid">
								<?php else: ?>
									<img src="no-image.jpg" alt="Vehicle Image" class="img-fluid">
								<?php endif; ?>
							</div>
							</td>
							<td class="">
								<div style="line-height:1em">
									<div><b><?= $row['manufacturer'] ?></b></div>
									<div><small class="text-muted"><?= $row['type'] ?></small></div>
								</div>
							</td>
							<td class="">
								<div style="line-height:1em">
									<div><b><?= $row['model'] ?></b></div>
									<div><small class="text-muted"><?= $row['engineType'] ?></small></div>
									<div><small class="text-muted"><?= $row['transmissionType'] ?></small></div>
								</div>
							</td>
							<td class="">
								<div style="line-height:1em">
									<div><?= $row['vr_number'] ?></div>
								</div>
							</td>
							<td class="text-right"><?= number_format($row['price'], 2) ?></td>
							<td align="center" class='text-center'>
								<a class="btn btn-flat btn-light bg-gradient-light btn-sm border sell_vehicle" href="./?page=inventory/sell_vehicle&id=<?= $row['inventoryID'] ?>"><i class="far fa-handshake"></i> Sell</a>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_vehicle($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_vehicle",
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
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>