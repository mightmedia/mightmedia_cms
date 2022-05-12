<div class="block-header">
	<h2>
		Users
	</h2>
</div>

<!-- Headings -->
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					List
				</h2>
			</div>
			<div class="body">
				<div class="body table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>name</th>
								<th>email</th>
								<th>active</th>
							</tr>
						</thead>
						<tbody>
							<?php if(! empty($users)) { ?>
								<?php foreach ($users as $userItem) { ?>
									<tr<?php echo (!$userItem['active'] ? ' class=" warning"' : ''); ?> >
										<th scope="row">
											<?php echo $userItem['id']; ?>
										</th>
										<td>
											<a href="<?php echo getRouteUrl('users.edit', ['id' => $userItem['id']]); ?>">
												<?php echo $userItem['name']; ?>
											</a>
										</td>
										<td>
											<?php echo $userItem['email']; ?>
										</td>
										<td>
											<?php echo $userItem['active']; ?>
										</td>
									</tr>
								<?php } ?>
							<?php } else { ?>
								<tr>
									<td colspan="4">
										No items
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<!-- pagination -->
					<nav>
						<ul class="pagination">
							<?php if($page != 1) { ?>
								<li>
									<a href="<?php echo getRouteUrl('users.list.pagination', ['page' => ($page - 1)]); ?>" class="waves-effect">
										<i class="material-icons">chevron_left</i>
									</a>
								</li>
							<?php } ?>
							<?php for($pag = 1; $pag <= $totalPages; $pag++) { ?>
								<?php
									if($page == $pag) {
										$class = ' class="active"';
									} else {
										$class = '';
									}
								?>
								<li<?php echo $class; ?>>
									<a href="<?php echo getRouteUrl('users.list.pagination', ['page' => $pag]); ?>" class="waves-effect">
										<?php echo $pag; ?>	
									</a>
								</li>
							<?php } ?>
							
							<?php if($page != $totalPages) { ?>
								<li>
									<a href="<?php echo getRouteUrl('users.list.pagination', ['page' => ($page + 1)]); ?>" class="waves-effect">
										<i class="material-icons">chevron_right</i>
									</a>
								</li>
							<?php } ?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>