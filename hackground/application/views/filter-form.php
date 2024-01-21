<style>
.advance-search-panel{
	background-color: #fff;
	box-shadow: 0 1px 3px rgb(0 0 0 / 10%);
    padding: 1rem;
    margin-top: 1rem;
}
</style>
<?php 
$srch = get();
$similar_search_module = array(
		'category/list_record',
		'country/list_record',
		'delivery_times/list_record',
		'language/list_record',
		'sections/list_record',
		'slider/list_record',
		'email_template/list_record',
		'notification_template/list_record',
		'skills/list_record',
		'cms/list_record',
		'coupon/list_record',
		'wallet/list_record',
		'sub_category/list_record',
		'sub_category_level_three/list_record',
		'sub_category_level_four/list_record',
		'component/list_record',
		'component/show_values',
		'member_landloard/list_record',
		'member_company/list_record',
);

$advance_search_module = array(
		'buyer_request/list_record',
		'proposal/list_record',
		'wallet/txn_list',
		'orders/list_record',
		'setting/main',
		'setting/default_setting',
		'member/list_record',
		'offers/list_record',
		
);

if(in_array($url_segment, $similar_search_module)){ ?>
<form action="">
<section class="content-header">
  <div class="row">
	<div class="offset-sm-8 col-sm-4">
		<div class="input-group">
			<input class="form-control" placeholder="Search..." name="term" value="<?php echo !empty($srch['term']) ? $srch['term'] : '';?>">
			<div class="input-group-append">
			  <button type="submit" class="btn btn-site"><i class="fa fa-search"></i></button>
			</div>
		  </div>
	</div>
  </div>
</section>
</form>
<?php }else if(in_array($url_segment, $advance_search_module)){  ?>
<form action="">
<input type="hidden" name="panel_open" value="<?php echo !empty($srch['panel_open']) ? $srch['panel_open'] : '0';?>" id="advance_search_panel_state"/>
<section class="content-header">
  <div class="row">
	<div class="col-sm-3">
		<a href="javascript:void(0)" onclick="toggleAdvanceSearch()" class="btn btn-box-tool" style="font-size: 1rem;">Advance Search &nbsp; <i class="icon-feather-zoom-in <?php echo ICON_SIZE;?>"></i></a>
	</div>
	<div class="offset-sm-5 col-sm-4">
		<div class="input-group">
			<input class="form-control" placeholder="Search..." name="term" value="<?php echo !empty($srch['term']) ? $srch['term'] : '';?>">

			<div class="input-group-append">
			  <button type="submit" class="btn btn-site"><i class="icon-feather-search"></i></button>
			</div>
		  </div>
	</div>
  </div>
  
  <div class="advance-search-panel" style="<?php echo !empty($srch['panel_open']) ? '' : 'display:none;';?>">
  
	<?php if($url_segment == 'buyer_request/list_record'){ ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('buyer_request/list_record?panel_open=1'); ?>">All</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('buyer_request/list_record?status='.REQUEST_ACTIVE.'&panel_open=1'); ?>">Active</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('buyer_request/list_record?status='.REQUEST_PENDING.'&panel_open=1'); ?>">Pending</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('buyer_request/list_record?status='.REQUEST_UNAPPROVED.'&panel_open=1'); ?>">Declined</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('buyer_request/list_record?status='.REQUEST_PAUSED.'&panel_open=1'); ?>">Paused</a></li>
        </ol>
    </nav>
	<?php } ?>
    
	<?php if($url_segment == 'member/list_record'){ ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('member/list_record?panel_open=1'); ?>">All</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('member/list_record?u_type=freelancer&panel_open=1'); ?>">Freelancer</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('member/list_record?u_type=employer&panel_open=1'); ?>">Employer</a></li>
    	</ol>
    </nav>
	<?php } ?>
	
	<?php if($url_segment == 'proposal/list_record'){
		 ?>
	
	<div class="row">
		<div class="col-sm">
			<label>Category</label>
			<select class="form-control" name="category">
				<option value="">-select-</option>
				<?php print_select_option($category, 'category_id', 'category_name', $srch['category']);?>
			</select>
		</div>
		<div class="col-sm">
			<label>Type</label>
			<select class="form-control" name="project_type">
			<option value="" >-select-</option>
			<option value="F" <?php if(array_key_exists('project_type',$srch) && $srch['project_type']=='F'){echo 'selected';}?>>Fixed</option>
			<option value="H" <?php if(array_key_exists('project_type',$srch) && $srch['project_type']=='H'){echo 'selected';}?>>Hourly</option>
			
			</select>
		</div>
		
		<div class="col-sm-auto">
        	<label class="d-block">&nbsp;</label>
			<button class="btn btn-site"><i class="icon-feather-filter"></i> Filter</button>
		</div>
	</div>
	
	<nav aria-label="breadcrumb" hidden>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
			<a href="<?php echo base_url('proposal/list_record?panel_open=1'); ?>">All</a></li>
			<li class="breadcrumb-item"><a href="<?php echo base_url('proposal/list_record?status='.PROJECT_OPEN.'&panel_open=1'); ?>">Open</a></li>
			<li class="breadcrumb-item"><a href="<?php echo base_url('proposal/list_record?status='.PROJECT_DRAFT.'&panel_open=1'); ?>">Draft</a></li>
			<li class="breadcrumb-item"><a href="<?php echo base_url('proposal/list_record?status='.PROJECT_HIRED.'&panel_open=1'); ?>">Hired</a></li>
			<li class="breadcrumb-item"><a href="<?php echo base_url('proposal/list_record?status='.PROJECT_CLOSED.'&panel_open=1'); ?>">Closed</a></li>
			<?php /*?><li class="breadcrumb-item"><a href="<?php echo base_url('proposal/list_record?status='.PROJECT_DELETED.'&panel_open=1'); ?>">Deleted</a></li><?php */?>
		</ol>
	</nav>
	
	<?php } ?>
	
	<?php if($url_segment == 'sub_category/list_record'){ ?>
	
	<div class="row">
		<div class="col-sm-4">
			<label>Category</label>
			<select class="form-control" name="category">
				<option value="">-select-</option>
				<?php print_select_option($category, 'category_id', 'category_name', $srch['category']);?>
			</select>
		</div>
		
		<div class="col-sm-12">
			<button class="btn btn-sm btn-site" style="margin-top: 10px; margin-bottom: 15px;">Filter</button>
		</div>
	</div>
	
	<?php } ?>
	
	
	<?php if($url_segment == 'orders/list_record'){ ?>
	<a href="<?php echo base_url('orders/list_record?panel_open=1'); ?>">All</a> |
	<a href="<?php echo base_url('orders/list_record?status='.ORDER_PENDING.'&panel_open=1'); ?>">Pending</a> |
	<a href="<?php echo base_url('orders/list_record?status='.ORDER_PROCESSING.'&panel_open=1'); ?>">Process</a> |
	<a href="<?php echo base_url('orders/list_record?status='.ORDER_COMPLETED.'&panel_open=1'); ?>">Completed</a> |
	<a href="<?php echo base_url('orders/list_record?status='.ORDER_CANCELLED.'&panel_open=1'); ?>">Cancelled</a> 
	<?php } ?>
	
	<?php if($url_segment == 'offers/list_record'){ ?>
	<a href="<?php echo base_url('offers/list_record?panel_open=1'); ?>">All</a> |
	<a href="<?php echo base_url('offers/list_record?status=1&panel_open=1'); ?>">Active</a> |
	<a href="<?php echo base_url('offers/list_record?status=0&panel_open=1'); ?>">Pending</a> |
	<a href="<?php echo base_url('offers/list_record?status=2&panel_open=1'); ?>">Rejected</a>
	<?php } ?>
	
	<?php if($url_segment == 'wallet/txn_list'){ ?>
	<a href="<?php echo base_url('wallet/txn_list?panel_open=1'); ?>">All</a> |
	<a href="<?php echo base_url('wallet/txn_list?status=1&panel_open=1'); ?>">Active</a> |
	<a href="<?php echo base_url('wallet/txn_list?status=0&panel_open=1'); ?>">Pending</a> |
	<a href="<?php echo base_url('wallet/txn_list?status=2&panel_open=1'); ?>">Deleted</a>
	
	<?php } ?>
	
	<?php if($url_segment == 'setting/main'){ 
	$setting_group = $this->uri->segment(3);
	?>
	<a href="<?php echo base_url('setting/main/'.$setting_group.'?show=all&panel_open=1'); ?>">All</a> |
	<a href="<?php echo base_url('setting/main/'.$setting_group.'?panel_open=1'); ?>">Editable</a> 
	
	<?php } ?>
	
	<?php if($url_segment == 'setting/default_setting'){ ?>
	<a href="<?php echo base_url('setting/default_setting/?show=all&panel_open=1'); ?>">All</a> |
	<a href="<?php echo base_url('setting/default_setting/?panel_open=1'); ?>">Editable</a> 
	
	<?php } ?>
	
	
	
  </div>
  
</section>
</form>

<script>
(function(){
	
var panel_open = <?php echo !empty($srch['panel_open']) ? 'true' : 'false';?>;
function toggleAdvanceSearch(){
	if(panel_open){
		$('#advance_search_panel_state').val(0);
		panel_open = false;
		$('.advance-search-panel').hide('fast');
	}else{
		panel_open = true;
		$('#advance_search_panel_state').val(1);
		$('.advance-search-panel').show('fast');
	}
}	

window.toggleAdvanceSearch = toggleAdvanceSearch;
	
})();
	
</script>
<?php } ?>