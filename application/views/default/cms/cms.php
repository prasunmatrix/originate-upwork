<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//dd($filter);
/* echo '<pre>';
print_r($cms_temp);
echo '</pre>'; */
?>
<div class="single-page-header bg-site">
	<div class="container">		
		<h1 class="text-center"><?php D($cms->title); ?></h1>
	</div>
</div>
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
<section class="section">
	<div class="container">
    	<?php D(html_entity_decode($cms->content)); ?>
    </div>
</section>
<?php */?>