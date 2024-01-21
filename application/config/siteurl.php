<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang_key="";
/*$ci =& get_instance();
$lang_ignore=$ci->config->item('lang_ignore');
if($_COOKIE['user_lang'] && $lang_ignore==FALSE){
	$lang_key=$_COOKIE['user_lang']."/";	
}
define('USER_LANG_KEY',$lang_key);
$lang_key=USER_LANG_KEY;*/
$config['homeURL'] = '';
$config['loginURL']= 'login/';
$config['forgotURL']= 'forgot/';
$config['IsLoginURL']= 'user/is_login';
$config['registerURL'] = 'sign-up/';
$config['AppiLogin']='user/applogin_check';
$config['SocialRegURL']='user/social_signup';
$config['logoutURL'] = 'logout/';
$config['dashboardURL'] = 'dashboard/';
$config['settingsURL'] = 'settings/';
$config['SetLanguage'] = 'home/setlanguage';
$config['VerifyURL'] = 'verify-user/'; #router
$config['resetPasswordURL'] = 'user/resetpassword';
$config['ForgotVerifyURL'] = 'verify-user-forgot/'; #router
$config['FortgotURLAJAX'] = 'ajax/forget-check';
$config['resetURLAJAX']= 'user/userresetCheckAjax';
$config['resendEmailURLAJAX']= 'user/resendemail';
$config['verifyDocumentURL']= 'dashboard/verifydocument';
$config['SaveDocumentAJAXURL']= 'dashboard/verifydocumentCheckAjax';

$config['TransactionHistoryURL'] = 'finance/transaction';
$config['WithdrawURL'] = 'finance/withdraw';
$config['WithdrawformAJAXURL'] = 'finance/withdrawmethod';
$config['processwithdrawmethodFormCheckAJAXURL'] = 'finance/processwithdrawmethod';
$config['actionwithdrawremove'] = 'finance/removewithdrawmethod';
$config['AddFundURL'] = 'finance/addfund';
$config['processAddFundFormCheckAJAXURL'] = 'finance/processfund';
$config['PaypalCheckOut'] = 'payment/paypal/';
$config['PaypalNotify'] = 'payment/paypalnotify/';
$config['StripeCheckOut'] = 'payment/stripe/';
$config['RequestPaymentStripe'] = 'payment/request_payment_stripe';
$config['MakePaymentStripe'] = 'payment/make_payment_stripe';


$config['settingpasswordURL'] = 'password/security_password';
$config['settingchangepasswordFormAJAXURL'] = 'password/change_password_form';
$config['settingchangepasswordFormCheckAJAXURL'] = 'password/change_password_form_check';

/*freelancer*/
$config['settingaccountInfoURL'] = 'settings/contact_info';
$config['settingaccountInfoDataAJAXURL'] = 'settings/contact_info_account_data';
$config['settingaccountInfoFormAJAXURL'] = 'settings/contact_info_account_form';
$config['settingaccountInfoFormCheckAJAXURL'] = 'settings/contact_info_account_form_check';
$config['settinglocationDataAJAXURL'] = 'settings/contact_location_data';
$config['settinglocationFormAJAXURL'] = 'settings/contact_location_form';
$config['settinglocationFormCheckAJAXURL'] = 'settings/contact_location_form_check';


/*client*/
$config['settingclientaccountInfoURL'] = 'clientsettings/client_contact_info';
$config['settingclientaccountInfoDataAJAXURL'] = 'clientsettings/contact_info_account_data';
$config['settingclientaccountInfoFormAJAXURL'] = 'clientsettings/contact_info_account_form';
$config['settingclientaccountInfoFormCheckAJAXURL'] = 'clientsettings/contact_info_account_form_check';
$config['settingclientcompanyDataAJAXURL'] = 'clientsettings/contact_company_data';
$config['settingclientcompanyFormAJAXURL'] = 'clientsettings/contact_company_form';
$config['settingclientcompanyFormCheckAJAXURL'] = 'clientsettings/contact_company_form_check';
$config['settingclientlogoFormCheckAJAXURL'] = 'clientsettings/logo_form_check';



$config['settingclientlocationDataAJAXURL'] = 'clientsettings/contact_location_data';
$config['settingclientlocationFormAJAXURL'] = 'clientsettings/contact_location_form';
$config['settingclientlocationFormCheckAJAXURL'] = 'clientsettings/contact_location_form_check';


$config['myprofileAJAXURL'] = 'profileview/index';
$config['viewprofileURL'] = 'profileview/view';
$config['editprofileAJAXURL'] = 'profileview/get_form';
$config['editprofileFormCheckAJAXURL'] = 'profileview/get_form_check';
$config['editprofileloadDataAJAXURL'] = 'profileview/load_data';
$config['deleteprofileDataAJAXURL'] = 'profileview/delete_data';



$config['CMSaboutus'] = 'about-us'; #router
$config['conatctURL'] = 'contact-us'; #router
$config['conatctCheckAjaxURL'] = 'contact-request-check'; #router
$config['CMStermsandconditions'] = 'terms-and-conditions'; #router
$config['CMSprivacypolicy'] = 'privacy-policy'; #router
$config['CMSrefundpolicy'] = 'refund-policy'; #router
$config['enterpriseURL'] = 'enterprise'; #router
$config['membershipURL'] = 'membership'; #router
$config['processMembershipURL'] = 'process-membership'; #router
$config['processMembershipFormCheckAJAXURL'] = 'membership/processmembership';
$config['CMShelp'] = 'help'; #router
$config['CMShowitworks'] = 'how-it-works'; #router
$config['CMSuseragreement'] = 'user-agreement'; #router


$config['postprojectURL'] = 'postproject/add';
$config['postprojectFormCheckAJAXURL'] = 'postproject/post_project_form_check';
$config['uploadFileFormCheckAJAXURL'] = 'postproject/uploadattachment';
$config['postprojectSuccessURL'] = 'postproject/success';
$config['editprojectURL'] = 'postproject/edit';


$config['myProjectDetailsURL'] = 'p';
$config['ApplyProjectURL'] = 'apply-job';
$config['HireProjectURL'] = 'projectview/hire';
$config['HireInviteFreelanceFormURL'] = 'projectclient/hireinviteform';

$config['OfferList'] = 'contract/offerlist';
$config['OfferDetails'] = 'contract/offer';
$config['offerActionAjaxURL'] = 'contract/offeraction';

$config['ContractList'] = 'contract';
$config['ContractDetails'] = 'contract/details';
$config['ContractMessage'] = 'contract/message';
$config['ContractTerm'] = 'contract/term';
$config['MilestoneDetails'] = 'contract/milestone';
$config['submitworkFormCheckAJAXURL'] = 'contract/submitwork_form_check';
$config['workActionAjaxURL'] = 'contract/workaction';
$config['workStartAjaxURL'] = 'contract/workstart';
$config['AddFundToEscrowAjaxURL'] = 'contract/addfundtoescrow';
$config['MakeDisputeURL'] = 'contract/createdispute';
$config['MakeDisputeURLFormCheckAJAXURL'] = 'contract/createdisputecheck';
$config['DisputeDetails'] = 'contract/disputedetails';
$config['submitDisputeOfferFormCheckAJAXURL'] = 'contract/submitdisputeoffer_form_check';
$config['disputeActionAjaxURL'] = 'contract/disputeaction';

$config['ContractDetailsHourly'] = 'workroom/details';
$config['ContractWorkLogHourly'] = 'workroom/worklog';
$config['ContractWorkLogHourlyAJAXURL'] = 'workroom/load_worklog';
$config['ContractInvoiceHourly'] = 'workroom/invoice';
$config['ContractMessageHourly'] = 'workroom/message';
$config['ContractTermHourly'] = 'workroom/term';
$config['submithourFormCheckAJAXURL'] = 'workroom/submitwork_form_check';
$config['workActionHourlyAjaxURL'] = 'workroom/workaction';
$config['CreateInvoicehourFormCheckAJAXURL'] = 'workroom/create_invoice_hourly';
$config['PauseContractAJAXURL'] = 'workroom/workactionpause';
$config['AddFundToEscrowHourlyAjaxURL'] = 'workroom/addfundtoescrow';

$config['InvoiceURL'] = 'invoice/listdata';
$config['GetInvoiceAJAXURL'] = 'invoice/load_invoice';
$config['InvoiceDetailsURL'] = 'invoice/details';
$config['InvoiceActionAjaxURL'] = 'invoice/action_invoice';
$config['ReviewURL'] = 'contract/endcontract';
$config['endcontractformFormCheckAJAXURL'] = 'contract/endcontractcheck';




$config['NotificationURL'] = 'notification';
$config['MessageURL'] = 'message';
$config['MessageRoomURL'] = 'message-room';
$config['CreateMessageRoomURL'] = 'message/createnewroom';


$config['applyprojectFormCheckAJAXURL'] = 'projectview/apply_project_form_check';
$config['hireprojectFormCheckAJAXURL'] = 'projectview/hire_project_form_check';

$config['myProjectDetailsBidsClientURL'] = 'projectview/applications';


$config['downloadProjectFileURL'] = 'projectview/downloadfile';
$config['viewapplicationURLAJAX'] = 'projectview/application';

$config['myprojectrecentClientURL'] = 'projectclient/recent';
$config['myProjectClientURL'] = 'projectclient/all';
$config['myProjectClientAJAXURL'] = 'projectclient/load_project';



$config['myProjectDetailsBidsClientloadCountAjaxURL'] = 'projectclient/load_proposal_count';
$config['myProjectDetailsBidsClientloadAjaxURL'] = 'projectclient/load_propasal';
$config['myProjectBidsClientStatusAjaxURL'] = 'projectclient/update_propasal';
$config['inviteToProjectAjaxURL'] = 'projectclient/invitetoproject';



$config['myContractClientURL'] = 'projectclient/contract';

$config['myBidsURL'] = 'projectfreelancer/bids';
$config['myBidsAJAXURL'] = 'projectfreelancer/load_project_bid';


$config['downloadTempURL'] = 'welcome/downloadtempfile';

$config['search_job'] = 'job/findjobs';
$config['actionfavorite_job'] = 'job/action_favorite';
$config['reportJobFormAjaxURL'] = 'job/action_report_form';
$config['actionreport_job'] = 'job/action_report';



$config['search_freelancer'] = 'findtalents/all_list';
$config['actionfavorite_freelancer'] = 'findtalents/action_favorite';

$config['favoriteURL'] = 'favorite';
$config['MyReviewURL'] = 'reviews';
$config['Reviewdetails'] = 'reviews/details';


