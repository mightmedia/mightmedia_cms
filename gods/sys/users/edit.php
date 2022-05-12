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
							<input type="text" id="name" name="name" class="form-control" value="<?php echo ! empty($users['name']) ? $users['name'] : ''; ?>">
						</div>
					</div>

					<label for="email">Email</label>
					<div class="form-group">
						<div class="form-line">
							<input type="text" id="email" name="email" class="form-control" value="<?php echo ! empty($users['email']) ? $users['email'] : ''; ?>">
						</div>
					</div>

					<label for="active">Post activation</label>
					<div class="switch">
						<label>
							NO
							<input id="active" name="active" type="checkbox" value="1" checked>
							<span class="lever switch-col-deep-orange"></span>
							YES
						</label>
					</div>
					<br>
					<button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
					<?php echo CSRFinput(); ?>
				</form>
			</div>
		</div>
	</div>
</div>