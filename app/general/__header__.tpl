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
  content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"
/>
<link rel="stylesheet" href="<?= $path['assets_css'] . '/app.css' ?>" />

<link
  rel="apple-touch-icon"
  sizes="180x180"
  href="<?= $path['assets_images'] ?>/favicon/apple-touch-icon.png"
/>
<link
  rel="icon"
  type="image/png"
  sizes="32x32"
  href="<?= $path['assets_images'] ?>/favicon/favicon-32x32.png"
/>
<link
  rel="icon"
  type="image/png"
  sizes="16x16"
  href="<?= $path['assets_images'] ?>/favicon/favicon-16x16.png"
/>
<link
  rel="manifest"
  href="<?= $path['assets_images'] ?>/favicon/site.webmanifest"
/>
<link
  rel="mask-icon"
  href="<?= $path['assets_images'] ?>/favicon/safari-pinned-tab.svg"
  color="#5bbad5"
/>
<meta name="msapplication-TileColor" content="#da532c" />
<meta name="theme-color" content="#ffffff" />

<?php
        use Application\Session;
       $noLoadPixels= Session::get('queryParams.noloadpixels',false);
        if (!$noLoadPixels  && !env('IS_LOCAL',false)) { ?>

<!-- Google Tag Manager -->
<script>
  (function (w, d, s, l, i) {
    w[l] = w[l] || [];
    w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
    var f = d.getElementsByTagName(s)[0],
      j = d.createElement(s),
      dl = l != "dataLayer" ? "&l=" + l : "";
    j.async = true;
    j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
    f.parentNode.insertBefore(j, f);
  })(window, document, "script", "dataLayer", "GTM-NRL2JBFC");
</script>
<!-- End Google Tag Manager -->

<!-- Google tag (gtag.js) -->
<script
  async
  src="https://www.googletagmanager.com/gtag/js?id=G-SSQ6XFQ6E2"
></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    dataLayer.push(arguments);
  }
  gtag("js", new Date());

  gtag("config", "G-SSQ6XFQ6E2");
</script>

<!-- Begin Inspectlet Asynchronous Code -->
<script type="text/javascript">
  (function () {
    window.__insp = window.__insp || [];
    __insp.push(["wid", 189645210]);
    var ldinsp = function () {
      if (typeof window.__inspld != "undefined") return;
      window.__inspld = 1;
      var insp = document.createElement("script");
      insp.type = "text/javascript";
      insp.async = true;
      insp.id = "inspsync";
      insp.src =
        ("https:" == document.location.protocol ? "https" : "http") +
        "://cdn.inspectlet.com/inspectlet.js?wid=189645210&r=" +
        Math.floor(new Date().getTime() / 3600000);
      var x = document.getElementsByTagName("script")[0];
      x.parentNode.insertBefore(insp, x);
    };
    setTimeout(ldinsp, 0);
  })();
</script>
<!-- End Inspectlet Asynchronous Code -->

<?php }  ?>
<?php perfom_head_tag_close_actions(); ?>
