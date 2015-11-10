<?php
/**
 * fGeek functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage fGeek
 * @author tishonator
 * @since fGeek 1.0.0
 *
 */

if ( ! function_exists( 'fgeek_setup' ) ) :
/**
 * fGeek setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 */
function fgeek_setup() {

	load_theme_textdomain( 'fgeek', get_template_directory() . '/languages' );

	add_theme_support( "title-tag" );

	// add the visual editor to resemble the theme style
	add_editor_style( array( 'css/editor-style.css' ) );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'primary menu', 'fgeek' ),
	) );

	// add Custom background				 
	add_theme_support( 'custom-background', 
				   array ('default-color'  => '#FFFFFF')
				 );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 'full', 'full', true );

	if ( ! isset( $content_width ) )
		$content_width = 900;

	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

	// add custom header
	add_theme_support( 'custom-header', array (
					   'default-image'          => '',
					   'random-default'         => '',
					   'width'                  => 294,
					   'height'                 => 200,
					   'flex-height'            => true,
					   'flex-width'             => true,
					   'default-text-color'     => '',
					   'header-text'            => '',
					   'uploads'                => true,
					   'wp-head-callback'       => '',
					   'admin-head-callback'    => '',
					   'admin-preview-callback' => '',
					) );

	// add support for Post Formats.
	add_theme_support( 'post-formats', array (
											'aside',
											'image',
											'video',
											'audio',
											'quote', 
											'link',
											'gallery',
					) );
}
endif; // fgeek_setup
add_action( 'after_setup_theme', 'fgeek_setup' );

/**
 * the main function to load scripts in the fGeek theme
 * if you add a new load of script, style, etc. you can use that function
 * instead of adding a new wp_enqueue_scripts action for it.
 */
function fgeek_load_scripts() {

	// load main stylesheet.
	wp_enqueue_style( 'fgeek-style', get_stylesheet_uri(), array( ) );
	
	wp_enqueue_style( 'fgeek-fonts', fgeek_fonts_url(), array(), null );
	
	// Load thread comments reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
	
	// Load Utilities JS Script
	wp_enqueue_script( 'fgeek-js', get_template_directory_uri() . '/js/utilities.js', array( 'jquery' ) );

	wp_enqueue_script( 'fgeek-bxslider-js', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array( 'jquery' ) );
}

add_action( 'wp_enqueue_scripts', 'fgeek_load_scripts' );

/**
 *	Load google font url used in the fGeek theme
 */
function fgeek_fonts_url() {

    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by PT Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $notosans = _x( 'on', 'Noto Sans font: on or off', 'fgeek' );

    if ( 'off' !== $notosans ) {
        $font_families = array();
 
        $font_families[] = 'Noto Sans';
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,greek,cyrillic-ext,greek-ext,devanagari,vietnamese,cyrillic,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

/**
 * Display html code of all social sites
 */
function fgeek_display_social_sites() {

	echo '<ul class="header-social-widget">';

	$socialURL = get_theme_mod('fgeek_social_facebook', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Facebook', 'fgeek') . '" class="facebook16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_google', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Google+', 'fgeek') . '" class="google16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_twitter', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Twitter', 'fgeek') . '" class="twitter16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_linkedin', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on LinkeIn', 'fgeek') . '" class="linkedin16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_instagram', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Instagram', 'fgeek') . '" class="instagram16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_rss', get_bloginfo( 'rss2_url' ));
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow our RSS Feeds', 'fgeek') . '" class="rss16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_tumblr', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Tumblr', 'fgeek') . '" class="tumblr16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_youtube', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Youtube', 'fgeek') . '" class="youtube16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_pinterest', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Pinterest', 'fgeek') . '" class="pinterest16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_vk', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on VK', 'fgeek') . '" class="vk16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_flickr', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Flickr', 'fgeek') . '" class="flickr16"></a>';
	}

	$socialURL = get_theme_mod('fgeek_social_vine', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Vine', 'fgeek') . '" class="vine16"></a>';
	}

	echo '</ul>';
}

/**
 * Display website's logo image
 */
function fgeek_show_website_logo_image_or_title() {

	if ( get_header_image() != '' ) {
	
		// Check if the user selected a header Image in the Customizer or the Header Menu
		$logoImgPath = get_header_image();
		$siteTitle = get_bloginfo( 'name' );
		$imageWidth = get_custom_header()->width;
		$imageHeight = get_custom_header()->height;
		
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<img src="' . esc_attr( $logoImgPath ) . '" alt="' . esc_attr( $siteTitle ) . '" title="' . esc_attr( $siteTitle ) . '" width="' . esc_attr( $imageWidth ) . '" height="' . esc_attr( $imageHeight ) . '" />';
		
		echo '</a>';

	} else {
	
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<h1>'.get_bloginfo('name').'</h1>';
		
		echo '</a>';
		
		echo '<strong>'.get_bloginfo('description').'</strong>';
	}
}

/**
 *	Displays the copyright text.
 */
function fgeek_show_copyright_text() {

	$footerText = get_theme_mod('fgeek_footer_copyright', null);

	if ( !empty( $footerText ) ) {

		echo esc_html( $footerText ) . ' | ';		
	}
}

/**
 *	widgets-init action handler. Used to register widgets and register widget areas
 */
function fgeek_widgets_init() {
	
	// Register Sidebar Widget.
	register_sidebar( array (
						'name'	 		 =>	 __( 'Sidebar Widget Area', 'fgeek'),
						'id'		 	 =>	 'sidebar-widget-area',
						'description'	 =>  __( 'The sidebar widget area', 'fgeek'),
						'before_widget'	 =>  '',
						'after_widget'	 =>  '',
						'before_title'	 =>  '<div class="sidebar-before-title"></div><h3 class="sidebar-title">',
						'after_title'	 =>  '</h3><div class="sidebar-after-title"></div>',
					) );
}

add_action( 'widgets_init', 'fgeek_widgets_init' );

/**
 * Displays the slider
 */
function fgeek_display_slider() { ?>
	 
	<ul class="bxslider">
		<?php
			// display slides
			for ( $i = 1; $i <= 3; ++$i ) {

					$defaultSlideContent = __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fgeek' );
					
					$defaultSlideImage = get_template_directory_uri().'/images/slider/' . $i .'.jpg';

					$slideContent = get_theme_mod( 'fgeek_slide'.$i.'_content', html_entity_decode( $defaultSlideContent ) );
					$slideImage = get_theme_mod( 'fgeek_slide'.$i.'_image', $defaultSlideImage );

				?>
					<li>
			  			<img src="<?php echo esc_attr( $slideImage ); ?>" class="slider-img" alt="<?php echo esc_attr( sprintf( __( 'image %s', 'fgeek' ), $i )  ); ?>" />
			  			<div class="caption">						
							<?php echo $slideContent; ?>
							<br /><br />
						</div>
			  		</li>

<?php		} ?>
	</ul><!-- .bxslider -->

<?php  
}

/**
 * Gets additional theme settings description
 */
function fgeek_get_customizer_sectoin_info() {

	$premiumThemeUrl = 'https://tishonator.com/product/tgeek';

	return sprintf( __( 'The fGeek theme is a free version of the professional WordPress theme tGeek. <a href="%s" class="button-primary" target="_blank">Get tGeek Theme</a><br />', 'fgeek' ), $premiumThemeUrl );
}

/**
 * Register theme settings in the customizer
 */
function fgeek_customize_register( $wp_customize ) {

    /**
	 * Add Social Sites Section
	 */
	$wp_customize->add_section(
		'fgeek_social_section',
		array(
			'title'       => __( 'Social Sites', 'fgeek' ),
			'capability'  => 'edit_theme_options',
			'description' => fgeek_get_customizer_sectoin_info(),
		)
	);
	
	// Add facebook url
	$wp_customize->add_setting(
		'fgeek_social_facebook',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_facebook',
        array(
            'label'          => __( 'Facebook Page URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_facebook',
            'type'           => 'text',
            )
        )
	);

	// Add google+ url
	$wp_customize->add_setting(
		'fgeek_social_google',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_google',
        array(
            'label'          => __( 'Google+ Page URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_google',
            'type'           => 'text',
            )
        )
	);

	// Add twitter url
	$wp_customize->add_setting(
		'fgeek_social_twitter',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_twitter',
        array(
            'label'          => __( 'Twitter Page URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_twitter',
            'type'           => 'text',
            )
        )
	);

	// Add LinkedIn url
	$wp_customize->add_setting(
		'fgeek_social_linkedin',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_linkedin',
        array(
            'label'          => __( 'LinkedIn Page URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_linkedin',
            'type'           => 'text',
            )
        )
	);

	// Add Instagram url
	$wp_customize->add_setting(
		'fgeek_social_instagram',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_instagram',
        array(
            'label'          => __( 'instagram Page URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_instagram',
            'type'           => 'text',
            )
        )
	);

	// Add RSS Feeds url
	$wp_customize->add_setting(
		'fgeek_social_rss',
		array(
		    'default'           => get_bloginfo( 'rss2_url' ),
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_rss',
        array(
            'label'          => __( 'RSS Feeds URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_rss',
            'type'           => 'text',
            )
        )
	);

	// Add Tumblr url
	$wp_customize->add_setting(
		'fgeek_social_tumblr',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_tumblr',
        array(
            'label'          => __( 'Tumblr Page URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_tumblr',
            'type'           => 'text',
            )
        )
	);

	// Add YouTube channel url
	$wp_customize->add_setting(
		'fgeek_social_youtube',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_youtube',
        array(
            'label'          => __( 'YouTube channel URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_youtube',
            'type'           => 'text',
            )
        )
	);

	// Add Pinterest page url
	$wp_customize->add_setting(
		'fgeek_social_pinterest',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_pinterest',
        array(
            'label'          => __( 'Pinterest Page URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_pinterest',
            'type'           => 'text',
            )
        )
	);

	// Add VK page url
	$wp_customize->add_setting(
		'fgeek_social_vk',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_vk',
        array(
            'label'          => __( 'VK Page URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_vk',
            'type'           => 'text',
            )
        )
	);

	// Add Flickr page url
	$wp_customize->add_setting(
		'fgeek_social_flickr',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_flickr',
        array(
            'label'          => __( 'Flickr Page URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_flickr',
            'type'           => 'text',
            )
        )
	);

	// Add Vine page url
	$wp_customize->add_setting(
		'fgeek_social_vine',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_social_vine',
        array(
            'label'          => __( 'Vine Page URL', 'fgeek' ),
            'section'        => 'fgeek_social_section',
            'settings'       => 'fgeek_social_vine',
            'type'           => 'text',
            )
        )
	);
	
	/**
	 * Add Slider Section
	 */
	$wp_customize->add_section(
		'fgeek_slider_section',
		array(
			'title'       => __( 'Slider', 'fgeek' ),
			'capability'  => 'edit_theme_options',
			'description' => fgeek_get_customizer_sectoin_info(),
		)
	);
	
	// Add slide 1 content
	$wp_customize->add_setting(
		'fgeek_slide1_content',
		array(
		    'default'           => __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fgeek' ),
		    'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_slide1_content',
        array(
            'label'          => __( 'Slide #1 Content', 'fgeek' ),
            'section'        => 'fgeek_slider_section',
            'settings'       => 'fgeek_slide1_content',
            'type'           => 'textarea',
            )
        )
	);
	
	// Add slide 1 background image
	$wp_customize->add_setting( 'fgeek_slide1_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '1.jpg',
    		'sanitize_callback' => 'esc_url_raw'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fgeek_slide1_image',
			array(
				'label'   	 => __( 'Slide 1 Image', 'fgeek' ),
				'section' 	 => 'fgeek_slider_section',
				'settings'   => 'fgeek_slide1_image',
			) 
		)
	);
	
	// Add slide 2 content
	$wp_customize->add_setting(
		'fgeek_slide2_content',
		array(
		    'default'           => __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fgeek' ),
		    'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_slide2_content',
        array(
            'label'          => __( 'Slide #2 Content', 'fgeek' ),
            'section'        => 'fgeek_slider_section',
            'settings'       => 'fgeek_slide2_content',
            'type'           => 'textarea',
            )
        )
	);
	
	// Add slide 2 background image
	$wp_customize->add_setting( 'fgeek_slide2_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '2.jpg',
    		'sanitize_callback' => 'esc_url_raw'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fgeek_slide2_image',
			array(
				'label'   	 => __( 'Slide 2 Image', 'fgeek' ),
				'section' 	 => 'fgeek_slider_section',
				'settings'   => 'fgeek_slide2_image',
			) 
		)
	);
	
	// Add slide 3 content
	$wp_customize->add_setting(
		'fgeek_slide3_content',
		array(
		    'default'           => __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fgeek' ),
		    'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_slide3_content',
        array(
            'label'          => __( 'Slide #3 Content', 'fgeek' ),
            'section'        => 'fgeek_slider_section',
            'settings'       => 'fgeek_slide3_content',
            'type'           => 'textarea',
            )
        )
	);
	
	// Add slide 3 background image
	$wp_customize->add_setting( 'fgeek_slide3_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '3.jpg',
    		'sanitize_callback' => 'esc_url_raw'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fgeek_slide3_image',
			array(
				'label'   	 => __( 'Slide 3 Image', 'fgeek' ),
				'section' 	 => 'fgeek_slider_section',
				'settings'   => 'fgeek_slide3_image',
			) 
		)
	);

	/**
	 * Add Footer Section
	 */
	$wp_customize->add_section(
		'fgeek_footer_section',
		array(
			'title'       => __( 'Footer', 'fgeek' ),
			'capability'  => 'edit_theme_options',
			'description' => fgeek_get_customizer_sectoin_info(),
		)
	);
	
	// Add footer copyright text
	$wp_customize->add_setting(
		'fgeek_footer_copyright',
		array(
		    'default'           => '',
		    'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fgeek_footer_copyright',
        array(
            'label'          => __( 'Copyright Text', 'fgeek' ),
            'section'        => 'fgeek_footer_section',
            'settings'       => 'fgeek_footer_copyright',
            'type'           => 'text',
            )
        )
	);
}

add_action('customize_register', 'fgeek_customize_register');

?>
