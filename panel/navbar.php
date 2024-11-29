<link rel="stylesheet" href="assets/css/navbar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hamburgers/1.2.1/hamburgers.min.css">

<div class="navbar">
    <a href="/"><img class="nav-logo" src="assets/img/logo-h.svg" alt="Chito logo"></a>

    <div class="nav-part">
        <?php require 'profilepic.php'; ?>
        
        <button class="hamburger hamburger--spin" type="button">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>

        <div class="nav-menu"></div>
    </div>
</div>

<script>
    let hh = document.querySelector('.hamburger');
    
    hh.addEventListener('click', () => {
        let menu = document.querySelector('.openable-menu');
        hh.classList.toggle('is-active');
        menu.classList.toggle('open');
    });
</script>