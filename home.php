<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylingfile/maindisplay.css">
    <link rel="stylesheet" href="stylingfile/home.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="iconlogo/bunniwinkleIcon.ico">
    <title>Inventory</title>
</head>

<body>

    <?php include 'sidebar.php' ?>

    <div class="maindisplayDiv2">
        <div class="insideDisplayDiv2">
            <!-- Title above the slideshow -->
            <h2 class="slideshow-title">WELCOME TO BUNNIWINKLE INVENTORY SYSTEM</h2>

            <!-- Slideshow container -->
            <div class="slideshow-container">

                <!-- Full-width images with number and caption text -->
                <div class="mySlides fade">
                    <div class="numbertext">1 / 3</div>
                    <img src="imgBG/bunniwinkleBG.jpg" class="slideshow-image">
                    <div class="text"></div>
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">2 / 3</div>
                    <img src="imgBG/bunniliveshop.jpg" class="slideshow-image">
                    <div class="text"></div>
                </div>

                <div class="mySlides fade">
                    <div class="numbertext">3 / 3</div>
                    <img src="imgBG/bunniartscraft.jpg" class="slideshow-image">
                    <div class="text"></div>
                </div>

                <!-- Next and previous buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <br>

            <!-- The dots/circles -->
            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        </div>
    </div>



    <script>
        let slideIndex = 0;
        showSlidesAuto(); // Initialize the automatic slideshow

        // Function to display slides manually using next/prev buttons
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Function to display slides manually using dots
        function currentSlide(n) {
            showSlides(slideIndex = n - 1);
        }

        // Function for automatic slideshow
        function showSlidesAuto() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlidesAuto, 3000); // Change slide every 3 seconds
        }
    </script>

</body>

</html>