
<table style="margin-top: 5px;" class="table table-responsive-sm table-bordered grid-table">
	<thead>
	<tr>
	<?php
		$count = 1;
	?>
	<?php foreach($headers as $header) :?>
		<th class="table-sortable-column" id="sortable-col-<?php echo $count; ?>">
			<?php echo $header; ?>
			<i style="display:none;" class="fa fa-caret-down fa-lg header-down-col-<?php echo $count; ?>"></i>
			<i style="display:none;" class="fa fa-caret-up fa-lg header-up-col-<?php echo $count; ?>"></i>
		</th>
		<?php $count++; ?>
	<?php endforeach; ?>
	 </tr>
	</thead>
	<tbody>
	</tbody>
</table>
<div class="form-group row">
	<div class="col-md-2">
		<input type="hidden" id="pagenumber-hidden" name="pagenumber" value="1" />
		<ul class="pagination" name="pagenumber-list">
		</ul>
	</div>
</div>
