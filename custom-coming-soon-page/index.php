<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once(dirname(__FILE__) . '../../../../../../wp-load.php'); 
/** PLUGIN URL PATH **/
// Pre-2.6 compatibility
if ( !defined('WP_CONTENT_URL') )
    define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( !defined('WP_CONTENT_DIR') )
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
// Guess the location
$sp_plugin_url = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'';
function sptop($mykey){
global $wpdb;
$cj_splash_plugin_name = "CJ Splash Page";
$shortname = strtolower(str_replace(" ", "_", $cj_splash_plugin_name)."_");
$settingsname = $shortname."settings";
	$sopt = get_option($settingsname);
	$mykey = $shortname.$mykey;
	foreach($sopt as $key=>$opt){
		if($key == $mykey){
			return stripslashes($opt);
		}
	}
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> <?php echo sptop('head_title'); ?> </title>
<link rel="stylesheet" type="text/css" href="<?php echo $sp_plugin_url ?>/style.css?v0.5" media="screen" />
<script type="text/javascript" src="<?php echo $sp_plugin_url ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $sp_plugin_url ?>/js/countdown.js"></script>
<script type="text/javascript" src="<?php echo $sp_plugin_url ?>/js/rounded.js"></script>
<script type="text/javascript" src="<?php echo $sp_plugin_url ?>/js/custom.js"></script>
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="<?php echo $sp_plugin_url ?>/styleie6.css" media="screen" />
<script type="text/javascript"> DD_roundies.addRule('.cjsp-pngfix'); </script>
<![endif]-->
<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" href="<?php echo $sp_plugin_url ?>/styleie7.css" media="screen" />
<![endif]-->
<?php
if(sptop('favicon_url') == 'yoursite.com/favicon.ico'){
    echo '<link rel="shortcut icon" href="'.$sp_plugin_url.'/images/favicon.ico" />';
}else{
    echo '<link rel="shortcut icon" href="'.sptop('favicon_url').'" />';
}
?>
<script type="text/javascript">
$(function(){
    var liftoffTime = new Date(<?php echo sptop('launch_year'); ?>, <?php echo sptop('launch_month'); ?> - 1, <?php echo sptop('launch_day'); ?>, 0, 0);
    $("#cjsp-countdown").countdown({
        until: liftoffTime,
        layout: "{dn} {dl}, {hn} {hl}, {mn} {ml}, {sn} {sl}",
        labels:['Anni','Mesi','Settimane','Giorni','Ore','Minuti','Secondi'],
        labels1:['Anno','Mese','Settimana','Giorno','Ora','Minuto','Secondo']
    });
});
</script>
<meta name="description" content="<?php echo sptop('head_description'); ?>" />
<meta name="keywords" content="<?php echo sptop('head_keywords'); ?>" />
<?php echo sptop('head_tags')."\n"; ?>
</head>
<body>
<div id="topbar">
	<div id="wrapper_partners">
		<div id="partners_left">
			<span>Un progetto di:</span>
			<a href='http://www.cmvallecamonica.bs.it' title="Comunità Montana ValleCamonica" class="partner"><img src="<?php echo $sp_plugin_url . "/images/logo/comunitamontana.jpg"?>"/></a>
			<a href='http://www.legambiente.org' title="Legambiente Lombardia" class="partner"><img src="<?php echo $sp_plugin_url . "/images/logo/legambiente.jpg"?>"/></a>
		</div><!-- /partners_left -->
		<div id="partners_right">
			<span>Grazie al contributo di:</span>
			<a href='http://www.fondazionecariplo.it' title="Fondazione Cariplo" class="partner"><img src="<?php echo $sp_plugin_url . "/images/logo/cariplo.jpg"?>"/></a>
			<a href='http://www.comune.paspardo.bs.it' title="Comune di Paspardo" class="partner"><img src="<?php echo $sp_plugin_url . "/images/logo/paspardo.jpg?1"?>"/></a>
		</div><!-- /partners_right  -->
	</div><!-- /wrapper_partners -->
</div><!-- /topbar -->
<div id="cjsp-wrapper">
<div id="cjsp-logo">
	<div class="clear"></div>
	<a href="<?php bloginfo('home'); ?>" title="<?php bloginfo('description'); ?>" class="logo">
		<img class="cjsp-pngfix" src="<?php if(sptop('logo_url') == "yoursite.com/images/logo.png") {echo $sp_plugin_url.'/images/logo.png';} else { echo sptop('logo_url');} ?>" alt="<?php bloginfo('description'); ?>" />
	</a>
</div><!-- /logo -->
<div id="cjsp-content" class="cjsp-pngfix">
    <div class="cjsp-topsection">
	<h1 class="cjsp-heading"><?php echo sptop('page_heading'); ?></h1><!-- /heading -->
	<p class="cjsp-msg"><?php echo sptop('page_msg'); ?></p><!-- /message -->
    </div>
	<div id="cjsp-countdown">54 Days, 21 Hours, 11 Minutes, 23 Seconds</div><!-- /countdown -->
	<?php /*
	<div id="cjsp-subscribeform">
		<form action="<?php echo $sp_plugin_url; ?>/mail.php#cjsp-smessage" method="post" class="aform" id="cjsp-sendsubscriber">
			<input type="text" class="cjsp-inputbox" id="cjsp-semail" name="semail" value="Enter your email address"  onfocus="if ( this.value == this.defaultValue ) this.value = '';" onblur="if ( this.value == '' ) this.value = this.defaultValue" />
			<input type="hidden" name="sto" value="<?php echo sptop('email_id'); ?>" />
			<input type="hidden" name="ssubject" value="<?php echo sptop('email_subject'); ?>" />
			<input type="hidden" name="sthankyou" value="<?php echo sptop('email_thankyou'); ?>" />
			<input type="submit" value="" name="sendsinfo" class="cjsp-submit" />
		</form>
	</div><!-- /subscribeform -->
	<p id="cjsp-smessage" class="cjsp-spammsg">Your email is safe with us. We hate spam as much as you do.</p>
	* */?>
	<p class="cjsp-connect">
		<?php
		if(sptop('twitter_username') == "" && sptop('facebook_username') == ""){
			$connect_via = "";
		}elseif(sptop('twitter_username') != "" && sptop('facebook_username') != ""){
			$connect_via = "Connect via: ";
			$or = " or ";
		}
		else{
			$connect_via = "Connect via: ";
		}
		if(sptop('twitter_username') != ""){
			$twitter = '<a href="http://www.twitter.com/'.sptop('twitter_username').'" title="Follow on Twitter" target="_blank">Twitter</a>'.$or;
		}
		if(sptop('facebook_username') != ""){
			$facebook = ' <a href="http://www.facebook.com/'.sptop('facebook_username').'" title="Connect via Facebook" target="_blank">Facebook</a>';
		}
		if(sptop('rss_url') != ""){
			$rssurl = ' | <a href="'.sptop('rss_url').'" title="Subscribe" target="_blank">Subscribe via RSS</a>';
		}
                if(sptop('login_link') == "Yes"){
                    $loginlink = ' | <a href="'.get_bloginfo('wpurl').'/wp-admin" title="Login"> Login </a> ';
                }
		?>
		<?php echo $connect_via.$twitter.$facebook.$rssurl; ?>
	</p>
</div><!-- /content -->
<img src="<?php echo "$sp_plugin_url/images/nel_frattempo.png"?>" alt="nel frattempo..." class="nelfrattempo cjsp-pngfix"/>
<div id="notizie">
<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>

		<h2>&raquo; <?php the_title(); ?></h2>
		<small>Scritto il <?php the_time('j F Y') ?> alle <?php the_time() ?></small>

		<div class="entry">
			<?php the_content(); ?>
		</div>

	<?php endwhile; ?>
<?php endif; ?>
</div>
<p class="footer">
Contatti:
Legambiente 392.92.76.538 &raquo;
Email:
<a href='mailto:alessia.chiappini@centrofaunisticoadamello.info'>alessia.chiappini@centrofaunisticoadamello.info</a>
 e
<a href='mailto:m.canziani@legambiente.org'>m.canziani@legambiente.org</a>
        <?php /*echo $loginlink; */?>
</p>
</div><!-- /wrapper -->
</body>
</html>
<?php die(); ?>
