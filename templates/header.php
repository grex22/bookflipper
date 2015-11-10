<header class="banner">
  <div class="container">
    <div class="row">
      <div class="col-xs-5">
        <a id="logo" class="brand" href="<?= esc_url(home_url('/')); ?>">
          <img src="<?php echo get_stylesheet_directory_uri();?>/dist/images/bookflipper-logo-rev.png">
        </a>
      </div>
      <div class="col-xs-7" id="mainnav">
        <nav class="nav-primary">
          <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-right','walker' => new wp_bootstrap_navwalker()]);
          endif;
          ?>
        </nav>
      </div>
    </div>
  </div>
</header>
