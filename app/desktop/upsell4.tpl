<!doctype html>
<html>
<head>
            <?php require_once 'general/__header__.tpl';?>

<link rel="stylesheet" type="text/css" href="<?= $path['css']; ?>/upsell.css">

</head>

<body>
        <?php include 'general/__gtag_script__.tpl';
                perform_body_tag_open_actions(); ?>
        <p id="loading-indicator" style="display:none;">Processing...</p>
<!-- TOP STRIP -->
<!-- <div class="top-strip">
    <div class="container">
        <p>FREE SHIPPING ON ALL ORDERS!</p>
    </div>
</div> -->

<!-- LOGO SECTION -->
<div class="logo-sec"  style="display: none;">
    <div class="container">
        <img src="<?= $path['images']; ?>/logo-2.png" alt="" class="up-log">
    </div>
</div>

<!-- BANNER SECTION -->
<div class="up-bnr up3-bnr">
    <div class="container">
        <div class="bnr-txt">
            <h3><img src="<?= $path['images']; ?>/lft-arw.png" alt="" class="lft-arw tadda"> Wait! Your Order Is Not Complete <img src="<?= $path['images']; ?>/rgt-arw.png" alt="" class="rgt-arw taddaR"></h3> 
            <p>Add Rush Processing To Ensure <br class="forMob">Fastest Delivery Possible</p> 
        </div>
        
        <!-- CONTENT BOX -->
        <div class="cont-bx">
            <div class="up-leftBx">
                <p class="ups1-txt1" style="color:#c4a26c;">Add Rush Processing & <br>Get Your Order Immediately</p>
                <div class="up-rghtBx up3-rghtBx forMob">
                    <img src="<?= $path['images']; ?>/up3-prod.png" class="up3-prod">
                </div>
                <ul class="up-s1-list up3-s1-list">
                    <li>Avoid Shipping Delays</li>
                    <li>Get Your Order Processed First</li>
                    <li>Faster Delivery for Faster Results!</li>
                </ul>
                <form name="is-upsell" class="is-upsell" accept-charset="utf-8" enctype="application/x-www-form-urlencoded;charset=utf-8">
                    <input type="hidden" name="campaigns[1][id]" id="dynamic_input" value="16">
                <a href="javascript:void(0);" class="up-btn pulse">Send My Products Now!</a>
                </form>
                <div class="up-prc-sec">

                    <div class="prc-Dv prc-Dv2">
                        <p class="rglr-prc ofr-prc">$4.95</p>
                    </div>
                </div>
                <p class="up-txt23">This Price Will Never Be Available Again</p>
                <div class="clearall"></div>

                <div class="clearall"></div>
                <a href="javascript:void(0);" class="no-thk-gray">No thank you</a>
                <p class="secure-txt"><img src="<?= $path['images']; ?>/up-lock.png">Secure 256 Bit Encrypted Connection</p>
            </div>
            
            <div class="up-rghtBx up3-rghtBx hide-mob">
                <img src="<?= $path['images']; ?>/up3-prod.png" class="up3-prod">
            </div>
        </div>
    </div>
</div>

<!-- FOOTER SECTION -->
<div class="footer">
    <div class="container">
    	<img src="<?= $path['images']; ?>/logo.png" alt="" class="ftr-up-logo">
        
            <p class="ftr-txt">
                <a  href="javascript:void(0);"
                onclick="javascript:openNewWindow('page-privacy.php','modal');">Privacy Policy</a> | <a href="javascript:void(0);"
                onclick="javascript:openNewWindow('page-terms.php','modal');">Terms & Conditions</a> |
                
                <a  href="javascript:void(0);"
                onclick="javascript:openNewWindow('page-contact.php','modal');">Contact Us</a> 
                
              </p>
        
        <p class="ftr-txt">Copyright &copy; <script type="text/javascript">var year = new Date();document.write(year.getFullYear());</script> My Super Gummies.<br class="forMob"> All rights reserved.</p>
    </div>
</div>
    <?php require_once 'general/__scripts__.tpl' ?>
    <?php require_once 'general/__analytics__.tpl' ?>
    <?php perform_body_tag_close_actions(); ?>
    <script>
      $('.up-btn').on('click',function(e){
        $('#loading-indicator').show();
        $("form[name='is-upsell']").submit(); 
      });
      $('.no-thk-gray').on('click',function(e){
        e.preventDefault();
        $('#loading-indicator').show();
        window.location.href="authorize.php";
      });
        $(document).ready(function(){
           
     
        $('.contact').magnificPopup({
            type: 'iframe',
            mainClass: 'contact-page',
        });
        $('.cvv').magnificPopup({
            type: 'iframe',
            mainClass: 'cvv-page',
        });
        $('.privacy-link').magnificPopup({
            type: 'iframe',
            mainClass: 'privacy-page',
        });
           });
    </script>
</body>
</html>
