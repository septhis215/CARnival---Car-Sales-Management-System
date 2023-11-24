<?php 
$user = $conn->query("SELECT * FROM customer where custID ='".$_settings->userdata('id')."'");
foreach($user->fetch_assoc() as $k =>$v){
    $meta[$k] = $v;
}
?>

<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-customer">	
				<input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
				<div class="form-group">
					<label for="firstname">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="lastname">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>" required autocomplete="off">
				</div>
				<div class="form-group">
					<label for="phonenumber">Phone Number</label>
					<input type="text" name="phonenumber" id="phonenumber" class="form-control" value="<?php echo isset($meta['phonenumber']) ? $meta['phonenumber']: '' ?>" required autocomplete="off">
				</div>
				<div class="form-group">
					<label for="address">Address</label>
					<input type="textbox" name="address" id="address" class="form-control" value="<?php echo isset($meta['address']) ? $meta['address']: '' ?>" required autocomplete="off">
				</div>
				<div class="form-group">
					<label for="sex">Sex</label>
					<select name="sex" id="sex" class="form-control" required>
						<option value="Male" <?php echo isset($meta['sex']) && $meta['sex'] == 'Male' ? 'selected' : ''; ?>>Male</option>
						<option value="Female" <?php echo isset($meta['sex']) && $meta['sex'] == 'Female' ? 'selected' : ''; ?>>Female</option>
					</select>
				</div>
				<div class="form-group">
					<label for="dob">Birthday</label>
					<input type="date" name="dob" id="dob" class="form-control" value="<?php echo isset($meta['dob']) ? $meta['dob'] : ''; ?>" required>
				</div>

			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary" form="manage-customer">Update</button>
				</div>
			</div>
		</div>
</div>
<script>
	$('#manage-customer').submit(function(e){
		e.preventDefault();
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Users.php?f=registration',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					location.reload()
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_loader()
				}
			}
		})
	})

</script>