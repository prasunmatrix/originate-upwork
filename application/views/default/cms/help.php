<div class="single-page-header bg-site">
	<div class="container">		
		<h1 class="text-center"><?php echo __('cms_help','Help');?></h1>
	</div>
</div>
<section class="section">
  <div class="container"> 
    <!-- Accordion -->
    <div class="accordion js-accordion"> 
     
	  <?php foreach($help as $k => $v){ ?>
      <!-- Accordion Item -->
      <div class="accordion__item js-accordion-item <?php echo $k == 0 ? 'active' : ''; ?>">
        <div class="accordion-header js-accordion-header"><h4><?php echo $v->title;?></h4></div>
        
        <!-- Accordtion Body -->
        <div class="accordion-body js-accordion-body"> 
          
          <!-- Accordion Content -->
          
          
		  <?php if($v->child){ ?>
          <!-- Sub Accordion Container -->
          <div class="accordion js-accordion"> 
            <?php foreach($v->child as $key => $child){ ?>
            <!-- Sub Accordion -->
            <div class="accordion__item js-accordion-item">
              <div class="accordion-header js-accordion-header">
              <h5><?php echo $child->title;?></h5></div>
              <div class="accordion-body js-accordion-body">              	
                <div class="accordion-body__contents">                
				 <ul class="list list-2">
                  <?php if($child->articles){foreach($child->articles as $a => $article){ ?>
					<li><a href="<?php echo base_url('help/'.$article->slug); ?>"><?php echo $article->title; ?></a></li>
				  <?php } } ?>
				   </ul>
                </div>
              </div>
            </div>
            
            <!-- Sub Accordion
            <div class="accordion__item js-accordion-item">
              <div class="accordion-header js-accordion-header"><h5>Sub Panel 2</h5></div>
              <div class="accordion-body js-accordion-body">
                <div class="accordion-body__contents">
                  <ul class="list list-2">
                    <li>It squid single-origin coffee nulla assumenda shoreditch et.</li>
                    <li> Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</li>
                    <li>Ad vegan excepteur butcher vice lomo.</li>
                    <li>Leggings occaecat craft beer farm-to-table.</li>
                    <li>Raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</li>
                  </ul>
                </div>
              </div>
            </div> -->
			<?php } ?>
          </div>
          <!-- Sub Accordion / End --> 
		  <?php }  ?>
        </div>
        <!-- Accordion Body / End --> 
      </div>
	  <?php } ?>
      <!-- Accordion Item / End --> 
      
    </div>
    <!-- Accordion / End --> 
  </div>
</section>
