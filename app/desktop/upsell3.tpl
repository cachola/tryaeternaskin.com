<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once 'general/__header__.tpl' ?>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pageTitle; ?></title> -->
    <link type="text/css" rel="stylesheet" href="<?= $path['css'] ?>/extras.css">
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
  </head>
<body>
  <?php include 'general/__gtag_script__.tpl';
  perform_body_tag_open_actions(); ?>
  <p id="loading-indicator" style="display:none;">Processing...</p>
    <div id="wrapper">
      <div class="thanks-purchase">
        <h1>Thank you for your purchase!</h1>
        <h2>We hope you enjoy the benefits of the RevSkin.</h2>
      </div>
      <div class="wait">
        <h1>Wait! Your order is not complete</h1>
        <p>Customers also purchased Aeterna Sleep Plus Collagen Cream</p>
        <div class="form-wrap">
          <img class="arrow" src="<?= $path['images'] ?>/arrow_red.png" alt=""/>
          <form name="is-upsell" class="is-upsell upsale-form" accept-charset="utf-8" enctype="application/x-www-form-urlencoded;charset=utf-8">
            <input type="hidden" name="campaigns[1][id]" id="dynamic_input" value="15">
            <p id="loading-indicator" style="display:none;">Processing...</p>
          <p id="crm-response-container" style="display:none;">Limelight messages will appear here...</p>
            
            <a href="javascript:void(0);" class="submitAll"><img src="<?= $path['images'] ?>/RevLips_Vert1.png" alt=""/></a>
            <!-- <input type="" style="text-align: center;" class="submitAll" value="Complete Checkout >>"/> -->
                  <a href="javascript:void(0);" class="up-btn submitAll"  id="submit-btn" >Complete Checkout >></a>
            <div class="bottom">
        <a href="upsell4.php"><i class="fa fa-times-circle"></i> <span>No thanks, I decline this offer</span></a>        
      </div>
          </form>
        </div>
      </div>
      <div class="more-info">
        <img class="award" src="<?= $path['images'] ?>/award_left_3.png" alt=""/>
        <img class="award" src="<?= $path['images'] ?>/award_right.jpg" alt=""/>
      </div>      
      <h2>We Care About Your Privacy</h2>
      <div class="secure"><img src="<?= $path['images'] ?>/secure.png" alt=""/></div>
      
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
<script>
    $('.submitAll').on('click', function () {
      $('.is-upsell').submit();
  });

  $('#btn-nothanks').on('click', function () {
              $('#loading-indicator').show();
              window.location.href = "upsell4.php";
          });

      </script>

</body>
</html>
