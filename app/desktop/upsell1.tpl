<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once 'general/__header__.tpl' ?>

    <meta charset="utf-8">
    
    <link type="text/css" rel="stylesheet" href="<?= $path['css'] ?>/extras.css">
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?= $path['css'] ?>/throbber.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= $path['assets_css'] ?>/magnific-popup.css">

    <!-- <script type="text/javascript" src="<?= $path['images'] ?>/form-upsale.js"></script>
    <script type="text/javascript" src="<?= $path['images'] ?>/throbber.js"></script> -->
    
  </head>
  <body>
    <?php include 'general/__gtag_script__.tpl';
     perform_body_tag_open_actions(); ?>
    <p id="loading-indicator" style="display:none;">Processing...</p>
    <div id="wrapper">
      <div class="thanks-purchase">
        <h1>Thank you for your purchase!</h1>
        <h2>We hope you enjoy the benefits of the  RevSkin you ordered.</h2>
      </div>
      <div class="wait">
        <h1>Wait! Your order is not complete</h1>
        <p>Customers also purchased RevEye Ageless Eye Cream</p>
        <div class="form-wrap">
          <img class="arrow" src="<?= $path['images'] ?>/arrow_red.png" alt=""/>
          <!-- <form name="is-upsell" class="is-upsell" accept-charset="utf-8" enctype="application/
            <input type="hidden" name="limelight_charset" id="limelight_charset" value="utf-8" />
            <input type="hidden" name="campaignId" value="[[campaignId]]" />
            <input type="hidden" name="sessionId" id="sessionId" value="[[sessionId]]">   -->
      
            <form name="is-upsell" class="is-upsell" accept-charset="utf-8"
            enctype="application/x-www-form-urlencoded;charset=utf-8">
            <input type="hidden" name="limelight_charset" id="limelight_charset" value="utf-8" />
            <input type="hidden" name="campaigns[7][id]" id="dynamic_input" value="2">
            <p id="loading-indicator" style="display:none;">Processing...</p>
        </form>
            <div id="upsell_img_block">   
            <img src="<?= $path['images'] ?>/RevEye_V2.png" id="upsell" alt=""/>
            </div>
            <input type="submit" id="submit-btn" value="Complete Checkout"/>
            <p id="loading-indicator" style="display:none;">Processing...</p>
            <p id="crm-response-container" style="display:none;">Limelight messages will appear here...</p>
          </form>
        </div>
      </div>
      <div class="more-info">
        <img class="award" src="<?= $path['images'] ?>/award_left_1.png" alt=""/>
        <img class="award award-right" src="<?= $path['images'] ?>/award_right.jpg"  alt=""/>
      </div>      
      <h2>We Care About Your Privacy</h2>
      <div class="secure"><img src="<?= $path['images'] ?>/secure.png" alt=""/></div>
      <div class="bottom">
        <a href="upsell2.php"><i class="fa fa-times-circle"></i> <span>No thanks, I decline this offer</span></a> 



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
