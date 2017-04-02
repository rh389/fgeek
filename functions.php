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
 * @subpackage fGeek
 * @author tishonator
 * @since fGeek 1.0.0
 *
 */

require_once( trailingslashit( get_template_directory() ) . 'customize-pro/class-customize.php' );

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
	add_editor_style( array( 'css/editor-style.css', get_template_directory_uri() . '/css/font-awesome.min.css' ) );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'fgeek' ),
	) );

	// add Custom background				 
	add_theme_support( 'custom-background', 
				   array ('default-color'  => '#FFFFFF')
				 );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 0, true );

	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 900;

	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list',
	) );

	// add custom header
    add_theme_support( 'custom-header', array (
                       'default-image'          => '',
                       'random-default'         => '',
                       'flex-height'            => true,
                       'flex-width'             => true,
                       'uploads'                => true,
                       'width'                  => 900,
                       'height'                 => 100,
                       'default-text-color'     => '#000000',
                       'wp-head-callback'       => 'fgeek_header_style',
                    ) );

    // add custom logo
    add_theme_support( 'custom-logo', array (
                       'width'                  => 145,
                       'height'                 => 36,
                       'flex-height'            => true,
                       'flex-width'             => true,
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
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array( ) );
	wp_enqueue_style( 'fgeek-style', get_stylesheet_uri(), array( ) );
	
	wp_enqueue_style( 'fgeek-fonts', fgeek_fonts_url(), array(), null );
	
	// Load thread comments reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
	
	// Load Utilities JS Script
	wp_enqueue_script( 'fgeek-js', get_template_directory_uri() . '/js/utilities.js', array( 'jquery' ) );

	wp_enqueue_script( 'bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array( 'jquery' ) );
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
function fgeek_show_website_logo_image_and_title() {

	if ( has_custom_logo() ) {

        the_custom_logo();
    }

    $header_text_color = get_header_textcolor();

    if ( 'blank' !== $header_text_color ) {
    
        echo '<div id="site-identity">';
        echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
        echo '<h1 class="entry-title">'.get_bloginfo('name').'</h1>';
        echo '</a>';
        echo '<strong>'.get_bloginfo('description').'</strong>';
        echo '</div>';
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

	// Register Footer Column #1
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #1', 'fgeek' ),
							'id' 			 =>  'footer-column-1-widget-area',
							'description'	 =>  __( 'The Footer Column #1 widget area', 'fgeek' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
	
	// Register Footer Column #2
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #2', 'fgeek' ),
							'id' 			 =>  'footer-column-2-widget-area',
							'description'	 =>  __( 'The Footer Column #2 widget area', 'fgeek' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
	
	// Register Footer Column #3
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #3', 'fgeek' ),
							'id' 			 =>  'footer-column-3-widget-area',
							'description'	 =>  __( 'The Footer Column #3 widget area', 'fgeek' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
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
			  			<img src="<?php echo esc_url( $slideImage ); ?>" class="slider-img" alt="<?php echo esc_attr( sprintf( __( 'image %s', 'fgeek' ), $i )  ); ?>" />
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

function fgeek_header_style() {

    $header_text_color = get_header_textcolor();

    if ( ! has_header_image()
        && ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color
             || 'blank' === $header_text_color ) ) {

        return;
    }

    $headerImage = get_header_image();
?>
    <style type="text/css">
        <?php if ( has_header_image() ) : ?>

                #header-main {background-image: url("<?php echo esc_url( $headerImage ); ?>");}

        <?php endif; ?>

        <?php if ( get_theme_support( 'custom-header', 'default-text-color' ) !== $header_text_color
                    && 'blank' !== $header_text_color ) : ?>

                #header-main, #header-main h1.entry-title {color: #<?php echo esc_attr( $header_text_color ); ?>;}

        <?php endif; ?>
    </style>
<?php
}

?>
