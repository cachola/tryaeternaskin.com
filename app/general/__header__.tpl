<meta charset="utf-8" />
<title><?= get_meta_details('site_title', $steps['current']['id']) ?></title>
<meta
  name="description"
  content="<?php get_meta_details('meta_description', $steps['current']['id']); ?>"
/>

<?php if(!empty($config['block_robots'])): ?>

<meta
  name="robots"
  content="noindex,nofollow,noarchive,nosnippet,noydir,noodp"
/>

<?php endif; ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="content-language" content="en-us" />
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="HandheldFriendly" content="true" />
<meta
  name="viewport"
  content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no, viewport-fit=cover"
/>
<link rel="stylesheet" href="<?= $path['assets_css'] . '/app.css' ?>" />

<link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
<link rel="shortcut icon" href="/favicon/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
<link rel="manifest" href="/favicon/site.webmanifest" />

<meta name="msapplication-TileColor" content="#da532c" />
<meta name="theme-color" content="#ffffff" />

<?php
        use Application\Session;
       $noLoadPixels= Session::get('queryParams.noloadpixels',false);
        if (!$noLoadPixels  && !env('IS_LOCAL',false)) { ?>



<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5K4RVSRP');</script>
<!-- End Google Tag Manager -->


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VK4HQPYKPN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VK4HQPYKPN');
</script>



<?php }  ?>
<?php perfom_head_tag_close_actions(); ?>
