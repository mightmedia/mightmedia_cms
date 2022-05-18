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

					<?php
						array_map(function($arr) use(&$output) {
						
							$output[$arr['id']] = $arr;

						}, $selectedPermissions);

						foreach ($permissions as $g) {
							$groupedPermissions[$g['group']][$g['id']]['name'] = $g['name'];

							if(isset($output[$g['id']])) {
								$groupedPermissions[$g['group']][$g['id']]['selected'] = true;
							} else {
								$groupedPermissions[$g['group']][$g['id']]['selected'] = false;
							}
						}

					?>
					<label for="permissions">Permissions</label>
					<select name="permissions" id="optgroup" class="ms" multiple="multiple">
						<?php foreach ($groupedPermissions as $group => $permissions) { ?>
							<optgroup label="<?php echo $group; ?>">
								<?php foreach ($permissions as $id => $permission) { ?>
									<option value="<?php echo $id; ?>"<?php echo $permission['selected'] ? ' selected' : ''; ?>>
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