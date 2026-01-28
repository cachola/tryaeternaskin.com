<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once 'general/__header__.tpl' ?>

  <meta charset="utf-8">

  <link type="text/css" rel="stylesheet" href="<?= $path['css'] ?>/extras.css">
  <link type="text/css" rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link type="text/css" rel="stylesheet" href="<?= $path['css'] ?>/throbber.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?= $path['assets_css'] ?>/magnific-popup.css">

  <!-- <script type="text/javascript" src="<?= $path['images'] ?>/form-upsale.js"></script>
    <script type="text/javascript" src="<?= $path['images'] ?>/throbber.js"></script> -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&family=Montserrat:wght@600;700;800&display=swap"
    rel="stylesheet">

  <style>
    :root {
      --navy: #234f72;
      --blue: #1d72d8;
      --red: #e31818;
      --bg1: #f7d7df;
      --bg2: #f9e7ec;
    }

    /* Demo page padding only */
    body {
      margin: 0;
      background: #eee;
      font-family: "Open Sans", sans-serif;
      /* padding: 24px; */
    }

    .forDesktop {
      display: block;
    }

    .forMobile {
      display: none;
    }

    .offer-block {
      max-width: 1200px;
      margin: 0 10px 0 10px;
      border: 8px dashed rgba(0, 0, 0, .75);
      border-radius: 8px;
      /* background:
        radial-gradient(1200px 500px at 20% 20%, rgba(255, 255, 255, .55), rgba(255, 255, 255, 0) 60%),
        radial-gradient(900px 400px at 70% 35%, rgba(255, 255, 255, .35), rgba(255, 255, 255, 0) 60%),
        linear-gradient(135deg, var(--bg1), var(--bg2)); */
      box-shadow: 0 6px 18px rgba(0, 0, 0, .15);
      padding: clamp(18px, 3vw, 34px);

      /* 1. Specify the image source */
      background-image: url('<?= $path["images"] ?>/bg-upsell-desktop.jpg');

      /* 2. Control the image size */
      background-size: cover;
      /* Scales the image to cover the entire container */
      /* Other options: 'contain', 'auto', '50% 50%' */

      /* 3. Prevent the image from repeating */
      background-repeat: no-repeat;

      /* 4. Position the image */
      background-position: center;
      /* Centers the image within the container */
      /* Other options: 'top', 'bottom', 'left', 'right', '25% 75%' */



    }

    .offer-inner {
      display: flex;
      align-items: center;
      gap: clamp(18px, 3vw, 44px);
      position: relative;
    }

    .arrow-inner {
      position: absolute;
      bottom: 7vh;
      right: -60px;
    }

    .offer-product {
      flex: 0 0 clamp(180px, 22vw, 320px);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .offer-product img {
      width: auto;
      height: 50%;
      display: block;
      filter: drop-shadow(0 10px 18px rgba(0, 0, 0, .25));
    }

    .offer-copy {
      flex: 1 1 auto;
      text-align: center;
      padding-right: clamp(0px, 1vw, 18px);
    }

    .offer-top {
      font-family: "Open Sans", sans-serif;
      font-weight: 800;
      color: var(--navy);
      font-size: clamp(18px, 2.4vw, 30px);
      letter-spacing: .2px;
      margin: 0 0 clamp(10px, 1.2vw, 18px);
    }

    .offer-red {
      font-family: "Montserrat", sans-serif;
      font-weight: 700;
      color: var(--red);
      font-size: clamp(17px, 1.8vw, 24px);
      letter-spacing: .08em;
      text-transform: uppercase;
      margin: 0 0 clamp(10px, 1.2vw, 18px);
      font-style: italic;
      /* matches the slanted look */
    }

    .offer-with {
      font-family: "Open Sans", sans-serif;
      font-weight: 400;
      color: var(--blue);
      font-size: clamp(20px, 2.6vw, 46px);
      margin: 0 0 clamp(10px, 1.2vw, 18px);
    }

    .offer-title {
      font-family: "Open Sans", sans-serif;
      font-weight: 800;
      color: var(--red) !important;
      text-transform: uppercase;
      font-size: clamp(20px, 2.1vw, 28px);
      letter-spacing: .02em;
      margin: 0 0 clamp(16px, 1.8vw, 26px);
    }

    .offer-line1 {
      font-family: "Open Sans", sans-serif;
      font-weight: 400;
      color: var(--navy);
      font-size: clamp(18px, 2.2vw, 38px);
      margin: 0;
      line-height: 1.25;
    }

    .offer-line1 b {
      font-weight: 800;
      letter-spacing: .02em;
    }

    .offer-line2 {
      font-family: "Open Sans", sans-serif;
      font-weight: 400;
      color: var(--navy);
      font-size: clamp(16px, 2.0vw, 30px);
      margin: clamp(6px, .8vw, 10px) 0 0;
      line-height: 1.25;
    }

    .offer-price {
      font-family: "Montserrat", sans-serif;
      font-weight: 800;
      color: var(--blue);
      font-size: clamp(48px, 7vw, 96px);
      margin: clamp(10px, 1.6vw, 18px) 0 0;
      letter-spacing: .01em;
    }

    #secureimg {
      width: 370px;
    }

    .offer-line-red {

      color: red !important;
      font-size: clamp(16px, 2.0vw, 30px) !important;
    }

    .strike-out {
      text-decoration: line-through !important;
    }

    /* Responsive stacking */
    @media (max-width: 820px) {
      .offer-inner {
        flex-direction: column;
      }

      .offer-product {
        flex-basis: auto;
        max-width: 320px;
      }

      .offer-copy {
        text-align: center;
        padding-right: 0;
      }

    }

    @media (max-width: 550px) {
      .offer-product img {
        max-width: 78% !important;
      }

      #wrapper .wait p {

        margin: 0 0 12px 0;
      }

      .offer-top {
        font-size: 5vw;
      }

      .offer-line2 {
        margin-top: 10px !important;
      }

      .offer-red {
        font-size: 17px !important;
      }

      .offer-line-red {
        margin-top: 10px !important;
      }
    }

    /* FULL-SCREEN UPSELL ON SMALL MOBILE */
    @media (max-width: 500px) {

      html,
      body {
        height: 100%;
        margin: 0;
      }
     body {

        padding-top: constant(safe-area-inset-top);
        padding-right: constant(safe-area-inset-right);
        padding-bottom: constant(safe-area-inset-bottom);
        padding-left: constant(safe-area-inset-left);

        padding-top: env(safe-area-inset-top);
        padding-right: env(safe-area-inset-right);
        padding-bottom: env(safe-area-inset-bottom);
        padding-left: env(safe-area-inset-left);
      }

      .forDesktop {
        display: none;
      }

      .forMobile {
        display: block;
      }

      #wrapper {
        padding-bottom: 0;
        /* remove extra space below */
      }

      .wait {
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      .offer-block {
        height: 65vh;
  
        max-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        /* Vertical center */
        padding: 16px 14px;
        margin: 10px 6px;
        box-sizing: border-box;
      }

      .offer-inner {
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 14px;
      }

      .offer-block {
        height: 65svh;
        /* “small viewport height” (safe, visible area) */
        height: 65dvh;
        /* “dynamic viewport height” (updates as bars show/hide) */
        max-height: 100dvh;
        overflow: hidden;
        /* prevents weird overflow outside dashed border */
      }

      .offer-inner {
        height: 100%;
      }

      .offer-product img {
        max-height: 32vh;
        /* Scale bottle to screen */
        width: auto;
        height: auto;
      }

      .offer-product img {
        max-height: 28dvh;
      }

      .offer-copy {
        text-align: center;
        padding: 0;
      }

      .offer-price {
        font-size: 12vw;
        /* Big but responsive */
      }

      .arrow-inner {
        display: none;
        /* Hide arrow on small screens */
      }

      #submit-btn {
        width: 92%;
        max-width: 420px;
        font-size: 1.2em;
        margin-top: 14px;
        height: 10svh;
      }


      .bottom {
        margin-bottom: 10px;
      }


      .offer-block {
        height: calc(100svh - 20svh - 10svh);
        /* “small viewport height” (safe, visible area) */
        height: calc(100dvh - 20dvh - 10dvh);
        /* “dynamic viewport height” (updates as bars show/hide) */
        max-height: 100dvh;
        overflow: hidden;
        /* prevents weird overflow outside dashed border */
      }
    }

    @media screen and (max-height: 600px) {

      /* CSS rules to be applied when the viewport height is less than 650px */
      .offer-block {
        height: 100vh;

      }
    }

    @media only screen and (min-device-width: 393px) and (max-device-width: 393px) and (min-device-height: 852px) and (max-device-height: 852px) and (-webkit-min-device-pixel-ratio: 3) {
      .offer-block {
        height: 61vh;
      }
    }
  </style>
  </style>


</head>

<body>
  <?php include 'general/__gtag_script__.tpl';
     perform_body_tag_open_actions(); ?>
  <p id="loading-indicator" style="display:none;">Processing...</p>
  <div id="wrapper">
    <!-- <div class="thanks-purchase">
      <h1>Thank you for your purchase!</h1>
      <p>We hope you enjoy the benefits of our <br class="br-mobile"> Age Defying Cream</p>
    </div> -->
    <div class="wait">
      <h1>Wait! Your order is not complete</h1>
      <p>Customers also purchased our <br class="br-mobile">Vitamin C Cleanser.</p>
      <!-- <p>Customers also purchased RevEye Ageless Eye Cream</p> -->
      <div class="form-wrap">

        <!-- <form name="is-upsell" class="is-upsell" accept-charset="utf-8" enctype="application/
            <input type="hidden" name="limelight_charset" id="limelight_charset" value="utf-8" />
            <input type="hidden" name="campaignId" value="[[campaignId]]" />
            <input type="hidden" name="sessionId" id="sessionId" value="[[sessionId]]">   -->

        <form name="is-upsell" class="is-upsell" accept-charset="utf-8"
          enctype="application/x-www-form-urlencoded;charset=utf-8">
          <input type="hidden" name="limelight_charset" id="limelight_charset" value="utf-8" />
          <input type="hidden" name="campaigns[15][id]" id="dynamic_input" value="15">
          <p id="loading-indicator" style="display:none;">Processing...</p>
        </form>
        <section class="offer-block">
          <div class="offer-inner">
            <img class="arrow-inner" src="<?= $path['images'] ?>/arrow_red.png" alt="" />
            <div class="offer-product">
              <!-- Replace with your bottle PNG (transparent background recommended) -->
              <img src="<?= $path['images'] ?>/up3-image.png" alt="">
            </div>

            <div class="offer-copy">
              <h2 class="offer-top">Limited Offer - 8 Remaining</h2>
              <p class="offer-red">GET CLEAN & BEAUTIFUL SKIN</p>
              <!-- <p class="offer-with">With Hyaluronic Acid + Collagen</p> -->
              <p class="offer-title">Vitamin C Cleanser</p>

              <!-- <p class="offer-line1">Add a <b>SAMPLE</b> bottle</p> -->
              <p class="offer-line-red"><span class="strike-out">$49.90 value</span></p>
              <p class="offer-line2">Yours for only</p>
              <div class="offer-price">$24.95</div>
            </div>
          </div>
        </section>
        <input type="submit" id="submit-btn" value="Complete Checkout" />

        <p id="loading-indicator" style="display:none;">Processing...</p>
        <p id="crm-response-container" style="display:none;">Limelight messages will appear here...</p>
        </form>
      </div>
    </div>

    <div class="more-info">
      <!-- <div > -->
      <img class="award" src="<?= $path['images'] ?>/award_upsell3.png" alt="" />
      <!-- </div> -->
      <div class="bottom forMobile">
        <a href="upsell4.php"><i class="fa fa-times-circle"></i> <span>No thanks, I decline this offer</span></a>
      </div>
      <!-- <div> -->
      <img class="award award-right" src="<?= $path['images'] ?>/award_right.jpg" alt="" />
      <!-- </div> -->

    </div>
    <div class="bottom forDesktop">
      <a href="upsell4.php"><i class="fa fa-times-circle"></i> <span>No thanks, I decline this offer</span></a>
    </div>
    <h2>We Care About Your Privacy</h2>
    <div class="secure"><img id="secureimg" src="<?= $path['images'] ?>/secure.png" alt="" /></div>
    <div id="throbber">
      <div class="throbber-overlay"></div>
      <div class="throbber-front">
        <h3 class="throbber-text"></h3>
        <div class="throbber"></div>
      </div>
      <div class="throbber-v-align"></div>
    </div>
    <?php require_once 'general/__scripts__.tpl' ?>
    <?php require_once 'general/__analytics__.tpl' ?>
    <?php perform_body_tag_close_actions(); ?>
    <script src="<?= $path['assets_js'] ?>/jquery.magnific-popup.js"></script>
    <script>

      $(document).ready(function (e) {


        $('#submit-btn').on('click', function (e) {
          e.preventDefault();
          $('.is-upsell').submit();
        });





        $('#btn-nothanks').on('click', function () {
          $('#loading-indicator').show();
          window.location.href = "upsell4.php";
        });

      });

    </script>
</body>

</html>