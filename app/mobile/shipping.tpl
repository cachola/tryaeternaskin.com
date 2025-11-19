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

    <style>
      .autocomplete-suggestions {
        overflow: auto;
        width: auto !important;
      }

      .autocomplete-suggestion {
        overflow: visible;
      }

      form {
        padding: 0;
      }
    </style>
  </head>

  <body data-mobile-id="5984" style="max-width: 600px; margin: 0 auto">
    <?php perform_body_tag_open_actions(); ?>
    <p id="loading-indicator" style="display: none">Processing...</p>
    <div id="app">
      <div id="pagecontainer">
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
              <li class="breadcrumbs__item breadcrumbs__item_2">
                <span>Select Package</span>
              </li>
              <li
                class="breadcrumbs__item breadcrumbs__item_3 breadcrumbs__item_active"
              >
                <span>Confirm Order</span>
              </li>
            </ul>
          </div>

          <p style="text-align: center">
            <br />
            <b style="color: #f18704; font-size: 16px"
              >FREE Sample reserved for:
              <span id="clockdiv"> 9:56</span> Minutes </b
            >
          </p>

          <div
            class="form-partial"
            id="partialcontainer"
            style="max-width: 95%; margin: 0 auto"
          >
            <form
              name="fullprospect_form"
              class="partialform form form123"
              id="frm"
              action="ajax.php?method=new_prospect"
              method="post"
              accept-charset="utf-8"
              enctype="application/x-www-form-urlencoded;charset=utf-8"
            >
              <div class="shipping-form-wrapper">
                <!-- <div class=" columns form-holder">
                                <label>First Name:</label>
                                <input class="form-control required" data-placement="auto left" name="firstName" id='fields_fname' placeholder="First Name*" title="First Name" type="text" data-error-message="Please enter your first name!" value="" maxlength="25">
                            </div>

                            <div class=" columns form-holder">
                                <label>Last Name:</label>
                                <input class="form-control required" data-placement="auto left" name="lastName" id='fields_lname' placeholder="Last Name*" value=""  title="Last Name" type="text" data-error-message="Please enter your last name!" maxlength="25">
                            </div> -->
                            <div class=" columns form-holder">
                              <label>First Name:</label>
                              <input class="form-control required" data-placement="auto left" name="firstName" value="" id='fields_fname' placeholder="First Name*" title="First Name*" type="text" data-error-message="Please enter your first name!" maxlength="25">
                          </div>
                          <div class=" columns form-holder">
                              <label>Last Name:</label>
                              <input class="form-control required" data-placement="auto left" name="lastName" id='fields_lname' placeholder="Last Name*" title="Last Name*" type="text" value="" data-error-message="Please enter your last name!" maxlength="25">
                          </div>

                <div class="form-holder">
                  <label>Address:</label>
                  <input
                    class="form-control required"
                    data-placement="auto left"
                    name="shippingAddress1"
                    id="gmap_autocomplete"
                    value=""
                    placeholder="Address*"
                    title="Address"
                    type="text"
                    data-error-message="Please enter your address!"
                    maxlength="25"
                  />
                </div>


                <div class="form-holder">
                  <label>City:</label>
                  <input
                    class="form-control required"
                    data-placement="auto left"
                    name="shippingCity"
                    value=""
                    id="city"
                    placeholder="City*"
                    title="City"
                    type="text"
                    data-error-message="Please enter your city!"
                    maxlength="25"
                  />
                </div>
                <div class="form-holder" style="display: none">
                  <!-- <label>Country</label> -->
                  <select
                    name="shippingCountry"
                    id="shippingCountry"
                    class="form-control required"
                    data-selected=""
                    data-error-message="Please select your country!"
                    data-selected="US"
                  >
                    <option value="US">Select Country</option>
                  </select>
                </div>

                <div class="form-holder" style="width: 48%;float: left;">
                  <label>State:</label>
                  <input
                    class="form-control required"
                    data-placement="auto left"
                    name="shippingState"
                    id="shippingState"
                    data-selected=""
                    iplaceholder="Your State*"
                    title="State"
                    type="text"
                    data-error-message="Please select your state!"
                  />
                </div>
                
                <div class="form-holder" style="    width: 48%;float: left;margin-left: 4%;">
                  <label>Zip Code:</label>
                  <input
                    class="form-control required"
                    data-placement="auto left"
                    name="shippingZip"
                    id="zip"
                    value=""
                    placeholder="Zip Code*"
                    minlength="5"
                    maxlength="5"
                    title="Zip Code"
                    type="tel"
                    data-error-message="Please enter a valid zip code!"
                  />
                </div>
                <!-- <div class="columns">
                  <label>Email:</label>
                  <input
                    class="form-control required"
                    data-placement="auto left"
                    name="email"
                    id="fields_email"
                    placeholder="Email*"
                    title="Email"
                    type="email"
                    data-validate="email"
                    value=""
                    data-error-message="Please enter a valid email id!"
                    maxlength="100"
                  />
                </div>

                <div class="columns">
                  <label>Phone Number</label>
                  <input
                    class="form-control required"
                    data-placement="auto left"
                    name="phone"
                    id="fields_phone"
                    placeholder="Phone Number*"
                    title="Phone Number"
                    type="tel"
                    value=""
                    maxlength="10"
                    data-error-message="Please enter a valid contact number!"
                  />
                </div> -->
                <div class=" columns">
                  <label>Phone:</label>
                  <input class="form-control required" data-placement="auto left" name="phone" id="fields_phone" placeholder="Phone Number*" title="Phone Number" type="tel" value="" data-error-message="Please enter a valid contact number!" maxlength="12">
              </div>
              <div class=" columns">
                  <label>Email:</label>
                  <input class="form-control required" data-placement="auto left" name="email" id='fields_email' placeholder="Email*" title="Email" type="email" data-error-message="Please enter a valid email id!" value="" maxlength="100" >
              </div>

                <button
                  id="submit_btn"
                  name="submit_btn"
                  style="font-size: 21px"
                  type="submit"
                >
                  Proceed to Checkout »
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="linebreak" style="margin: 15px 0"></div>
        <div id="content-3">
          <div style="color: #7b0600; font-size: 11px; text-align: center">
            We care about your privacy.
          </div>
        </div>
        <div id="top-2">
          <img src="<?= $path['images'] ?>/godaddyimg.png" />
        </div>
        <div class="linebreak" style="margin: 15px 0"></div>
        <div id="top-3">
          <img src="<?= $path['images'] ?>/safe.png" />
        </div>
        <div class="linebreak" style="margin: 15px 0"></div>

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
                  >Contact Us</a
                >
              </li>
            </ul>
            <br />
            <div class="text-center">
              <p>
                Keto Fire Gummies is committed to maintaining the highest
                quality products and the utmost integrity in business practices.
                All products sold on this website are certified by Good
                Manufacturing Practices (GMP), which is the highest standard of
                testing in the supplement industry.
              </p>
              <br />
              <p>
                Notice: The products and information found on this site are not
                intended to replace professional medical advice or treatment.
                These statements have not been evaluated by the Food and Drug
                Administration. These products are not intended to diagnose,
                treat, cure or prevent any disease. Individual results may vary.
              </p>
            </div>
            <br />
          </center>

          <center>
            <div class="text-center">
              <p class="cop-text">
                &copy; <span class="product-name">Keto Fire Gummies</span>. All
                Rights Reserved.
              </p>
              <br />
            </div>
          </center>
          <p></p>
        </div>
      </div>
    </div>

    <?php require_once 'general/__scripts__.tpl' ?>
    <!-- <?php require_once 'general/__analytics__.tpl' ?> -->
    <?php perform_body_tag_close_actions(); ?>

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
    <script>
      $(document).ready(function (e) {
        $(".numeric").on("keyup", function () {
          var value = $(this).val();
          var regex_cell = /[^[0-9 ]]*/gi;
          var new_value = value.replace(regex_cell, "");
          $(this).val(new_value);
        });

        $("#submit_btn").on("click", function (event) {
          event.preventDefault();
          $("#loading-indicator").show();
          setTimeout(function () {
            $("#loading-indicator").hide();
          }, 4000);
          $("#frm").submit();
        });
      });
      	// clock 10 minutes

		var spd = 100;
		var spdVal = 10;
		var cntDown = 10 * 60 * spdVal;
		setInterval(function () {
		var mn, sc, ms;
		cntDown--;
		if (cntDown < 0) {
		  	return false;
			}
		mn = Math.floor(cntDown / spdVal / 60);
		mn = mn < 10 ? "0" + mn : mn;
		sc = Math.floor((cntDown / spdVal) % 60);
		sc = sc < 10 ? "0" + sc : sc;
		ms = Math.floor(cntDown % spdVal);
		ms = ms < 10 ? "0" + ms : ms;
		var result = mn + ":" + sc;
		if (document.getElementById("clockdiv")) {
		  	document.getElementById("clockdiv").innerHTML = result;
			}
		}, spd);

	
    </script>
  </body>
</html>
