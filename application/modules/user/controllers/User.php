<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MX_Controller {
	
	private $data;
	
    public function __construct() {
		parent::__construct();
		$this->loggedUser=$this->session->userdata('loggedUser');
        $this->load->model('user_model');
		$this->data['curr_class'] = $this->router->fetch_class();
		$this->data['curr_method'] = $this->router->fetch_method();
		if($this->loggedUser && in_array($this->data['curr_method'],array('login','signup','forgot'))){
			redirect(get_link('dashboardURL'));
		}
		$this->layout->set_js(array(
			'utils/helper.js',
			'bootbox_custom.js',
			'mycustom.js',
		));
    }

    public function login() {

		$breadcrumb = array(
			array(
				'title'=>'Login',
				'path'=>''
			)
		);
		$this->data['breadcrumb']=breadcrumb($breadcrumb,'Login');
		$this->layout->view('login', $this->data);
	}
	public function userloginCheckAjax()
	{
		$this->load->library('form_validation');
		$this->load->library('bcrypt');
		checkrequestajax();
		$i=0;
		$msg=array();
		if($this->input->post()){
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
		if($this->form_validation->run( )== FALSE){
			$error=validation_errors_array();
			if($error){
				foreach($error as $key=>$val){
					$msg['status'] = 'FAIL';
	    			$msg['errors'][$i]['id'] = $key;
					$msg['errors'][$i]['message'] = $val;
	   				$i++;
				}
			}
		}else{
			if($i==0){
				$customerData=getData(array(
				'select'=>'a.access_user_id,a.access_user_password,login_status',
				'table'=>'access_panel a',
				'where'=>array('a.access_user_email'=>trim(post('email'))),
				'single_row'=>true,
				));
				$password=post('password');
				$mdpass= md5(post('password'));
				if($customerData){
					if($customerData->login_status==1 && ($this->bcrypt->check_password($password, $customerData->access_user_password) || $mdpass==$customerData->access_user_password)){
						if($mdpass==$customerData->access_user_password){
							$hash = $this->bcrypt->hash_password($password);
							update(array('table'=>'access_panel','where'=>array('access_user_id'=>$customerData->access_user_id),'data'=>array('access_user_password'=>$hash)));
						}
						$LAST_PCI=$this->user_model->getLastActive($customerData->access_user_id);
						$customer=array('LID'=>$LAST_PCI['LID'],'ACC_P_TYP'=>$LAST_PCI['TYP'],'OID'=>$LAST_PCI['OID'],'MID'=>$LAST_PCI['MID'],'UNAME'=>$LAST_PCI['UNAME']);
						$this->session->set_userdata('loggedUser',$customer);
						if($LAST_PCI['TYP']=='F'){
							getMembershipData($LAST_PCI['MID']);
						}
						$msg['status'] = 'OK';
						$msg['customsuccess'] = 'successContain';
						
						$msg['redirect'] =URL::get_link('dashboardURL');
						if($this->input->post('ref')){
							$refferURL=$this->input->post('ref');
							if($this->config->item($refferURL)){
								$msg['redirect'] =get_link($refferURL);
							}
						}elseif($this->input->post('refer')){
							$refferURL=get_link('homeURL').$this->input->post('refer');
							$msg['redirect'] =$refferURL;
						}
					}else{
						$msg['status'] = 'FAIL';
						$msg['errors'][$i]['id'] = 'password';
						$msg_error="Error try again later";
						if($customerData->login_status==0){
							$msg_error = 'You account not activate yet';
						}
						$msg['errors'][$i]['message'] = $msg_error;
					}		
				}else{
					$msg['status'] = 'FAIL';
					$msg['errors'][$i]['id'] = 'password';
					$msg['errors'][$i]['message'] = 'Invalid email or password';
				}
			}	
		}		
	}
	unset($_POST);
	echo json_encode($msg);		
	}

	public function signup() {
		$breadcrumb = array(
			array(
				'title'=>'Signup',
				'path'=>''
			)
		);
		$this->data['country']=getAllCountry();
		$this->data['breadcrumb']=breadcrumb($breadcrumb,'Signup');
		$this->layout->view('signup', $this->data);
	}
	public function usersignupCheckAjax()
	{
		$this->load->library('form_validation');
		$this->load->library('bcrypt');
		checkrequestajax();
		$i=0;
		$msg=array();
		$step=1;
		$is_employer=0;
		if($this->input->post()){
		$this->form_validation->set_rules('step', 'Step', 'required|trim|xss_clean');
		if(post('step')){
			$step=post('step');
		}
		if($step>=1 && $step!=3){
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|valid_email|is_unique[access_panel.access_user_email]',array('is_unique' => 'This email already exists. Please use the reset password link'));
		}
		if($step==2 || $step==3){
			$this->form_validation->set_rules('country', 'Country name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean|max_length[15]|min_length[6]|alpha_numeric');
			$this->form_validation->set_rules('user_type', 'User type', 'required|trim|xss_clean');
			
			if(post('user_type') && post('user_type')=='F'){
				$this->form_validation->set_rules('username', 'username', 'required|trim|xss_clean|is_unique[member.member_username]',array('is_unique' => 'Already exists'));
			}
		}
		if($step==3){
			$solial_log=$this->session->userdata('solial_log');
			if(!$solial_log){
				$this->form_validation->set_rules('solial_log', 'error', 'required');
			}else{
				$email=$solial_log['email'];
				if(!$email){
					$this->form_validation->set_rules('email', 'Email', 'required');
				}else{
					$check=$this->db->where('access_user_email',$email)->count_all_results('access_panel');
					if($check){
						$this->form_validation->set_rules('email', 'Email', 'required',array('required' => 'This email already exists. Please use the reset password link'));	
					}
				}
				
			}
		}
		
		if($this->form_validation->run( )== FALSE){
			$error=validation_errors_array();
			if($error){
				foreach($error as $key=>$val){
					$msg['status'] = 'FAIL';
	    			$msg['errors'][$i]['id'] = $key;
					$msg['errors'][$i]['message'] = $val;
	   				$i++;
				}
			}
		}else{
			if(post('user_type') && (post('user_type')=='F' || post('user_type')=='E')){
				
			}else{
				$msg['status'] = 'FAIL';
    			$msg['errors'][$i]['id'] = 'user_type';
				$msg['errors'][$i]['message'] = 'Invalid profile type';
   				$i++;
			}
		}
		if($i==0){
			if($step==1){
				$msg['status'] = 'OK';
				$msg['calback'] = 'nextstep';
				$msg['calbackdata'] = array('email'=>post('email'));
				
			}elseif($step==2 || $step==3){
				$pass=post('password');
				$hash = $this->bcrypt->hash_password($pass);
				if($step==3){
					$dataPost=array(
						'access_user_email'=>$solial_log['email'],
						'access_user_password'=>$hash,
						'login_status'=>1,
					);
					$email=$solial_log['email'];
					$name=$solial_log['name'];
				}else{
					$dataPost=array(
						'access_user_email'=>trim(post('email')),
						'access_user_password'=>$hash,
						'login_status'=>1,
					);
					$email=trim(post('email'));
					$name=trim(post('name'));
				}
				$LID=insert_record('access_panel',$dataPost,TRUE);
				if($LID){
					$token = md5(time().'-'.$LID);
					$code=md5($email);
					$username=NULL;
					if(post('username')){
						$username=post('username');
					}
					$insdata=array('access_user_id'=>$LID,'member_name'=>$name,'member_email'=>$email,'member_register_date'=>date('Y-m-d H:i:s'),'member_username'=>$username);
					if(post('user_type')=='E'){
						$insdata['is_employer']=1;
					}
					if($step==3){
						$insdata['is_email_verified']=1;
					}
					$member_id=insert_record('member',$insdata,TRUE);
					if(post('user_type')=='E'){
						$organization_name=$insdata['member_name'];
						$organization_id=insert_record('organization',array('organization_name'=>$organization_name,'organization_email'=>$email,'organization_register_date'=>date('Y-m-d H:i:s'),'member_id'=>$member_id),TRUE);
						if($organization_id){
							insert_record('organization_address',array('organization_id'=>$organization_id,'organization_country'=>post('country')),FALSE);
						}
					}else{
						insert_record('member_address',array('member_id'=>$member_id,'member_country'=>post('country')),FALSE);
					}
					if($member_id){
						$profile_name=$insdata['member_name'];
						insert_record('wallet',array('user_id'=>$member_id,'title'=>$profile_name,'balance'=>0),FALSE);
						$insdataToken=array('member_id'=>$member_id,'token_value'=>$token,'sent_date'=>date('Y-m-d H:i:s'),'access_ip'=>$this->input->ip_address(),'token_type'=>'REGISTER');
						$LAST_PCI=$this->user_model->getLastActive($LID);
						$customer=array('LID'=>$LAST_PCI['LID'],'ACC_P_TYP'=>$LAST_PCI['TYP'],'OID'=>$LAST_PCI['OID'],'MID'=>$LAST_PCI['MID'],'UNAME'=>$LAST_PCI['UNAME']);
						$this->session->set_userdata('loggedUser',$customer);
						if($step==2){
							$id=insert_record('profile_verify_token',$insdataToken,TRUE);
						}
						if(post('user_type')=='F'){
							getMembershipData($member_id);
						}
					}
					
					if($token){
						if($step==2){
							$url=URL::get_link('VerifyURL').$token;
							$template='email-verification';
							$data_parse=array(
							'MEMBER_NAME'=>$profile_name,
							'VERIFICATION_URL'=>$url,
							);
							$to=post('email');
							//$to='asish9735@gmail.com';
							SendMail($to,$template,$data_parse);
							
						}
						$template='new-registration';
						$data_parse=array(
						'MEMBER_URL'=>ADMIN_URL.'member/list_record',
						);
						SendMail(get_setting('admin_email'),$template,$data_parse);
						$data_pase = array(
							'FULL_NAME' => $profile_name
						);
						$this->admin_notification_model->parse('admin-user-signup', $data_pase, 'member/list_record');
						$msg['status'] = 'OK';
						$msg['name'] = $profile_name;
						//$msg['redirect'] = VPATH."user-signup-verify";
						$msg['redirect'] =URL::get_link('dashboardURL');
						$this->session->unset_userdata('solial_log');
					}else{
						$msg['status'] = 'FAIL';
						$msg['errors'][$i]['id'] = 'email';
						$msg['errors'][$i]['message'] = 'Token not create';
					}
				}else{
					$msg['status'] = 'FAIL';
					$msg['errors'][$i]['id'] = 'email';
					$msg['errors'][$i]['message'] = 'Error in process';
				}
			}
				
		}		
	}
	unset($_POST);
	echo json_encode($msg);		
	}
	public function forgot() {
		$this->layout->view('forgot', $this->data);
	}
	public function userforgotCheckAjax()
	{
		$this->load->library('form_validation');
		checkrequestajax();
		$i=0;
		$msg=array();
		if($this->input->post()){
		$this->form_validation->set_rules('forgot_email', 'Email', 'required|trim|xss_clean|valid_email');
		if ($this->form_validation->run() == FALSE){
			$error=validation_errors_array();
			if($error){
				foreach($error as $key=>$val){
					$msg['status'] = 'FAIL';
	    			$msg['errors'][$i]['id'] = $key;
					$msg['errors'][$i]['message'] = $val;
	   				$i++;
				}
			}
		}else{

			if($i==0){
				$customerData=getData(array(
				'select'=>'a.access_user_id,login_status',
				'table'=>'access_panel a',
				'where'=>array('a.access_user_email'=>trim(post('forgot_email'))),
				'single_row'=>true,
				));
				if($customerData){
					$LAST_PCI=$this->user_model->getLastActive($customerData->access_user_id);
					$token = md5(time().'-'.$customerData->access_user_id);
					$insdataToken=array('access_user_id'=>$customerData->access_user_id,'member_id'=>$LAST_PCI['MID'],'token_value'=>$token,'sent_date'=>date('Y-m-d H:i:s'),'access_ip'=>$this->input->ip_address(),'token_type'=>'FORGOT');
					delete(array('table'=>'profile_verify_token','where'=>array('access_user_id'=>$customerData->access_user_id,'token_type'=>'FORGOT')));
					$id=insert_record('profile_verify_token',$insdataToken,TRUE);
					$url=URL::get_link('ForgotVerifyURL').$token;
					$template='forgot-password';
					$data_parse=array(
					'MEMBER_NAME'=>getFieldData('member_name','member','member_id',$LAST_PCI['MID']),
					'VERIFY_URL'=>$url,
					);
					SendMail(post('forgot_email'),$template,$data_parse);
					$msg['status'] = 'OK';
					$msg['redirect'] =get_link('homeURL');
				}else{
					$msg['status'] = 'FAIL';
					$msg['errors'][$i]['id'] = 'forgot_email';
					$msg['errors'][$i]['message'] = 'Email not match ';
				}
			}	
		}		
	}
	unset($_POST);
	echo json_encode($msg);		
	}
	public function resetpassword($verifycode=''){
		
		$this->data['verifycode']=$verifycode;
		$this->data['is_valid']=0;
		if($verifycode){
			$time=date('Y-m-d H:i:s',strtotime('-1 hours'));
			$verifyData=getData(array(
				'select'=>'a.member_id',
				'table'=>'profile_verify_token a',
				'where'=>array('a.token_value'=>$verifycode,'token_type'=>'FORGOT','sent_date >='=>$time),
				'single_row'=>true,
				));
			if($verifyData){
				$this->data['is_valid']=1;
			}
		}
		$this->layout->view('resetpassword', $this->data);
	}

	public function userresetCheckAjax()
	{
		$this->load->library('form_validation');
		$this->load->library('bcrypt');
		checkrequestajax();
		$i=0;
		$msg=array();
		if($this->input->post()){
		$this->form_validation->set_rules('verifycode', 'verifycode', 'required|trim|xss_clean');
		$this->form_validation->set_rules('new_pass', 'new password', 'required|trim|xss_clean');
		$this->form_validation->set_rules('new_pass_again', 'confirm', 'required|trim|xss_clean|matches[new_pass]');
		if ($this->form_validation->run() == FALSE){
			$error=validation_errors_array();
			if($error){
				foreach($error as $key=>$val){
					$msg['status'] = 'FAIL';
	    			$msg['errors'][$i]['id'] = $key;
					$msg['errors'][$i]['message'] = $val;
	   				$i++;
				}
			}
		}else{

			if($i==0){
				$this->load->library('bcrypt');
				$customerData=getData(array(
				'select'=>'a.access_user_id,login_status',
				'table'=>'profile_verify_token p_v',
				'join'=>array(array('table'=>'access_panel a','on'=>'p_v.access_user_id=a.access_user_id','position'=>'left')),
				'where'=>array('p_v.token_type'=>'FORGOT','token_value'=>trim(strip_tags(post('verifycode')))),
				'single_row'=>true,
				));
				if($customerData){
					$pass=post('new_pass');
					$hash = $this->bcrypt->hash_password($pass);
					updateTable('access_panel',array('access_user_password'=>$hash),array('access_user_id'=>$customerData->access_user_id));
					delete(array('table'=>'profile_verify_token','where'=>array('access_user_id'=>$customerData->access_user_id,'token_type'=>'FORGOT')));
					$msg['status'] = 'OK';
					$msg['redirect'] =get_link('loginURL');
				}else{
					$msg['status'] = 'FAIL';
					$msg['errors'][$i]['id'] = 'verifycode';
					$msg['errors'][$i]['message'] = 'Invalid verify code';
				}
			}	
		}		
	}
	unset($_POST);
	echo json_encode($msg);		
	}
	public function userverify($verifycode=''){
		
		$this->data['verifycode']=$verifycode;
		$this->data['is_valid']=0;
		if($verifycode){
			$time=date('Y-m-d H:i:s',strtotime('-1 hours'));
			$verifyData=getData(array(
				'select'=>'a.member_id',
				'table'=>'profile_verify_token a',
				'where'=>array('a.token_value'=>$verifycode,'token_type'=>'REGISTER','sent_date >='=>$time),
				'single_row'=>true,
				));
			if($verifyData){
				$this->data['is_valid']=1;
				updateTable('member',array('is_email_verified'=>1),array('member_id'=>$verifyData->member_id));
				delete(array('table'=>'profile_verify_token','where'=>array('member_id'=>$verifyData->member_id,'token_type'=>'REGISTER')));
				$member_id=$verifyData->member_id;
				$RECEIVER_EMAIL=getFieldData('member_email','member','member_id',$member_id);
				$data_parse=array(
				'MEMBER_NAME'=>getFieldData('member_name','member','member_id',$member_id),
				);
				$template='user-email-verified';
				SendMail($RECEIVER_EMAIL,$template,$data_parse);
				
			/*	loadModel('notifications/notification_model');
				$notificationData=array(
				'sender_id'=>0,
				'receiver_id'=>$member_id,
				'template'=>'welcome_notification_verified',
				'url'=>$this->config->item('dashboardURL'),
				'content'=>json_encode(array('MID'=>$member_id)),
				);
				$this->notification_model->savenotification($notificationData);*/
			}
		}
		$this->layout->view('verify-user', $this->data);
	}
	public function resendemail(){
		checkrequestajax();
		$msg=array();
		$this->loggedUser=$this->session->userdata('loggedUser');
		if($this->loggedUser){
			$LID=$this->loggedUser['LID'];
			$MID=$this->loggedUser['MID'];
			$token = md5(time().'-'.$LID);
			$insdataToken=array('access_user_id'=>$LID,'member_id'=>$MID,'token_value'=>$token,'sent_date'=>date('Y-m-d H:i:s'),'access_ip'=>$this->input->ip_address(),'token_type'=>'REGISTER');
			delete(array('table'=>'profile_verify_token','where'=>array('access_user_id'=>$LID,'token_type'=>'REGISTER')));
			$id=insert_record('profile_verify_token',$insdataToken,TRUE);
			$url=URL::get_link('VerifyURL').$token;
			$template='email-verification';
			$data_parse=array(
			'MEMBER_NAME'=>getFieldData('member_name','member','member_id',$MID),
			'VERIFICATION_URL'=>$url,
			);
			$to=getFieldData('access_user_email','access_panel','access_user_id',$LID);
			//$to='asish9735@gmail.com';
			SendMail($to,$template,$data_parse);
			$msg['status']='OK';
		}else{
			$msg['status']='FAIL';
		}
		echo json_encode($msg);		
	}
	public function signout(){
		$this->loggedUser=$this->session->userdata('loggedUser');
		if($this->loggedUser){
			$this->member_id=$this->loggedUser['MID'];
			$this->db->where('user_id',$this->member_id)->delete('online_user');
		}
		$this->session->unset_userdata('loggedUser');
		redirect(URL::get_link('homeURL'));
	}
	public function is_login() {
		$this->loggedUser=$this->session->userdata('loggedUser');
		if($this->loggedUser){
			echo 1;
		}else{
			echo 0;
		}
	}

	public function login_check() {
		$this->load->library('form_validation');
		if(post()){
			$this->form_validation->set_rules('email', 'email', 'required');
			$this->form_validation->set_rules('password', 'password', 'required');
			
			if($this->form_validation->run()){
				
				$this->api->set_data('form_validation_status', API_SUCCESS);
			}else{
				$error = validation_errors_array();
				$this->api->set_error($error);
				
			}
		}

		$this->api->out();
		
	}
	public function applogin_check($type='')
	{
		$this->load->library('form_validation');
		checkrequestajax();
		$i=0;
		$msg=array();
		if($this->input->post() && $type){
			if($type=='facebook' || $type=='google'){
				/*$url='https://graph.facebook.com/oauth/access_token?client_id=1225948780930403&client_secret=45db911b706fabb4256965e3ff6e75d2&grant_type=client_credentials';
				$valid=checkvalidfacebook($url);
				$url='https://graph.facebook.com/v5.0/'.post('id').'/?access_token='.$valid->access_token;
				$valid=checkvalidfacebook($url);
				var_dump($valid);*/
				$this->form_validation->set_rules('id', __('accesspanel_id','id'), 'required|trim|xss_clean');
				//$this->form_validation->set_rules('name', 'name', 'required|trim|xss_clean');
				$this->form_validation->set_rules('email', __('accesspanel_lang_signup_Email','Email'), 'required|trim|xss_clean|valid_email');
				if ($this->form_validation->run() == FALSE){
					$error=validation_errors_array();
					if($error){
						foreach($error as $key=>$val){
							$msg['status'] = 'FAIL';
			    			$msg['errors'][$i]['id'] = $key;
			    			$msg['errors'][$i]['message'] = $val;
			    			if($key=='email'){
								$msg['errors'][$i]['message'] = __('accesspanel_lang_email_not_exists','Email not exists or not valid from api');
							}
			   				$i++;
						}
					}
				}
				else{
					$customerData=getData(array(
					'select'=>'a.access_user_id,a.access_user_password,login_status',
					'table'=>'access_panel a',
					'where'=>array('a.access_user_email'=>trim(post('email'))),
					'single_row'=>true,
					));
					if($customerData){
						if($customerData->login_status==1){
							$LAST_PCI=$this->user_model->getLastActive($customerData->access_user_id);
							$customer=array('LID'=>$customerData->access_user_id,'LAST_PCI'=>$LAST_PCI['LAST_PCI'],'ACC_P_TYP'=>$LAST_PCI['TYP'],'MID'=>$LAST_PCI['MID'],'OID'=>$LAST_PCI['OID'],'UNAME'=>NULL);
							$this->session->set_userdata('loggedUser',$customer);	
							$msg['status'] = 'OK';
							$msg['customsuccess'] = 'successContain';
							$msg['redirect'] =get_link('dashboardURL');
							if($this->input->post('ref')){
								$refferURL=$this->input->post('ref');
								if($this->config->item($refferURL)){
									$msg['redirect'] =get_link($refferURL);
								}
							}elseif($this->input->post('refer')){
								$refferURL=get_link('homeURL').'/'.$this->input->post('refer');
								$msg['redirect'] =$refferURL;
							}
						}
					}
					else{
						$solial_log=array(
							'id'=>trim(post('id')),
							'email'=>trim(post('email')),
							'name'=>trim(post('name')),
						);
						$this->session->set_userdata('solial_log',$solial_log);

						$msg['status'] = 'OK';
						$msg['customsuccess'] = 'successContain';
						$msg['redirect'] =get_link('SocialRegURL');
						if($this->input->post('ref')){
							$refferURL=$this->input->post('ref');
							$msg['redirect'].='?ref='.$refferURL;
						}elseif($this->input->post('refer')){
							$refferURL=$this->input->post('refer');
							$msg['redirect'].='?refer='.$refferURL;
						}
						
					}
					
				}
				
			}
	
		}
	unset($_POST);
	echo json_encode($msg);		
	}
	public function social_signup() {
		$breadcrumb = array(
			array(
				'title'=>'Signup',
				'path'=>''
			)
		);
		$this->data['solial_log']=$this->session->userdata('solial_log');
		if(!$this->data['solial_log']){
			redirect(URL::get_link('homeURL'));
		}
		$this->data['country']=getAllCountry();
		$this->data['breadcrumb']=breadcrumb($breadcrumb,'Signup');
		$this->layout->view('social-signup', $this->data);
	}
	
	
	public function signup_check() {
		
	}

	public function logout(){

	}

}
