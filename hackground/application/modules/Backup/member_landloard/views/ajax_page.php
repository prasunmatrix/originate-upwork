<?php if($page == 'add'){ ?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo $title;?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
<form role="form" id="add_form" action="<?php echo $form_action;?>" onsubmit="submitForm(this, event)">
      
        <pre>Nothing to submit</pre>
      
     
        <button type="submit" class="btn btn-site">Add</button>
      
</form>
</div>

<script>

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
                  <label for="landlord_name">Landload Name </label>
                  <input type="text" class="form-control reset_field" id="landlord_name" name="landlord_name" autocomplete="off" value="<?php echo !empty($detail['landlord_name']) ? $detail['landlord_name'] : '';?>">
                </div>
				
				<div class="form-group">
                  <label for="deed_number">Deed Numbers</label>
                  <input type="text" class="form-control reset_field" id="deed_number" name="deed_number" autocomplete="off" value="<?php echo !empty($detail['deed_number']) ? $detail['deed_number'] : '';?>">
                </div>
				
				<div class="form-group">
                  <label for="pre_registration_no">Pre Registration No.</label>
                  <input type="text" class="form-control reset_field" id="pre_registration_no" name="pre_registration_no" autocomplete="off" value="<?php echo !empty($detail['pre_registration_no']) ? $detail['pre_registration_no'] : '';?>">
                </div>
				
				<div class="form-group">
				   <label class="form-label">Status</label>
					<div class="radio-inline">
						<input type="radio" name="status" value="1" class="magic-radio" id="status_1" checked>
						<label for="status_1">Active</label> 
					</div>
					 <div class="radio-inline">
						  <input type="radio" name="status" value="0" class="magic-radio" id="status_0" <?php echo $detail['landlord_status'] == '0' ?  'checked' : ''; ?>>
						  <label for="status_0">Inactive</label> 
					  </div>
				</div>
			  
				
			  
              
                <button type="submit" class="btn btn-site">Save</button>
          
        </form>
</div>

<script>

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