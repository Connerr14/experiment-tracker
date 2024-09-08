<!DOCTYPE html>
<?php
require_once "../serverScripting/includes/config_session.inc.php";
require_once "../serverScripting/includes/login_view.inc.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sleep Experiment Tracker</title>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body id="homePage">
    <header>
        <?php
            include "../serverScripting/includes/navigation/globalHeader.php";
        ?>
    </header>
    <div class="content">
        <h2>Welcome to the Sleep Experiment Tracker</h2>
        <p>Track and analyze your sleep patterns to optimize your health and productivity. Set up your experiment and log your daily sleep metrics. Then, after the experiment time period, our analysis algorithms will analyze the data to see if the experiment factor had an impact on your sleep. </p>
        <a href="setup.php">Set Up Experiment</a>
        <a href="logStats.php">Enter Daily Stats</a>
    </div>
    <div id="imgContainer">
        <img src="../images/person-sleeping.png" alt="Person sleeping">
    </div>
    <div class="card-container">
        <div class="card">
            <h3>Improved Sleep Quality</h3>
            <p>Identify factors that improve your sleep quality and make adjustments to your sleep routine for better rest.</p>
        </div>
        <div class="card">
            <h3>Increased Energy Levels</h3>
            <p>Track your sleep and energy levels to find the optimal sleep duration and improve your daily productivity.</p>
        </div>
        <div class="card">
            <h3>Better Health Insights</h3>
            <p>Gain insights into your sleep patterns and overall health by analyzing your sleep data over time.</p>
        </div>
    </div>
    <div class="testimonials">
        <h2>What Our Users Say</h2>
        <div id="image-container">
            <img src="../images/five-star-rating.png" alt="5 star rating">
        </div>
        <div class="testimonial">
            <h4>John Doe</h4>
            <p>"This tracker has helped me improve my sleep quality tremendously. I now wake up feeling more refreshed and energized."</p>
        </div>
        <div class="testimonial">
            <h4>Jane Smith</h4>
            <p>"I love being able to see how my sleep patterns affect my daily energy levels. It's a game-changer for productivity."</p>
        </div>
        <div class="testimonial">
            <h4>Emily Johnson</h4>
            <p>"The insights I've gained from tracking my sleep have been invaluable for my overall health and well-being."</p>
        </div>
    </div>
    <div class="content">
        <h3>Ready to Get Started?</h3>
        <a href="setup.php">Start experimenting now</a>
    </div>  
    <footer>
        <?php
            include "../serverScripting/includes/navigation/globalFooter.php";
        ?>
    </footer>
</body>
</html>
