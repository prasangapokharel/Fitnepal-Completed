<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="navbar.css"> <!-- Include your custom CSS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="path/to/your/custom.js"></script> <!-- Include your custom JS -->
</head>
<body>
    <nav class="navbar navbar-expand-custom navbar-mainbg">
        <a class="navbar-brand navbar-logo" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
                <li class="nav-item <?php echo $activePage === 'dashboard' ? 'active' : ''; ?>">
                    <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                <li class="nav-item <?php echo $activePage === 'addressbook' ? 'active' : ''; ?>">
                    <a class="nav-link" href="addressbook.php"><i class="far fa-address-book"></i>Address Book</a>
                </li>
                <li class="nav-item <?php echo $activePage === 'components' ? 'active' : ''; ?>">
                    <a class="nav-link" href="components.php"><i class="far fa-clone"></i>Components</a>
                </li>
                <!-- Add more nav items as needed -->
            </ul>
        </div>
    </nav>

    <script>
        function updateSelectorPosition() {
            var tabsNewAnim = $('#navbarSupportedContent');
            var activeItemNewAnim = tabsNewAnim.find('.active');
            var itemPosNewAnimTop = activeItemNewAnim.position();
            var itemPosNewAnimLeft = activeItemNewAnim.position();
            var activeWidthNewAnimHeight = activeItemNewAnim.innerHeight();
            var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
            $(".hori-selector").css({
                "top": itemPosNewAnimTop.top + "px",
                "left": itemPosNewAnimLeft.left + "px",
                "height": activeWidthNewAnimHeight + "px",
                "width": activeWidthNewAnimWidth + "px"
            });
        }

        $(document).ready(function () {
            setTimeout(function () { updateSelectorPosition(); });
        });

        $("#navbarSupportedContent").on("click", "li", function (e) {
            $('#navbarSupportedContent ul li').removeClass("active");
            $(this).addClass("active");
            updateSelectorPosition();
        });
        
        $(window).on('resize', function () {
            setTimeout(function () { updateSelectorPosition(); }, 500);
        });

        $(".navbar-toggler").click(function () {
            $(".navbar-collapse").slideToggle(300);
            setTimeout(function () { updateSelectorPosition(); });
        });
    </script>
</body>
</html>
