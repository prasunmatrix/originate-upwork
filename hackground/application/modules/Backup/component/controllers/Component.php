<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Component extends MX_Controller {
   
   private $data;
   
	public function __construct(){
		$this->data['curr_controller'] = $this->router->fetch_class()."/";
		$this->data['curr_method'] = $this->router->fetch_method()."/";
		
		$this->load->model('component_model', 'component');
		$this->data['table'] = 'component';
		$this->data['lang_table'] = 'component_names';
		$this->data['primary_key'] = $this->data['table'].'_id';
		
		
		$model_configuration = array(
			'table' => $this->data['table'],
			'lang_table' => $this->data['lang_table'],
			'primary_key' => $this->data['primary_key'],
		);
		
		$this->component->configure($model_configuration);
		
		parent::__construct();
		
		admin_log_check();
	}

	public function index(){
		redirect(base_url($this->data['curr_controller'].'list_record'));
	}
	
	public function list_record(){
		$srch = get();
		$curr_limit = get('per_page');
		$limit = !empty($curr_limit) ? $curr_limit : 0; 
		$offset = 20;
		$this->data['main_title'] = 'Component Management';
		$this->data['second_title'] = 'All Component List';
		$this->data['title'] = 'Component';
		$breadcrumb = array(
			array(
				'name' => 'Component',
				'path' => '',
			),
		);
		$this->data['breadcrumb'] = breadcrumb($breadcrumb);
		$this->data['list'] = $this->component->getList($srch, $limit, $offset);
		$this->data['list_total'] = $this->component->getList($srch, $limit, $offset, FALSE);
		
		$this->load->library('pagination');
		$config['base_url'] = base_url($this->data['curr_controller'].'list_record');
		$config['total_rows'] =$this->data['list_total'];
		$config['per_page'] = $offset;
		$config['page_query_string'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		
		$this->pagination->initialize($config);
		
		$this->data['links'] = $this->pagination->create_links();
		$this->data['add_command'] = 'add';
		$this->data['edit_command'] = 'edit';
		$this->data['add_btn'] = 'Add Component';
		$this->layout->view('list', $this->data);
       
	}
	
	public function load_ajax_page(){
		$page = get('page');
		$this->data['page'] = $page;
		if($page == 'add'){
			
			$this->data['title'] = 'Add Component';
			$this->data['form_action'] = base_url($this->data['curr_controller'].'add');
			
		}else if($page == 'edit'){
			
			$id = get('id');
			$this->data['ID']= $id;
			$this->data['form_action'] = base_url($this->data['curr_controller'].'edit');
			$this->data['detail'] = $this->component->getDetail($id);
			$this->data['title'] = 'Edit Component';
			
		}else if($page == 'add_category_component'){
			$this->data['category_subchild_id']= get('category_subchild_id');
			$this->data['category_level']= get('category_level');
			
			if($this->data['category_level'] == 1){
				$this->load->model('category/category_model', 'category_name');
			}else if($this->data['category_level'] == 2){
				$this->load->model('sub_category/sub_category_model', 'category_name');
			}else if($this->data['category_level'] == 3){
				$this->load->model('sub_category_level_three/sub_category_level_three_model', 'category_name');
			}else{
				$this->load->model('sub_category_level_four/sub_category_level_four_model', 'category_name');
			}
			
			$category_name = $this->category_name->get_category_name($this->data['category_subchild_id']);
			$this->data['title'] = "Manage Component ($category_name)";
			$this->data['form_action'] = base_url($this->data['curr_controller'].'save_category_component');
			$this->data['components'] = $this->component->getList(array('status' => ACTIVE_STATUS), 0, 1000);
			
			$this->data['category_components'] = $this->component->getCategoryComponents($this->data['category_subchild_id'], $this->data['category_level']);
			
		}else if($page == 'add_component_value'){
			
			$this->data['component_id'] = get('component_id');
			$this->data['title'] = 'Add Component Value';
			$this->data['form_action'] = base_url($this->data['curr_controller'].'add_component_value');
			
		}else  if($page == 'edit_component_value'){
			
			$id = get('id');
			$this->data['ID']= $id;
			$this->data['form_action'] = base_url($this->data['curr_controller'].'edit_component_value');
			$this->data['detail'] = $this->component->getComponentValueById($id);
			$this->data['title'] = 'Edit Component Value';

		}
		$this->load->view('ajax_page', $this->data);
	}
	
	public function add(){
		$lang = get_lang();
		if(post() && $this->input->is_ajax_request()){
			$this->load->library('form_validation');
			foreach($lang as $k => $v){
				$this->form_validation->set_rules('lang[component_name]['.$v.']', "name $v", 'required|trim|max_length[100]');
			}
			$this->form_validation->set_rules('component_key', 'component key', 'required|regex_match[/^[0-9a-z\-A-Z]+$/]|is_unique[component.component_key]');
			$this->form_validation->set_rules('component_type', 'component type', 'required');
			$this->form_validation->set_rules('status', 'status', '');
			if($this->form_validation->run()){
				$post = post();
				$insert = $this->component->addRecord($post);
				if(post('add_more') && post('add_more') == '1'){
					$this->api->cmd('reset_form');
				}else{
					$this->api->cmd('reload');
				}
				
			}else{
				$errors = validation_errors_array();
				$this->api->set_error($errors);
			}
			
		}else{
			$this->api->set_error('invalid_request', 'Invalid Request');
		}
		
		$this->api->out();
	}
	
	public function edit(){
		$lang = get_lang();
		if(post() && $this->input->is_ajax_request()){
			$this->load->library('form_validation');
			foreach($lang as $k => $v){
				$this->form_validation->set_rules('lang[component_name]['.$v.']', "name $v", 'required|trim|max_length[100]');
			}
			$this->form_validation->set_rules('component_key', 'component key', 'required|regex_match[/^[0-9a-z\-A-Z]+$/]');
			$this->form_validation->set_rules('component_type', 'component type', 'required');
			$this->form_validation->set_rules('status', 'status', '');
			$this->form_validation->set_rules('ID', 'id', 'required');
			if($this->form_validation->run()){
				$post = post();
				$ID = post('ID');
				unset($post['ID']);
				$update = $this->component->updateRecord($post, $ID);
				$this->api->cmd('reload');
			}else{
				$errors = validation_errors_array();
				$this->api->set_error($errors);
			}
			
		}else{
			$this->api->set_error('invalid_request', 'Invalid Request');
		}
		
		$this->api->out();
	}
	
	
	public function save_category_component(){
		
		if(post()){
			$post = post();
			$update = $this->component->saveCategoryComponent($post);
		}
		$this->api->cmd('reload');
		$this->api->out();
	}
	
	public function change_status(){
		if(post() && $this->input->is_ajax_request()){
			
			$ID = post('ID');
			$sts = post('status');
			$action_type = post('action_type');
			
			if(is_array($ID)){
				$this->db->where_in($this->data['primary_key'], $ID)->update($this->data['table'], array('component_status' => $sts));
			}else{
				$upd['data'] = array('component_status' => $sts);
				$upd['where'] = array($this->data['primary_key'] => $ID);
				$upd['table'] = $this->data['table'];
				update($upd);
				
			}
			
			if($action_type == 'multiple'){
				$this->api->cmd('reload');
			}else{
				
				$html = '';
				if($sts == ACTIVE_STATUS){
					$html = '<a href="'.JS_VOID.'"  data-toggle="tooltip" title="Make inactive" onclick="changeStatus(0, '.$ID.', this)"><span class="badge badge-success">Active</span></a>';
				}else{
					$html = '<a href="'.JS_VOID.'" data-toggle="tooltip" title="Make active"  onclick="changeStatus(1, '.$ID.', this)"><span class="badge badge-danger">Inactive</span></a>';
				}
			
			
				$this->api->data('html', $html);
				$this->api->cmd('replace');
			}
			
			
		}else{
			$this->api->set_error('invalid_request', 'Invalid Request');
		}
		
		$this->api->out();
	}
	
	public function delete_record($id=''){
		$action_type = post('action_type');
		if($action_type == 'multiple'){
			$id = post('ID');
		}
		if($id){
			$this->component->deleteRecord($id);
			$cmd = get('cmd');
			if($cmd && $cmd == 'remove'){
				if($id && is_array($id)){
					$this->db->where_in($this->data['primary_key'] ,  $id)->delete($this->data['table']);
				}else{
					$this->db->where($this->data['primary_key'] ,  $id)->delete($this->data['table']);
				}
				
			}
			$this->api->cmd('reload');
		}else{
			$this->api->set_error('invalid_request', 'Invalid Request');
		}
		$this->api->out();
	}
	
	/* --------------------[ COMPONENT VALUE ]---------------------------------------------*/
	
	public function show_values($component_id=''){
		if(!$component_id){
			return false;
		}
		
		$srch = get();
		$this->data['component_id'] = $srch['component_id'] = $component_id;
		$curr_limit = get('per_page');
		$limit = !empty($curr_limit) ? $curr_limit : 0; 
		$offset = 20;
		$component_name = $this->component->getNameById($component_id);
		$this->data['main_title'] = "$component_name - Values Management";
		$this->data['second_title'] = "All <b>$component_name</b> Values";
		$this->data['title'] = "$component_name Values";
		$breadcrumb = array(
			array(
				'name' => 'Component',
				'path' => base_url('component/list_record'),
			),
			array(
				'name' => "$component_name",
				'path' => '',
			),
		);
		$this->data['breadcrumb'] = breadcrumb($breadcrumb);
		$this->data['list'] = $this->component->getComponentValues($srch, $limit, $offset);
		$this->data['list_total'] = $this->component->getComponentValues($srch, $limit, $offset, FALSE);
		
		$this->load->library('pagination');
		$config['base_url'] = base_url($this->data['curr_controller'].'show_values/'.$component_id);
		$config['total_rows'] =$this->data['list_total'];
		$config['per_page'] = $offset;
		$config['page_query_string'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		
		$this->pagination->initialize($config);
		
		$this->data['links'] = $this->pagination->create_links();
		$this->data['add_command'] = 'add_component_value';
		$this->data['edit_command'] = 'edit_component_value';
		$this->data['add_btn'] = 'Add Value';
		$this->data['primary_key'] = 'component_value_id';
		$this->layout->view('list-component-value', $this->data);
       
	}
	
	public function add_component_value(){
		$lang = get_lang();
		if(post() && $this->input->is_ajax_request()){
			$this->load->library('form_validation');
			foreach($lang as $k => $v){
				$this->form_validation->set_rules('lang[component_value_name]['.$v.']', "name $v", 'required|trim|max_length[100]');
			}
			$this->form_validation->set_rules('component_value_key', 'component value key', 'required|regex_match[/^[0-9a-z\-A-Z]+$/]');
			$this->form_validation->set_rules('status', 'status', '');
			if($this->form_validation->run()){
				$post = post();
				$insert = $this->component->addComponentValues($post);
				if(post('add_more') && post('add_more') == '1'){
					$this->api->cmd('reset_form');
				}else{
					$this->api->cmd('reload');
				}
				
			}else{
				$errors = validation_errors_array();
				$this->api->set_error($errors);
			}
			
		}else{
			$this->api->set_error('invalid_request', 'Invalid Request');
		}
		
		$this->api->out();
	}
	
	public function edit_component_value(){
		$lang = get_lang();
		if(post() && $this->input->is_ajax_request()){
			$this->load->library('form_validation');
			foreach($lang as $k => $v){
				$this->form_validation->set_rules('lang[component_value_name]['.$v.']', "name $v", 'required|trim|max_length[255]');
			}
			$this->form_validation->set_rules('component_value_key', 'component value key', 'required|regex_match[/^[0-9a-z\-A-Z]+$/]');
			$this->form_validation->set_rules('status', 'status', '');
			$this->form_validation->set_rules('ID', 'id', 'required');
			if($this->form_validation->run()){
				$post = post();
				$ID = post('ID');
				unset($post['ID']);
				$update = $this->component->updateComponentValues($post, $ID);
				$this->api->cmd('reload');
			}else{
				$errors = validation_errors_array();
				$this->api->set_error($errors);
			}
			
		}else{
			$this->api->set_error('invalid_request', 'Invalid Request');
		}
		
		$this->api->out();
	}
	
	public function change_value_status(){
		if(post() && $this->input->is_ajax_request()){
			
			$ID = post('ID');
			$sts = post('status');
			$action_type = post('action_type');
			
			$this->data['primary_key'] = 'component_value_id';
			$this->data['table'] = 'component_value';
			
			if(is_array($ID)){
				$this->db->where_in($this->data['primary_key'], $ID)->update($this->data['table'], array('component_value_status' => $sts));
			}else{
				$upd['data'] = array('component_value_status' => $sts);
				$upd['where'] = array($this->data['primary_key'] => $ID);
				$upd['table'] = $this->data['table'];
				update($upd);
				
			}
			
			if($action_type == 'multiple'){
				$this->api->cmd('reload');
			}else{
				
				$html = '';
				if($sts == ACTIVE_STATUS){
					$html = '<a href="'.JS_VOID.'"  data-toggle="tooltip" title="Make inactive" onclick="changeStatus(0, '.$ID.', this)"><span class="badge badge-success">Active</span></a>';
				}else{
					$html = '<a href="'.JS_VOID.'" data-toggle="tooltip" title="Make active"  onclick="changeStatus(1, '.$ID.', this)"><span class="badge badge-danger">Inactive</span></a>';
				}
			
			
				$this->api->data('html', $html);
				$this->api->cmd('replace');
			}
			
			
		}else{
			$this->api->set_error('invalid_request', 'Invalid Request');
		}
		
		$this->api->out();
	}
	
	public function delete_values($id=''){
		$action_type = post('action_type');
		if($action_type == 'multiple'){
			$id = post('ID');
		}
		
		$this->data['primary_key'] = 'component_value_id';
		$this->data['table'] = 'component_value';
			
		if($id){
			$this->component->deleteValues($id);
			$cmd = get('cmd');
			if($cmd && $cmd == 'remove'){
				if($id && is_array($id)){
					$this->db->where_in($this->data['primary_key'] ,  $id)->delete($this->data['table']);
				}else{
					$this->db->where($this->data['primary_key'] ,  $id)->delete($this->data['table']);
				}
				
			}
			$this->api->cmd('reload');
		}else{
			$this->api->set_error('invalid_request', 'Invalid Request');
		}
		$this->api->out();
	}
	
	public function upload_file(){
		if($_FILES && $this->input->is_ajax_request()){
			$upload_dir = LC_PATH.'component_icons/';
			
			if(!is_dir($upload_dir)){
				mkdir($upload_dir);
			}
			$config['upload_path']          = $upload_dir;
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['file_ext_tolower']        = TRUE;
			$config['encrypt_name']        = TRUE;
			
			$this->load->library('upload', $config);
			
			if(! $this->upload->do_upload('file')){
				
				$this->api->set_error('upload_error', $this->upload->display_errors());
				
			}else{
				
				$this->api->data('upload_data', $this->upload->data());
				
				$this->api->data('file_url', UPLOAD_HTTP_PATH.'component_icons/'.$this->upload->data('file_name'));
				
			}
			

		}
		
		$this->api->out();
	}
	
	
	
}





