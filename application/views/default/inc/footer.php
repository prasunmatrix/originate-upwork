<?php
$all_category=getAllCategory(array('limit'=>6,'is_featured'=>1));
?>
<!-- Footer -->
<div id="footer">  
  <!-- Footer Middle Section -->
  <div class="footer-middle-section">
    <div class="container">
      <div class="row"> 
        <div class="col-lg-3 col-sm-6 col-12">
          <div class="footer-links">
            <h4><?php echo __('category','Category');?> <a href="javascript:void(0)" class="icon-line-awesome-angle-down"></a></h4>
            <ul class="foot-nav">
              <?php if($all_category){
                foreach($all_category as $c=>$category){
                ?>
                <li><a href="<?php echo get_link('search_job')?>?category=<?php echo $category->category_id;?>"><span><?php echo $category->category_name;?></span></a></li>
                <?php
                }
              }
              ?>
             </ul>
          </div>
        </div>
        <!-- Links -->
        <div class="col-lg-3 col-sm-6 col-12">
          <div class="footer-links">
            <h4><?php echo __('browse','Browse');?> <a href="javascript:void(0)" class="icon-line-awesome-angle-down"></a></h4>
            <ul class="foot-nav">
              <li><a href="<?php D(get_link('search_job'))?>"><span><?php echo __('find_projects','Find Projects');?></span></a></li>
              <li><a href="<?php D(get_link('search_freelancer'))?>"><span><?php echo __('find_professionals','Find Professionals');?></span></a></li>
              <li><a href="<?php D(get_link('search_freelancer'))?>?country=GBR"><span><?php echo __('freelancer_in_uk','Freelancers in UK');?></span></a></li>
              <li><a href="<?php D(get_link('search_freelancer'))?>?country=USA"><span><?php echo __('freelancer_in_usa','Freelancers in USA');?></span></a></li>
              <li><a href="<?php D(get_link('search_freelancer'))?>?country=CAN"><span><?php echo __('freelancer_in_canada','Freelancers in Canada');?></span></a></li>
              <li><a href="<?php D(get_link('search_freelancer'))?>?country=AUS"><span><?php echo __('freelancer_in_australia','Freelancers in Australia');?></span></a></li>
            </ul>
          </div>
        </div>
        <!-- Links -->
        <div class="col-lg-3 col-sm-6 col-12">
          <div class="footer-links">
            <h4><?php echo __('company','Company');?> <a href="javascript:void(0)" class="icon-line-awesome-angle-down"></a></h4>
            <ul class="foot-nav">
              <li><a href="<?php D(get_link('CMSaboutus'))?>"><span><?php echo __('about_us','About Us');?></span></a></li>                                                        
              <li><a href="<?php D(get_link('conatctURL'))?>"><span><?php echo __('contact_us','Contact Us');?></span></a></li>
              <li><a href="<?php D(get_link('enterpriseURL'))?>"><span><?php echo __('enterprise','Enterprise');?></span></a></li>
              <li><a href="<?php D(get_link('CMSprivacypolicy'))?>"><span><?php echo __('privacy_policy','Privacy Policy');?></span></a></li>
              <li><a href="<?php D(get_link('CMSrefundpolicy'))?>"><span><?php echo __('refund_policy','Refund Policy');?></span></a></li>
              <li><a href="<?php D(get_link('CMStermsandconditions'))?>"><span><?php echo __('terms_conditions','Terms &amp; Conditions');?></span></a></li>              
            </ul>
          </div>
        </div>        
        <!-- Links -->
        <div class="col-lg-3 col-sm-6 col-12">
          <div class="footer-links">
            <h4><?php echo __('resources','Resources');?> <a href="javascript:void(0)" class="icon-line-awesome-angle-down"></a></h4>
            <ul class="foot-nav">
              <li><a href="<?php D(get_link('CMShelp'))?>"><span><?php echo __('faqs','FAQs');?></span></a></li>              
              <li><a href="<?php D(get_link('CMShowitworks'))?>"><span><?php echo __('how_it_works','How it works');?></span></a></li>
              <li><a href="<?php D(get_link('membershipURL'))?>"><span><?php echo __('membership','Membership');?></span></a></li>
            </ul>
          </div>
        </div>                
      </div>
    </div>
  </div>
  <!-- Footer Middle Section / End --> 
  
  <!-- Footer Copyrights -->
  <div class="footer-bottom-section">
    <div class="container">
    <div class="row footer-rows-container">       
      <!-- Left Side -->
      <div class="col-auto">
      	  <ul class="social-links footer-social-links">
            <<?php 
          $facebook_url=get_setting('facebook_url');
          if($facebook_url){?>
            <li><a href="<?php echo  $facebook_url;?>" title="Facebook" data-tippy-placement="bottom" data-tippy-theme="light" target="_blank"><i class="icon-brand-facebook-f"></i></a></li>
          <?php }?>
          <?php 
          $twitter_url=get_setting('twitter_url');
          if($twitter_url){?>
            <li><a href="<?php echo  $twitter_url;?>" title="Twitter" data-tippy-placement="bottom" data-tippy-theme="light" target="_blank"><i class="icon-brand-twitter"></i></a></li>                
          <?php }?>
          <?php 
          $linkedin_url=get_setting('linkedin_url');
          if($linkedin_url){?>
            <li><a href="<?php echo  $linkedin_url;?>" title="LinkedIn" data-tippy-placement="bottom" data-tippy-theme="light" target="_blank"><i class="icon-brand-linkedin-in"></i></a></li>
          <?php }?>
          <?php 
          $instagram_url=get_setting('instagram_url');
          if($instagram_url){?>
            <li><a href="<?php echo  $instagram_url;?>" title="Instagram" data-tippy-placement="bottom" data-tippy-theme="light" target="_blank"><i class="icon-brand-instagram"></i></a></li>
          <?php }?>
          <?php 
          $youtube_url=get_setting('youtube_url');
          if($youtube_url){?>
            <li><a href="<?php echo  $youtube_url;?>" title="Youtube" data-tippy-placement="bottom" data-tippy-theme="light" target="_blank"><i class="icon-brand-youtube"></i></a></li>
          <?php }?>
          </ul>
	  </div>              
      <div class="col text-center">
        	<p>&copy; <?php echo __('copyright','Copyright');?> <?php echo date('Y');?> OriginateSoft.com. <?php echo __('all_rights_reserved','All Rights Reserved');?></p>
        </div>
      
      <!-- Right Side -->
      <div class="col-auto">                         
        <!-- Language Switcher -->
        <select class="selectpicker language-switcher" data-selected-text-format="count" data-size="5">
              <option selected>English</option>
              <option>Français</option>
              <option>Español</option>
              <option>Deutsch</option>
            </select>
      </div>
    </div>		
		
        
    </div>
  </div>
  <!-- Footer Copyrights / End --> 
  
</div>
<!-- Footer / End -->

</div>
<!-- Wrapper / End -->
<?php 
$load_js=$this->layout->load_js();
$load_js_default=array('jquery-3.3.1.min.js','popper.min.js','bootstrap.min.js','jquery-migrate-3.0.0.min.js','mmenu.min.js','tippy.all.min.js','simplebar.min.js','bootstrap-slider.min.js','bootstrap-select.min.js','snackbar.js','clipboard.min.js','counterup.min.js','magnific-popup.min.js','feedback-plugins.js','feedback.js','slick.min.js','custom.js','promise.min.js','loadMore.js', 'app-service.js');
$this->minify->js($load_js_default);
if(!empty($load_js)){
	foreach($load_js as $files){
		$this->minify->add_js($files);
	}
}
echo $this->minify->deploy_js(FALSE, 'footer.min.js');
 ?>

<!-- Main Script Loading --> 
<script>
var is_login="<?php echo ($this->session->userdata('loggedUser') ? 1:0)?>";
$(document).ready(function(){
	
	if(typeof main == 'function'){
		main();
	}
  if(typeof mainpart == 'function'){
    mainpart();
	}
	if(is_login==1){
	if(typeof AppService !== 'undefined'){
		AppService.setUrl('<?php echo base_url('message/update_service'); ?>');
		AppService.init();
		
		AppService.on('new_message', function(data){
			if(data > 0){
				$('.new-message-counter').html(data);
				$('.new-message-counter').show();
			}else{
				$('.new-message-counter').hide();
			}
		});
		
		AppService.on('new_notification', function(data){
			if(data > 0){
				$('.new-notification-counter').html(data);
				$('.new-notification-counter').show();
			}else{
				$('.new-notification-counter').hide();
			}
		});
		
	};
}
	
	
	
	(function(){
		/* Message loading */
		var message_open_state = false;
		/* var simpleBar = new SimpleBar(document.getElementById('header-message-container'));
		var scrollElement = simpleBar.getScrollElement(); */
		
		$('.header-notifications-trigger.message-trigger').click(function(){
			// load message 
			
			var $msg_list = $('#header-message-list');
			message_open_state = !message_open_state;
			$.getJSON('<?php echo base_url('message/chat_list_htm');?>', function(res){
				$msg_list.html(res.html);
				updateheadscroll('message');
			});
		});
	})();
	
	;(function(){
		/* Notification loading */
		var notification_open_state = false;	
		$('.header-notifications-trigger.notification-trigger').click(function(){
			// load message 
			var $noti_list = $('#header-notification-list');
			notification_open_state = !notification_open_state;
			$.getJSON('<?php echo base_url('notification/notification_list_htm');?>', function(res){
				$noti_list.html(res.html);
				updateheadscroll('notification');
			});
			
		});
	})();
	
	
	
});
function updateheadscroll(type){
	if(type=='message'){
		var container = $('#header-message-list');	
	}
	else{
		var container = $('#header-notification-list');
	}
	var scrollbar=container.closest('.header-notifications-scroll');
	var scrollContainerList = container;
	var itemsCount = scrollContainerList.children("li").length;
  if(itemsCount>0){
    if(type=='message'){
      $('.viewallbtnmessage').show();
    }else{
        $('.viewallbtnnotification').show();
    }
    
  }
	var notificationItems;
	if (scrollContainerList.children("li").outerHeight() > 120) {
		var notificationItems = 2;
	} else {
		var notificationItems =4;
	}
	if (itemsCount > notificationItems) {
		var listHeight = 0;
		scrollContainerList.find('li:lt('+notificationItems+')').each(function() {
		   listHeight += $(this).height();
		});
		scrollbar.css({ height: listHeight });
		scrollbar.find('.simplebar-track').show();
	} else {
		scrollbar.css({ height: 'auto' });
		scrollbar.find('.simplebar-track').hide();
	}		
}
function upldateLanguage(ev){
	var language=$(ev).data('language');
	var previous_lang='<?php D($this->config->item('language'))?>';
	if(previous_lang==language){
		return false;
	}
	$.post('<?php D(get_link('SetLanguage'))?>',{currentlink:"<?php D(uri_string());?>",newlang:language,preflang:previous_lang},function(response){
		window.location.href=response['refeffer']+"<?php if($_SERVER['QUERY_STRING']){D('?'.$_SERVER['QUERY_STRING']);}?>";
	},'JSON');
}
$(window).load(function(){
	if(typeof mainload == 'function'){
		mainload();
	}
	
});
</script>
</body>
</html>