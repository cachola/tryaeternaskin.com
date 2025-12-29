<!DOCTYPE html>
<html lang="en">

<head>


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
            top: 335px;
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
            font-size: clamp(18px, 2.4vw, 40px);
            letter-spacing: .2px;
            margin: 0 0 clamp(10px, 1.2vw, 18px);
        }

        .offer-red {
            font-family: "Montserrat", sans-serif;
            font-weight: 700;
            color: var(--red);
            font-size: clamp(20px, 3.0vw, 46px);
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
            color: var(--navy);
            text-transform: uppercase;
            font-size: clamp(22px, 3.1vw, 54px);
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
            font-size: clamp(16px, 2.0vw, 34px);
            margin: clamp(6px, .8vw, 10px) 0 0;
            line-height: 1.25;
        }

        .offer-price {
            font-family: "Montserrat", sans-serif;
            font-weight: 800;
            color: var(--blue);
            font-size: clamp(48px, 7vw, 120px);
            margin: clamp(10px, 1.6vw, 18px) 0 0;
            letter-spacing: .01em;
        }

        #secureimg {
            width: 370px;
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
        .imgorig{
            width: 50%;
        }
    </style>
</head>

<body>
    
    <div class="scale-wrapper">
        <div class="scale-block">
            <!-- Drop-in replacement for the image (pure HTML/CSS + inline SVG) -->
            <section class="reveye-card" aria-label="RevEye Ageless Eye Cream">
                <div class="reveye-badge" aria-hidden="true">
                    <!-- Simple badge/ribbon as SVG (scales cleanly like an image) -->
                 <img src="./app/desktop/images/award_left_1.svg" alt="">
                </div>

                <h2 class="reveye-title">Vitamin C Cleanser</h2>

                <p class="reveye-subtitle">
                    Get firmer, cleaner skin by washing away<br>
                    dirt and oil leaving a fresh, radiant glow



<!-- 
                    Get smoother, firmer and more youthful skin<br>
                     by hydrating the delicate eye area for a <br>
                     more youthful, rested appearance.<br> -->
                    <!-- Promote a firmer, more youthful and <br>
                    radiant complexion by attracting moisture and <br>
                    provide skin building blocks.<br> -->
                </p>
            </section>
        </div>
    </div>
    <div>
        <img src="./app/desktop/images/award_left_1.png" class="imgorig" alt="">
    </div>
    <style>
        .reveye-card {
            /* match the image’s “white card” look */
            background: #fff;
            width: 100%;
            /* optional: keep the same aspect ratio as the original image */
            aspect-ratio: 1188 / 732;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            /* padding: clamp(28px, 5vw, 64px); */
            box-sizing: border-box;
        }

        .reveye-badge {
            /* width: clamp(110px, 14vw, 170px); */
            height: auto;
            margin-bottom: clamp(18px, 3vw, 34px);
            line-height: 0;
        }

        .reveye-badge svg {
            width: 100%;
            height: auto;
            display: block;
        }

        .reveye-title {
            margin: 0;
            color: #5E5C5C;
            /* close to the screenshot gray */
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 300;
            letter-spacing: 0.2px;
            font-size: 52px;
        }

        .reveye-subtitle {
            margin: clamp(14px, 2vw, 22px) 0 0;
            color: #F79646;
            /* close to the screenshot orange */
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 300;
            font-size: 44px;
            line-height: 1.18;
            /* max-width: 22ch; */
            /* keeps line lengths similar to the image */
        }
        
    .scale-wrapper {
    width: 100%;
    max-width: 1188px; /* optional */
    aspect-ratio: 16 / 9; /* behaves like image ratio */
    }

    .scale-block {
    width: 100%;
    height: 100%;
    transform-origin: top left;
    transform: scale(1);
    }
    </style>
<script>
    const block = document.querySelector('.scale-block');

function setScale() {
//   const scale = block.parentElement.clientWidth / 800;
const scale=1
  block.style.transform = `scale(${scale})`;
}

window.addEventListener('resize', setScale);
setScale();

</script>

</body>

</html>