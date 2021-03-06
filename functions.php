<?php
/**
 * snowproblem functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package snowproblem
 */

if ( ! function_exists( 'snowproblem_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function snowproblem_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on snowproblem, use a find and replace
	 * to change 'snowproblem' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'snowproblem', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'snowproblem' ),
		'social'  => esc_html__( 'Social Menu', 'snowproblem'),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'snowproblem_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // snowproblem_setup
add_action( 'after_setup_theme', 'snowproblem_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function snowproblem_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'snowproblem_content_width', 640 );
}
add_action( 'after_setup_theme', 'snowproblem_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function snowproblem_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'snowproblem' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	// Register the footer as an area to display widgets in.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'snowproblem' ),
		'id'            => 'footer',
		'description'   => 'The bottom of any page.',
		'before_widget' => '<article id="%1$s" class="widget %2$s">',
		'after_widget'  => '</article>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'snowproblem_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function snowproblem_scripts() {

	// Include the fontawesome stylesheet.
	wp_enqueue_style( 'snowproblem-fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');

	wp_enqueue_style( 'snowproblem-style', get_stylesheet_uri() );

	wp_enqueue_style( 'snowproblem-main-style', get_template_directory_uri() . '/stylesheets/main.css' );

	// Adds in support for jQuery.
	if ( ! is_admin() ) {
        wp_enqueue_script( 'jquery' );
    }

	wp_enqueue_script( 'snowproblem-add-classes', get_template_directory_uri() . '/js/add-classes.js' );

	wp_enqueue_script( 'snowproblem-featured', get_template_directory_uri() . '/js/featured.js' );

	wp_enqueue_script( 'snowproblem-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'snowproblem-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'snowproblem_scripts' );

/**
 * Change the default read more text from an excerpt.
 */
function snowproblem_excerpt_more( $more ) {
	return '...';
}

/**
 * Change the html markupp of comments.
 */
function snowproblem_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
	<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<?php if ( $args['avatar_size'] != '0' ) : ?>
			<div class="author-image-container">
				<?php echo get_avatar( $comment, ( isset($args['avatar_size']) ? $args['avatar_size'] : 96) ); ?>
			</div>
		<?php endif; ?>

		<section class="entry-meta">
			<span class="posted-on">
				<?php printf( __('%1$s: %2$s'), get_comment_date(),  get_comment_time() ); ?>
			</span>
			<span class="byline">
				<?php printf( __( '<span class="author">%s</span>' ), get_comment_author_link() ); ?>
			</span>
		</section> <!-- .comment-meta -->

		<section class="comment-body">
			<?php comment_text(); ?>
		</section> <!-- .comment-body -->

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>

		<div class="background"></div>

	</article> <!-- #comment-? -->
<?php
}

add_filter('excerpt_more', 'snowproblem_excerpt_more');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
