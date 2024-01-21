
<?php 
if($cms_temp){
	foreach($cms_temp as $k=>$block){
		if($block->cms_class){
			echo '<div class="'.$block->cms_class.'">';
		}
		$child_block=array();
		if($block->child_class){
			$child_block=explode(',',$block->child_class);
		}
		if($child_block){
			foreach($child_block as $c=>$child){
				echo '<div class="'.$child.'">';
			}
		}
		if($block->part){
			foreach($block->part as $p=>$part){
				echo '<div class="'.$part->part_class.'">';
				echo html_entity_decode($part->part_content);
				echo '</div>';
			}

		}
		if($child_block){
			foreach($child_block as $c=>$child){
				echo '</div>';	
			}
		}
		if($block->cms_class){
			echo '</div>';		
		}
	}
}
?>
<?php /*?>
<section class="section how-home">
  <div class="container">
    <div class="section-headline centered mb-4">
      <h2>How It Works</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam, quis nostrud exercitation ullamco.</p>
    </div>
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="how-box">
          <div class="how-steps">
            <h2>01</h2>
          </div>
          <div class="how-box-icon"> <img src="<?php echo IMAGE;?>icon_job.png" alt="cat_2" /> </div>
          <h3>Post A Job</h3>
          <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet consectetur adipisci velit, sed quia non numquam eius.</p>
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="how-box">
          <div class="how-steps">
            <h2>02</h2>
          </div>
          <div class="how-box-icon"> <img src="<?php echo IMAGE;?>icon_bid.png" alt="cat_2" /> </div>
          <h3>Bid Project</h3>
          <p>Duis aute irure dolor in reprehenderit voluptate velit esse cillum dolore eu fugiat nulla pariatur excepteur sint occaecat.</p>
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="how-box">
          <div class="how-steps">
            <h2>03</h2>
          </div>
          <div class="how-box-icon"> <img src="<?php echo IMAGE;?>icon_pay.png" alt="cat_2" /> </div>
          <h3>Get Payment</h3>
          <p>Pay on an hourly basis or on a fixed price basis for the entire project through a secured payment gateway system.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<?php */?>

<section class="how_it_work">
<div class="container">
<?php // echo $breadcrumb;?>
<ul class="nav nav-tabs justify-content-center mb-0" id="myTab" role="tablist">  
  <?php if($how_it_works_freelancer){?>
  <li class="nav-item">
    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php D($cms_freelancer->title); ?></a>
  </li> 
  <?php }?>
  <?php if($how_it_works_employer){?>
  <li class="nav-item">
    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><?php D($cms_employer->title); ?></a>
  </li> 
  <?php }?>
</ul>
</div>  
</section>
<div class="tab-content" id="myTabContent">
<?php if($how_it_works_freelancer){?>
<!-- FREELANCER -->
<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
<?php
	foreach($how_it_works_freelancer as $k=>$block){
		if($block->cms_class){
			echo '<div class="'.$block->cms_class.'">';
		}
		$child_block=array();
		if($block->child_class){
			$child_block=explode(',',$block->child_class);
		}
		if($child_block){
			foreach($child_block as $c=>$child){
				echo '<div class="'.$child.'">';
			}
		}
		if($block->part){
			foreach($block->part as $p=>$part){
				echo '<div class="'.$part->part_class.'">';
				echo html_entity_decode($part->part_content);
				echo '</div>';
			}

		}
		if($child_block){
			foreach($child_block as $c=>$child){
				echo '</div>';	
			}
		}
		if($block->cms_class){
			echo '</div>';		
		}
	}
?>
</div>
<?php }?>
<?php if($how_it_works_employer){?>
<!-- EMPLOYER -->
<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
<?php
	foreach($how_it_works_employer as $k=>$block){
		if($block->cms_class){
			echo '<div class="'.$block->cms_class.'">';
		}
		$child_block=array();
		if($block->child_class){
			$child_block=explode(',',$block->child_class);
		}
		if($child_block){
			foreach($child_block as $c=>$child){
				echo '<div class="'.$child.'">';
			}
		}
		if($block->part){
			foreach($block->part as $p=>$part){
				echo '<div class="'.$part->part_class.'">';
				echo html_entity_decode($part->part_content);
				echo '</div>';
			}

		}
		if($child_block){
			foreach($child_block as $c=>$child){
				echo '</div>';	
			}
		}
		if($block->cms_class){
			echo '</div>';		
		}
	}
?>
</div>
<?php }?>

</div>

<style>
ul.iList {
	font-style:italic;
	padding-left:20px;
}
ul.iList li {
	list-style:circle
}
</style>