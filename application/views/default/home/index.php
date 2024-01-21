<!-- Intro Banner -->
<section class="home-banner">
  <?php if ($slider) { ?>
    <div class="row align-items-center h-100">
      <div class="col-12">
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
          <ol class="carousel-indicators">
            <?php foreach ($slider as $k => $banner) { ?>
              <li data-target="#carouselExampleFade" data-slide-to="<?php echo $k; ?>" class="<?php if ($k == 0) {echo 'active';} ?>"></li>
            <?php } ?>
          </ol>
          <div class="carousel-inner">
            <?php foreach ($slider as $k => $banner) { ?>
              <div class="carousel-item <?php if ($k == 0) {
				  echo 'active';
				} ?>"> <img src="<?php echo UPLOAD_HTTP_PATH . 'slider/' . $banner->slide_image; ?>" class="d-block w-100" alt="..."> </div>
            <?php } ?>
          </div>
          <?php /*?><a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a><?php */ ?>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="banner-search">
    <div class="container h-100">
      <div class="row align-items-center h-100">
        <div class="col-md-7 col-12">
          <div class="banner-headline">
            <h2><?php echo __('home_page_banner_header', 'Welcome to the new gen of hiring where bright ideas turn into reality.'); ?></h2>
            <p><?php echo __('home_page_banner_p_tag', 'Your only job platform to find the best talents, flexible job opportunities and handsome payment.'); ?></p>
            <div class="input-group mb-3" hidden>
              <input type="text" class="form-control" placeholder="Search projects or professionals" />
              <button class="btn btn-white"><i class="icon-feather-search"></i></button>
            </div>
            <a href="<?php echo URL::get_link('search_job'); ?>" class="btn btn-outline-white me-2"><?php echo __('get_started', 'Get Started'); ?></a> <a href="#" hidden class="btn btn-outline-black">Watch Tutorial</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Popular Job Categories -->
<section class="section">
  <div class="container">
    <div class="section-headline centered mb-4">
      <h2><?php echo __('home_page_job_categories_h2_tag', 'Popular Services') ?></h2>
      <p><?php echo __('home_page_job_categories_p_tag', 'Find the most talented professionals from wherever you are. Hire easily and get your projects delivered in no time. Choose between the most trending categories and get them onboard.') ?></p>
    </div>
    <div class="row row-10 -mb-4">
      <?php
      if ($popular_category) {
        foreach ($popular_category as $k => $category) {
          $icon = NO_IMAGE;
          if ($category['category_icon'] && file_exists(UPLOAD_PATH . 'category_icons/' . $category['category_icon'])) {
            $icon = UPLOAD_HTTP_PATH . 'category_icons/' . $category['category_icon'];
          }
      ?>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12"> <a href="<?php echo URL::get_link('search_job'); ?>?category=<?php echo $category['category_id']; ?>" class="photo-box small" data-background-image="images/cat_1.jpg">
              <div class="photo-box-content">
                <div class="photo-box-icon"> <img src="<?php echo $icon; ?>" alt="<?php echo $category['category_name']; ?>" /> </div>
                <h3><?php echo $category['category_name']; ?></h3>
                <p><?php echo $category['description']; ?></p>
              </div>
            </a> </div>
      <?php
        }
      }
      ?>

    </div>
    <div class="text-center" hidden><a href="#" class="btn btn-primary"><?php echo __('home_page_view_category', 'View All Category'); ?></a></div>
  </div>
</section>
<!-- Popular Job Categories / End -->

<?php
if ($cms_temp) {
  foreach ($cms_temp as $k => $block) {
    if ($block->cms_class) {
      echo '<div class="' . $block->cms_class . ' pt-0">';
    }
    $child_block = array();
    if ($block->child_class) {
      $child_block = explode(',', $block->child_class);
    }
    if ($child_block) {
      foreach ($child_block as $c => $child) {
        echo '<div class="' . $child . '">';
      }
    }
    if ($block->part) {
      foreach ($block->part as $p => $part) {
        echo '<div class="' . $part->part_class . '">';
        echo html_entity_decode($part->part_content);
        echo '</div>';
      }
    }
    if ($child_block) {
      foreach ($child_block as $c => $child) {
        echo '</div>';
      }
    }
    if ($block->cms_class) {
      echo '</div>';
    }
  }
}
?>
<?php /*?>
<section class="section pt-0 how-home">
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
<?php */ ?>

<!-- Highest Rated Freelancers -->
<section class="section pt-0 full-width-carousel-fix">
  <div class="container">
    <div class="section-headline centered mb-3">
      <h2><?php echo __('home_page_freelancers_categories_h2_tag', 'Hire the Best Talents'); ?></h2>
      <p><?php echo __('home_page_freelancers_categories_p_tag', 'Collaborate with the top tier freelancers for your brands and turn your vision into reality. Have a look at the most experienced, talented and thoroughly-bred professionals.'); ?></p>
    </div>
    <div class="default-slick-carousel freelancers-container freelancers-grid-layout" dir="ltr">
      <?php
      if ($popular_freelancer) {
        foreach ($popular_freelancer as $k => $freelancer) {
          $skills = array_map(function ($item) {
            return $item['skill_name'];
          }, $freelancer['user_skill']);
          $skills_name = implode(', ', $skills);
      ?>
          <div class="freelancer">
            <!-- Overview -->
            <div class="freelancer-overview">
              <div class="freelancer-overview-inner">
                <!-- Avatar -->
                <div class="freelancer-avatar">
                  <div class="verified-badge"></div>
                  <a href="<?php echo $freelancer['profile_link']; ?>"><img src="<?php echo $freelancer['user_logo']; ?>" alt="professional01"></a>
                </div>
                <!-- Name -->
                <div class="freelancer-name">
                  <h4><a href="<?php echo $freelancer['profile_link']; ?>"><?php echo $freelancer['member_name']; ?></a> <?php if ($freelancer['country_code_short']) { ?><img class="flag" src="<?php echo IMAGE; ?>flags/<?php echo strtolower($freelancer['country_code_short']); ?>.svg" alt="" title="<?php echo $freelancer['country_name']; ?>" data-tippy-placement="top"><?php } ?></h4>
                  <span><?php echo $freelancer['member_heading']; ?>&nbsp;</span>
                </div>
                <!-- Rating -->
                <div class="freelancer-rating">
                  <div class="star-rating" data-rating="<?php echo round($freelancer['avg_rating'], 2); ?>"></div>
                </div>
                <p><?php echo $skills_name; ?>&nbsp;</p>
                <a href="<?php echo $freelancer['profile_link']; ?>" class="btn btn-outline-site btn-block"><?php echo __('home_page_categories_view_profile', 'View Profile'); ?></a>
              </div>
            </div>
          </div>
      <?php
        }
      }
      ?>

    </div>
  </div>
</section>
<!-- Highest Rated Freelancers / End -->

<!-- Membership Plans -->
<?php /*?>
<section class="section pt-0">
  <div class="container"> 
    <!-- Section Headline -->
    <div class="section-headline centered margin-top-0 mb-3">
      <h2>Membership Plans</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam, quis nostrud exercitation ullamco.</p>
    </div>
    <!-- Billing Cycle  -->
      <div class="billing-cycle-radios mb-4">
        <div class="radio billed-monthly-radio">
          <input id="radio-5" name="radio-payment-type" type="radio" checked>
          <label for="radio-5"><span class="radio-label"></span> Billed Monthly</label>
        </div>
        <div class="radio billed-yearly-radio">
          <input id="radio-6" name="radio-payment-type" type="radio">
          <label for="radio-6"><span class="radio-label"></span> Billed Yearly <span class="small-label">Save 10%</span></label>
        </div>
      </div>
    <!-- Pricing Plans Container -->
    <div class="pricing-plans-container"> 
      <!-- Plan -->
      <div class="pricing-plan">
        <h3>Basic Plan</h3>
        <div class="pricing-plan-label billed-monthly-label"><strong>Free</strong></div>
        <div class="pricing-plan-label billed-yearly-label"><strong>$499</strong>/ yr</div>
        <img src="<?php echo IMAGE;?>badge_green.png" alt="badge" class="mb-2">
        <div class="pricing-plan-features"> <strong>Features</strong>
          <ul class="list list-2">
            <li>Verified freelancer work history and reviews on Upwork</li>
            <li>Safe, easy payments</li>
            <li>Built-in collaboration features</li>
            <li>Upwork Payment Protection Plan</li>
            <li>Customer Support</li>
            <li>Transaction details reporting</li>
            <li>3 freelancer invites per job post</li>
            <li><del>Team reporting</del></li>
            <li><del>Job post and talent sourcing assistance</del></li>
            <li><del>Featured Jobs upgrade</del></li>
          </ul>
        </div>
        <a href="#" class="btn btn-primary btn-block">Select Plan</a> </div>
      
      <!-- Plan -->
      <div class="pricing-plan recommended">
        <h3>Standard Plan</h3>
        <div class="pricing-plan-label billed-monthly-label"><strong>$49.99/</strong><sup>mo*</sup></div>
        <div class="pricing-plan-label billed-yearly-label"><strong>$499.99/</strong><sup>yr</sup></div>
        <img src="<?php echo IMAGE;?>badge_white.png" alt="badge" class="mb-2">
        <div class="pricing-plan-features"> <strong>Features</strong>
          <ul class="list list-2">
            <li>Verified freelancer work history and reviews on Upwork</li>
            <li>Safe, easy payments</li>
            <li>Built-in collaboration features</li>
            <li>Upwork Payment Protection Plan</li>
            <li>Premium Customer Support</li>
            <li>Team reporting</li>
            <li>Job post and talent sourcing assistance</li>
            <li>Dedicated account management</li>
            <li>15 freelancer invites per job post</li>
            <li>Featured Jobs upgrade</li>
          </ul>
        </div>
        <a href="#" class="btn btn-white btn-block">Select Plan</a> </div>
      
      <!-- Plan -->
      <div class="pricing-plan">
        <h3>Premium Plan</h3>
        <div class="pricing-plan-label billed-monthly-label"><strong>$99.99/</strong><sup>mo</sup></div>
        <div class="pricing-plan-label billed-yearly-label"><strong>$999.99/</strong><sup>yr</sup></div>
        <img src="<?php echo IMAGE;?>badge_green.png" alt="badge" class="mb-2">
        <div class="pricing-plan-features"> <strong>Features</strong>
          <ul class="list list-2">
            <li>Verified freelancer work history and reviews on Upwork</li>
            <li>Safe, easy payments</li>
            <li>Built-in collaboration features</li>
            <li>Upwork Payment Protection Plan</li>
            <li>Premium Customer Support</li>
            <li>Team reporting</li>
            <li>Job post and talent sourcing assistance</li>
            <li>Dedicated account management</li>
            <li>15 freelancer invites per job post</li>
            <li>Featured Jobs upgrade</li>
          </ul>
        </div>
        <a href="#" class="btn btn-primary btn-block">Select Plan</a> </div>
    </div>
  </div>
</section>
<?php */ ?>
<!-- Membership Plans / End-->
<?php if ($testimonial) { ?>
  <!-- Feedback -->
  <section class="section bg-white">
    <div class="container">
      <!-- Section Headline -->
      <div class="section-headline centered">
        <h2><?php echo __('home_page_feedback_header', 'Client Testimonials'); ?></h2>
        <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam, quis nostrud exercitation ullamco.</p>-->
      </div>
      <div class="testimonial-style-5 testimonial-slider-2 poss--relative" dir="ltr">
        <!-- Start Testimonial Nav -->
        <div class="testimonal-nav">
          <?php foreach ($testimonial as $k => $row) {
            $logo = IMAGE . 'default/thumb/default-member-logo.svg';
            if ($row->logo) {
              $logo = UPLOAD_HTTP_PATH . 'testimonial-icon/' . $row->logo;
            }
          ?>
            <div class="testimonal-img"> <img src="<?php echo   $logo; ?>" alt="<?php echo $row->name; ?>"> </div>
          <?php } ?>
        </div>
        <!-- End Testimonial Nav -->

        <!-- Start Testimonial For -->
        <div class="testimonial-for">
          <?php
          foreach ($testimonial as $k => $row) {
          ?>
            <div class="testimonial-desc">
              <div class="triangle"></div>
              <div class="client">
                <h3><?php echo $row->name; ?></h3>
                <p><i><?php echo $row->company_name; ?></i></p>
                <!-- <div class="star-rating" data-rating="3.5"></div> -->
              </div>
              <p><?php echo nl2br($row->description); ?></p>
            </div>
          <?php
          }
          ?>
        </div>
        <!-- End Testimonial For -->
      </div>
    </div>
  </section>
  <!-- Feedback End -->
<?php } ?>
<!-- Choose Account -->
<section class="section choose-acc">
  <div class="container">
    <div class="row">
      <aside class="col-sm-6 col-12">
        <div class="card text-center">
          <div class="card-body">
            <img src="<?php echo IMAGE; ?>icon_hire.png" alt="icon hire" class="mb-3">
            <h3><?php echo __('home_page_choose_acc_hire_h3_tag', 'Finding professionals to hire?'); ?></h3>
            <h2><?php echo __('home_page_choose_acc_hire_h2_tag', 'Professionals'); ?></h2>
            <p><?php echo __('home_page_choose_acc_hire_p_tag', 'Your perfect talent waits! Hire the most qualified applicants from thousands of freelancers and get the job done. Find out why Upwork Clone Script is trusted by hundreds of employers.'); ?></p>
            <a href="<?php D(get_link('postprojectURL')) ?>" class="btn btn-outline-site" style="min-width:100px;"><?php echo __('home_page_choose_acc_hire_a_tag', 'Post A Job'); ?></a>
          </div>
        </div>
      </aside>
      <aside class="col-sm-6 col-12">
        <div class="card text-center">
          <div class="card-body">
            <img src="<?php echo IMAGE; ?>icon_job.png" alt="icon job" class="mb-3">
            <h3><?php echo __('home_page_choose_acc_job_h3_tag', 'Are you looking for projects?'); ?></h3>
            <h2><?php echo __('home_page_choose_acc_job_h2_tag', 'Projects'); ?></h2>
            <p><?php echo __('home_page_choose_acc_job_p_tag', 'Browse through millions of job posts, view local and international projects, discover new companies, gain trust and build a promising freelancing career. Know about the job nature, use your skill and get hired.'); ?></p>
            <a href="<?php echo URL::get_link('search_job'); ?>" class="btn btn-outline-site" style="min-width:100px;"><?php echo __('home_page_choose_acc_job_a_tag', 'Get Started'); ?></a>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>
<!-- Choose Account End -->
<?php if ($partner) { ?>
  <!-- Partner -->
  <section class="section pt-0 partner">
    <div class="container">
      <!-- Section Headline -->
      <div class="section-headline centered">
        <h2><?php echo __('home_page_partner_section_h2_tag', 'Trusted Partners'); ?></h2>
        <p><?php echo __('home_page_partner_section_p_tag', 'Trusted by 10M+ businesses') ?></p>
      </div>
      <div class="logo-carousel">
        <?php
        foreach ($partner as $k => $row) {
          $logo = IMAGE . 'default/thumb/default-member-logo.svg';
          if ($row->box_image) {
            $logo = UPLOAD_HTTP_PATH . 'box/' . $row->box_image;
          }
        ?>
          <div class="card text-center">
            <div class="card-body">
              <img src="<?php echo $logo; ?>" alt="<?php echo $row->name; ?>">
            </div>
          </div>
        <?php
        }
        ?>

      </div>
    </div>
  </section>
  <!-- Partner End -->
<?php } ?>
<!-- Top Skills -->
<section class="section pt-0">
  <div class="container">
    <!-- Section Headline -->
    <div class="section-headline centered mb-4">
      <h2><?php echo __('home_page_top_skill_h2_tag', 'Top Skills') ?></h2>
    </div>
    <ul class="list list-2 top-list">
      <?php if ($popular_skills) {
        foreach ($popular_skills as $k => $sk) {

      ?>
          <li><a href="<?php echo get_link('search_freelancer') . '?byskillsname[]=' . $sk->skill_key; ?>"><?php echo $sk->skill_name; ?></a></li>
      <?php
        }
      } ?>

    </ul>
    <div class="text-center" hidden><a href="#" class="btn btn-outline-site"><?php echo __('home_page_view_all_skill','View All Skills');?></a></div>
  </div>
</section>
<!-- Top Skills End -->