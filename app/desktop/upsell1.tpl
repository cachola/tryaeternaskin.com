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
      width: 100%;
      height: auto;
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
      font-size: clamp(24px, 2.4vw, 30px);
      letter-spacing: .2px;
      margin: 0 0 clamp(10px, 1.2vw, 18px);
    }

    .offer-red {
      font-family: "Montserrat", sans-serif;
      font-weight: 700;
      color: var(--red);
      font-size: clamp(20px, 3.0vw, 29px);
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
      font-size: clamp(20px, 2.6vw, 29px);
      margin: 0 0 clamp(10px, 1.2vw, 18px);
    }

    .offer-title {
      font-family: "Open Sans", sans-serif;
      font-weight: 800;
      color: var(--red) !important;
      text-transform: uppercase;
      font-size: clamp(22px, 3.1vw, 36px);
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
    }
  </style>


</head>

<body>
  <?php include 'general/__gtag_script__.tpl';
     perform_body_tag_open_actions(); ?>
  <p id="loading-indicator" style="display:none;">Processing...</p>
  <div id="wrapper">
    <!-- <div class="thanks-purchase">
      <h1>Thank you for your purchase!</h1>
      <p>We hope you enjoy the benefits of our<br class="br-mobile"> Age Defying Cream.</p>
    </div> -->
    <div class="wait">
      <h1>Wait! Your order is not complete</h1>
      <p>Customers also purchased our<br class="br-mobile"> Hyaluronic Acid + Collagen Anti Age Serum.</p>
      <!-- <p>Customers also purchased RevEye Ageless Eye Cream</p> -->
      <div class="form-wrap">

        <!-- <form name="is-upsell" class="is-upsell" accept-charset="utf-8" enctype="application/
            <input type="hidden" name="limelight_charset" id="limelight_charset" value="utf-8" />
            <input type="hidden" name="campaignId" value="[[campaignId]]" />
            <input type="hidden" name="sessionId" id="sessionId" value="[[sessionId]]">   -->

        <form name="is-upsell" class="is-upsell" accept-charset="utf-8"
          enctype="application/x-www-form-urlencoded;charset=utf-8">
          <input type="hidden" name="limelight_charset" id="limelight_charset" value="utf-8" />
          <input type="hidden" name="campaigns[13][id]" id="dynamic_input" value="13">
          <p id="loading-indicator" style="display:none;">Processing...</p>
        </form>
        <section class="offer-block">
          <div class="offer-inner">
            <img class="arrow-inner" src="<?= $path['images'] ?>/arrow_red.png" alt="" />
            <div class="offer-product">
              <!-- Replace with your bottle PNG (transparent background recommended) -->
              <img src="<?= $path['images'] ?>/up1-image.png" alt="RevEye Ageless Eye Cream">
            </div>

            <div class="offer-copy">
              <h2 class="offer-top">Limited Offer - 7 Remaining</h2>
              <p class="offer-red">MAXIMIZE YOUR RESULTS</p>
              <p class="offer-with">With Hyaluronic Acid + Collagen</p>
              <p class="offer-title">Anti Age Serum</p>

              <p class="offer-line1">Add a <b>SAMPLE</b> bottle</p>
              <p class="offer-line2">Just pay shipping of</p>
              <div class="offer-price">$9.95</div>
            </div>
          </div>
        </section>
        <input type="submit" id="submit-btn" value="Complete Checkout" />
        <div class="bottom">
          <a href="upsell2.php"><i class="fa fa-times-circle"></i> <span>No thanks, I decline this offer</span></a>
        </div>
        <p id="loading-indicator" style="display:none;">Processing...</p>
        <p id="crm-response-container" style="display:none;">Limelight messages will appear here...</p>
        </form>
      </div>
    </div>

    <div class="more-info">
      <!-- <div > -->
      <img class="award" src="<?= $path['images'] ?>/award_upsell1.png" alt="" />
      <!-- </div> -->
      <!-- <div> -->
      <img class="award award-right" src="<?= $path['images'] ?>/award_right.jpg" alt="" />
      <!-- </div> -->

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
          window.location.href = "upsell2.php";
        });

      });

    </script>
</body>

</html>