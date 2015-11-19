<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
    ?>
    <?php
      if(is_front_page()):
      get_template_part('templates/header');
    ?>
      <section class="home_section masthead">
        <div class="container">
          <div class="row">
            <div class="col-xs-10 col-xs-offset-1 text-center">
              <h1>YOUR HOME FOR SOURCING BOOKS ONLINE...FROM HOME. </h1>
            </div>
          </div>
          <div class="row">
            <?php
              $box_1_title = get_field('box_1_title');
              $box_2_title = get_field('box_2_title');
              $box_3_title = get_field('box_3_title');
              $box_4_title = get_field('box_4_title');
              $box_1_content = get_field('box_1_content');
              $box_2_content = get_field('box_2_content');
              $box_3_content = get_field('box_3_content');
              $box_4_content = get_field('box_4_content');
            ?>
            <div class="col-sm-8 col-sm-offset-2 text-center">
              <div class="row masthead_steps">
                <div class="col-sm-3 col-xs-6 text-center">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-filter.png">
                  <?= $box_1_title; ?>
                </div>
                <div class="col-sm-3 col-xs-6 text-center">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-search.png">
                  &nbsp;&nbsp;<?= $box_2_title; ?>
                </div>
                <div class="col-sm-3 col-xs-6 text-center">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-calculate.png">
                  <?= $box_3_title; ?>
                </div>
                <div class="col-sm-3 col-xs-6 text-center">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-cart.png">
                  <?= $box_4_title; ?>
                </div>
              </div>
              <div class="row">
                <form class="home_login form-inline">
                  <input type="text" name="username" placeholder="USERNAME">
                  <input type="password" name="password" placeholder="PASSWORD">
                  <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <a href="#">Forgot Password?</a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="home_section">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3 text-center">
              <a href="#" class="btn btn-primary btn-lg">Sign Up <em>Now.</em></a>
              <div class="spacer clearfix"></div>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius libero dolor, at ornare diam commodo vitae. Nam eget urna sapien. Sed dignissim placerat purus nec sodales. Ut eu orci vitae purus gravida varius.</p>
            </div>
          </div>
        </div>
      </section>
      <section class="home_section alt">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3 text-center">
              <h2 class="no_margin_top">Refer a Friend.</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius libero dolor, at ornare diam commodo vitae. Nam eget urna sapien. Sed dignissim placerat purus nec sodales. Ut eu orci vitae purus gravida varius.</p>
              <a href="#" class="btn btn-primary btn-lg">Sign Up <em>Now.</em></a>
            </div>
          </div>
        </div>
      </section>
      <section class="home_section">
        <div class="container">
          <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
              <h2 class="green text-center">Use the F.A.C.S. method to make data-driven decisions:</h2>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="row big_margin_bottom">
                <div class="col-sm-3 col-xs-3 text-center big_steps">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-filter-b.png">
                  01
                </div>
                <div class="col-sm-9 col-xs-9">
                  <h2 class="green no_margin_top"><?= $box_1_title ?></h2>
                  <?= $box_1_content ?>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row big_margin_bottom">
                <div class="col-sm-3 col-xs-3 text-center big_steps">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-search-b.png">
                  02
                </div>
                <div class="col-sm-9 col-xs-9">
                  <h2 class="green no_margin_top"><?= $box_2_title ?></h2>
                  <?= $box_2_content; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="row big_margin_bottom">
                <div class="col-sm-3 col-xs-3 text-center big_steps">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-calculate-b.png">
                  03
                </div>
                <div class="col-sm-9 col-xs-9">
                  <h2 class="green no_margin_top"><?=$box_3_title;?></h2>
                  <?=$box_3_content;?>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row big_margin_bottom">
                <div class="col-sm-3 col-xs-3 text-center big_steps">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-cart-b.png">
                  04
                </div>
                <div class="col-sm-9 col-xs-9">
                  <h2 class="green no_margin_top"><?= $box_4_title ?></h2>
                  <?= $box_4_content ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="home_section alt video_section">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 text-center">
              <h2 class="green">Check out eFlip in action:</h2>
              <img src="http://placehold.it/650x350">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3 text-center">
              <p>Lorem ipsum dolor sit ante. Duis nec elit purus. Nulla vitae lorem tristique, facilisis magna sit amet, iaculis urna. In hac habitasse platea dictumst. Morbi in placerat elit. Nam eu felis eget ipsum porta pellentesque. </p>
              <a href="#" class="btn btn-primary btn-lg">Sign Up <em>Now.</em></a>
            </div>
          </div>
        </div>
      </section>
    <?php
      else: // else is NOT home page
        get_template_part('templates/header');?>

        <?php
        include Wrapper\template_path();

      endif; //endif if isn't home page

      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  </body>
</html>
