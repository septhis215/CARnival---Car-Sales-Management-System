<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `carModel` where modelID = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
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
	<h4 class="font-wight-bolder"><?= isset($modelID) ? "Update Model Details" : "New Model Entry" ?></h4>
</div>
<div class="row mt-n4 align-items-center justify-content-center flex-column">
	<div class="col-lg-10 col-md-11 col-sm-12 col-xs-12">
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid">
					<form action="" id="model-form">
						<input type="hidden" name ="modelID" value="<?php echo isset($modelID) ? $modelID : '' ?>">
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="manufacturerID" class="control-label">Manufacturer</label>
								<select name="manufacturerID" id="manufacturerID" class="form-control form-control-sm rounded-0" required="required">
									<option value="" <?= !isset($manufacturerID) ? 'selected' : '' ?>></option>
									<?php 
									$manufacturer = $conn->query("SELECT * FROM `manufacturers` where delete_flag = 0 and `status` = 1 order by `manufacturerName` asc");
									while($row = $manufacturer->fetch_assoc()):
									?>
									<option value="<?= $row['manufacturerID'] ?>" <?= isset($manufacturerID) && $manufacturerID == $row['manufacturerID'] ? 'selected' : '' ?>><?= $row['manufacturerName'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="carTypeID" class="control-label">Type</label>
								<select name="carTypeID" id="carTypeID" class="form-control form-control-sm rounded-0" required="required">
									<option value="" <?= !isset($carTypeID) ? 'selected' : '' ?>></option>
									<?php 
									$types = $conn->query("SELECT * FROM `carType` where delete_flag = 0 and `status` = 1 order by `carTypeName` asc");
									while($row = $types->fetch_assoc()):
									?>
									<option value="<?= $row['carTypeID'] ?>" <?= isset($carTypeID) && $carTypeID == $row['carTypeID'] ? 'selected' : '' ?>><?= $row['carTypeName'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="model" class="control-label">Model</label>
								<input type="text" name="model" id="model" class="form-control form-control-sm rounded-0" value="<?php echo isset($model) ? $model : ''; ?>"  required/>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="engineType" class="control-label">Engine Type</label>
								<input type="text" name="engineType" id="engineType" class="form-control form-control-sm rounded-0" value="<?php echo isset($engineType) ? $engineType : ''; ?>"  required/>
							</div>
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="transmissionType" class="control-label">Transimission Type</label>
								<input type="text" name="transmissionType" id="transmissionType" class="form-control form-control-sm rounded-0" value="<?php echo isset($transmissionType) ? $transmissionType : ''; ?>"  required/>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<label for="description" class="control-label">Description</label>
								<textarea rows="4" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : ''; ?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="status" class="control-label">Status</label>
								<select name="status" id="status" class="form-control form-control-sm rounded-0" required="required">
									<option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
									<option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
								</select>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-flat btn-sm btn-navy bg-gradient-navy" form="model-form"><i class="fa fa-save"></i> Save</button>
				<?php if(isset($modelID)): ?>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=models/view_model&id=<?= isset($modelID) ? $modelID : '' ?>"><i class="fa fa-angle-left"></i> Cancel</a>
				<?php else: ?>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=models"><i class="fa fa-angle-left"></i> Cancel</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#manufacturerID').select2({
			placeholder:"Please Select Manufacturer here",
			width:'100%',
			containerCssClass:'form-control form-control-sm rounded-0'
		})
		$('#typeID').select2({
			placeholder:"Please Select Car Type here",
			width:'100%',
			containerCssClass:'form-control form-control-sm rounded-0'
		})
		$('#model-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_model",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.replace('./?page=models/view_model&id='+resp.pid)
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").scrollTop(0);
                    }else{
						alert_toast("An error occured",'error');
					}
					end_loader()
				}
			})
		})

	})
</script>