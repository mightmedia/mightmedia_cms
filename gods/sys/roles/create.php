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
					Create
				</h2>
			</div>
			<div class="body">
				<form action="" method="post">
					<label for="name">Name</label>
					<div class="form-group">
						<div class="form-line">
							<input type="text" id="name" name="name" class="form-control">
						</div>
					</div>

					<?php

						foreach ($permissions as $g) {
							$groupedPermissions[$g['group']][$g['id']]['name'] = $g['name'];
						}

					?>
					<label for="permissions">Permissions</label>
					<select name="permissions" id="optgroup" class="ms" multiple="multiple">
						<?php foreach ($groupedPermissions as $group => $permissions) { ?>
							<optgroup label="<?php echo $group; ?>">
								<?php foreach ($permissions as $id => $permission) { ?>
									<option value="<?php echo $id; ?>">
										<?php echo $permission['name']; ?>
									</option>
								<?php } ?>
							</optgroup>
						<?php } ?>
                                
					</select>

					<br>
					<button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
					<?php echo CSRFinput(); ?>
				</form>
			</div>
		</div>
	</div>
</div>