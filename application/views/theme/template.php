<?php

$this->load->view('theme/header');

if (isset($permission['statusFlag']) && ($permission['statusFlag'] == true)) {
	$this->load->view($main_content);
} else {?>

	<div class="gm_page">
		<div class="row">
			<div class="col-md-12">
				<label class="error_flag">
					<?php if (isset($permission['statusMsg']) && !empty($permission['statusMsg'])) {echo $permission['statusMsg'];}?>
				</label>
			</div>
		</div>
	</div>

<?php }?>

<?php
$this->load->view('theme/footer');

?>
