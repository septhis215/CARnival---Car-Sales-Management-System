<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `manufacturers` where manufacturerID = '{$_GET['id']}' and delete_flag = 0 ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
		echo '<script>alert("Manufacturer ID is not valid."); location.replace("./?page=manufacturers")</script>';
	}
}else{
	echo '<script>alert("Manufacturer ID is Required."); location.replace("./?page=manufacturers")</script>';
}
?>
<style>
	#uni_modal .modal-footer{
		display:none !important;
	}
</style>
<div class="container-fluid">
	<dl>
		<dt class="text-muted">Manufacturer</dt>
		<dd class="pl-4"><?= isset($manufacturerName) ? $manufacturerName : "" ?></dd>
		<dt class="text-muted">Vehicle Status</dt>
		<dd class="pl-4">
			<?php if($status == 1): ?>
				<span class="badge badge-success px-3 rounded-pill">Available</span>
			<?php else: ?>
				<span class="badge badge-danger px-3 rounded-pill">Unavailable</span>
			<?php endif; ?>
		</dd>
	</dl>
</div>
<hr class="mx-n3">
<div class="py-1 text-right">
	<button class="btn btn-flat btn-sm btn-light bg-gradient-light border" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
</div>