<?php
$loggedUser=$this->session->userdata('loggedUser');
if($loggedUser){
	$profile_name='';
	$this->access_user_id=$loggedUser['LID'];	
	$this->access_member_type=$loggedUser['ACC_P_TYP'];
	$this->member_id=$loggedUser['MID'];
	$this->organization_id=$loggedUser['OID'];
	$member_name=getFieldData('member_name','member','member_id',$this->member_id);
	if($this->access_member_type=='C'){
		$logo=getCompanyLogo($this->organization_id);
		$organization_name=getFieldData('organization_name','organization','member_id',$this->member_id);
		$profile_name=($organization_name  ? $organization_name:$member_name);
	}else{
		$logo=getMemberLogo($this->member_id);
		$profile_name=$member_name;
	}
	$profile_type_name=($this->access_member_type =='C'  ? "Client":"Freelancer");
	$wallet_balance=getFieldData('balance','wallet','user_id',$this->member_id);
}
?>
<!-- Header Container
================================================== -->
<header id="header-container" class="fullwidth">
<?php /* if($this->router->fetch_class()=='dashboard'){?>dashboard-header not-sticky<?php }*/?>
	<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="start-side">				
				<!-- Logo -->
				<div id="logo">
					<a href="<?php echo base_url();?>"><img src="<?php echo IMAGE;?>logo.png" data-sticky-logo="<?php echo IMAGE;?>logo.png" data-transparent-logo="<?php echo IMAGE;?>logo2.png" alt=""></a>
				</div>				
				
			</div>
			<!-- Left Side Content / End -->


			<!-- Right Side Content / End -->
			<div class="end-side">
            	<!-- Main Navigation -->
				<nav id="navigation">
					<ul id="responsive">                    
                    <li><a href="<?php D(get_link('CMShowitworks'))?>"><?php echo __('how_it_works','How It Works'); ?></a></li>
                    <li><a href="<?php D(get_link('conatctURL'))?>"><?php echo __('contact_us','Contact Us'); ?></a></li>
					<?php if($loggedUser){
						if($this->access_member_type=='C'){
						?>
						<li><a href="<?php echo URL::get_link('search_freelancer'); ?>"><?php echo __('professionals','Professionals'); ?></a></li>
						<li><a href="<?php D(get_link('postprojectURL'))?>"><?php echo __('',''); ?><?php echo __('post_a_job','Post A Job'); ?></a></li>
						<?php }
						if($this->access_member_type=='F'){
						?>
						<li><a href="<?php echo URL::get_link('search_job'); ?>"><?php echo __('projects','Projects'); ?></a></li>
						<?php }?>
						<li><a href="<?php echo URL::get_link('dashboardURL'); ?>"><?php echo __('dashboard','Dashboard'); ?></a></li>
					<?php }else{?>
					<li><a href="<?php echo URL::get_link('search_job'); ?>"><?php echo __('projects','Projects'); ?></a></li>
					<li><a href="<?php echo URL::get_link('search_freelancer'); ?>"><?php echo __('',''); ?><?php echo __('professionals','Professionals'); ?></a></li>
                    <li class="d-sm-none"><a href="<?php echo URL::get_link('loginURL'); ?>"><?php echo __('login','Log In'); ?></a></li>
					<li class="d-sm-none"><a href="<?php echo URL::get_link('registerURL'); ?>"><?php echo __('register','Register'); ?></a></li>
                    <li class="d-sm-none"><a href="<?php echo URL::get_link('registerURL'); ?>"><?php echo __('post_a_job','Post A Job'); ?></a></li>
					<?php }?>
					
				  </ul>
				</nav>
				<!--<div class="clearfix"></div>-->
				<!-- Main Navigation / End -->

			<?php if(!is_login_user()){ ?>
				<div class="header-widget hide-on-mobile_ d-none d-sm-block">
					<ul class="display-inline">
                    	<li><a href="<?php echo URL::get_link('loginURL'); ?>"><img src="<?php echo IMAGE;?>login_16.png" alt=""> <?php echo __('login','Log In'); ?></a></li>
						<li><a href="<?php echo URL::get_link('registerURL'); ?>"><img src="<?php echo IMAGE;?>register_16.png" alt=""> <?php echo __('register','Register'); ?></a></li>
                    	<li><a href="<?php echo URL::get_link('registerURL'); ?>" class="btn btn-primary text-white"><img src="<?php echo IMAGE;?>post_20.png" alt=""> <?php echo __('post_a_job','Post A Job'); ?></a></li>
					</ul>
                </div>
			<?php }else{ ?>

				<!--  User Notifications -->
				<div class="header-widget">					
					<!-- Notifications -->
					<div class="header-notifications">
						<!-- Trigger -->
						<div class="header-notifications-trigger notification-trigger">
							<a href="#"><i class="icon-feather-bell"></i><span class="new-notification-counter" style="display:none"></span></a>
						</div>
						<!-- Dropdown -->
						<div class="header-notifications-dropdown">
							<div class="header-notifications-headline">
								<h4><?php echo __('notifications','Notifications'); ?></h4>
								<button class="mark-as-read" title="Mark all as read" data-tippy-placement="left" hidden>
									<i class="icon-feather-check-square"></i>
								</button>
							</div>                            
							<div class="header-notifications-content">
								<div class="header-notifications-scroll" data-simplebar>
									<ul id="header-notification-list">
										
									</ul>
									<a id="load_more_notification_btn" href="javascript:void(0)" style="display:none;"><?php echo __('load_more','Load more'); ?></a>
								</div>
							</div>
							<a href="<?php echo get_link('NotificationURL');?>" style="display:none" class="header-notifications-button button-sliding-icon viewallbtnnotification"><?php echo __('view_all_notification','View All Notifications');?><i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>
					
					<!-- Messages -->
					<div class="header-notifications">
						<div class="header-notifications-trigger message-trigger">
							<a href="#"><i class="icon-feather-mail"></i><span class="new-message-counter" style="display:none"></span></a>
						</div>

						<!-- Dropdown -->
						<div class="header-notifications-dropdown">

							<div class="header-notifications-headline">
								<h4><?php echo __('messages','Messages'); ?></h4>
								<button class="mark-as-read" title="Mark all as read" data-tippy-placement="left" hidden>
									<i class="icon-feather-check-square"></i>
								</button>
							</div>

							<div class="header-notifications-content with-icon">
								<div class="header-notifications-scroll" id="header-message-container" data-simplebar>
									<ul id="header-message-list">
										
									</ul>
									<a id="load_more_msg_btn" href="javascript:void(0)" style="display:none;"><?php echo __('load_more','Load more'); ?></a>
								</div>
							</div>

							<a href="<?php echo get_link('MessageURL');?>" style="display:none" class="header-notifications-button button-sliding-icon viewallbtnmessage"><?php echo __('view_all_message','View All Messages'); ?><i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>

				</div>
				<!--  User Notifications / End -->				

				<!-- User Menu -->
				<div class="header-widget">
					<!-- Messages -->
					<div class="header-notifications user-menu">
						<div class="header-notifications-trigger">
							<a href="#"><div class="user-avatar status-online"><img src="<?php echo $logo;?>" alt=""></div></a>
						</div>

						<!-- Dropdown -->
						<div class="header-notifications-dropdown">

							<!-- User Status -->
							<div class="user-status">

								<!-- User Name / Avatar -->
								<div class="user-details">
									<div class="user-avatar status-online"><img src="<?php echo $logo;?>" alt=""></div>
									<div class="user-name">
										<p><?php echo $profile_name;?></p>
                                        <span><?php echo $profile_type_name;?></span>
                                        <i class="icon-material-outline-account-balance-wallet text-success"></i> <?php echo CurrencySymbol();?><b><?php  D(priceFormat($wallet_balance));?></b>
									</div>
								</div>
								
								<!-- User Status Switcher -->
								<?php /*?><div class="status-switch" id="snackbar-user-status">
									<label class="user-online current-status">Online</label>
									<label class="user-invisible">Invisible</label>
									<!-- Status Indicator -->
									<span class="status-indicator" aria-hidden="true"></span>
								</div><?php */?>
						</div>
						
						<ul class="user-menu-small-nav">
							<li><a href="<?php echo URL::get_link('dashboardURL'); ?>"><i class="icon-material-outline-dashboard"></i> <?php echo __('dashboard','Dashboard'); ?></a></li>
							<li><a href="<?php echo URL::get_link('settingsURL'); ?>"><i class="icon-material-outline-settings"></i> <?php echo __('settings','Settings'); ?></a></li>
							<li><a href="<?php echo URL::get_link('logoutURL'); ?>"><i class="icon-material-outline-power-settings-new"></i> <?php echo __('logout','Logout'); ?></a></li>
						</ul>

						</div>
					</div>
				</div>
				<!-- User Menu / End -->
                
				<?php } ?>
                <div class="header-widget">
                	<?php if($this->config->item('language')=='ar'){?>
					<a href="<?php D(VZ);?>" onclick="upldateLanguage(this)" class="setlang log-in-button" data-language="en" title="EN"><img src="<?php echo IMAGE;?>flags/en.svg" alt="" height="18" width="24" style="border-radius:0.2rem;"></a>
					<?php }?>
					<?php if($this->config->item('language')=='en'){?>
					<a href="<?php D(VZ);?>" onclick="upldateLanguage(this)" class="setlang log-in-button" data-language="ar" title="AR"><img src="<?php echo IMAGE;?>flags/ae.svg" alt="" height="18" width="24" style="border-radius:0.2rem;"></a>
					<?php } ?>
                </div>
				<!-- Mobile Navigation Button -->
				<span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

			</div>
			<!-- Right Side Content / End -->

		</div>
	</div>
	<!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->
