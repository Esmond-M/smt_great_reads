<?php
  $use_anduril_template = 'default-template';
  get_header();
  if (is_active_sidebar($use_anduril_template . '-top')) {
    dynamic_sidebar($use_anduril_template . '-top');
  }
  ?>
  <style>
    .smt-great-reads {
      margin: 15px auto;
    }

    .smt-great-reads .item {

    }

    .smt-great-reads .thumbnail {
      width: 100%;
    }

    .smt-great-reads .thumbnail img {
      width: 100%;
    }

    .smt-great-reads .headline {

    }

    .smt-great-reads .vote {
      text-align: center;
      color: #af2000;
      cursor: pointer;
    }

  </style>
  <div id="masterContainer">
    <div class="container-fluid">
      <div class="row">
        <?php
          if (is_active_sidebar($use_anduril_template . '-sidebar')) {
            ?>
              <div class="doubleColumnMargin">
                <div class="col-sm-8">
                  <?php
                    if (!is_front_page()) {
                      ?>
                        <div class="container-fluid">
                          <div class="pageHeadline">
                            <?php _e(get_the_title()); ?>
                          </div>
                      <?php
                    }
                    _e(apply_filters('the_content', $post->post_content));
                    ?>
                      </div>
                    <?php
                      get_great_reads();
                  ?>
                </div>
                <div class="col-sm-4 sidebarContainer">
                  <?php dynamic_sidebar($use_anduril_template . '-sidebar'); ?>
                </div>
              </div>
            <?php
          }
          else if (is_active_sidebar($use_anduril_template . '-main')) {
            ?>
              <div class="col-sm-12">
                <div class="singleColumnMargin">
                  <?php
                    if (!is_front_page()) {
                      ?>
                      <div class="container-fluid">
                        <div class="pageHeadline">
                          <?php _e(get_the_title()); ?>
                        </div>
                      <?php
                    }
                    _e(apply_filters('the_content', $post->post_content));
                    ?>
                      </div>
                    <?php
                      get_great_reads();
                  ?>
                </div>
              </div>
            <?php
          }
          else {
            ?>
              <div class="col-sm-12">
                <div class="singleColumnMargin">
            <?php
            if (!is_front_page()) {
              ?>
              <div class="container-fluid">
                <div class="pageHeadline">
                  <?php _e(get_the_title()); ?>
                </div>
              <?php
            }
            _e(apply_filters('the_content', $post->post_content));
          }
        ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  function get_great_reads() {
    $args = array(
      'posts_per_page'   => 99,
      'offset'           => 0,
      'orderby'         => array('meta_sort' => 'DESC','date' => 'DESC'),
      'post_type'        => 'greatreads',
      'post_status'      => array('publish'),
      'suppress_filters' => true,
      'meta_query'      => array(
        'meta_sort' => array(
          'key'     => '_smt_great_reads_votes',
          'type'    => 'NUMERIC'
        )
      )
    );
    $posts_array = get_posts($args);
    $post_array_sort_order = [];
    ?>
      <div class="smt-great-reads">
        <div class="container-fluid">
          <div class="row eqRow">
            <?php
              foreach ($posts_array as $post) {
                $item_sort_info = [];
                ?>
                  <div class="col-sm-3">

                    <div class="item">
                      <div class="thumbnail">
                        <a href="<?= get_permalink($post); ?>">
                          <img src="<?= get_the_post_thumbnail_url($post); ?>" />
                        </a>
                      </div>
                      <div class="headline">
                        <a href="<?= get_permalink($post); ?>">
                          <?= $post->post_title; ?>
                        </a>
                      </div>
                      <div class="vote" onclick="alert('Voting not yet enabled. Stand by.');">
                          <?= $post->_smt_great_reads_votes; ?> <i class="fa fa-thumbs-o-up"></i> (vote!)
                      </div>
                    </div>

                  </div>
                <?php
                $item_sort_info['language'] = $post->_smt_great_reads_language;
                $item_sort_info['year'] = $post->_smt_great_reads_year;
                $item_sort_info['votes'] = $post->_smt_great_reads_votes;
                $post_array_sort_order[$post->ID] = $item_sort_info;
              }
              $order_json = json_encode($post_array_sort_order);
            ?>
          </div>
        </div>
      </div>
      <script>
        const smtGreatReadsSortArray = <?= $order_json; ?>;
        console.log(smtGreatReadsSortArray);
      </script>
    <?php

  }
  get_footer();
?>
