<?php
/**
 * Main Themify class
 * @package themify
 */
class Themify {
	/** Default sidebar layout
	 * @var string */
	public $layout;
	public $post_filter=false;
	public $post_layout;
	
	public $hide_title;
	public $hide_meta;
	public $hide_date;
	public $hide_image;
	
	public $unlink_title;
	public $unlink_image;
	
	public $display_content = '';
	public $media_position='above';
	public $auto_featured_image;
	
	public $width = '';
	public $height = '';
	public $image_size='';
	public $avatar_size = 96;
	public $page_navigation;
	public $posts_per_page;
	
	public $is_shortcode = false;
	public $page_id = '';
	public $query_category = '';
	public $query_post_type = '';
	public $query_taxonomy = '';
	public $paged = '';
	public $query_all_post_types;
	
	
	private static $page_image_width = 978;
	// Default Single Image Size
	private static $single_image_width = 978;
	private static $single_image_height = 400;
	
	// Grid4
	private static $grid4_width = 222;
	private static $grid4_height = 140;
	
	// Grid3
	private static $grid3_width = 306;
	private static $grid3_height = 190;
	
	// Grid2
	private static $grid2_width = 474;
	private static $grid2_height = 270;
	
	// List Large
	private static $list_large_image_width = 716;
	private static $list_large_image_height = 390;
	 
	// List Thumb
	private static $list_thumb_image_width = 160;
	private static $list_thumb_image_height = 100;
	
	// List Grid2 Thumb
	private static $grid2_thumb_width = 110;
	private static $grid2_thumb_height = 100;
	
	// List Post
	private static $list_post_width = 978;
	private static $list_post_height = 400;
	
	// Sorting Parameters
	public $order = 'DESC';
	public $orderby = 'date';
	public $order_meta_key = false;
	
	public $page_title;
	public $image_page_single_width;
	public $image_page_single_height;
	public $hide_page_image;
	public $excerpt_length;
	public $isPage=false;

	function __construct() {
		add_action('template_redirect', array($this, 'template_redirect'),5);
	}
	
	
	private function themify_set_global_options() {
		
		///////////////////////////////////////////
		//Global options setup
		///////////////////////////////////////////
	    
		$this->layout = themify_get('setting-default_layout', 'sidebar2',true);
		
		$this->post_layout = themify_get( 'setting-default_post_layout', 'list-post',true );
		
		$this->hide_title = themify_get('setting-default_post_title', '', true);
		$this->unlink_title = themify_get('setting-default_unlink_post_title', '', true);
		
		$this->hide_image = themify_get('setting-default_post_image', '', true);
		$this->unlink_image = themify_get('setting-default_unlink_post_image', '', true);
		$this->auto_featured_image = themify_check('setting-auto_featured_image', '', true);
		
		$this->hide_meta = themify_get('setting-default_post_meta', '', true);
		$this->hide_date = themify_get('setting-default_post_date', '', true);

		$this->order = themify_get('setting-index_order', $this->order, true);
		$this->orderby = themify_get('setting-index_orderby', $this->orderby, true);

		if ($this->orderby === 'meta_value' || $this->orderby === 'meta_value_num') {
		    $this->order_meta_key = themify_get('setting-index_meta_key', '', true);
		}

		$this->width = themify_get('setting-image_post_width', '', true);
		$this->height = themify_get('setting-image_post_height', '', true);
		
		$this->display_content = themify_get('setting-default_layout_display', '', true);
		$this->excerpt_length = themify_get( 'setting-default_excerpt_length' , '', true);
		$this->avatar_size = apply_filters('themify_author_box_avatar_size', $this->avatar_size);
		$this->posts_per_page = get_option('posts_per_page');
	}

	function template_redirect() {
		$this->themify_set_global_options();
		if( is_singular() ) {
			$this->display_content = 'content';
		}
		
		
		if (is_page() || themify_is_shop()) {
			if (post_password_required()) {
			    return;
			}
			$this->page_id = get_the_ID();
			$this->paged=get_query_var( 'paged' ) ;
			if(empty($this->paged)){
			    $this->paged=get_query_var( 'page',1 );
			}
			global $paged;
			$paged = $this->paged;
			
			$this->layout = themify_get_both('page_layout', 'setting-default_page_layout', 'sidebar2');
			$this->hide_page_image = themify_get('setting-hide_page_image', false, true) === 'yes' ? 'yes' : 'no';
			$this->image_page_single_width = themify_get('setting-page_featured_image_width', self::$page_image_width, true);
			$this->image_page_single_height = themify_get('setting-page_featured_image_height', 0, true);
			$this->page_title = themify_get_both('hide_page_title', 'setting-hide_page_title', 'no');
			if(!themify_is_shop()){
			    $this->query_category = themify_get('query_category','');
			    if($this->query_category!==''){
				$this->query_taxonomy = 'category';
				$this->query_post_type = 'post';
				$this->post_layout = themify_get( 'layout','list-post');
				$this->hide_title = themify_get('hide_title',$this->hide_title); 
				$this->unlink_title = themify_get('unlink_title',$this->unlink_title); 
				$this->hide_image = themify_get('hide_image',$this->hide_image); 
				$this->unlink_image = themify_get('unlink_image',$this->unlink_image); 
				$this->hide_meta = themify_get('hide_meta',$this->hide_meta); 
				$this->hide_date = themify_get('hide_date',$this->hide_date); 
				$this->display_content = themify_get( 'display_content','excerpt');
				$this->width = themify_get('image_width',$this->width); 
				$this->height = themify_get('image_height',$this->height ); 
				$this->page_navigation = themify_get('hide_navigation',$this->page_navigation); 
				$this->posts_per_page = themify_get('posts_per_page',$this->posts_per_page);
				$this->order = themify_get( 'order','desc');
				$this->orderby = themify_get( 'orderby', 'date');
				if ($this->orderby === 'meta_value' || $this->orderby === 'meta_value_num') {
				    $this->order_meta_key = themify_get( 'meta_key', $this->order_meta_key );
				}
			    }
			}
			
		}
		elseif( is_single() ) {
			$this->layout = themify_get_both('layout','setting-default_page_post_layout','sidebar2');
			$this->hide_title = themify_get_both('hide_post_title','setting-default_page_post_title');
			$this->unlink_title = themify_get_both('unlink_post_title','setting-default_page_unlink_post_title');
			$this->hide_date = themify_get_both('hide_post_date','setting-default_page_post_date');
			$this->hide_meta = themify_get_both('hide_post_meta','setting-default_page_post_meta');
			$this->hide_image = themify_get_both('hide_post_image','setting-default_page_post_image');
			$this->unlink_image = themify_get_both('unlink_post_image','setting-default_page_unlink_post_image');
                        $this->width = themify_get_both('image_width','setting-image_post_single_width','');
                        $this->height = themify_get_both('image_height','setting-image_post_single_height','');
			$this->display_content = '';
		}
		elseif ( is_archive() ) {
			$excluded_types = apply_filters( 'themify_exclude_CPT_for_sidebar', array('post', 'page', 'attachment', 'tbuilder_layout', 'tbuilder_layout_part', 'section'));
            $postType = get_post_type();
			if ( !in_array($postType, $excluded_types,true) ) {
			    $this->layout = themify_get( 'setting-custom_post_'. $postType .'_archive',$this->layout ,true );
			}
		}

		if($this->width==='' && $this->height===''){
		    if(is_single()){
			$this->width =self::$single_image_width;
			$this->height = self::$single_image_height;
		    }
		    else{
			switch ($this->post_layout){
			    case 'grid4':
				$this->width = self::$grid4_width;
				$this->height = self::$grid4_height;
			    break;
			    case 'grid3':
				$this->width = self::$grid3_width;
				$this->height = self::$grid3_height;
			    break;
			    case 'grid2':
				$this->width = self::$grid2_width;
				$this->height = self::$grid2_height;
			    break;
			    case 'list-large-image':
				$this->width = self::$list_large_image_width;
				$this->height = self::$list_large_image_height;
			    break;
			    case 'list-thumb-image':
				$this->width = self::$list_thumb_image_width;
				$this->height = self::$list_thumb_image_height;
			    break;
			    case 'grid2-thumb':
				$this->width = self::$grid2_thumb_width;
				$this->height = self::$grid2_thumb_height;
			    break;
			    default :
				$this->width = self::$list_post_width;
				$this->height = self::$list_post_height;
			    break;
			}
		    }
		}
		
		
	}
	
	/**
	 * Returns post category IDs concatenated in a string
	 * @param number Post ID
	 * @return string Category IDs
	 */
	public function get_categories_as_classes($post_id){
		$categories = wp_get_post_categories($post_id);
		$class = '';
		foreach($categories as $cat)
			$class .= ' cat-'.$cat;
		return $class;
	}
	 	 
	 /**
	  * Returns category description
	  * @return string
	  */
	 function get_category_description(){
	 	$category_description = category_description();
		if ( !empty( $category_description ) ){
			return '<div class="category-description">' . $category_description . '</div>';
		}
	 }
	 
	 
}
global $themify;
$themify = new Themify();