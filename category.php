<?php
      $parent_cat_arg = array(
        'post_type' => 'product',
        'hide_empty' => true,
        'pad_counts' => 0,
        'parent' => 0
      );
      $parent_cat = get_terms('product_cat',$parent_cat_arg);//category name
      echo '<ul>';
      foreach ($parent_cat as $catVal) {
        $paren_term_link = get_term_link( $catVal );
        echo '<li><a href='. esc_url($paren_term_link) .'>'.$catVal->name.'</a></li>'; //Parent Category
        $child_arg = array(
          'post_type' => 'product',
          'hide_empty' => false,
          'parent' => $catVal->term_id
        );
        $child_cat = get_terms( 'product_cat', $child_arg );
        $exclude_posts = [];
          echo '<ul>';
            foreach( $child_cat as $child_term ) {
              $child_term_link = get_term_link( $child_term );
              echo '<li><a href='. esc_url( $child_term_link ) .'>'. $child_term->name .'</a></li>'; //Child Category
              $post_args = array(
                'post_type' => 'product',
                'orderby' => 'title',
                'order' => 'ASC',
                'hierarchical' => false,
                'posts_per_page' => -1,
                'product_cat' => $child_term->name
              );
              $posts = get_posts($post_args);
              foreach ($posts as $post) {
                $child_post_link = get_post_permalink( $post->ID );
                echo '<ul>';
                echo '<li><a href='.esc_url($child_post_link).'>'.$post->post_title."</a></li>";
                echo '</ul>';
                $exclude_posts[] = $post->ID;
              }
            }
          echo '</ul>';
          $parent_post_args = array(
            'post_type' => 'product',
            'orderby' => 'title',
            'order' => 'ASC',
            'hierarchical' => false,
            'posts_per_page' => -1,
            'product_cat' => $catVal->name,
            'post__not_in' => $exclude_posts
          );
          $parent_posts = get_posts($parent_post_args);
          foreach ($parent_posts as $parent_post) {
            $parent_post_link = get_post_permalink( $parent_post->ID );
            echo '<ul>';
            echo '<li><a href='.esc_url($parent_post_link).'>'.$parent_post->post_title."</a></li>";
            echo '</ul>';
          }
      }
      echo '</ul>';
    ?>
