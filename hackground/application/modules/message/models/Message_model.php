<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_Model{
	
	private $table , $primary_key;
	
	public function __construct(){
		$this->table = 'conversations';
		$this->primary_key = 'conversations_id';
        return parent::__construct();
	}
	
	public function getList($srch=array(), $limit=0, $offset=20, $for_list=TRUE){
		$this->db->select('c.*,p.project_title,c_m.message,c_m.attachment,c_m.sending_date')
			->from($this->table . ' as  c')
			->join('project as p','c.project_id=p.project_id','left')
			->join('conversations_message c_m', 'c_m.message_id=c.last_message_id', 'LEFT')
			;
		$this->db->where('c.status', 1)->order_by('c.conversations_id','desc');
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('c.last_message_id', 'DESC')->get()->result_array();
			if($result){
				foreach($result as $k=>$row){
					$row['group']=$this->db->select('m.member_name,r.user_id')->from('conversations_room as r')->join('member as m','r.user_id=m.member_id','left')->where('r.conversations_id',$row['conversations_id'])->get()->result();
					$row['sender_name']='';
					$row['receiver_name']='';
					$result[$k]=$row;
				}
			}
			
		}else{
			$result = $this->db->count_all_results();
		}
		
		return $result;
	}
	public function getMessageChatList($room_id){
		$this->db->select('c_m.message_id,c_m.is_deleted,c_m.is_edited,c_m.message,c_m.attachment,c_m.sender_id,c_m.sending_date,m.member_name as sender_name')
			->from('conversations_message as c_m')
			->join('member as m','c_m.sender_id=m.member_id','left');
		$this->db->where('c_m.conversations_id', $room_id);
		
		$result = $this->db->order_by('c_m.message_id', 'ASC')->get()->result();
		if($result){
			foreach($result as $k=>$row){
				if($row->is_edited){
					$row->edited=$this->db->select('message_org,edit_date')->from('conversations_message_edited')->where('mesage_id',$row->message_id)->order_by('edit_id','desc')->get()->result();
				}
				$result[$k]=$row;
			}
		}
		return $result;
	}
	public function getConversationID($project_id='',$member_ids=array(),$is_auth=0){
		$sender_id=$member_ids[0];
		$conversationData=getData(array(
			'select'=>'p_c.conversations_id, count(p_c_m.conversations_id) as total',
			'table'=>'conversations as p_c',
			'join'=>array(array('table'=>'conversations_room as p_c_m','on'=>'p_c.conversations_id=p_c_m.conversations_id','position'=>'left')),
			'where'=>array('p_c.project_id'=>$project_id),
			'where_in'=>array('p_c_m.user_id'=>$member_ids),
			'single_row'=>true,
			'group'=>'p_c_m.conversations_id',
			'having'=>'count(total)>1',
			
		));
		if($conversationData){
			$selected_conversation_id=$conversationData->conversations_id;
		}else{
			$project_conversation=array(
				'project_id'=>$project_id,
				'status'=>1
			);
			$selected_conversation_id=insert_record('conversations',$project_conversation,TRUE);
			if($selected_conversation_id){
				$conversations_message=array(
					'conversations_id'=>$selected_conversation_id,
					'sender_id'=>$sender_id,
					'sending_date'=>date('Y-m-d H:i:s'),
					'message'=>'Chat initiated',
				);
				$message_id=insert_record('conversations_message',$conversations_message,TRUE);
				if($message_id){
					$this->db->where('conversations_id',$selected_conversation_id)->update('conversations',array('last_message_id'=>$message_id));
					if($member_ids){
						foreach($member_ids as $member_id){
							if($sender_id==$member_id){
								$is_auth_set=1;
							}else{
								$is_auth_set=$is_auth;
							}
							$project_conversation_member=array(
							'conversations_id'=>$selected_conversation_id,
							'user_id'=>$member_id,
							'auth_status'=>$is_auth_set,
							'last_seen_msg'=>$message_id,
							);
							insert_record('conversations_room',$project_conversation_member,TRUE);
						}
					}
				}
			}
		}	
		return $selected_conversation_id;
	}

	

	
	
}


