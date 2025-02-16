<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="main_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style>
        /* Your existing styles... */
        .user-icon {
            position: relative;
            cursor: pointer;
        }
        .user-menu {
            display: none;
            position: absolute;
            right: 10px;
            top: 50px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            width: 150px; /* Reduced size */
            padding: 5px 0;
            text-align: center;
        }
        .user-menu a {
            display: block;
            padding: 8px;
            text-decoration: none;
            color: black;
            font-size: 14px; /* Smaller font */
        }
        .user-menu a:hover {
            background-color: #f0f0f0;
        }
        .sliding-menu-container {
            position: fixed;
            right: -250px; /* Initially hidden */
            top: 0;
            width: 250px;
            height: 100%;
            background-color: #fff;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
            transition: right 0.3s ease;
        }
        .sliding-menu-content {
            padding: 20px;
        }
        .contribute-expert-section {
            margin-top: 10px; /* Add some space above the form */
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .contribute-expert-section h2 {
            font-size: 18px; /* Adjust the font size */
            color: #FA4B37; /* Match your theme color */
        }
        .contribute-expert-section input,
        .contribute-expert-section textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #FA4B37; /* Pink border */
            border-radius: 4px; /* Rounded corners */
        }
        .contribute-expert-section button {
            padding: 10px 20px;
            background-color: #FA4B37; /* Pink background */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s; /* Transition for hover effect */
        }
        .contribute-expert-section button:hover {
            background-color: #DF2771; /* Darker pink on hover */
        }
        .popup {
            display: none; /* Hidden by default */
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border : 1px solid #FA4B37;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .popup h2 {
            color: #FA4B37;
        }
        .popup button {
            background-color: #FA4B37;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
        }
        .popup button:hover {
            background-color: #DF2771;
        }
    </style>
</head>
</head>

<!-- Rest of your HTML content remains the same -->
<body>

<!-- Add Bootstrap navbar for mobile responsiveness -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand website-name" href="#">Rangeela Moves</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ">
            <li class="nav-item">
                <a class="nav-link" href="#home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#about_section">About</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="#contactus_section">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#feedBACK">Feedback</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#query_section"><i class="fas fa-question-circle"></i>Query</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="DanceCategory.html">Browse Categories</a> <!-- New Link -->
            </li>
        </ul>
        <?php if (isset($_SESSION['user_id'])): ?>
    <div class="user-icon ml-auto" onclick="toggleUserMenu()">
        <img src="images/profile_icon.png" alt="User Icon" style="border-radius: 50%; width: 40px; height: 40px;">
    </div>
    <div class="user-menu" id="userMenu">
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
<?php else: ?>
    <span class="menu-icon ml-auto" onclick="toggleSlidingMenu()">
        <i class="fas fa-bars"></i>
    </span>
<?php endif; ?>

    </div>
</nav>
<?php if (!isset($_SESSION['user_id'])): ?>
    <div class="sliding-menu-container">
        <div class="sliding-menu-content">
            <p><a href="#home"><i class="fas fa-home"></i> Home</a></p>
            <p><a href="#feedBACK"><i class="fas fa-comment"></i> Feedback</a></p>
        
            <p><a href="#contribute_expert" onclick="toggleExpertForm()">Contribute as Expert</a></p>
        </div>
    </div>
<?php endif; ?>

<!-- Contribute as Expert Form -->
<div class="contribute-expert-section" id="contribute_expert" style="display: none;">
    <h2>Contribute as Expert</h2>
    <p>If you would like to contribute as an expert, please fill out the form below and send your dance videos to <strong>guneet.kaur@wsu.edu</strong>.</p>
    <form action="submit_expert.php" method="post">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="text" name="phone" placeholder="Your Phone Number" required>
        <textarea name="message" placeholder="Tell us about your expertise" required></textarea>
        <button type="submit">Submit</button>
    </form>
</div>
<!-- Sliding menu container -->
<?php if (!isset($_SESSION['user_id'])): ?>
    <div class="sliding-menu-container">
        <div class="sliding-menu-content">
            <p><a href="#home"><i class="fas fa-home"></i> Home</a></p>
            <p><a href="#feedBACK"><i class="fas fa-comment"></i> Feedback</a></p>
            <p><a href="#query_section"><i class="fas fa-question-circle"></i> Query</a></p>
            <p><a href="#contactus_section"><i class="fas fa-life-ring"></i> Help</a></p>
            <p><a href="login.html"><i class="fas fa-sign-in-alt"></i> Log In</a></p>
        </div>
    </div>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
     function toggleExpertForm() {
        const expertForm = document.getElementById('contribute_expert');
        expertForm.style.display = expertForm.style.display === 'none' || expertForm.style.display === '' ? 'block' : 'none';
    }
    function toggleUserMenu() {
        const userMenu = document.getElementById("userMenu");
        userMenu.style.display = userMenu.style.display === "block" ? "none" : "block";
    }

    document.addEventListener("click", function(event) {
    const userMenu = document.getElementById("userMenu");
    const userIcon = document.querySelector(".user-icon");
    if (userMenu && userIcon && !userIcon.contains(event.target) && !userMenu.contains(event.target)) {
        userMenu.style.display = "none";
    }
});

    function toggleSlidingMenu() {
        const slidingMenu = document.querySelector(".sliding-menu-container");
        slidingMenu.style.right = slidingMenu.style.right === "0px" ? "-250px" : "0px";
    }

    document.addEventListener("click", function(event) {
        const slidingMenu = document.querySelector(".sliding-menu-container");
        const menuIcon = document.querySelector(".menu-icon");

        if (slidingMenu && menuIcon && !menuIcon.contains(event.target) && !slidingMenu.contains(event.target)) {
            slidingMenu.style.right = "-250px";
        }
    });
</script>
<div class="container" id="home">
    <div class="row">
        <div class="col-md-6">
            <p id="typed-text"></p>
            <a href="login.html"><button class="btn btn-primary">Get Started</button></a>
        </div>
        <div class="col-md-6">
            <img src="images/pink_dance.png" alt="Image" class="img-fluid" style="width: 70%; height: auto;">
        </div>
    </div>
</div>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="popup" id="thankYouPopup">
        <h2>Thank You!</h2>
        <p>Your submission has been received successfully.</p>
        <button onclick="closePopup()">Close</button>
    </div>
<?php endif; ?>
<script>
    // Text to be typed
    const textToType = "Step into the rhythm of creativity, where every move is a masterpiece. Showcase your passion, connect with experts, and inspire the world—one dance at a time. Let art move you on Rangeela Moves!";

    // DOM element where the text will be displayed
    const typedTextElement = document.getElementById("typed-text");

    // Typing animation function
    function typeText() {
        let index = 0;
        const typingInterval = 50; // Adjust the typing speed (lower value means faster typing)

        function typeNextCharacter() {
            if (index < textToType.length) {
                typedTextElement.textContent += textToType.charAt(index);
                index++;
                setTimeout(typeNextCharacter, typingInterval);
            }
        }

        typeNextCharacter();
    }

    // Call the typing animation function when the page loads
    window.addEventListener("load", typeText);
    function closePopup() {
        document.getElementById('thankYouPopup').style.display = 'none';
        document.getElementById('contribute_expert').style.display = 'none'; // Hide the form
    }

    // Show the popup if it exists
    window.onload = function() {
        if (document.getElementById('thankYouPopup')) {
            document.getElementById('thankYouPopup').style.display = 'block';
        }
    };
</script>

<!----=========Start your journey=================-->
<div class="container">
    <div class="title"><p>-------&#9829-------<br>Start your journey with us<br>-------&#9829-------</p></div>
    <div class="box">
        <p>1.<br>Sign up</p>
    </div>
    <div class="box">
        <p>2.<br>Connect</p>
    </div>
    <div class="box">
        <p>3.<br>Interact</p>
    </div>
</div>


<!-- =================ABOUT================== -->
<div class="diffSection" id="about_section">
    <center><p style="font-size: 50px; padding: 100px">About Us</p></center>
    <div class="about-content">
        <div class="side-image">
            <img class="sideImage" src="images\new.png">
        </div>
        <div class="side-text">
            <h2>Rangeela Moves</h2>
            <p>Welcome to Rangeela Moves, a place where dance from every corner of the world comes together! With thousands of dance styles across different cultures, there’s always something new to explore. Learn about the dance forms you love, upload your own performances, and connect with experts to refine your skills. Whether you’re here to showcase your passion or discover something new, Rangeela Moves is your space to celebrate dance and be inspired</p>
        </div>
    </div>
</div>


<!--=================== CONTACT US===================== -->
<div class="diffSection" id="contactus_section">
    <center><p style="font-size: 50px; padding: 100px">---&#9829--Contact Us---&#9829---</p></center>
    <div class="csec"></div>
    <div class="back-contact">
        <div class="cc">
        <form action="mailto:guneet.kaur@wsu.edu@gmail.com" method="post" enctype="text/plain">
            <label>First Name <span class="imp">*</span></label><label style="margin-left: 185px">Last Name <span class="imp">*</span></label><br>
            <center>
            <input type="text" name="" style="margin-right: 10px; width: 175px" required="required"><input type="text" name="lname" style="width: 175px" required="required"><br>
            </center>
            <label>Email <span class="imp">*</span></label><br>
            <input type="email" name="mail" style="width: 100%" required="required"><br>
            <label>Message <span class="imp">*</span></label><br>
            <input type="text" name="message" style="width: 100%" required="required"><br>
            <label>Additional Details</label><br>
            <textarea name="addtional"></textarea><br>
            <button type="submit" id="csubmit">Send Message</button>
        </form>
        </div>
    </div>
</div>

<!-- ============================FEEDBACK =========================-->
<div class="title2" id="feedBACK">
    <span>Give Feedback</span>
    <div class="shortdesc2">
        <p>Please share your valuable feedback to us</p>
    </div>
</div>

<div class="feedbox">
    
    <div class="feed">
        <form action="" method="post" enctype="text/plain">
            <label>Your Name</label><br>
            <input type="text" name="" class="fname" required="required"><br>
            <label>Email</label><br>
            <input type="email" name="mail" required="required"><br>
            <label>Additional Details</label><br>
            <textarea name="addtional"></textarea><br>
            <button type="submit" id="csubmit">Send Message</button>
        </form>
    </div>
</div>


<!-- ===============================FOOTER============================-->
<footer>
    <div class="footer-container" id="query_section">
        <div class="left-col">
            <p style="font-family: 'Pacifico' ;font-size:30px;">Rangeela Moves</p>
            <div class="social-media">
                <a href="#" style="  filter: invert(1);"><img src="images\facebook.png"></a>
                <a href="#" style="  filter: invert(1);"><img src="images\instagram.png"></a>
                <a href="#" style="  filter: invert(1);"><img src="images\twitter.png"></a>

            </div><br><br>
            <p class="rights-text"> Created By Avid Team.</p>
            <br><p><img src="images\location.png">Washington State University<br>Pullman,WA</p><br>
            <p><img src="images\phone.png"> +1-1234-567-890<br><img src="images\email.png" style="filter:invert(1)">&nbsp; guneet.kaur@wsu.com</p>
            <p><img src="images\email.png" style="filter:invert(1)">&nbsp; ananya.mukherjee1@wsu.com</p>
            <p><img src="images\email.png" style="filter:invert(1)">&nbsp; himanshi.vasani@wsu.com</p>
            <p><img src="images\email.png" style="filter:invert(1)">&nbsp; sneha.kataria@wsu.com</p>


        </div>


    <div class="right-col">
        <h1 style="color: #fff">Your Query</h1>
        <div class="border"></div><br>
        <div class="form-container">
            <form  action="query.php">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="text-box" placeholder="Enter your email...">

                <label for="query">Query:</label>
                <textarea id="query" name="query_message" class="feedback-textarea" placeholder="Type your query here..."></textarea>

                <button type="submit" class="submit-btn">Send Query</button>
            </form>
        </div>
    </div>

</div>
</footer>

</body>
</html>
