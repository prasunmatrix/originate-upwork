<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MX_Controller {
   
   private $data;
   
	public function __construct(){
		$this->data['curr_controller'] = $this->router->fetch_class()."/";
		$this->data['curr_method'] = $this->router->fetch_method()."/";
		$this->load->model('invoice_model', 'invoice');
		$this->data['table'] = 'invoices';
		$this->data['primary_key'] = 'invoice_id';
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
		$this->data['main_title'] = 'Invoice Management';
		$this->data['second_title'] = 'All invoice List';
		$this->data['title'] = 'Invoice';
		$breadcrumb = array(
			array(
				'name' => 'Invoice',
				'path' => '',
			),
		);
		$this->data['breadcrumb'] = breadcrumb($breadcrumb);
		$this->data['list'] = $this->invoice->getList($srch, $limit, $offset);
		$this->data['list_total'] = $this->invoice->getList($srch, $limit, $offset, FALSE);
		
		$this->load->library('pagination');
		$config['base_url'] = base_url($this->data['curr_controller'].'list_record');
		$config['total_rows'] =$this->data['list_total'];
		$config['per_page'] = $offset;
		$config['page_query_string'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		
		$this->pagination->initialize($config);
		
		$this->data['links'] = $this->pagination->create_links();
		$this->data['add_command'] = null;
		$this->data['edit_command'] = null;
		$this->layout->view('list', $this->data);
       
	}
	
	public function load_invoice(){
		$show='all';
		if($this->input->get('show')){
			$show=$this->input->get('show');
		}
		$contract_id_enc=$this->input->get('cid');
		$get_all_invoice=$this->input->get('get_all_invoice');
		$filter=array();

		$show_invoice=FALSE;
		if($contract_id_enc){
			$this->data['contractDetails'] = getData(array(
			'select'=>'p.project_id,p.project_url,p.project_title,c.contract_id,c.contract_title,c.contract_amount,c.is_hourly,c.contract_status,c.offer_by,c.contract_date,o.member_id as owner_id,c.contractor_id,co.max_hour_limit,co.allow_manual_hour',
			'table'=>'project_contract c',
			'join'=>array(
				array('table'=>'project_contract_offer co', 'on'=>'c.contract_id=co.contract_id', 'position'=>'left'),
				array('table'=>'project p', 'on'=>'c.project_id=p.project_id', 'position'=>'left'),
				array('table'=>'project_owner o', 'on'=>'p.project_id=o.project_id', 'position'=>'left'),
			),
			'where'=>array('md5(c.contract_id)'=>$contract_id_enc),
			'single_row'=>TRUE
			));
			if($this->data['contractDetails']){
				//print_r($this->data['contractDetails']);
				$contract_id=$this->data['contractDetails']->contract_id;
				$project_id=$this->data['contractDetails']->project_id;
				$contractor_id=$this->data['contractDetails']->contractor_id;
				$filter['project_id']=$project_id;
				$filter['contract_id']=$contract_id;
				$filter['invoice_for']='contract';
				$show_invoice=TRUE;
			}
		}
		if($show=='pending'){
			$filter['invoice_status']='0';
		}elseif($show=='rejected'){
			$filter['invoice_status']='2';
		}elseif($show=='completed'){
			$filter['invoice_status']='1';
		}
			
		$this->data['invoiceData']=array();
		$invoice_total=0;
		$from=0;
		$perpage=25;
		if(get('from')){
			$from=(get('from')-1)*$perpage;
		}
		if($show_invoice){
			$this->data['invoiceData']=$this->invoice->getList($filter,$from,$perpage,TRUE);
			$invoice_total=$this->invoice->getList($filter,$from,$perpage,FALSE);
		}
		$this->data['total_page']=ceil($invoice_total/$perpage);
		
		$this->data['show']=$show;
		$this->data['list']=$this->load->view('invoice-ajax',$this->data, TRUE, TRUE);
		
	
		//print_r($this->data);
		echo json_encode($this->data);
	}
}





