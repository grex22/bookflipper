<?php use Roots\Sage\Titles; ?>
<div id="pagetitle">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <?php
          //get Page Basics custom fields
          $title = get_field('verbose_page_title') ? get_field('verbose_page_title') : Titles\title();
          $subtitle = get_field('page_sub-title');
        ?>
        <h1><?= $title; ?></h1>
        <?php if($subtitle): ?>
          <div class="subtitle"><?= $subtitle ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
