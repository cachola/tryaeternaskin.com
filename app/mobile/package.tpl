<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once 'general/__header__.tpl' ?>

    <link href="<?= $path['css'] ?>/app.css" rel="stylesheet" />
    <link
      href="<?= $path['css'] ?>/inner.css"
      type="text/css"
      rel="stylesheet"
    />
    <link
      href="<?= $path['css'] ?>/btn-animation.css"
      type="text/css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald&display=swap"
      rel="stylesheet"
    />
    <style>
      .pack-Opt span {
        position: absolute;
        width: 24px;
        height: 24px;
        background: url(../app/mobile/images/check.png) no-repeat center center;
        left: 17px;
        top: 50%;
        margin-top: -12px;
      }

      .checked.pack-Opt span {
        background: url(../app/mobile/images/checked.png) no-repeat center center;
      }
      .subscribe,
      .onetime {
        /* float: left; */
        cursor: pointer;
        width: 90%;
        border: 1px solid #fd4e58;
        border-radius: 12px;
        height: 40px;
        background: #fff;
        font-family: "Mark Pro";
        font-weight: bold;
        font-size: 22px;
        line-height: 35px;
        text-align: center;
        /* padding: 0 10px 0 10px; */
        position: relative;
        margin: 10px auto;
        color: #fd6f03;
      }
      .onetime {
        /* float: right; */
        margin-bottom: 20px;
      }
      .checked {
        color: #fff;
        border: 1px solid #e2a553;
        background: rgb(214, 161, 79);
        background: linear-gradient( 90deg, #f5e956 0%,#f0bd44 25% ,#f0bd44 35%,#f0bd44 65%,#d8453e 100% );
      }
      .show-767 {
        display: none;
      }

      .retail-block {
        background: #f704b6;
        width: 90%;
        float: right;
      }
      .package3 .retail-block {
        background: gold;
      }
      .shipping-block {
        color: white;
      }
      .package3 .shipping-block {
        color: black;
      }
      @media only screen and (max-width: 767px) {
        .optbx {
          width: 100%;
          background: none;
          padding: 0;
        }
        /* .subscribe,
  .onetime {
	line-height: 18px; 
	padding: 2px 0 0 50px;
  } */
        .show-767 {
          display: block;
        }
      }
      @media only screen and (max-width: 479px) {
        .optbx {
          width: 100%;
        }

        /* .subscribe,
  .onetime {
	font-size: 16px;
	line-height: 20px;
	padding: 4px 0 0 45px;
  } */
        .pack-Opt span {
          left: 10px;
        }
      }

      @media only screen and (max-width: 359px) {
        .subscribe,
        .onetime {
          font-size: 15px;
          line-height: 18px;
          padding: 4px 0 0 26px;
          height: 24px;
        }
      }
    </style>
  </head>

  <body style="max-width: 600px; margin: 0 auto">
    <?php perform_body_tag_open_actions(); ?>
    <p id="loading-indicator" style="display: none">Processing...</p>
    <div id="app">
      <div class="choose-p" id="pagecontainer">
        <div id="top-1">
          <center>
            <img
              src="<?= $path['images'] ?>/logo2-strips.png"
              style="width: 158px; margin: 6px 0 10px 0"
            />
          </center>
          <div class="shipping-container">
            <span><strong>Fast, Free Shipping</strong> For A Limited Time</span>
          </div>
          <div class="breadcrumbs">
            <ul class="breadcrumbs__list">
              <li class="breadcrumbs__item">
                <span>Qualify Now</span>
              </li>
              <li
                class="breadcrumbs__item breadcrumbs__item_2 breadcrumbs__item_active"
              >
                <span>Select Package</span>
              </li>
              <li class="breadcrumbs__item breadcrumbs__item_3">
                <span>Confirm Order</span>
              </li>
            </ul>
          </div>

          <p style="text-align: center; padding-top: 13px">
            <b style="color: #000; font-size: 18px">
              <span style="color: #80399f">Approved</span>
            </b>
          </p>
        </div>
        <div class="linebreak" style="margin: 11px 0 13px"></div>
        <div class="optbx dsplay">
          <div class="subscribe pack-Opt checked"><span></span>Subscribe & Save</div>
          <div class="onetime pack-Opt"><span></span>One-Time Purchase</div>
        </div>

        <!-- 5 bottle -->
        <div
          class="package package1 buy-package package-selected selected"
          data-cbid="3"
          data-package-price="179.97"
          data-prod-count="5"
        >
          <div class="package__left">
            <span class="package__name">Package 1</span>
            <span class="package__coll">3 BOTTLES</span>
            <span class="package__free">+ Get 2 Free!**</span>
            <span class="package__some">same as</span>
            <span class="package__price">
              <p style="display: inline-block" class="price">$35.99</p>
              <span>/bottle</span>
            </span>
            <span class="package__stock">In Stock - Sell Out Risk: High</span>
            <span class="save-label">save over <span>40%</span></span>
          </div>
          <div class="package__right">
            <div class="bottle-block clearfix">
              <div class="package-images__item">
                <img
                  alt=""
                  src="<?= $path['images'] ?>/product.png"
                  class="prod-btl1"
                />
                <img
                  alt=""
                  src="<?= $path['images'] ?>/product.png"
                  class="prod-btl2"
                />
                <img
                  alt=""
                  src="<?= $path['images'] ?>/product.png"
                  class="prod-btl3"
                />
              </div>
              <img
                alt=""
                src="<?= $path['images'] ?>/plus-icon.png"
                class="chk-plus"
              />
              <div class="package-images__item">
                <img
                  alt=""
                  src="<?= $path['images'] ?>/product.png"
                  class="prod-btl4"
                />
                <img
                  alt=""
                  src="<?= $path['images'] ?>/product.png"
                  class="prod-btl5"
                />
              </div>
            </div>
            <div class="retail-block">
              <!-- <span class="package__retail">Retail: <span class="retail-price">$66.23</span>/bottle</span> -->
              <span class="shipping-block"><span>Free shipping</span></span>
            </div>
          </div>
          <span class="best-choise"
            >Best <br />
            choice</span
          >
          <a href="javascript:void(0);" class="submit-button"
            ><span class="package-btn btn_pulse"
              >yes - choose this package <span>»</span></span
            ></a
          >
        </div>

        <div class="linebreak" style="margin: 13px 0 12px"></div>

        <div
          class="package package2 buy-package"
          data-cbid="2"
          data-package-price="119.98"
          data-prod-count="3"
        >
          <div class="package__left">
            <span class="package__name">Package 2</span>
            <span class="package__coll">2 BOTTLES</span>
            <span class="package__free">+ Get 1 Free!**</span>
            <span class="package__some">same as</span>
            <span class="package__price">
              <p style="display: inline-block" class="price">$39.99</p>
              <span>/bottle</span>
            </span>
            <span class="package__stock">In Stock - Sell Out Risk: High</span>
          </div>
          <div class="package__right">
            <div class="bottle-block clearfix">
              <div class="package-images__item">
                <img
                  alt=""
                  src="<?= $path['images'] ?>/product.png"
                  class="prod-btl1"
                  style="left: 48%"
                />
                <img
                  alt=""
                  src="<?= $path['images'] ?>/product.png"
                  class="prod-btl3"
                  style="left: 28%"
                />
              </div>
              <img
                alt=""
                src="<?= $path['images'] ?>/plus-icon.png"
                class="chk-plus"
              />
              <div class="package-images__item">
                <img
                  alt=""
                  src="<?= $path['images'] ?>/product.png"
                  class="prod-btl5"
                />
              </div>
              <div class="save-block">
                <span class="save-block__title">Save</span>
                <span class="save-block__price save-price">$59.99</span>
              </div>
            </div>
            <div class="retail-block">
              <!-- <span class="package__retail">Retail: <span class="retail-price">$74.95</span>/bottle</span> -->
              <span class="shipping-block"><span>Free shipping</span></span>
            </div>
          </div>

          <a href="javascript:void(0);" class="submit-button"
            ><span class="package-btn"
              >yes - choose this package <span>»</span></span
            ></a
          >
        </div>

        <div class="linebreak" style="margin: 13px 0 12px"></div>
        <div
          class="package package3 buy-package"
          data-cbid="1"
          data-package-price="59.99"
          data-prod-count="1"
        >
          <div class="package__left">
            <span class="package__name">Package 3</span>
            <span class="package__coll">1 BOTTLE</span>
            <!-- <span class="package__free">+ Get 1 Free!*</span> -->
            <span class="package__some">same as</span>
            <span class="package__price">
              <p style="display: inline-block" class="price">$59.99</p>
              <span>/bottle</span>
            </span>
            <span class="package__stock">In Stock - Sell Out Risk: High</span>
          </div>
          <div class="package__right">
            <div class="bottle-block clearfix">
              <div class="package-images__item">
                <img
                  alt=""
                  src="<?= $path['images'] ?>/product.png"
                  class="prod-btl1"
                  style="left: 100%"
                />
              </div>
              <!-- <img
                alt=""
                src="<?= $path['images'] ?>/plus-icon.png"
                class="chk-plus"
              />
              <div class="package-images__item">
                <img
                  alt=""
                  src="<?= $path['images'] ?>/product.png"
                  class="prod-btl5"
                />
              </div> -->
              <!-- <div class="save-block">
                <span class="save-block__title">Save</span>
                <span class="save-block__price save-price">$30.00</span>
              </div> -->
            </div>
            <div class="retail-block">
              <!-- <span class="package__retail ">Retail: <span class="retail-price">$89.99</span>/bottle</span> -->
              <span class="shipping-block"><span>Priority shipping</span></span>
            </div>
          </div>

          <a href="javascript:void(0);" class="submit-button"
            ><span class="package-btn"
              >yes - choose this package <span>»</span></span
            ></a
          >
        </div>

  

        <div class="linebreak" style="margin: 9px 0 12px"></div>
      </div>
      <!-- <div id="top-2">
        <img src="<?= $path['images'] ?>/godaddyimg.png" />
      </div> -->
      <!-- <div class="linebreak" style="margin: 13px 0 12px"></div> -->
      <div id="top-3">
        <img src="<?= $path['images'] ?>/safe.png" />
      </div>
      <div class="linebreak" style="margin: 12px 0 7px"></div>

      <div id="footer">
        <br />
        <center>
          <ul class="terms-links">
            <li>
              <a
                href="javascript:void(0);"
                onclick="javascript:openNewWindow('../page-privacy.php', 'modal');"
                >Privacy Policy |</a
              >
            </li>
            <li>
              <a
                href="javascript:void(0);"
                onclick="javascript:openNewWindow('../page-terms.php', 'modal');"
                >Terms and Conditions |</a
              >
            </li>
            <li>
              <a
                href="javascript:void(0);"
                onclick="javascript:openNewWindow('../page-contact.php', 'modal');"
                >Contact</a
              >
            </li>
          </ul>
          <br />
          <div class="text-center">
            <p>
              Keto Fire Gummies is committed to maintaining the highest quality
              products and the utmost integrity in business practices. All
              products sold on this website are certified by Good Manufacturing
              Practices (GMP), which is the highest standard of testing in the
              supplement industry.
            </p>
            <br />
            <p>
              Notice: The products and information found on this site are not
              intended to replace professional medical advice or treatment.
              These statements have not been evaluated by the Food and Drug
              Administration. These products are not intended to diagnose,
              treat, cure or prevent any disease. Individual results may vary.
            </p>
            <br />
            <p>
              **FREE Bottle(s) Included With Purchase Of Multi-Bottle Packages
            </p>
          </div>
          <br />
        </center>

        <center>
          <div class="text-center">
            <p class="cop-text">
              &copy;
              <script>
                var date = new Date();
                document.write(date.getFullYear());
              </script>
              <span class="product-name">Keto Fire Gummies</span>. All Rights
              Reserved.
            </p>
            <br />
          </div>
        </center>
        <p></p>
      </div>
    </div>
    <?php perform_body_tag_close_actions(); ?>
    <script
      type="text/ecmascript"
      src="<?= $path['assets_js'] ?>/jquery.magnific-popup.js"
    ></script>
    <!-- <script
      type="text/ecmascript"
      src="<?= $path['js'] ?>/lazysizes.min.js"
    ></script>
    <script
      type="text/ecmascript"
      src="<?= $path['js'] ?>/ls.unveilhooks.min.js"
    ></script> -->

    <script
      type="text/javascript"
      src="<?= $path['assets_js'] ?>/places.js"
    ></script>

    <script
      type="text/javascript"
      async
      defer
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_PLACES_API_ID; ?>&libraries=places&callback=initAutocomplete"
    ></script>

    <script type="text/javascript">
      let obj = "";
      var isSubscription = 'true';
      $(".subscribe").click(function (e) {
        isSubscription = 'true';
        $(".onetime").removeClass("checked");
        $(".subscribe").addClass("checked");
        // $(".package3  .save-block").show();

        // $(".package1 .retail-price").html("$89.99");
        $(".package1 .price").html("$35.99");
        $(".package1 .save-price").html("$119.98");
        $(".package1").attr("data-package-price", "$179.97");
        $(".package1").attr("data-cbid", "3");

        // $(".package2 .retail-price").html("$89.99");
        $(".package2 .price").html("$39.99");
        $(".package2 .save-price").html("$59.99");
        $(".package2").attr("data-package-price", "$119.98");
        $(".package2").attr("data-cbid", "2");

        // $(".package3 .retail-price").html("$89.99");
        $(".package3 .price").html("$30.00");
        $(".package3 .save-price").html("$59.99");
        $(".package3").attr("data-package-price", "$59.99");
        $(".package3").attr("data-cbid", "1");

        // $(".pack1btn").attr("data-id", "4");
        // $(".pack2btn").attr("data-id", "5");
        // $(".pack3btn").attr("data-id", "6");
        // setCart();
      });

      $(".onetime").click(function (e) {
        isSubscription='false';
        $(".subscribe").removeClass("checked");
        $(".onetime").addClass("checked");
        // $(".package3  .save-block").hide();

        // $(".package1 .retail-price").html("$89.99");
        $(".package1 .price").html("$53.99");
        $(".package1 .save-price").html("$179.98");
        $(".package1").attr("data-package-price", "$269.97");
        $(".package1").attr("data-cbid", "6");

        // $(".package2 .retail-price").html("$89.99");
        $(".package2 .price").html("$59.99");
        $(".package2 .save-price").html("$89.99");
        $(".package2").attr("data-package-price", "$179.98");
        $(".package2").attr("data-cbid", "5");

        // $(".package3 .retail-price").html("$89.99");
        $(".package3 .price").html("$89.99");
        $(".package3 .save-price").html("$0.00");
        $(".package3").attr("data-package-price", "$95.94");
        $(".package3").attr("data-cbid", "4");

        // $(".pack1btn").attr("data-id", "1");
        // $(".pack2btn").attr("data-id", "2");
        // $(".pack3btn").attr("data-id", "3");
        // setCart();
      });

      // $(".subscribe").trigger("click");
      //   $(".product").click(function () {
      //     $(".active").removeClass("active");
      //     $(this).addClass("active");
      //     setCart();
      //     var parentElement = this;
      //     selectButtons.each(function (i) {
      //       if ($.contains(parentElement, this)) {
      //         $(this).text("Selected!");
      //       } else {
      //         $(this).text("Select Package");
      //       }
      //     });
      //   });

      $(".submit-button").on("click", function (e) {
        e.preventDefault();
        obj = $(this).closest(".buy-package");
        obj.addClass("package-selected").siblings().removeClass("package-selected");
        $("#loading-indicator").fadeIn().delay(800);
        var cbid = obj.attr("data-cbid");
        var pprice = obj.attr("data-package-price");
        var pcount = obj.attr("data-prod-count");
        localStorage.setItem("data-cbid", obj.attr("data-cbid"));
        localStorage.setItem(
          "data-package-price",
          obj.attr("data-package-price")
        );
        localStorage.setItem("isSubscription",isSubscription)
        localStorage.setItem("data-prod-count", obj.attr("data-prod-count"));
        window.location.href = "shipping.php";
      });
    </script>
  </body>
</html>
