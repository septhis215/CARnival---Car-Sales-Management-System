<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Manufacturers</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="add_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Add New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="50%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>No.</th>
						<th>Manufacturer</th>
						<th>Current Status</th>
						<th>Date/Time Created</th>
						<th>Operation</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `manufacturers` where delete_flag = 0 order by `manufacturerName` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?= $row['manufacturerName'] ?></td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Available</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Unavailable</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								<span><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></span>
							</td>
							<td align="center">
									<button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
											Option
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item view_manufacturer" href="javascript:void(0)" data-id="<?php echo $row['manufacturerID'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item edit_manufacturer" href="javascript:void(0)" data-id="<?php echo $row['manufacturerID'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_manufacturer" href="javascript:void(0)" data-id="<?php echo $row['manufacturerID'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
									</div>
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
		$('#add_new').click(function(){
			uni_modal('<i class="far fa-plus-square"></i> New Manufacturer','manufacturers/manage_manufacturer.php')
		})
		$('.view_manufacturer').click(function(){
			uni_modal('<i class="fa fa-th-list"></i> Manufacturer Details', 'manufacturers/view_manufacturer.php?id='+$(this).attr('data-id'))
		})
		$('.edit_manufacturer').click(function(){
			uni_modal('<i class="fa fa-edit"></i> Update Manufacturer Details', 'manufacturers/manage_manufacturer.php?id='+$(this).attr('data-id'))
		})
		$('.delete_manufacturer').click(function(){
			_conf("Do you want to delete this Manufacturer permanently?","delete_manufacturer",[$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_manufacturer($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_manufacturer",
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
