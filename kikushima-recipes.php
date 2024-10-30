<?php
/**
 * Kikushima Recipes
 *
 * Plugin Name: Kikushima Recipes
 * Plugin URI:
 * Description: Add recipes shortcode to display recipes on the page
 * Version:     1.0
 * Author:      kikushima
 * Author URI:  https://kikushima-japan.co.jp
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
/*
Copyright 2020 KIKUSHIMA,Inc. (email: info@kikushima-japan.co.jp)
Kikushima Jobs is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Kikushima Jobs is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Kikushima Jobs. If not, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.html.
 */
if (!defined('ABSPATH')) {
	die('Invalid request.');
}

if (!class_exists('KIKUSHIMA_Recipes')) :

	class KIKUSHIMA_Recipes
	{
		public function __construct() {}

		public function init_actions()
		{
			$this->set_language();


			add_action( 'init', array( $this, 'cptui_register_my_cpts_recipes' ) );
			add_action( 'init', array( $this, 'cptui_register_my_taxes_tags' ) );
			add_action( 'init', array( $this, 'cptui_register_my_taxes_categories') );

			add_shortcode( "recipes", array( $this, "add_recipes_shortcode" ) );
			add_action( "wp_enqueue_scripts", array( $this, "bootstrap_enqueue" ) );
		}

		public function set_language() {
			$langDir = basename( dirname(__FILE__) ) . "/languages/";
			load_plugin_textdomain( "kikushima-recipes", false,  $langDir );
		}

		public function cptui_register_my_cpts_recipes()
		{

			/**
			 * Post Type: jobs.
			 */
			$labels = array(
				"name" => "recipes",
				"singular_name" => "recipe",
				"menu_name" => __( "recipe", "kikushima-recipes" ),
				"all_items" => __( "recipes", "kikushima-recipes" ),
				"add_new" => __( "new recipe", "kikushima-recipes" ),
				"add_new_item" => __( "new recipe", "kikushima-recipes" ),
				"edit_item" => __( "edit recipe", "kikushima-recipes" ),
				"new_item" => __( "new recipe", "kikushima-recipes" ),
				"view_item" => __( "show recipe", "kikushima-recipes" ),
				"view_items" => __( "show recipe", "kikushima-recipes" ),
				"search_items" => __( "search recipe", "kikushima-recipes" ),
				"not_found" => __( "no such recipe.", "kikushima-recipes" ),
				"not_found_in_trash" => __( "no recipes in trash.", "kikushima-recipes" ),
				"archives" => __( "recipes", "kikushima-recipes" ),
			);

			$args = array(
				"label" => "recipes",
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "recipes",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => true,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => array( "slug" => "recipes", "with_front" => true ),
				"query_var" => true,
				"menu_icon" => "dashicons-carrot",
				"supports" => array( "title", "editor", "thumbnail", "excerpt" ),
				'taxonomies' => array('recipes_tags'),
			);

			register_post_type( "recipes", $args );
		}

		public function cptui_register_my_taxes_tags()
		{

			/**
			 * Taxonomy: タグ.
			 */
			$labels = array(
				"name" => __( "tag", "kikushima-recipes" ),
				"singular_name" => __( "tag", "kikushima-recipes" ),
				"menu_name" => __( "tag", "kikushima-recipes" ),
				"all_items" => __( "tags", "kikushima-recipes" ),
				"edit_item" => __( "edit tag", "kikushima-recipes" ),
				"view_item" => __( "show tag", "kikushima-recipes" ),
				"update_item" => __( "update tag", "kikushima-recipes" ),
				"add_new_item" => __( "new tag", "kikushima-recipes" ),
				"new_item_name" => __( "new tag", "kikushima-recipes" ),
			);

			$args = array(
				"label" => __( "tag", "kikushima-recipes" ),
				"labels" => $labels,
				"public" => true,
				"publicly_queryable" => true,
				"hierarchical" => false,
				"show_ui" => true,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"query_var" => true,
				"rewrite" => ['slug' => 'recipes_tags', 'with_front' => true,],
				"show_admin_column" => false,
				"show_in_rest" => true,
				"rest_base" => "recipes_tags",
				"rest_controller_class" => "WP_REST_Terms_Controller",
				"show_in_quick_edit" => false,
			);
			register_taxonomy( "recipes_tags", ["recipes"], $args );
		}

		public function cptui_register_my_taxes_categories()
		{

			/**
			 * Taxonomy: タグ.
			 */
			$labels = array(
				"name" => __( "category", "kikushima-recipes" ),
				"singular_name" => __( "category", "kikushima-recipes" ),
				"menu_name" => __( "category", "kikushima-recipes" ),
				"all_items" => __( "categories", "kikushima-recipes" ),
				"edit_item" => __( "edit category", "kikushima-recipes" ),
				"view_item" => __( "show category", "kikushima-recipes" ),
				"update_item" => __( "update category", "kikushima-recipes" ),
				"add_new_item" => __( "new category", "kikushima-recipes" ),
				"new_item_name" => __( "new category", "kikushima-recipes" ),
			);

			$args = array(
				"label" => __( "category", "kikushima-recipes" ),
				"labels" => $labels,
				"public" => true,
				"publicly_queryable" => true,
				"hierarchical" => false,
				"show_ui" => true,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"query_var" => true,
				"rewrite" => ['slug' => 'recipes_categories', 'with_front' => true,],
				"show_admin_column" => false,
				"show_in_rest" => true,
				"rest_base" => "recipes_categories",
				"rest_controller_class" => "WP_REST_Terms_Controller",
				"show_in_quick_edit" => false,
			);
			register_taxonomy( "recipes_categories", ["recipes"], $args );
		}

		public function add_recipes_shortcode($atts)
		{

			extract(shortcode_atts(array(
				'show_excerpt' => 1,
				"show_detail" => 1,
				"posts_number" => -1,
				"categories" => ""
			), $atts));



			$show_excerpt = !empty($show_excerpt) && $show_excerpt == 1 ? true : false;
			$show_detail = !empty($show_detail) && $show_detail == 1 ? true : false;
			$posts_number = !empty($posts_number) && (int)$posts_number ? (int)$posts_number : -1;

			$categories = !empty($categories) ? trim($categories) : "";
			$categories = str_replace("、", ",", $categories);
			$categories = str_replace(" ", "", $categories);
			$categories = str_replace("　", "", $categories);

			$category_array = array();

			$categories = explode(",", $categories);

			foreach ($categories as $category) {
				if(!empty(trim($category))) {
					$category_array[] = trim($category);
				}
			}

			$categories = $category_array;




			$output = '<div id="recipes" class="container">';


			$taxonomies = get_object_taxonomies("recipes", "objects");


			foreach ($taxonomies as $taxonomy_slug => $taxonomy) {


				if ($taxonomy_slug == "recipes_categories") {

					$terms = get_terms("recipes_categories");

					if(count($categories) == 0 || (count($categories) > 0 && count($terms) == 0)) {
						$args = array(
							"post_type" => "recipes"
						);
						if ($posts_number != -1) {
							$args["posts_per_page"] = $posts_number;
						}
						$jobs_query = new WP_Query($args);

						if ($jobs_query->have_posts()) {

							while ($jobs_query->have_posts()) {
								$jobs_query->the_post();
								$output .= $this->get_recipe_info($show_excerpt, $show_detail);
							}

						} else {
							$output .= '<h2>' . __( "No recipes available at the moment.", "kikushima-recipes" ) . '</h2>';
						}

						wp_reset_postdata();
					} else {


						foreach ($terms as $term) {

							if(!in_array($term->name, $categories)) {
								continue;
							}

							$output .= "<h2>" . $term->name . "</h2>";

							$args = array(
								"post_type" => "recipes",
								'tax_query' => array(
									array(
										'taxonomy' => 'recipes_categories',
										'field' => 'term_id',
										'terms' => $term->term_id
									)
								)
							);
							if ($posts_number != -1) {
								$args["posts_per_page"] = $posts_number;
							}
							$jobs_query = new WP_Query($args);

							if ($jobs_query->have_posts()) {

								while ($jobs_query->have_posts()) {
									$jobs_query->the_post();
									$output .= $this->get_recipe_info($show_excerpt, $show_detail, $term->term_id);
								}

							} else {
								$output .= '<h2>' . __( "No recipes available at the moment.", "kikushima-recipes" ) . '</h2>';
							}

							wp_reset_postdata();
						}

					}

				}

			}


			$output .= '</div>';
			return $output;

		}

		public function bootstrap_enqueue()
		{
			// JS
			if( ! wp_script_is("bootstrap", "enqueued" ) ) {
				wp_register_script(
					'bootstrap',
					plugins_url('js/bootstrap-4.5.0.min.js', __FILE__),
					array("jquery")
				);

				wp_enqueue_script("bootstrap");
			}

			if( ! wp_style_is( "bootstrap", "enqueued" ) ) {
				wp_register_style(
					'bootstrap',
					plugins_url('css/bootstrap-4.5.0.min.css', __FILE__)
				);
				wp_enqueue_style('bootstrap');
			}


			// customize css
			wp_register_style(
				"kikushima_recipes",
				plugins_url('css/style.css', __FILE__),
				array("bootstrap")
			);
			wp_enqueue_style('kikushima_recipes');
		}



		private function get_recipe_info($show_excerpt, $show_detail, $term_id = null)
		{


			$id = get_the_ID();

			$title = get_the_title();

			$excerpt = get_the_excerpt();

			$tags = $this->get_recipe_tags(get_the_ID());

			$content = get_the_content();

			$show_detail = __( "show detail", "kikushima-recipes" );
			$close_detail = __( "close detail", "kikushima-recipes" );

			$output = <<<EOF
<style>
#recipes a.collapse-controller.collapsed:before {
    content: '$show_detail';
}

#recipes a.collapse-controller:before {
    content: '$close_detail';
}

</style>
EOF;



			$output .= <<<EOF
    <div class="card">
        <div class="row no-gutters">
EOF;

			$output .= $this->get_recipe_thumnails(get_the_ID());


			$output .= <<<EOF

            <div class="col-sm-8">
                <div class="card-block px-2">
                    <h3 class="card-title recipe-title">$title</h3>
                    <div class="recipe-tag-list">
                        $tags
                    </div>
                    <p class="card-text excerpt">
EOF;

			if ($show_excerpt) {
				$output .= $excerpt;
			} else {
				$output .= $content;
			}

			$output .= <<<EOF
                    </p>

                </div>
            </div>
        </div>
        
EOF;

			if($term_id) {
				$detail_area_id = $term_id . "-" . $id;
			} else {
				$detail_area_id = $id;
			}


			if ($show_detail) {

				$output .= <<<EOF
        
        <div class="card-footer w-100 text-muted text-center">
            <a 
                class="collapse-controller collapsed" 
                data-toggle="collapse" 
                data-target="#detail-$detail_area_id" 
                href="#detail-$detail_area_id">    
            </a>
        </div>
        
EOF;

			}


			$output .= <<<EOF
    </div>
    
EOF;

			if ($show_detail) {
				$output .= <<<EOF
    
    <div id="detail-$detail_area_id" class="collapse-detail collapse border">
        $content
        
        <div class="card-footer w-100 text-muted text-center">
            <a 
                class="collapse-controller collapsed" 
                data-toggle="collapse" 
                data-target="#detail-$detail_area_id" 
                href="#detail-$detail_area_id">    
            </a>
        </div>
        
    </div>
    
EOF;
			}

			$output .= <<<EOF

    <br/>

EOF;

			return $output;
		}

		private function get_recipe_thumnails($post_id)
		{

			$post = get_post($post_id);

			$images = array();

			if (has_post_thumbnail($post)) {
				$thumbnail_id = get_post_thumbnail_id($post);

				$thumbnail = wp_get_attachment_image_src($thumbnail_id, 'full');

				$thumbnail_src = $thumbnail[0];

				$images[] = $thumbnail_src;
			}

			if (class_exists('Dynamic_Featured_Image')) {
				global $dynamic_featured_image;
				$featured_images = $dynamic_featured_image->get_featured_images();

				foreach ($featured_images as $featured_image) {
					if ($featured_image["full"]) {
						$images[] = $featured_image["full"];
					}
				}
			}

			if (count($images) == 0) {
				return "";
			}

			if (count($images) == 1) {

				$thumbnail_src = esc_url($thumbnail_src);

				$thumbnail_html = <<<EOF
<div class="col-sm-4">
<img src="{$thumbnail_src}" class="img-fluid" alt="thumbnail_src">
</div>
EOF;
			} else {
				$thumbnail_html = <<<EOF
<div class="col-sm-4">
<!--Carousel Wrapper-->
    <div id="carousel-thumb-$post_id" class="carousel slide carousel-fade carousel-thumbnails" data-ride="carousel">
      <!--Slides-->
      <div class="carousel-inner" role="listbox">
EOF;

				foreach ($images as $index => $image) {

					$image = esc_url($image);

					$thumbnail_html .= <<<EOF
<div class="carousel-item
EOF;
					if ($index == 0) {
						$thumbnail_html .= " active";
					}

					$thumbnail_html .= <<<EOF
                    ">
          <img class="d-block w-100" src="$image" alt="$index slide">
        </div>
EOF;

				}

				$thumbnail_html .= <<<EOF
      </div>
      <!--/.Slides-->
      <!--Controls-->
      <a class="carousel-control-prev" href="#carousel-thumb-$post_id" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carousel-thumb-$post_id" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
      
      <ol class="carousel-indicators">
      
EOF;

				foreach ($images as $index => $image) {

					$image = esc_url($image);

					$thumbnail_html .= <<<EOF
<li data-target="#carousel-thumb-$post_id" data-slide-to="$index" 
EOF;
					if ($index == 0) {
						$thumbnail_html .= ' class="active"';
					}

					$thumbnail_html .= <<<EOF
                    "><img class="d-block w-100" src="$image"
            class="img-fluid"></li>
EOF;
				}

				$thumbnail_html .= <<<EOF
      </ol>
    </div>
</div>
EOF;

			}

			return $thumbnail_html;
		}

		private function get_recipe_tags($post_id)
		{
			$post = get_post($post_id);

			$post_type = $post->post_type;

			$taxonomies = get_object_taxonomies($post_type, "objects");

			$out = array();
			foreach ($taxonomies as $taxonomy_slug => $taxonomy) {


				if($taxonomy_slug == "recipes_tags") {



					$terms = get_the_terms($post_id, $taxonomy_slug);

					if (!empty($terms)) {
						foreach ($terms as $term) {
							$css_class = $term->description;
							if (!$term->description) {
								$css_class = "badge-primary";
							}

							$out[] =
								'<span class="recipe-tags badge badge-pill ' . esc_attr( $css_class ) . '">'
								. esc_html( $term->name )
								. "</span>";
						}
					}
				}


			}

			return implode('', $out);
		}

	}

	$kikushima_recipes = new KIKUSHIMA_Recipes();
	add_action('plugins_loaded', array($kikushima_recipes, 'init_actions'));

endif;