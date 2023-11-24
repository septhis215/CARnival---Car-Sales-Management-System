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
		<h3 class="card-title">List of Transactions</h3>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>DateTime</th>
						<th>Customer</th>
						<th>Salesperson</th>
						<th>Vehicle</th>
						<th>Price</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("
                    SELECT t.*, 
                        CONCAT(t.firstname,' ', t.lastname) as customer, 
						u.email as salesperson_email,
                        v.vr_number, 
                        v.price, 
                        m.model, 
                        m.engineType, 
                        m.transmissionType, 
                        b.manufacturerName as manufacturer, 
                        ct.carTypeName as type 
                    FROM transaction_list t 
                    INNER JOIN inventory v ON t.vehicle_id = v.inventoryID
                    INNER JOIN carmodel m ON v.modelID = m.modelID 
                    INNER JOIN manufacturers b ON m.manufacturerID = b.manufacturerID 
                    INNER JOIN cartype ct ON m.carTypeID = ct.carTypeID 
                    INNER JOIN users u ON t.salesperson = CONCAT(u.firstname,' ', u.lastname)
                    WHERE v.status = 1 AND v.delete_flag = 0 
                    ORDER BY ABS(UNIX_TIMESTAMP(v.date_created)) ASC 
                ");
				
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
                            <td><?= date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
							<td class="">
								<div style="line-height:1em">
									<div><b><?= $row['customer'] ?></b></div>
									<div><small class="text-muted"><?= $row['email'] ?></small></div>
								</div>
							</td>
							<td>
							<div><b><?= $row['salesperson'] ?></b></div>
							<div><small class="text-muted"><?= $row['salesperson_email'] ?></small></div>

						</td>
							<td class="">
								<div style="line-height:1em">
									<div><b><?= $row['manufacturer'] ?> - <?= $row['model'] ?></b></div>
									<div><small class="text-muted">Plate #: <?= $row['vr_number'] ?></small></div>
								</div>
							</td>
							<td class="text-right"><?= number_format($row['price'], 2) ?></td>
							<td align="center" class='text-center'>
								<a class="btn btn-flat btn-light bg-gradient-light btn-sm border" href="./?page=inventory/view_transaction&id=<?= $row['id'] ?>"><i class="fa fa-eye"></i> View</a>
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