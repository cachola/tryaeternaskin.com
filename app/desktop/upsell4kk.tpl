<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="UTF-8">

    <?php require_once 'general/__header__.tpl' ?>

    <link type="text/css" rel="stylesheet" href="<?= $path['css'] ?>/extras.css">

    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="<?= $path['assets_css'] ?>/magnific-popup.css">

    <!-- <link type="text/css" rel="stylesheet" href="<?= $path['css'] ?>/throbber.css"> -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->


    <!-- <script type="text/javascript" src="<?= $path['js'] ?>/form-upsale.js"></script>

    <script type="text/javascript" src="<?= $path['js'] ?>/throbber.js"></script> -->

    <meta name="viewport" content="width=device-width, initial-scale=1">    

  </head>

  <body>

    <?php include 'general/__gtag_script__.tpl';
     perform_body_tag_open_actions(); ?>
    <p id="loading-indicator" style="display:none;">Processing...</p>

    <div id="wrapper">

      <div class="thanks-purchase">

        <h1>Thank you for your purchase!</h1>

        <h2>We hope you enjoy the benefits of the RevSkin you ordered.</h2>

      </div>

      <div class="wait">

        <h1>Wait! Your order is not complete</h1>

        <p>Customers also purchased RevLips Booster</p>

        <div class="form-wrap">

          <img class="arrow" src="<?= $path['images'] ?>/arrow_red.png" alt=""/>

          <form name="is-upsell" class="is-upsell" accept-charset="utf-8"
          enctype="application/x-www-form-urlencoded;charset=utf-8">
          <input type="hidden" name="limelight_charset" id="limelight_charset" value="utf-8" />
          <input type="hidden" name="campaigns[9][id]" id="dynamic_input" value="4">
          <p id="loading-indicator" style="display:none;">Processing...</p>
      </form>
          <!-- <form name="is-upsell" class="is-upsell" accept-charset="utf-8" enctype="application/

            <input type="hidden" name="limelight_charset" id="limelight_charset" value="utf-8" />

            <input type="hidden" name="campaignId" value="[[campaignId]]" />

            <input type="hidden" name="sessionId" id="sessionId" value="[[sessionId]]">       -->

            <a><img class="pointer-class" src="<?= $path['images'] ?>/RevLips_V2.png" alt=""/> </a>

            <input type="submit" id="submit-btn" value="Complete Checkout"/>

            <p id="loading-indicator" style="display:none;">Processing...</p>

            <p id="crm-response-container" style="display:none;">Limelight messages will appear here...</p>

          <!-- </form> -->


        </div>

      </div>

      <div class="more-info">

        <img class="award" src="<?= $path['images'] ?>/award_left_3.png" alt=""/>

        <img class="award award-right" src="<?= $path['images'] ?>/award_right.jpg" alt=""/>

      </div>      

      <h2>We Care About Your Privacy</h2>

      <div class="secure"><img src="<?= $path['images'] ?>/secure.png" alt=""/></div>

      <div class="bottom">

        <a href="upsell4.php""><i class="fa fa-times-circle"></i> <span>No thanks, I decline this offer</span></a>        

      </div>

    </div>

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
         $(document).ready(function () {
            $('.contact').magnificPopup({
                type: 'iframe',
                mainClass: 'contact-page',
            });

            $('.privacy-link').magnificPopup({
                type: 'iframe',
                mainClass: 'privacy-page',
            });
          });
      $('#submit-btn').on('click', function (e) {
        e.preventDefault();

        $('.is-upsell').submit();
    });

    $('#btn-nothanks').on('click', function () {
                $('#loading-indicator').show();
                window.location.href = "upsell4.php";
            });

        </script>

  </body>

</html>

