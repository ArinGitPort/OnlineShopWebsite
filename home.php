<?php

include 'sessionchecker.php';
?>

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

            <h2 class="slideshow-title">WELCOME TO BUNNIWINKLE INVENTORY SYSTEM</h2>

            <div class="slideshow-container">

                <div class="mySlides fade">
                    <div class="numbertext">1 / 3</div>
                    <img src="imgBG/bunniBG.jpg" class="slideshow-image">
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
                <p class="introducePara">Welcome to bunniwinkle inventory system app. The goal of this app is to make
                    monitoring of orders and products easier. </p>

                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <br>

            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        </div>
    </div>



    <script>
        let slideIndex = 0;
        showSlidesAuto(); 

      
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n - 1);
        }
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
            setTimeout(showSlidesAuto, 3000); 
        }
    </script>

</body>

</html>