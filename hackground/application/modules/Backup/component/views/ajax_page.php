<?php if($page == 'add'){ ?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo $title;?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span></button>
	
</div>
<div class="modal-body">
		<form role="form" id="add_form" action="<?php echo $form_action;?>" onsubmit="submitForm(this, event)">
				<?php
				$input_types = array(
					array(
						'label' => 'Text',
						'value' => 'TEXT',
					),
					array(
						'label' => 'Select',
						'value' => 'SELECT',
					),
					array(
						'label' => 'Radio',
						'value' => 'RADIO',
					),
					array(
						'label' => 'Checkbox',
						'value' => 'CHECKBOX',
					),
				);
				?>
				<div class="form-group">
                  <label for="component_type" class="form-label">Input Type </label>
                  <select name="component_type" class="form-control">
					<option value=""> - Select Category -</option>
					<?php print_select_option($input_types, 'value', 'label'); ?>
				  </select>
                </div>
				
				<?php
				$lang = get_lang();
				foreach($lang as $k => $v){ ?>
				<div class="form-group">
                  <label for="name_<?php echo $v;?>" class="form-label">Name (<?php echo $v;?>)</label>
                  <input type="text" class="form-control reset_field" id="name_<?php echo $v;?>" name="lang[component_name][<?php echo $v; ?>]" autocomplete="off">
                </div>
				
				
				<?php } ?>
              
			   <div class="form-group">
                  <label for="component_key" class="form-label">Component Key </label>
                  <input type="text" class="form-control reset_field" id="component_key" name="component_key" autocomplete="off">
                </div>
				
				<div class="form-group">
                  <label for="description" class="form-label">Component Info</label>
                  <textarea class="form-control reset_field" id="description" name="description"></textarea>
                </div>
				
				<?php $this->load->view('upload_file_component', array('input_name' => 'component_icon', 'label' => 'Icon Image',  'url' => base_url('component/upload_file'))); ?>
				
				<div class="form-group">
                  <label for="component_icon_class" class="form-label">Icon </label>
                  <input type="text" class="form-control reset_field" id="component_icon_class" name="component_icon_class" autocomplete="off" />
                </div>
				
				
			   <div class="form-group">
                  <label for="component_order" class="form-label">Display Order </label>
                  <input type="text" class="form-control reset_field" id="component_order" name="component_order" autocomplete="off">
                </div>
				
				<div class="form-group">
					<div>
					 <input type="hidden" name="visible_in_detail" value="0" />
					 <input type="checkbox" name="visible_in_detail" value="1" class="magic-checkbox" id="visible_in_detail">
					  <label for="visible_in_detail">Visible in Detail</label>
					</div>
				</div>
			  
				
			   <div class="form-group">
			   <label class="form-label">Status</label>
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

				
				<?php
				$input_types = array(
					array(
						'label' => 'Text',
						'value' => 'TEXT',
					),
					array(
						'label' => 'Select',
						'value' => 'SELECT',
					),
					array(
						'label' => 'Radio',
						'value' => 'RADIO',
					),
					array(
						'label' => 'Checkbox',
						'value' => 'CHECKBOX',
					),
				);
				?>
				<div class="form-group">
                  <label for="component_type">Input Type </label>
                  <select name="component_type" class="form-control">
					<option value=""> - Select Category -</option>
					<?php print_select_option($input_types, 'value', 'label', $detail['component_type']); ?>
				  </select>
                </div>
				
				<?php
				$lang = get_lang();
				foreach($lang as $k => $v){ ?>
				<div class="form-group">
                  <label for="name_<?php echo $v;?>">Name (<?php echo $v;?>)</label>
                  <input type="text" class="form-control reset_field" id="name_<?php echo $v;?>" name="lang[component_name][<?php echo $v; ?>]" autocomplete="off"  value="<?php echo !empty($detail['lang']['component_name'][$v]) ? $detail['lang']['component_name'][$v] : '';?>" />
                </div>
				
				
				<?php } ?>
              
			   <div class="form-group">
                  <label for="component_key">Component Key </label>
                  <input type="text" class="form-control reset_field" id="component_key" name="component_key" autocomplete="off" value="<?php echo !empty($detail['component_key']) ? $detail['component_key'] : '';?>" />
                </div>
				
				<div class="form-group">
                  <label for="description">Component Info</label>
                  <textarea class="form-control reset_field" id="description" name="description"><?php echo !empty($detail['description']) ? $detail['description'] : '';?></textarea>
                </div>
				
				<?php if(!empty($detail['component_icon']) && file_exists(LC_PATH.'component_icons/'.$detail['component_icon'])){ ?>
				<div class="form-group">
                  <label>Previous Image </label>
                  <div class="image-wrapper" id="previous_category_icon">
					<button type="button" class="close" onclick="removeByID('previous_category_icon')"><span aria-hidden="true">&times;</span></button>
					<img src="<?php echo UPLOAD_HTTP_PATH.'component_icons/'.$detail['component_icon']; ?>" class="img-rounded" alt="" width="210">
					<input type="hidden" name="component_icon" value="<?php echo $detail['component_icon'];?>"/>
				</div>
                </div>
				<?php } ?>
				
				<?php $this->load->view('upload_file_component', array('input_name' => 'component_icon', 'label' => 'Icon Image',  'url' => base_url('component/upload_file'))); ?>
				
				<div class="form-group">
                  <label for="icon_class">Icon </label>
                  <input type="text" class="form-control reset_field" id="icon_class" name="component_icon_class" autocomplete="off" value="<?php echo !empty($detail['component_icon_class']) ? $detail['component_icon_class'] : '';?>" />
                </div>
				
			   <div class="form-group">
                  <label for="component_order">Display Order </label>
                  <input type="text" class="form-control reset_field" id="component_order" name="component_order" autocomplete="off" value="<?php echo !empty($detail['component_order']) ? $detail['component_order'] : '';?>" />
                </div>
				
				<div class="form-group">
					<div>
					 <input type="hidden" name="visible_in_detail" value="0" />
					 <input type="checkbox" name="visible_in_detail" value="1" class="magic-checkbox" id="visible_in_detail" <?php echo (!empty($detail['visible_in_detail']) && $detail['visible_in_detail'] == '1') ? 'checked' : '';?>>
					  <label for="visible_in_detail">Visible in Detail</label>
					</div>
				</div>
				
			   <div class="form-group">
			   <label class="form-label">Status</label>
                <div class="radio-inline">
					<input type="radio" name="status" value="1" class="magic-radio" id="status_1" checked>
					<label for="status_1">Active</label> 
				</div>
				 <div class="radio-inline">
					  <input type="radio" name="status" value="0" class="magic-radio" id="status_0" <?php echo $detail['component_status'] == '0' ?  'checked' : ''; ?>>
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

<?php if($page == 'add_category_component'){ ?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo $title;?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
    </button>	
</div>
<div class="modal-body">
	<form role="form" id="add_form" action="<?php echo $form_action;?>" onsubmit="submitForm(this, event)">
		<input type="hidden" name="category_subchild_id" value="<?php echo $category_subchild_id; ?>"/>
		<input type="hidden" name="child_level" value="<?php echo $category_level; ?>"/>
		
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Selected Components</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Add New Component</a></li>
            </ul>
            <div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<div class="">
						<table class="table table-hover">
							<thead>
								<tr>
									<th style="width:30%">Component</th>
									<th style="width:10%">Select</th>
									<th style="width:10%">Searchable</th>
									<th style="width:10%">Required</th>
									<th style="width:10%">HightLight</th>
									<th style="width:10%">Range Filter</th>
									<th style="width:20%">Order</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($components as $component){ 
								if(!in_array($component['component_id'], $category_components['component'])){
									continue;
								}
								?>
								<tr>
									<td><?php echo $component['component_name']; ?> &nbsp; &nbsp; <a href="<?php echo JS_VOID; ?>" data-toggle="tooltip" title="<?php echo !empty($component['description']) ? $component['description'] : 'No Info'; ?>"><i class="fa fa-info-circle dark <?php echo ICON_SIZE;?>"></i></a></td>
									<td>
										<div>
										 <input type="checkbox" name="component_id[]" value="<?php echo $component['component_id'];?>" class="magic-checkbox searchable_check" id="component_<?php echo $component['component_id'];?>" data-component-id="<?php echo $component['component_id'];?>" <?php echo in_array($component['component_id'], $category_components['component']) ? 'checked' : '';?>>
										  <label for="component_<?php echo $component['component_id'];?>"></label>
										</div>
									</td>
									<td>
										<div>
										 <input type="checkbox" name="searchable_component_id[]" value="<?php echo $component['component_id'];?>" class="magic-checkbox checkable_component_<?php echo $component['component_id'];?>" id="component_searchable_<?php echo $component['component_id'];?>" <?php echo in_array($component['component_id'], $category_components['searchable']) ? 'checked' : '';?>>
										  <label for="component_searchable_<?php echo $component['component_id'];?>"></label>
										</div>
									</td>
									<td class="text-center">
										<span>
										 <input type="checkbox" name="required_component_id[]" value="<?php echo $component['component_id'];?>" class="magic-checkbox checkable_component_<?php echo $component['component_id'];?>" id="component_required_<?php echo $component['component_id'];?>" <?php echo in_array($component['component_id'], $category_components['required']) ? 'checked' : '';?>>
										  <label for="component_required_<?php echo $component['component_id'];?>"></label>
										</span>
									</td>
									<td class="text-center">
										<span>
										 <input type="checkbox" name="highlight_component_id[]" value="<?php echo $component['component_id'];?>" class="magic-checkbox checkable_component_<?php echo $component['component_id'];?>" id="component_highlight_<?php echo $component['component_id'];?>" <?php echo in_array($component['component_id'], $category_components['highlight']) ? 'checked' : '';?>>
										  <label for="component_highlight_<?php echo $component['component_id'];?>"></label>
										</span>
									</td>
									<td class="text-center">
										<?php if($component['component_type'] == 'TEXT'){ ?>
										<span>
										 <input type="checkbox" name="rangefilter_component_id[]" value="<?php echo $component['component_id'];?>" class="magic-checkbox checkable_component_<?php echo $component['component_id'];?>" id="component_rangefilter_<?php echo $component['component_id'];?>" <?php echo in_array($component['component_id'], $category_components['rangefilter']) ? 'checked' : '';?>>
										  <label for="component_rangefilter_<?php echo $component['component_id'];?>"></label>
										</span>
										<?php } ?>
									</td>
									<td class="text-center">
										<input type="number" class="form-control checkable_component_<?php echo $component['component_id'];?>" name="component_order[<?php echo $component['component_id'];?>]" value="<?php echo !empty($category_components['display_order'][$component['component_id']]) ? $category_components['display_order'][$component['component_id']] : ''; ?>"/>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
            
              <div class="tab-pane" id="tab_2">
				<div class="">
						<table class="table table-hover">
							<thead>
								<tr>
									<th style="width:30%">Component</th>
									<th style="width:10%">Select</th>
									<th style="width:10%">Searchable</th>
									<th style="width:10%">Required</th>
									<th style="width:10%">HightLight</th>
									<th style="width:10%">Range Filter</th>
									<th style="width:20%">Order</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($components as $component){ 
								if(in_array($component['component_id'], $category_components['component'])){
									continue;
								}
								?>
								<tr>
									<td><?php echo $component['component_name']; ?> &nbsp; &nbsp; <a href="<?php echo JS_VOID; ?>" data-toggle="tooltip" title="<?php echo !empty($component['description']) ? $component['description'] : 'No Info'; ?>"><i class="fa fa-info-circle dark <?php echo ICON_SIZE;?>"></i></a></td>
									<td>
										<div>
										 <input type="checkbox" name="component_id[]" value="<?php echo $component['component_id'];?>" class="magic-checkbox searchable_check" id="component_<?php echo $component['component_id'];?>" data-component-id="<?php echo $component['component_id'];?>" <?php echo in_array($component['component_id'], $category_components['component']) ? 'checked' : '';?>>
										  <label for="component_<?php echo $component['component_id'];?>"></label>
										</div>
									</td>
									<td>
										<div>
										 <input type="checkbox" name="searchable_component_id[]" value="<?php echo $component['component_id'];?>" class="magic-checkbox checkable_component_<?php echo $component['component_id'];?>" id="component_searchable_<?php echo $component['component_id'];?>" <?php echo in_array($component['component_id'], $category_components['searchable']) ? 'checked' : '';?>>
										  <label for="component_searchable_<?php echo $component['component_id'];?>"></label>
										</div>
									</td>
									<td class="text-center">
										<span>
										 <input type="checkbox" name="required_component_id[]" value="<?php echo $component['component_id'];?>" class="magic-checkbox checkable_component_<?php echo $component['component_id'];?>" id="component_required_<?php echo $component['component_id'];?>" <?php echo in_array($component['component_id'], $category_components['required']) ? 'checked' : '';?>>
										  <label for="component_required_<?php echo $component['component_id'];?>"></label>
										</span>
									</td>
									<td class="text-center">
										<span>
										 <input type="checkbox" name="highlight_component_id[]" value="<?php echo $component['component_id'];?>" class="magic-checkbox checkable_component_<?php echo $component['component_id'];?>" id="component_highlight_<?php echo $component['component_id'];?>" <?php echo in_array($component['component_id'], $category_components['highlight']) ? 'checked' : '';?>>
										  <label for="component_highlight_<?php echo $component['component_id'];?>"></label>
										</span>
									</td>
									<td class="text-center">
										<?php if($component['component_type'] == 'TEXT'){ ?>
										<span>
										 <input type="checkbox" name="rangefilter_component_id[]" value="<?php echo $component['component_id'];?>" class="magic-checkbox checkable_component_<?php echo $component['component_id'];?>" id="component_rangefilter_<?php echo $component['component_id'];?>" <?php echo in_array($component['component_id'], $category_components['rangefilter']) ? 'checked' : '';?>>
										  <label for="component_rangefilter_<?php echo $component['component_id'];?>"></label>
										</span>
										<?php } ?>
									</td>
									<td class="text-center">
										<input type="number" class="form-control checkable_component_<?php echo $component['component_id'];?>" name="component_order[<?php echo $component['component_id'];?>]" value="<?php echo !empty($category_components['display_order'][$component['component_id']]) ? $category_components['display_order'][$component['component_id']] : ''; ?>"/>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
              </div>
            </div>
            <!-- /.tab-content -->
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
	if(res.cmd){
		if(res.cmd == 'reload'){
			location.reload();
		}else if(res.cmd == 'reset_form'){
			var form = $('#add_form');
			form.find('.reset_field').val('');
		}		
		
	}
}

$('.searchable_check').change(function(){
	var component_id = $(this).data('componentId');
	var checked = $(this).is(':checked');
	var target_component = $('.checkable_component_'+component_id);
	if(checked){
		$(target_component).removeAttr('disabled');
	}else{
		$(target_component).prop('checked', false);
		$(target_component).attr('disabled', 'disabled');
	}
});
$('.searchable_check').change();
</script>
<?php } ?>

<?php if($page == 'add_component_value'){ ?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo $title;?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span></button>
	
</div>
<div class="modal-body">
		<form role="form" id="add_form" action="<?php echo $form_action;?>" onsubmit="submitForm(this, event)">

				<input type="hidden" name="component_id" value="<?php echo $component_id; ?>"/>
				<?php
				$lang = get_lang();
				foreach($lang as $k => $v){ ?>
				<div class="form-group">
                  <label for="name_<?php echo $v;?>">Value Name (<?php echo $v;?>)</label>
                  <input type="text" class="form-control reset_field" id="name_<?php echo $v;?>" name="lang[component_value_name][<?php echo $v; ?>]" autocomplete="off">
                </div>
				<?php } ?>
              
			   <div class="form-group">
                  <label for="component_value_key"> Value Key </label>
                  <input type="text" class="form-control reset_field" id="component_value_key" name="component_value_key" autocomplete="off">
                </div>
				
				<div class="form-group">
                  <label for="component_value_order">Display Order </label>
                  <input type="text" class="form-control reset_field" id="component_value_order" name="component_value_order" autocomplete="off">
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

<?php if($page == 'edit_component_value'){ ?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo $title;?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span></button>
	
</div>
<div class="modal-body">
		<form role="form" id="add_form" action="<?php echo $form_action;?>" onsubmit="submitForm(this, event)">
			<input type="hidden" name="ID" value="<?php echo $ID?>"/>

				<?php
				$lang = get_lang();
				foreach($lang as $k => $v){ ?>
				<div class="form-group">
                  <label for="name_<?php echo $v;?>">Value Name (<?php echo $v;?>)</label>
                  <input type="text" class="form-control reset_field" id="name_<?php echo $v;?>" name="lang[component_value_name][<?php echo $v; ?>]" autocomplete="off" value="<?php echo !empty($detail['lang']['component_value_name'][$v]) ? $detail['lang']['component_value_name'][$v] : '';?>">
                </div>
				<?php } ?>
              
			   <div class="form-group">
                  <label for="component_value_key"> Value Key </label>
                  <input type="text" class="form-control reset_field" id="component_value_key" name="component_value_key" autocomplete="off" value="<?php echo !empty($detail['component_value_key']) ? $detail['component_value_key'] : '';?>">
                </div>
				
				<div class="form-group">
                  <label for="component_value_order">Display Order </label>
                  <input type="text" class="form-control reset_field" id="component_value_order" name="component_value_order" autocomplete="off" value="<?php echo !empty($detail['component_value_order']) ? $detail['component_value_order'] : '';?>">
                </div>
				
			   <div class="form-group">
			   <label class="form-label">Status</label>
                <div class="radio-inline">
					<input type="radio" name="status" value="1" class="magic-radio" id="status_1" checked>
					<label for="status_1">Active</label> 
				</div>
				 <div class="radio-inline">
					  <input type="radio" name="status" value="0" class="magic-radio" id="status_0" <?php echo $detail['component_value_status'] == '0' ?  'checked' : ''; ?>>
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
