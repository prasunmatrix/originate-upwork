<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisement_model extends CI_Model{
	
	private $table , $lang_table, $primary_key;
	
	public function __construct(){
        return parent::__construct();
	}
	
	
	public function configure($options=array()){
		$this->table = !empty($options['table']) ? $options['table'] : '';
		$this->lang_table =  !empty($options['lang_table']) ? $options['lang_table'] : '';
		$this->primary_key = !empty($options['primary_key']) ? $options['primary_key'] : '';
	}
	
	public function getList($srch=array(), $limit=0, $offset=20, $for_list=TRUE){
		$admin_default_lang = admin_default_lang();
		$this->db->select('*')
			->from($this->table. ' a');
			
		
		if(!empty($srch['show']) && $srch['show'] == 'trash'){
			$this->db->where('a.status', DELETE_STATUS);	
		}else{
			$this->db->where('a.status <>', DELETE_STATUS);	
		}
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('a.advertisement_id', 'DESC')->get()->result_array();
		}else{
			$result = $this->db->count_all_results();
		}
		
		return $result;
	}
	
	public function addRecord($data=array()){
		$structure = array(
			'ad_image' => !empty($data['ad_image']) ? $data['ad_image'] : '',
			'ad_code' => !empty($data['ad_code']) ? $data['ad_code'] : '',
			'ad_url' => !empty($data['ad_url']) ? $data['ad_url'] : '',
			'ad_size' => !empty($data['ad_size']) ? $data['ad_size'] : '',
			'ad_type' => !empty($data['ad_size']) ? $data['ad_type'] : '',
			'page' => !empty($data['page']) ? $data['page'] : '',
			'position' => !empty($data['position']) ? $data['position'] : '',
			'status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = $this->table;
		$insert_id = insert($ins, TRUE);
		
		$location = !empty($data['advertisement_location']) ? $data['advertisement_location'] : array();
		$category = !empty($data['advertisement_category']) ? $data['advertisement_category'] : array();
		
		$this->setAdvertisementLocation($location, $insert_id);
		$this->setAdvertisementCategory($category, $insert_id);
		
		/* $lang_fields = $data['lang'];
		$this->insert_lang_data($lang_fields, $insert_id); */
		
	
		
		return $insert_id;
	}
	
	public function setAdvertisementLocation($data=array(), $advertisement_id=''){
		$table = 'advertisement_location';
		$this->db->where('advertisement_id', $advertisement_id)->delete($table);
		$ins = array();
		foreach($data as $k => $v){
			$ins[] = array(
				'advertisement_id' => $advertisement_id,
				'location_id' => $v,
			);
		}
		
		if($ins){
			$this->db->insert_batch($table, $ins);
		}
		
	}
	
	public function setAdvertisementCategory($data=array(), $advertisement_id='', $level=1){
		$table = 'advertisement_category';
		$this->db->where('advertisement_id', $advertisement_id)->delete($table);
		$ins = array();
		foreach($data as $k => $v){
			$ins[] = array(
				'advertisement_id' => $advertisement_id,
				'category_id' => $v,
				'category_level' => $level,
			);
		}
		
		if($ins){
			$this->db->insert_batch($table, $ins);
		}
	}
	
	public function insert_lang_data($lang_fields=array(), $insert_id=''){
		$all_lang = get_lang();
		
		$this->db->where($this->primary_key, $insert_id)->delete($this->lang_table);
		foreach($all_lang as $k => $v){
			
			
			$structure = array(
				$this->primary_key => $insert_id,
				'category_lang' => $v,
			);
			
			foreach($lang_fields as $field_name => $lang_val){
				$structure[$field_name] = $lang_fields[$field_name][$v];
			}
			
			$lang_record['data'] = $structure;
			$lang_record['table'] = $this->lang_table;
			
			insert($lang_record);
		}
	}


	public function updateRecord($data=array(), $id=''){
		$structure = array(
			'ad_image' => !empty($data['ad_image']) ? $data['ad_image'] : '',
			'ad_code' => !empty($data['ad_code']) ? $data['ad_code'] : '',
			'ad_url' => !empty($data['ad_url']) ? $data['ad_url'] : '',
			'ad_size' => !empty($data['ad_size']) ? $data['ad_size'] : '',
			'ad_type' => !empty($data['ad_size']) ? $data['ad_type'] : '',
			'page' => !empty($data['page']) ? $data['page'] : '',
			'position' => !empty($data['position']) ? $data['position'] : '',
			'status' => !empty($data['status']) ? $data['status'] : '0',
		);
		$ins['data'] = $structure;
		$ins['table'] = $this->table;
		$ins['where'] = array($this->primary_key => $id);
		
		
		/* $lang_fields = $data['lang'];
		$this->insert_lang_data($lang_fields, $id); */
		
		
		update($ins);
		
		$location = !empty($data['advertisement_location']) ? $data['advertisement_location'] : array();
		$category = !empty($data['advertisement_category']) ? $data['advertisement_category'] : array();
		
		$this->setAdvertisementLocation($location, $id);
		$this->setAdvertisementCategory($category, $id);
		
		return TRUE;
		
	}
	
	public function deleteRecord($id=''){
		if($id && is_array($id)){
			return $this->db->where_in($this->primary_key, $id)->update($this->table, array('category_status' => DELETE_STATUS));
		}else{
			$ins['data'] = array('category_status' => DELETE_STATUS);
			$ins['table'] = $this->table;
			$ins['where'] = array($this->primary_key => $id);
			return  update($ins);
		}
		
	}
	
	public function getDetail($id=''){
		$result = $this->db->where($this->primary_key, $id)->get($this->table)->row_array();
		if($result){
			$result['advertisement_location'] = $result['advertisement_category'] = array();
			$ad_location = $this->db->where('advertisement_id', $id)->get('advertisement_location')->result_array();
			$ad_category = $this->db->where('advertisement_id', $id)->get('advertisement_category')->result_array();
			if($ad_location){
				foreach($ad_location as $k => $v){
					$result['advertisement_location'][] = $v['location_id'];
				}
			}
			if($ad_category){
				foreach($ad_category as $k => $v){
					$result['advertisement_category'][] = $v['category_id'];
				}
			}
		}
		return $result;
	}
	
	private function _adAttributes(){
		$attr = array(
			'pages' => array(
				array(
					'name' => 'Home Page',
					'slug' => 'home-page',
					'position' => array(
						array(
							'name' => 'header',
							'size' => array(
								'720x35',
								'820x35',
								'920x35',
								'620x35',
							)
						),
						
						array(
							'name' => 'footer',
							'size' => array(
								'720x35',
								'820x35',
								'920x35',
								'620x35',
							)
						)
						
					)
				),
				
				array(
					'name' => 'Ad List Page',
					'slug' => 'listing-page',
					'position' => array(
						array(
							'name' => 'header',
							'size' => array(
								'720x35',
								'820x35',	
							)
						),
						
						array(
							'name' => 'footer',
							'size' => array(
								'720x35',
								'620x35',
							)
						),
						
						array(
							'name' => 'left',
							'size' => array(
								'250x250',
								'100x50',
							)
						),
						
						array(
							'name' => 'right',
							'size' => array(
								'250x250',
								'100x50',
							)
						)
						
					)
				),
				
				array(
					'name' => 'Ad Detail Page',
					'slug' => 'detail-page',
					'position' => array(
						array(
							'name' => 'header',
							'size' => array(
								'720x35',
								'820x35',
								'920x35',
								'620x35',
							)
						),
						
						array(
							'name' => 'footer',
							'size' => array(
								'720x35',
								'820x35',
								'920x35',
								'620x35',
							)
						),
						
						array(
							'name' => 'right',
							'size' => array(
								'250x250',
								'100x50',
							)
						)
						
					)
				),
				
			)
		);
		
		return $attr;
	}
	
	public function get_pages(){
		$attr = $this->_adAttributes();
		return $attr['pages'];
	}
	
	public function get_position($page=''){
		$pages = $this->get_pages();
		foreach($pages as $k => $v){
			if($v['slug'] == $page){
				return $v['position'];
			}
		}
		
		return FALSE;
	}
	
	public function get_size($page='', $position=''){
		$all_position = $this->get_position($page);
		foreach($all_position as $k => $v){
			if($v['name'] == $position){
				return $v['size'];
			}
		}
		
		return FALSE;
	}
	
	public function get_page_name($page_slug=''){
		$pages = $this->get_pages();
		foreach($pages as $k => $v){
			if($v['slug'] == $page_slug){
				return $v['name'];
			}
		}
	}
	
	
	public function get_location(){
		$admin_default_lang = admin_default_lang();
		$default_country = default_country();
		$this->db->select('b.state_id,b.state_name')
			->from('state a')
			->join('state_names b', 'a.state_id=b.state_id');
		
		if(!empty($srch['show']) && $srch['show'] == 'trash'){
			$this->db->where('a.state_status', DELETE_STATUS);	
		}else{
			$this->db->where('a.state_status <>', DELETE_STATUS);	
		}
		
		$this->db->where('a.country_code', $default_country);
		$this->db->where('b.state_lang', $admin_default_lang);	
		
		$result = $this->db->order_by('b.state_name', 'ASC')->get()->result_array();
		
		return $result;
	}
	
}


