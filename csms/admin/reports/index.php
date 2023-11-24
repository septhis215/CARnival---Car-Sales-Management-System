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
<?php
$month = isset($_GET['month']) ? $_GET['month'] : date("Y-m");
?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">Monthly Sales Report</h3>
	</div>
	<div class="card-body">
        <div class="container-fluid">
            <fieldset class="border pb-3 px-2 mb-3">
                <legend class="w-auto px-3">Filter & Action</legend>
                <form action="" id="filter-form">
                    <div class="row align-items-end">
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="month" class="control-label">Choose Month</label>
                                <input type="month" class="form-control form-control-sm rounded-0" id="month" name="month" value="<?= $month ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-flat btn-primary bg-gradient-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                                <button class="btn btn-flat btn-success bg-gradient-success btn-sm" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                            </div>
                        </div>
                    </div>
                </form>
            </fieldset>
			<table class="table table-hover table-striped table-bordered" id="transaction-tbl">
			<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>DateTime</th>
						<th>Customer</th>
						<th>Salesperson</th>
						<th>Vehicle</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$total = 0;
					$i = 1;
					$qry = $conn->query("
					SELECT t.*, 
						CONCAT(t.firstname, ' ', t.lastname) as customer, 
						u.email as salesperson_email,
						v.vr_number,
						v.price, 
						m.model, 
						m.engineType, 
						m.transmissionType, 
						b.manufacturerName as `manufacturer`, 
						ct.carTypeName as `type` 
					FROM transaction_list t 
					INNER JOIN `inventory` v ON t.vehicle_id = v.inventoryID 
					INNER JOIN carModel m ON v.modelID = m.modelID 
					INNER JOIN manufacturers b ON m.manufacturerID = b.manufacturerID 
					INNER JOIN carType ct ON m.carTypeID = ct.carTypeID 
					INNER JOIN users u ON t.salesperson = CONCAT(u.firstname, ' ', u.lastname) 
					WHERE v.status = 1 
					AND v.delete_flag = 0 
					AND DATE_FORMAT(t.date_created, '%Y-%m') = '{$month}' 
					ORDER BY ABS(UNIX_TIMESTAMP(v.date_created)) ASC 
				");
				
						while($row = $qry->fetch_assoc()):
						$total += $row['price'];

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
							<td class="text-left"><?= number_format($row['price'], 2) ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="4" class="text-center font-weight-bolder">Total Sales</th>
						<th class="text-left"><?= format_num($total,2) ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<noscript id="print-header">
	<div>
		<style>
			html, body{
				min-height:unset !important;
			}
		</style>
		<div class="d-flex w-100 align-items-center">
			<div class="col-2 text-center">
					<img src="<?= validate_image($_settings->info('logo')) ?>" style="width:4em !important;height:4em !important;object-fit:cover;object-position:center center" class="img-thumbnail p-0 border border-dark rounded-circle" alt="">
			</div>
			<div class="col-8 text-center" style="line-height:1em">
				<h4 class="text-center mb-0"><?= $_settings->info('name') ?></h4>
				<h4 class="text-center mb-0">Monthly Sales Report</h4>
				<h4 class="text-center mb-0">as of <?= date("F Y", strtotime($month.'-01')) ?></h4>
			</div>
		</div>
		<hr>
	</div>
</noscript>
<script>
	$(document).ready(function(){
		$('#transaction-tbl').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')

        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = "./?page=reports&"+$(this).serialize()
        })
        $('#print').click(function(){
			var p = $('head').clone()
			var ph = $($('noscript#print-header').html()).clone()
			var el = $('#transaction-tbl').clone()
			var s = $('#script-list').clone()
			el.dataTable().fnDestroy()
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
	})
</script>