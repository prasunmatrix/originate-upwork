<?php if($page == 'add'){ ?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo $title;?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span></button>
	
</div>
<div class="modal-body">
<form role="form" id="add_form" action="<?php echo $form_action;?>" onsubmit="submitForm(this, event)">
    
    <div class="form-group">
      <label for="category_key">Location </label>
      <select class="form-control select2" name="advertisement_location[]" data-placeholder="Advertisement Location" multiple>
        <?php print_select_option($location, 'state_id', 'state_name'); ?>
      </select>
    </div>
    
    <div class="form-group">
      <label for="category_key">Category </label>
      <select class="form-control select2" name="advertisement_category[]" data-placeholder="Advertisement Category" multiple>
        <?php print_select_option($category, 'category_id', 'category_name'); ?>
      </select>
    </div>
    
    
    <div class="form-group">
      <label for="category_key">Page </label>
      <select class="form-control" name="page" onchange="get_position()">
        <option value="">-Select-</option>
        <?php foreach($pages as $page){ ?>
        <option value="<?php echo $page['slug'];?>"><?php echo $page['name'];?></option>
        <?php } ?>
      </select>
    </div>
    
    <div class="form-group">
      <label for="category_key">Position </label>
      <select class="form-control" name="position" onchange="get_size()">
        <option value="">-Select-</option>
      </select>
    </div>
    
    <div class="form-group">
      <label for="category_key">Size </label>
      <select class="form-control" name="ad_size">
        <option value="">-Select-</option>
      </select>
    </div>
    
    <div class="form-group">
      <label for="category_key">Type </label>
      <select class="form-control" name="ad_type" onchange="checkAdType()">
        <option value="admin">Admin</option>
        <option value="script">Script</option>
        <option value="image">Image</option>
      </select>
    </div>
    
    <div id="ad_image_wrapper">
    <?php $this->load->view('upload_file_component', array('input_name' => 'ad_image',  'label' => 'Advertisement Image',  'url' => base_url('advertisement/upload_file'))); ?>
    </div>
    <div class="form-group" id="ad_code_wrapper">
      <label for="ad_code">Advertisement Code </label>
      <textarea class="form-control" name="ad_code"></textarea>
    </div>
   
   <div class="form-group">
      <label for="ad_url">Ad URL </label>
      <input type="text" class="form-control reset_field" id="ad_url" name="ad_url" autocomplete="off">
    </div>
    
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

$(function(){
    $('.select2').select2();
});

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

function get_position(){
	reset_select([$('[name="position"]'), $('[name="ad_size"]')]);
	var page = $('[name="page"] :selected').val();
	$.get('<?php echo base_url('advertisement/get_option_value?option=page_position&page=')?>'+page, function(res){
		$('[name="position"]').html(res);
	});
	
	
}

function get_size(){
	reset_select([$('[name="ad_size"]')]);
	var position = $('[name="position"] :selected').val();
	var page = $('[name="page"] :selected').val();
	$.get('<?php echo base_url('advertisement/get_option_value?option=ad_size&page=')?>'+page+'&position='+position, function(res){
		$('[name="ad_size"]').html(res);
	});
}

function reset_select(opt){
	if(opt.length > 0 && opt instanceof Array){
		opt.forEach(function(item, ind){
			$(item).html('<option value="">-Select-</option>');
		});
	}
}

function checkAdType(){
	var selected_val = $('[name="ad_type"] :selected').val();
	if(selected_val == 'image'){
		$('#ad_code_wrapper').hide();
		$('#ad_image_wrapper').show();
	}else if(selected_val == 'script'){
		$('#ad_code_wrapper').show();
		$('#ad_image_wrapper').hide();
	}else{
		$('#ad_code_wrapper,#ad_image_wrapper').show();
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
                  <label for="category_key">Location </label>
					<div data-error-wrapper="advertisement_location">
				  <select class="form-control select2" name="advertisement_location[]" data-placeholder="Advertisement Location" multiple>
					<?php print_select_option($location, 'state_id', 'state_name', $detail['advertisement_location']); ?>
				  </select>
				  </div>
                </div>
				
				<div class="form-group">
                  <label for="category_key">Category </label>
				  <div data-error-wrapper="advertisement_category">
				  <select class="form-control select2" name="advertisement_category[]" data-placeholder="Advertisement Category" multiple>
					<?php print_select_option($category, 'category_id', 'category_name', $detail['advertisement_category']); ?>
				  </select>
				   </div>
                </div>
				
				<div class="form-group">
                  <label for="category_key">Page </label>
				  <select class="form-control" name="page" onchange="get_position()">
					<option value="">-Select-</option>
					<?php print_select_option($pages, 'slug', 'name', $detail['page']); ?>
					</select>
                </div>
				
				<div class="form-group">
                  <label for="category_key">Position </label>
				  <select class="form-control" name="position" onchange="get_size()">
					<option value="">-Select-</option>
					<?php print_select_option($positions, 'name', 'name', $detail['position']); ?>
				  </select>
                </div>
				
				<div class="form-group">
                  <label for="category_key">Size </label>
				  <select class="form-control" name="ad_size">
					<option value="">-Select-</option>
					<?php foreach($sizes as $size){ ?>
					<option value="<?php echo $size; ?>" <?php echo $detail['ad_size'] == $size ? 'selected' : ''; ?>><?php echo $size; ?></option>
					<?php } ?>
				  </select>
                </div>
				
				<div class="form-group">
                  <label for="category_key">Type </label>
				  <select class="form-control" name="ad_type" onchange="checkAdType()">
					<option value="admin" <?php echo (!empty($detail['ad_type']) && $detail['ad_type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
					<option value="script" <?php echo (!empty($detail['ad_type']) && $detail['ad_type'] == 'script') ? 'selected' : ''; ?>>Script</option>
					<option value="image" <?php echo (!empty($detail['ad_type']) && $detail['ad_type'] == 'image') ? 'selected' : ''; ?>>Image</option>
				  </select>
                </div>
				
				
				<?php if(!empty($detail['ad_image']) && file_exists(LC_PATH.'advertisement/'.$detail['ad_image'])){ ?>
				<div class="form-group">
                  <label>Previous Image </label>
                  <div class="image-wrapper" id="previous_category_background">
					<button type="button" class="close" onclick="removeByID('previous_category_background')"><span aria-hidden="true">&times;</span></button>
					<img src="<?php echo UPLOAD_HTTP_PATH.'advertisement/'.$detail['ad_image']; ?>" class="img-rounded" alt="" width="210">
					<input type="hidden" name="ad_image" value="<?php echo $detail['ad_image'];?>"/>
				</div>
                </div>
				<?php } ?>
				
				<div id="ad_image_wrapper">
				<?php $this->load->view('upload_file_component', array('input_name' => 'ad_image',  'label' => 'Advertisement Image',  'url' => base_url('advertisement/upload_file'))); ?>
				</div>
				
				<div class="form-group" id="ad_code_wrapper">
                  <label for="ad_code">Advertisement Code </label>
                  <textarea class="form-control" name="ad_code"><?php echo !empty($detail['ad_code']) ? $detail['ad_code'] : '';?></textarea>
                </div>
			   
			   <div class="form-group">
                  <label for="ad_url">Ad URL </label>
                  <input type="text" class="form-control reset_field" id="ad_url" name="ad_url" autocomplete="off" value="<?php echo !empty($detail['ad_url']) ? $detail['ad_url'] : '';?>">
                </div>
			
			   <div class="form-group">
			   <label class="form-label">Status</label>
                <div class="radio-inline">
					<input type="radio" name="status" value="1" class="magic-radio" id="status_1" checked>
					<label for="status_1">Active</label> 
				</div>
				 <div class="radio-inline">
					  <input type="radio" name="status" value="0" class="magic-radio" id="status_0" <?php echo $detail['status'] == '0' ?  'checked' : ''; ?>>
					  <label for="status_0">Inactive</label> 
				  </div>
              </div>
			  

                <button type="submit" class="btn btn-site">Save</button>

        </form>
</div>

<script>

init_plugin();


$(function(){
    $('.select2').select2();
});

function submitForm(form, evt){
	evt.preventDefault();
	ajaxSubmit($(form), onsuccess);
}

function onsuccess(res){
	if(res.cmd && res.cmd == 'reload'){
		location.reload();
	}
}

function get_position(){
	reset_select([$('[name="position"]'), $('[name="ad_size"]')]);
	var page = $('[name="page"] :selected').val();
	$.get('<?php echo base_url('advertisement/get_option_value?option=page_position&page=')?>'+page, function(res){
		$('[name="position"]').html(res);
	});
	
	
}

function get_size(){
	reset_select([$('[name="ad_size"]')]);
	var position = $('[name="position"] :selected').val();
	var page = $('[name="page"] :selected').val();
	$.get('<?php echo base_url('advertisement/get_option_value?option=ad_size&page=')?>'+page+'&position='+position, function(res){
		$('[name="ad_size"]').html(res);
	});
}

function reset_select(opt){
	if(opt.length > 0 && opt instanceof Array){
		opt.forEach(function(item, ind){
			$(item).html('<option value="">-Select-</option>');
		});
	}
}

function checkAdType(){
	var selected_val = $('[name="ad_type"] :selected').val();
	if(selected_val == 'image'){
		$('#ad_code_wrapper').hide();
		$('#ad_image_wrapper').show();
	}else if(selected_val == 'script'){
		$('#ad_code_wrapper').show();
		$('#ad_image_wrapper').hide();
	}else{
		$('#ad_code_wrapper,#ad_image_wrapper').show();
	}
}

$(document).ready(function(){
	checkAdType();
});
</script>
<?php } ?>