<!-- Sidebar Start-->
<div class="border-end bg-white" id="sidebar-wrapper">
	<div class="sidebar-heading border-bottom bg-light text-center"><img src="<?php echo base_url(); ?>/assets/img/pngwing.com" style="width:50px;height:auto;" /></div>
	<div class="list-group list-group-flush">

		<a class="list-group-item" href="<?php echo base_url('dashBoardIndex'); ?>">Dashboard</a>

		<?php if (verifyUserPermission(2)): ?>
			<a class="list-group-item" href="<?php echo base_url('getOrgList'); ?>">App Approval List</a>
		<?php endif?>

		<a class="list-group-item" href="<?php echo base_url('appLogout'); ?>">Logout</a>

 		<!-- <a class="list-group-item btn-primary" data-toggle="collapse" href="#admin_activity" role="button" aria-expanded="false" aria-controls="admin_activity" >Admin Activity</a>
 		<div class="collapse" id="admin_activity">
 			<a class="list-group-item" href="<?php echo base_url('add_Alt_Admin'); ?>">Add Comp Admin</a>
 			<a class="list-group-item" href="<?php echo base_url('add_Location'); ?>">Add Comp Location</a>
 			<a class="list-group-item" href="<?php echo base_url('add_Department'); ?>">Add Comp Department</a>
 			<a class="list-group-item" href="<?php echo base_url('add_User'); ?>">Add USER</a>
 		</div>

 		<a class="list-group-item btn-primary" data-toggle="collapse" href="#transfer_point" role="button" aria-expanded="false" aria-controls="transfer_point">Transfer Points</a>
 		<div class="collapse" id="transfer_point">
 			<a class="list-group-item" href="<?php echo base_url('tranfer_points_dept_to_dept'); ?>">Between Departments</a>
 			<a class="list-group-item" href="<?php echo base_url('tranfer_points_loc_to_loc'); ?>">Between Locations</a>
 			<a class="list-group-item" href="<?php echo base_url('tranfer_points_pool_to_dept'); ?>">Pool to Department</a>
 			<a class="list-group-item" href="<?php echo base_url('tranfer_points_dept_to_pool'); ?>">Department to Pool</a>
 		</div> -->

 	</div>
 </div>
 <!-- Sidebar end-->
