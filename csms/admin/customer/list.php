<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Customer</h3>
		<div class="card-tools">
			<a href="./?page=customer/manage_customer" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
			<colgroup>
				<col width="5%">
				<col width="12%">
				<col width="12%">
				<col width="12%">
				<col width="10%">
				<col width="6%">
				<col width="13%">
				<col width="10%">
			</colgroup>
			<thead>
				<tr>
					<th>#</th>
					<th>Date Updated</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone No</th>
					<th>Sex</th>
					<th>DoB</th>
					<th>Address</th>
					<th>Action</th>
				</tr>
			</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT *, concat(firstname,' ', lastname) as `name` from `customer` where custID != '{$_settings->userdata('id')}' order by concat(firstname,' ', lastname) asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_updated'])) ?></td>
							
							<td><?php echo $row['name'] ?></td>
							<td><?php echo $row['email'] ?></td>
							<td><?php echo $row['phonenumber'] ?></td>
							<td><?php echo $row['sex'] ?></td>
							<td><?php echo $row['dob'] ?></td>
							<td><?php echo $row['address'] ?></td>W
							<td align="center">
								 <button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="./?page=customer/manage_customer&id=<?= $row['custID'] ?>"><span class="fa fa-edit text-dark"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['custID'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this User permanently?","delete_customer",[$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [6] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Users.php?f=delete_customer",
			method:"POST",
			data:{id: $id},
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(resp == 1){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>