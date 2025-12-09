<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
 <?php include 'general/__header__.tpl'; ?>
  <title>Aeterna Skin</title>

  <meta name="description" content="Aeterna Skin" />

  <!--  -->
  <!-- <meta name="robots" content="noindex,nofollow,noarchive,nosnippet,noydir,noodp" />
  <link rel="shortcut icon" href="<?= $path['images'] ?>/fav-icon.png" type="image/x-icon">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta http-equiv="content-language" content="en-us" />

  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <meta name="HandheldFriendly" content="true" />
  <meta name="viewport" content="width=device-width, user-scalable=no" />
  <meta property="og:image" content="<?= $path['images'] ?>/thumb.png" /> -->
  <link rel="stylesheet" href="/assets/css/app.css" />
  <link rel="stylesheet" type="text/css" href="<?= $path['assets_css']; ?>/cards_sp.css" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script type="text/javascript">
    function preventBack() { window.history.forward(); }
    setTimeout("preventBack()", 0);
    window.onunload = function () { null };    
  </script>
  <style>
    .symbol {
      font-size: 55px;
      position: absolute;
      display: inline;
      top: 7px;
    }

    .text_line {
      position: relative;
      left: 77px;
      display:
        inline;
      text-align: left;
    }

    .symbol-wrap {
      width: 398px;
      margin: 0 auto;
    }

    @media (max-width:992px) {
      .symbol {
        font-size: 50px;
        position: absolute;
        display: inline;
        top: 6px;
      }

      .symbol-wrap {
        width: 300px;
        margin: 0 auto;
      }
    }

    @media (max-width:491px) {
      .symbol {
        font-size: 44px;
        position: absolute;
        display: inline;
        top: 11px;
        left: 21px;
      }

      .text_line {
        position: relative;
        left: 25px;
        display: inline;
        text-align: left;
      }
    }

    @media (max-width:420px) {
      .symbol {
        font-size: 48px;
        position: absolute;
        display: inline;
        top: 31px;
      }

      .text_line {
        position: relative;
        left: 67px;
        display: inline-block;
        text-align: left;
        width: 260px;
      }
    }
  </style>

  <link rel="stylesheet" type="text/css" href="<?= $path['css'] ?>/checkout-combine.css?v=1.18" />
  <style>
    #app_common_modal_close,
    #error_handler_overlay_close {
      line-height: 27px !important;
    }

    input.has-error,
    select.has-error,
    input.no-error,
    select.no-error {
      padding-right: 27px !important;
    }

    @media screen and (min-width: 601px) and (max-width: 1024px) {
      .flx1 {
        display: flex;
        align-items: center;
        /* justify-content: center; */
        min-height: 42px;
      }

      p.mc-promo {
        padding: 9px 10px 9px 96px !important;
      }
    }

    .checkout-form .fields label {
      vertical-align: middle;
    }

    .check-upsell {
      display: inline-block;
      position: relative;
      padding-left: 22px;
    }

    .checkbox_content {
      display: flex;
      width: 100%;
      margin-left: 0;
      gap: 3px;
    }

    .checkbox_content .ship_img {
      max-width: 42px;
      vertical-align: middle;
    }

    .checkbox_text p {
      font-size: 14px;
      line-height: 18px;
      margin-bottom: 9px;
      margin-top: 2px;
      color: #000;
      letter-spacing: -0.2px;
    }

    .check_list li {
      display: flex;
      gap: 5px;
      align-items: flex-start;
      font-size: 12px;
      margin-bottom: 10px;
    }

    .check_list img {
      width: 16px;
    }

    .label-checkbox p {
      padding-left: 37px;
      margin: 7px 0 0 !important;
    }

    .label-checkbox {
      margin-bottom: 0 !important;
    }

    .label-checkbox p img {
      margin-right: 4px;
    }
  </style>
</head>

<body>
  <?php include 'general/__gtag_script__.tpl';
        perform_body_tag_open_actions(); ?>
  <div class="order__header_top">
    <div class="container">
      <span class="views-coll" style="color: #ff5f93">12 others </span> are
      viewing this offer right now !<span class="timer" id="time"></span>
    </div>
  </div>
  <header>
    <div class="container">
      <div class="logo"></div>
      <div class="seals">
        <img src="<?= $path['images'] ?>/checkout-seals.png" alt="checkout-seals" />
      </div>
      <div class="clear"></div>
    </div>
  </header>
  <main class="clearfix">
    <div class="container">
      <div class="product-option-box">
        <div class="progress clearfix">
          <div class="bar"></div>
          <div class="part">
            <div>Shipping Info</div>
            <div>1</div>
          </div>
          <div class="part">
            <div>Confirm Order</div>
            <div>2</div>
          </div>
          <div class="part grey">
            <div>Order Summary</div>
            <div>3</div>
          </div>
        </div>
        <div class="clear"></div>
        <div class="text">
          <p class="mb-only">
            <strong>Great Job!</strong> You're taking your first step towards
            a better you!
          </p>
          <p>
            Your reservation of
            <strong>Aeterna Skincare Advanced Wrinkle Cream</strong>
            expires in
            <span id="countdown" class="timer">5:00!</span>
          </p>
          <p class="mb-only">Act now before our supplies run out!</p>
          <div class="risk">
            <div class="soldout-risk">
              Current Availability:
              <div class="bar">
                <div class="level"></div>
              </div>
              LOW. Sell-Out Risk: <strong class="red">HIGH</strong>
            </div>
          </div>
          <p>
            Just pay a small shipping fee. Enjoy your expedited delivery to
            <b>test</b>
            <b>test</b>,
            <b>4844 NW 18th Avenue</b>,
            <b>Pompano Beach</b>, <b></b>
            <b>FL</b>
            <b>33064</b>!
          </p>
          <p>
            If you order in the next
            <em><strong>1 hour and 13 minutes</strong></em>, your order is scheduled to arrive by
            <span class="red nowrap">22nd September, 2025</span>
            !
          </p>
        </div>
        <div class="product">
          <div class="left">
            <div class="bottle">&nbsp;</div>
          </div>
          <div class="right">
            <h3>Aeterna Skincare Advanced Wrinkle Cream</h3>
            <div id="checkout_trial_length">
              <div class="supply" style="text-transform: capitalize">
                7-Day SAMPLE
              </div>
            </div>
            <ul>
              <li>Price:<span id="checkout-trial-price">$0.00</span></li>
              <li>
                S&amp;H:<span>$14.99</span>
              </li>
              <li id="promo">
                MasterCard Promo:<span class="red promo">-$5.05</span>
              </li>
              <li>
                Total:<span><strong class="total">$9.94</strong></span>
              </li>
            </ul>
          </div>
          <div class="clear"></div>
        </div>
        <div class="big-arrow">
          CONFIRM YOUR EXCLUSIVE OFFER NOW!
          <div>LIMITED QUANTITIES AVAILABLE</div>
        </div>
        <div class="footer_trial_disclaimer forDesktop">
          <div>
            We are committed to maintaining the highest quality products and
            the utmost integrity in business practices. All products sold on
            this website are certified by Good Manufacturing Practices (GMP),
            which is the highest standard of testing in the supplement
            industry.
          </div>
          <div>
            *Due to limited inventory levels on any given day,
            <b>we must limit trial sales to 250 maximum per day.</b>
            Representations regarding the efficacy and safety of Aeterna Skincare Advanced Wrinkle Cream have not been
            evaluated by the Food and Drug Administration.
          </div>
          <div>
            After your trial period has expired, you will be enrolled in our
            membership program for $88.97 per month. You can
            cancel anytime by calling
            <a href="tel:888-918-5943">888-918-5943</a>.
          </div>
        </div>
        <!-- <div class="frmCheckElemts forDesktop">
          <label class="spl-checkbox" style="vertical-align: top; text-align: center">
            <input type="checkbox" name="emag_subscription" id="ebook_check" value="Y" checked="checked"
              class="chkbox uprev_check" style="margin: 0" />
            <span>Yes, Please Include My Skin Care Guide</span>
          </label>
        </div> -->
        <div style="text-align: center;margin: 25px 0;" class="forDesktop">
          <label for="free_trial" class="payment_as_shipping_label">
            <input type="checkbox" name="" id="free_trial" checked="" class="chkbox bill-inp">
            <span style="color:gray;"> Get 1 Week Of FitnessXR &amp; USADC</span>
          </label>
        </div>
      </div>
      <div class="form-box">
        <div class="inner">
          <div class="final-step">
            <strong>FINAL STEP</strong>
            Payment Information
          </div>
          <form method="post" action="ajax.php?method=new_order_prospect" class="checkout-form" name="checkout_form"
            accept-charset="utf-8" enctype="application/x-www-form-urlencoded;charset=utf-8" id="frm">
            <input type="hidden" name="campaigns[1][id]" id="dynamic_input" value="1" />
            <span class="accept-text">We Accept:</span>

            <div class="cards_sp">
              <span class="card-visa allCards"></span>

              <span class="card-mastercard allCards"></span>

              <span class="card-discover allCards"></span>
            </div>
            <p style="display: none" id="cc_type" type="select" name="cc_type">
              <select name="creditCardType" class="required cctype" data-deselect="false"
                data-error-message="Please select valid card type!">
                <option value="">Card Type</option>
                <option value="master">Master Card</option>
                <option value="visa">Visa</option>
                <option value="discover">Discover</option>
              </select>
            </p>

            <div class="sameAsShipping">
              <label>
                <input type="checkbox" id="billShipSame" name="billingSameAsShipping" checked />
                Same Shipping and Billing Address
              </label>
              <p style="display: none">
                <input type="radio" name="billingSameAsShipping" value="yes" checked="checked" id="shipping_yes" />
                YES
                <input type="radio" name="billingSameAsShipping" value="no" id="shipping_no" />
                NO
              </p>
            </div>

            <div id="billAddress" class="billing-info" style="display: none">
              <div style="padding-bottom: 15px; text-align: center; font-size: 18px; font-weight: bold">
                Enter your billing information
              </div>
              <div class="fields">
                <label>First Name</label>
                <input type="text" name="billingFirstName" class="n-input form-control" placeholder="Billing First Name"
                  data-error-message="Please enter your billing First Name!" />
              </div>
              <div class="fields">
                <label>Last Name</label>
                <input type="text" name="billingLastName" class="n-input form-control" placeholder="Billing Last Name"
                  data-error-message="Please enter your billing Last Name!" />
              </div>
              <div class="fields" style="display: none">
                <label>Country</label>
                <select name="billingCountry" class="n-select form-control" data-selected="US"
                  data-error-message="Please select your billing Country!">
                  <option value="">Select Country</option>
                </select>
              </div>
              <div class="fields">
                <label>Address</label>
                <input type="text" name="billingAddress1" class="n-input form-control" placeholder="Billing Address"
                  id="billingAddress1" data-error-message="Please enter your billing Address!" />
              </div>
              <!-- <div class="fields">
                <label>Address 2</label>
                <input type="text" id="billingAddress2" name="billingAddress2" class="n-input form-control"
                  placeholder="Apt / Suite #" data-error-message="Please enter your billing address2!" />
              </div> -->
              <div class="fields">
                <label>City</label>
                <input type="text" name="billingCity" class="n-input form-control" placeholder="Billing City"
                  id="billingCity" data-error-message="Please enter your billing City!" />
              </div>
              <div class="fields">
                <label>State</label>
                <input type="text" name="billingState" class="n-select form-control" placeholder="Billing State"
                  id="billingState" data-error-message="Please select your billing State!" />
              </div>
              <div class="fields">
                <label>Zip</label>
                <input type="tel" name="billingZip" class="n-input form-control" placeholder="Billing Zip Code"
                  data-error-message="Please enter a valid billing Zip Code!" maxlength="5" data-min-length="5"
                  id="billingZip" />
              </div>
            </div>

            <p style="display: none" id="cc_type" type="select" name="cc_type">
              <select name="creditCardType" class="required cctype" data-deselect="false"
                data-error-message="Please select valid card type!">
                <option value="">Card Type</option>
                <option value="master">Master Card</option>
                <option value="visa">Visa</option>
                <option value="discover">Discover</option>
              </select>
            </p>
            <div class="fields">
              <label>Card Number</label>
              <input type="tel" name="creditCardNumber" id="card_number" class="required n-input clearable formfield ib"
                maxlength="16" placeholder="____ ____ ____ ____"
                data-error-message="Please enter a valid Credit Card Number!"
                onkeyup="javascript: this.value = this.value.replace(/[^0-9]/g, '');" />
            </div>
            <div class="fields">
              <label>Exp Month</label>
              <select name="expmonth" style="padding: 5px" class="required expmonth"
                data-error-message="Please select a valid Expiry Month!">
                <option value="">Month</option>
                <option value="01">(01) January</option>
                <option value="02">(02) February</option>
                <option value="03">(03) March</option>
                <option value="04">(04) April</option>
                <option value="05">(05) May</option>
                <option value="06">(06) June</option>
                <option value="07">(07) July</option>
                <option value="08">(08) August</option>
                <option value="09">(09) September</option>
                <option value="10">(10) October</option>
                <option value="11">(11) November</option>
                <option value="12">(12) December</option>
              </select>
            </div>
            <div class="fields">
              <label>Exp Year</label>
              <select name="expyear" style="padding: 5px" class="required s-select"
                data-error-message="Please select a valid Expiry Year!">
                <option value="">Year</option>
                <option value="25">2025</option>
                <option value="26">2026</option>
                <option value="27">2027</option>
                <option value="28">2028</option>
                <option value="29">2029</option>
                <option value="30">2030</option>
                <option value="31">2031</option>
                <option value="32">2032</option>
                <option value="33">2033</option>
                <option value="34">2034</option>
                <option value="35">2035</option>
                <option value="36">2036</option>
                <option value="37">2037</option>
                <option value="38">2038</option>
                <option value="39">2039</option>
                <option value="40">2040</option>
                <option value="41">2041</option>
                <option value="42">2042</option>
                <option value="43">2043</option>
                <option value="44">2044</option>
              </select>
            </div>
            <div class="fields">
              <label>CVV</label>
              <input type="tel" name="CVV" class="required input-fields s-input formfield short cvv_cst"
                data-validate="cvv" maxlength="3" placeholder="CVV"
                data-error-message="Please enter a valid CVV Code!" />
              <a href="javascript:void(0);" class="bottomhref"
                onClick="javascript:openNewWindow('cvv.html','modal');"><img src="<?= $path['images'] ?>/cvv-img.png"
                  alt="cvv icon" style="vertical-align: middle; margin-left: 12px; width: 84px" /></a>
            </div>
            <div class="fields">
              <div class="disclaimer" style="padding: 10px 10px 0 10px">
                By submitting, you affirm to have read and agreed to our
                <a href="javascript:void(0);" onClick="javascript:openNewWindow('page-terms.php','modal');"
                  style="color: inherit; text-decoration: underline; cursor: pointer">Terms &amp; Conditions</a>.
              </div>
            </div>
            <div class="label-checkbox">
              <input type="checkbox" name="offers" class="insurance_check" checked>
              <span>
                <img src="<?= $path['images'] ?>/shipping_icon.png" alt="" class="ship_icon">
                <strong>Add SHIPPING INSURANCE for $6.95</strong>
              </span>
              <p><img src="<?= $path['images'] ?>/check_mark.png" alt="" class="check_icon">Protect your order against
                loss or damage during transit.</p>

            </div>
            <div class="check-upsell">

              <input type="checkbox" name="offers" class="mini_upsell_check" checked="">
              <div class="checkbox_content">
                <span>
                  <img src="<?= $path['images'] ?>/up1-popup.png" alt="" class="ship_img">
                </span>
                <div class="checkbox_text">
                  <p>
                    <strong>Yes! Boost my Results with Skin-Balancing Toner - ONLY $19.99 (Reg: <span
                        style="text-decoration:line-through;"> $59.99</span>)</strong>
                  </p>
                  <ul class="check_list">
                    <li><img src="<?= $path['images'] ?>/check_mark.png" alt="" class="check_icon"> Hydrate, Balance,
                      and Renew Your Skin </li>
                    <li><img src="<?= $path['images'] ?>/check_mark.png" alt="" class="check_icon"> Crafted with care
                      with only the finest ingredients </li>
                  </ul>
                  <p>(Limited-time add-on — not available after checkout!)</p>
                </div>
              </div>
            </div>
            <div class="fields submit">
              <button type="submit" class="submit" id="submit_btn">
                RUSH MY SAMPLE
              </button>
            </div>
          </form>
        </div>
        <!-- <div class="frmCheckElemts forMobile">
          <label class="spl-checkbox">
            <input type="checkbox" name="emag_subscription" id="ebook_check" value="Y" checked="checked" class="chkbox"
              style="margin: 0" />
            <span>Yes, Please Include My Skin Care Guide</span>
          </label>
        </div> -->
        <div style="text-align: center;margin: 25px 0;" class="forMobile">
          <label for="free_trial" class="payment_as_shipping_label">
            <input type="checkbox" name="" id="free_trial_mob" checked="" class="chkbox bill-inp">
            <span style="color:gray;"> Get 1 Week Of FitnessXR &amp; USADC</span>
          </label>
        </div>
        <p class="secure-256 center">
          <img src="<?= $path['images'] ?>/lock-icon.png" alt="lock icon" />
          Secure 256 Bit Encrypted Connection
        </p>
        <p class="center">
          <img src="<?= $path['images'] ?>/secureicons.jpg" alt="secure icon" />
        </p>
        <div class="gbox mbp-10">
          <img src="<?= $path['images'] ?>/moneyback.png" class="mb-10" alt="moneyback" />
          <p>
            <strong>100% Guaranteed</strong> to meet or exceed your
            expectations. If for ANY reason you are not thrilled with your
            results simply return your order for 100% of your money back
            (minus shipping).
          </p>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <div class="container">
      <div style="position: absolute; overflow: hidden; width: 1px; height: 1px"></div>
      <div class="footer">
        <p class="copyright">
          Copyright &copy; 2026 Aeterna Skin &mdash; All Rights Reserved.
        </p>
        <p class="customerservice">
          Customer Service:
          <a href="tel:888-918-5943" class="footertel">888-918-5943</a>
        </p>
        <p class="footerlinks">
          <a href="javascript:void(0);" class="bottomhref"
            onClick="javascript:openNewWindow('page-terms.php','modal');">Terms &amp; Conditions</a>
          |
          <a href="javascript:void(0);" class="bottomhref"
            onClick="javascript:openNewWindow('page-privacy.php','modal');">Privacy Policy</a>
          |
          <a href="javascript:void(0);" class="bottomhref"
            onClick="javascript:openNewWindow('page-contact.php','modal');">Contact Us</a>
        </p>
      </div>
    </div>
  </footer>

  <div class="modal softModal">
    <div class="modal-inner soft-modal-inner">
      <a data-modal-close>&times;</a>
      <div class="modal-content soft-modal-content"></div>
    </div>
  </div>

  <div id="vmodal" style="display: none"></div>
  <div id="vmodal-submitting" style="display: none">
    <div class="vmodal-custom-content">
      <div style="text-align: center">
        <div style="margin: 20px 0">
          <span class="submitting-text">Submitting Your Information</span>
          <span class="dots"></span>
        </div>
        <div>
          <img src="<?= $path['images'] ?>/secure.png" alt="secure" width="400" />
        </div>
      </div>
    </div>
  </div>

  <p id="loading-indicator" style="display: none">Processing...</p>
  <p id="crm-response-container" style="display: none">
    Limelight messages will appear here...
  </p>
  <?php
    include 'general/__scripts__.tpl';
    include 'general/__analytics__.tpl';
    perform_body_tag_close_actions();
?>
  <?php if (defined('GOOGLE_PLACES_API_ID') && !empty(GOOGLE_PLACES_API_ID)) { ?>
  <script type="text/javascript" src="<?= $path['assets_js'] ?>/places.js"></script>
  <script type="text/javascript" async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_PLACES_API_ID; ?>&libraries=places&callback=initAutocomplete"></script>
  <?php } ?>
  <script type="text/ecmascript" src="<?= $path['assets_js'] ?>/jquery.magnific-popup.js"></script>

  <!-- <script
      type="text/javascript"
      src="<?= $path['js'] ?>/social-proof.js"
    ></script> -->
  <script type="text/javascript" src="<?= $path['js'] ?>/scripts.js"></script>
  <!-- footer -->
  <script>
    var makeFitnessUpsell = true;
    $(document).ready(function () {
      // $(".billingtoggle").change(function () {
      //   if ($("input[name=billingSameAsShipping]").val() == "yes") {
      //     $("#billingSameAsShipping").val("no").trigger("change");
      //     initAutocompleteBilling();
      //   } else {
      //     $("#billingSameAsShipping").val("yes").trigger("change");
      //   }
      // });
      $("#billShipSame").change(function () {
        if ($(this).is(":checked")) {
          $("#shipping_yes").prop("checked", true).trigger("change");
        } else {
          $("#shipping_no").prop("checked", true).trigger("change");
          initAutocompleteBilling();
        }
      });
      $(".contact").magnificPopup({
        type: "iframe",
        mainClass: "contact-page",
      });
      $(".cvv").magnificPopup({
        type: "iframe",
        mainClass: "cvv-page",
      });
      $(".privacy-link").magnificPopup({
        type: "iframe",
        mainClass: "privacy-page",
      });
      // if (shipState != "") {
      //   $("#shippingState").val(shipState);
      // }

      $(".cctype").on("change", function (event) {
        /* Act on the event */
        if ($(this).val() != "") {
          switch ($(this).val()) {
            case "visa":
              $(".allCards").addClass("inactive");
              $(".card-visa").removeClass("inactive");
              break;
            case "master":
              $(".allCards").addClass("inactive");
              $(".card-mastercard").removeClass("inactive");
              break;
            case "discover":
              $(".allCards").addClass("inactive");
              $(".card-discover").removeClass("inactive");
              break;
            default:
              console.log("Credit Card type not found");
          }
        }
      });

      $("input[name=creditCardNumber]").blur(function () {
        if (
          $("input[name=creditCardNumber]").val() == "" &&
          $("select[name=creditCardType]").val() != ""
        ) {
          $(".allCards").removeClass("inactive");
        }
      });

      $('#free_trial, #free_trial_mob').on('click', function () {
        // This function will execute when any of the specified IDs are clicked.
        console.log('Element with ID:', $(this).attr('id'), 'was clicked! value:', $(this).is(":checked"));

        makeFitnessUpsell = $(this).is(":checked");
        });
    });


    $(document).off("click", "#submit_btn");
    $(document).on("click", "#submit_btn", function (e) {
      // if(!$('#chkAgree').is(':checked')){
      //     toastr.warning('Please check agree before continue.').css("font-size","0.8em");
      //     e.preventDefault();
      //     return;
      // }

      cb.beforeFormSubmitEvents.pop();

      cb.beforeFormSubmitEvents.push(function (e) {
        $("#loading-indicator").show();
        var configData = $("#frm").serialize();
        $.ajax({
          url: AJAX_PATH + "checkout",
          method: "post",
          data: configData,
        })
          .success(function (data) {
            setTimeout(function () {
              $("#loading-indicator").hide();
              if (data.errors) {
                cb.errorHandler([
                  "This transaction has been declined. Please check your card and try again; if you still have issues please contact customer service at 888-918-5943",
                ]);
              } else {

                doFitness();

              }
            }, 2000);
          })
          .fail(function () {
            console.log("error");
          });
      });


    });


    function doFitness() {
      if (makeFitnessUpsell ) {
        $.ajax({
          url: 'ajaxfitxr.php',
          type: 'POST',
          processData: false,
          contentType: false,
          success: function (res) {
            console.log('ajaxfitxr done')
            doUsadc();
          },
          fail: function () {
            console.log('ajaxfitxr fail')
            doUsadc();
          }
        });
      }
      else {
        window.onbeforeunload = null;
        window.location.href = "upsell1.php";
      }

    }

    function doUsadc() {

      $.ajax({
        url: 'ajaxusadc.php',
        type: 'POST',
        processData: false,
        contentType: false,
        success: function (res) {
          console.log('ajaxusadc done')
          window.onbeforeunload = null;
          window.location.href = "upsell1.php";
        },
        fail: function () {
          console.log('ajaxusadc fail')
          window.onbeforeunload = null;
          window.location.href = "upsell1.php";
        }
      });

    }


  </script>
</body>

</html>