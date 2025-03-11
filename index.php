<?php require_once("config.php");
      include("./layout/hlava.php");
      require("./layout/navbar.php");
      require("common.php"); ?>

<body>
    <header id="showcase">
        <div class="showcase-content" >
            <h1 class="l-heading">Bůh nás miluje</h1>
            <p class="lead" id="sequence">
                Římanům 8 18 Soudím totiž, že utrpení nynějšího času se nedají srovnat s budoucí slávou, která má být na nás zjevena.
            </p>
            <a href="#what" class="btn">Dozvědět se více</a>
        </div>
    </div>
        </div>
    </header>
            
    <section id="what" class="bg-light py-1">
        <div class="container">
            <h2 class="m-heading text-center"><span class="text-primary"> O</span> Nás</h2>
            <video controls>
                <source src="./vido/Video Project.mp4" type="video/mp4">
              Your browser does not support the video tag.
            </video>
            <div class="items">
            
                <div class="item">
                    <i class="fa-solid fa-globe"></i>
                    <div>
                        <h3>Modlitby</h3>
                        <p>Modlitby jsou naší zbraní proti všemu zlému</p>
                    </div>
                </div>
                <div class="item">
                    <i class="fa-solid fa-book"></i>
                    <div>
                        <h3>Verše</h3>
                        <p>Máme verše pro každý problém a situaci</p>
                    </div>
                </div>
                <div class="item">
                    <i class="fa-solid fa-fire-flame-curved"></i>
                    <div>
                        <h3>Varujeme před hříchy</h3>
                        <p>7 smrtelných hříchů</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="who">
        <div class="who-img"></div>
        <div class="who-text bg-dark p-2">

            <h2 class="m-heading">
                <span class="text-primary"> Kdo</span> jsme
            </h2>
            <p></p>
            <h3>Náš tým</h3>
            <ul class="list">
                <li>Bůh: Stvořitel</li>
                <li>Ježíš Kristus: Vykupitel</li>
                <li>Duch Svatý. Utěšitel</li>
            </ul>
        </div>
    </section>
    <footer id="main-footer" class="bg-dark text-center py-1">
        <div class="container">
            <p>Copyright &copy; 2023, Království Nebeské</p>
        </div>
    </footer>
    <script>
        function debounce(func, wait = 20, immediate = true) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

const sliderImages = document.querySelectorAll('.item');

function checkSlide() {
    
    sliderImages.forEach(sliderImage => {
        console.log('height',sliderImage.offsetTop);
        // half way through the image
        const slideInAt = (window.scrollY + window.innerHeight) - sliderImage.offsetHeight / 2;
        // bottom of the image
        const imageBottom = sliderImage.offsetTop + sliderImage.offsetHeight;
        const isHalfShown = slideInAt > sliderImage.offsetTop;
        const isNotScrolledPast = window.scrollY < imageBottom;
        if (isHalfShown && isNotScrolledPast) {
            sliderImage.classList.add('active');
        } else {
            sliderImage.classList.remove('active');
        }
    });
}

window.addEventListener('scroll', debounce(checkSlide));


        var example = ['Římanům 8 18 Soudím totiž, že utrpení nynějšího času se nedají srovnat s budoucí slávou, která má být na nás zjevena.', 'Žalmy 118 8 Lépe utíkat se k Hospodinu, než doufat v člověka.', 'Žalmy 23 4 I když půjdu roklí šeré smrti, nebudu se bát ničeho zlého, vždyť se mnou jsi ty. Tvoje berla a tvá hůl mě potěšují.', 'Kazatel 7 20 Není na zemi člověka spravedlivého, aby konal dobro a nehřešil.'];

       textSequence(0);
       function textSequence(i) {

           if (example.length > i) {
               setTimeout(function() {
                   document.getElementById('sequence').innerHTML = example[i];
                  textSequence(++i);
               }, 5500); // 1 second (in milliseconds)

           } else if (example.length == i) { // Loop
               textSequence(0);
           }

     } 



</script>"
    </script>
</body>
</html>

