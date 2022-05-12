<?php
	global $headerData;
?>

<div class="block-header">
	<h2>
		<?php echo $headerData['pageName']; ?>
	</h2>
</div>

<!-- Headings -->
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					Edit
				</h2>
			</div>
			<div class="body">
				<form action="" method="post">
					<label for="name">Name</label>
					<div class="form-group">
						<div class="form-line">
							<input type="text" id="name" name="name" class="form-control" value="<?php echo ! empty($roles['name']) ? $roles['name'] : ''; ?>">
						</div>
					</div>

					<select id="optgroup" class="ms" multiple="multiple">
                                <optgroup label="Alaskan/Hawaiian Time Zone">
                                    <option value="AK">Alaska</option>
                                    <option value="HI">Hawaii</option>
                                </optgroup>
					</select>

					<br>
					<button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
					<?php echo CSRFinput(); ?>
				</form>
			</div>
		</div>
	</div>
</div>