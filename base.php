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
      get_template_part('templates/home_header');
    ?>
      <section class="home_section masthead">
        <div class="row">
          <div class="col-xs-8 col-xs-offset-2 text-center">
            <h2>IT TAKES TIME TO DRIVE AROUND AND SOURCE BOOKS PHYSICALLY.</h2>
            <h1>Welcome to the Book Sourcing Solution for FBA Sellers.</h1>
          </div>
        </div>
      </section>
      <section class="home_section">
        <div class="container">
          <div class="row">
            <div class="col-xs-6 col-xs-offset-3 text-center">
              <a href="#" class="btn btn-primary">Login</a>
              <a href="#" class="btn btn-primary btn-lg">Sign Up <em>Now.</em></a>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius libero dolor, at ornare diam commodo vitae. Nam eget urna sapien. Sed dignissim placerat purus nec sodales. Ut eu orci vitae purus gravida varius.</p>
            </div>
          </div>
        </div>
      </section>
      <section class="home_section alt">
        <div class="container">
          <div class="row">
            <div class="col-xs-6 col-xs-offset-3 text-center">
              <a href="#" class="btn btn-primary">Login</a>
              <a href="#" class="btn btn-primary btn-lg">Sign Up <em>Now.</em></a>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius libero dolor, at ornare diam commodo vitae. Nam eget urna sapien. Sed dignissim placerat purus nec sodales. Ut eu orci vitae purus gravida varius.</p>
            </div>
          </div>
        </div>
      </section>
    <?php 
      else: // else is NOT home page
      get_template_part('templates/header');
    ?>
    <div class="wrap container" role="document">
      <div class="content row">
        <main class="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
        <?php if (Setup\display_sidebar()) : ?>
          <aside class="sidebar">
            <?php include Wrapper\sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      </div><!-- /.content -->
    </div><!-- /.wrap -->
    <?php
      endif; //endif if isn't home page
      
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  </body>
</html>
