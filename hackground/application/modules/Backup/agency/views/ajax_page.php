<?php if($page == 'add'){ ?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo $title;?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span></button>
	
</div>
<div class="modal-body">
		<form role="form" id="add_form" action="<?php echo $form_action;?>" onsubmit="submitForm(this, event)">
             
				
				<div class="form-group">
                  <label for="agent_name">Agency Name </label>
                  <input type="text" class="form-control reset_field" id="agent_name" name="agent_name" autocomplete="off">
                </div>
				<div class="form-group">
                  <label for="agent_registration_number">Agency Registration Number </label>
                  <input type="text" class="form-control reset_field" id="agent_registration_number" name="agent_registration_number" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="agent_permit_number">Agency Permit Number </label>
                  <input type="text" class="form-control reset_field" id="agent_permit_number" name="agent_permit_number" autocomplete="off">
                </div>
				<div class="form-group">
                  <label for="ded_license_number">DED License Number </label>
                  <input type="text" class="form-control reset_field" id="ded_license_number" name="ded_license_number" autocomplete="off">
                </div>

				
				<?php $this->load->view('upload_file_component', array('input_name' => 'agent_logo',  'label' => 'Agent logo',  'url' => base_url('agency/upload_file/logo'))); ?>
				
			
				
				
			   <div class="form-group">
			   <p><b>Status</b></p>
                <div class="radio-inline">
					<input type="radio" name="status" value="1" class="magic-radio" id="status_1" checked>
					<label for="status_1">Active</label> 
				</div>
				 <div class="radio-inline">
					  <input type="radio" name="status" value="0" class="magic-radio" id="status_0">
					  <label for="status_0">Inactive</label> 
				  </div>
              </div>
			  
			  <div class="form-group">
				<div>
			     <input type="checkbox" name="add_more" value="1" class="magic-checkbox" id="add_more">
                  <label for="add_more">Add more record</label>
				</div>
              </div>
			  

                <button type="submit" class="btn btn-site">Add</button>

        </form>
</div>

<script>

init_plugin();

function submitForm(form, evt){
	evt.preventDefault();
	ajaxSubmit($(form), onsuccess);
}

function onsuccess(res){
	if(res.cmd){
		if(res.cmd == 'reload'){
			location.reload();
		}else if(res.cmd == 'reset_form'){
			var form = $('#add_form');
			form.find('.reset_field').val('');
		}		
		
	}
}

</script>
<?php } ?>

<?php if($page == 'edit'){ ?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo $title;?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span></button>
	
</div>
<div class="modal-body">
		<form role="form" id="add_form" action="<?php echo $form_action;?>" onsubmit="submitForm(this, event)">
			  <input type="hidden" name="ID" value="<?php echo $ID?>"/>
				
				<div class="form-group">
                  <label for="agent_name">Agency Name </label>
                  <input type="text" class="form-control reset_field" id="agent_name" name="agent_name" autocomplete="off" value="<?php echo !empty($detail['agent_name']) ? $detail['agent_name'] : '';?>">
                </div>
				<div class="form-group">
                  <label for="agent_registration_number">Agency Registration Number </label>
                  <input type="text" class="form-control reset_field" id="agent_registration_number" name="agent_registration_number" autocomplete="off" value="<?php echo !empty($detail['agent_registration_number']) ? $detail['agent_registration_number'] : '';?>" readonly>
                </div>
                <div class="form-group">
                  <label for="agent_permit_number">Agency Permit Number </label>
                  <input type="text" class="form-control reset_field" id="agent_permit_number" name="agent_permit_number" autocomplete="off" value="<?php echo !empty($detail['agent_permit_number']) ? $detail['agent_permit_number'] : '';?>">
                </div>
				<div class="form-group">
                  <label for="ded_license_number">DED License Number </label>
                  <input type="text" class="form-control reset_field" id="ded_license_number" name="ded_license_number" autocomplete="off" value="<?php echo !empty($detail['ded_license_number']) ? $detail['ded_license_number'] : '';?>">
                </div>

				<?php if(!empty($detail['agent_logo']) && file_exists(LC_PATH.'broker/company-logo/'.$detail['agent_logo'])){ ?>
				<div class="form-group">
                  <label>Previous Image </label>
                  <div class="image-wrapper" id="previous_agent_logo">
					<button type="button" class="close" onclick="removeByID('previous_agent_logo')"><span aria-hidden="true">&times;</span></button>
					<img src="<?php echo UPLOAD_HTTP_PATH.'broker/company-logo/'.$detail['agent_logo']; ?>" class="img-rounded" alt="" width="210">
					<input type="hidden" name="agent_logo" value="<?php echo $detail['agent_logo'];?>"/>
				</div>
                </div>
				<?php } ?>
				<?php $this->load->view('upload_file_component', array('input_name' => 'agent_logo',  'label' => 'Agent logo',  'url' => base_url('agency/upload_file/logo'))); ?>
				
				
				
			   <div class="form-group">
			   <label class="form-label">Status</label>
                <div class="radio-inline">
					<input type="radio" name="status" value="1" class="magic-radio" id="status_1" checked>
					<label for="status_1">Active</label> 
				</div>
				 <div class="radio-inline">
					  <input type="radio" name="status" value="0" class="magic-radio" id="status_0" <?php echo $detail['agent_status'] == '0' ?  'checked' : ''; ?>>
					  <label for="status_0">Inactive</label> 
				  </div>
              </div>
			  
                <button type="submit" class="btn btn-site">Save</button>
        </form>
</div>

<script>

init_plugin();

function submitForm(form, evt){
	evt.preventDefault();
	ajaxSubmit($(form), onsuccess);
}

function onsuccess(res){
	if(res.cmd && res.cmd == 'reload'){
		location.reload();
	}
}

</script>
<?php } ?>