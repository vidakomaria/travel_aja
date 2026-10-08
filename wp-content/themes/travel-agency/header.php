<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Travel_Agency
 */

    /**
     * Doctype Hook
     * 
     * @hooked travel_agency_doctype
    */
    do_action( 'travel_agency_doctype' );   
?>
<head itemscope itemtype="http://schema.org/WebSite">
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123333065-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-123333065-1');
</script>

	<meta name="google-site-verification" content="E-XzYUMam30jzkzh7N-j-6cUkYdNbVziNmWAaPARHEA" />
	<meta name="google-site-verification" content="8S9i7r1kaAx7LH2wEuk2369dgKkSVpKsvyNIwawugDE" />

<?php     
    /**
     * Before wp_head
     * 
     * @hooked travel_agency_head
    */
    do_action( 'travel_agency_before_wp_head' );
    
    wp_head(); 
?>

</head>
<meta name="B-verify" content="60cd7a4553c1f2cbf0f7de321387e6116c16fa25" />

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
	
<?php
    /**
     * Before Header
     * 
     * @hooked travel_agency_page_start - 20 
    */
    do_action( 'travel_agency_before_header' );
    
    /**
     * Header
     * 
     * @hooked travel_agency_header - 20     
    */
    do_action( 'travel_agency_header' );
    
    /**
     * Before Content
     * 
     * @hooked travel_agency_breadcrumb - 20
    */
    do_action( 'travel_agency_after_header' );
    
    /**
     * Content
     * 
     * @hooked travel_agency_content_start
    */
    do_action( 'travel_agency_content' );
	