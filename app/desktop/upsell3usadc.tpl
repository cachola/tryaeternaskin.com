<!doctype html>
<html>
<head>
            <?php require_once 'general/__header__.tpl';?>

<link rel="stylesheet" type="text/css" href="<?= $path['css']; ?>/upsell.css">
<style>
.up-leftBx {
    width: 100%;
}
.up-btn {

width: 40%
  }
</style>
</head>

<body>
        <?php include 'general/__gtag_script__.tpl';
                perform_body_tag_open_actions(); ?>
        <p id="loading-indicator" style="display:none;">Processing...</p>
<!-- TOP STRIP -->
<div class="top-strip" style="display: none;">
    <div class="container">
        <p>FREE SHIPPING ON ALL ORDERS!</p>
    </div>
</div>

<!-- LOGO SECTION -->
<div class="logo-sec" style="display: none;">
    <div class="container">
        <img src="<?= $path['images']; ?>/logo.png" alt="" class="up-log">
    </div>
</div>

<!-- BANNER SECTION -->
<div class="up-bnr up4-bnr">
    <div class="container">
        <div class="bnr-txt">
            <h3><img src="<?= $path['images']; ?>/lft-arw.png" alt="" class="lft-arw tadda"> Wait! Your Order Is Not Complete
                <img src="<?= $path['images']; ?>/rgt-arw.png" alt="" class="rgt-arw taddaR"></h3>
            <p>You’ve Qualified For Our New <br class="forMob">Customer Special Offer!</p>
        </div>
        
        <!-- CONTENT BOX -->
        <div class="cont-bx">
            <div class="up-leftBx">
                <p class="ups1-txt1" style="color:#0176a1;">Add USA Discount Club 7-Day
                FREE Trial</p>
                <div style="text-align: center;">
                <!-- <div class="up-rghtBx up4-rghtBx forMob"> -->
                    <img src="<?= $path['images']; ?>/up4-usa.png" class="up4-prod  forMob">
                <!-- </div> -->
                <!-- <div class="up-rghtBx up4-rghtBx hide-mob"> -->
                    <img src="<?= $path['images']; ?>/up4-usa-desk.png" class="up4-prod hide-mob">
                <!-- </div> -->
            </div>
                <!-- <p style="font-size: 22px;margin-top: 20px;"><b>Get The Best Deals Locally & Online</b></p>
                <ul class="up-s1-list up4-s1-list">
                    <li><b>Shopping</b> Your Favorite Top Brands & Retail Partners</li>
                    <li><b>Hotels</b> Save More The Next Time You Check In</li>
                    <li><b>Entertainment</b> Discounts on Movies, Parks, Sports & More!</li>
                </ul> -->
                
                <div class="up-prc-sec">
                    <div class="prc-Dv">
                        <p class="prc-txt1">Retail Price</p>
                        <p class="rglr-prc"><span class="strikeout">$19.97</span></p>
                    </div>
                    <div class="prc-Dv prc-Dv2">
                        <p class="prc-txt1">Offer Price</p>
                        <p class="rglr-prc ofr-prc">FREE</p>
                    </div>
                </div>
                <div class="clearall"></div>
                <a href="javascript:void(0);" class="up-btn pulse">Yes! Add To My Order!</a>
                <div class="clearall"></div>
                <a href="javascript:void(0);" class="no-thk">No thank you</a>
                <p class="secure-txt"><img src="<?= $path['images']; ?>/up-lock.png">Secure 256 Bit Encrypted Connection</p>
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

$(".up-btn").click(function(e) {
            e.preventDefault();
            $('#loading-indicator').show(); 
            $.ajax({
                        url: 'ajaxusadc.php',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            console.log('ajaxusadc done')
                            window.location.href='authorize.php';
                        },
                        fail: function () {
                            console.log('ajaxusadc fail')
                            window.location.href='authorize.php';
                        }
                    });
           
        });
        $('.no-thk').on('click', function () {
                $('#loading-indicator').show(); 
                window.location.href = "authorize.php";
            });





    </script>
</body>
</html>
