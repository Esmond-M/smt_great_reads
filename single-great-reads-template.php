<?php
  $use_anduril_template = 'post';
  get_header();
  if (is_active_sidebar($use_anduril_template . '-top')) {
    dynamic_sidebar($use_anduril_template . '-top');
  }
  ?>
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
                      get_great_reads_post($post);
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
                      get_great_reads_post($post);
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

              get_great_reads_post($post);
          }
        ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  function get_great_reads_post($post) {
    $details = '
    <p><b>Author</b>: ' . $post->_smt_great_reads_author . '</p>
    <p><b>Language</b>: ' . $post->_smt_great_reads_language . '</p>
    <p><b>Year</b>: ' . $post->_smt_great_reads_year . '</p>
    <p><b>Votes</b>: ' . $post->_smt_great_reads_votes . '</p>';
    echo $details;
  }
  get_footer();
?>
