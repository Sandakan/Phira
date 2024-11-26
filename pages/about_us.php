<?php
require('../config.php');
require('../utils/database.php');
session_start();

$conn = initialize_database();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Phira</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/legal.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/index.css">
</head>

<body>
    <header>
    <div class="logo">
    <a href="<?php echo BASE_URL; ?>/index.php"><img src="../public/images/logo-white" alt="logo"></a>
		</div>

		<ul class="nav-bar">
        <li><a href="./help.php">Help</a></li>
			<li><a href="./about_us.php">About</a></li>
			<li><a href="./contact_us.php">Contact</a></li>
			<li><a href="./privacy_policy.php">Privacy Policy</a></li>
		</ul>
		<a href="<?php echo BASE_URL; ?>/pages/auth/login.php" id="get">Get started</a>

    </header>
    <div class="header">
    
        <div class="header-content">
            <h1>About Phira</h1>
            <p>Connecting hearts, building meaningful relationships.</p>
        </div>
    </div>
    <main class="about-container">
        <div class="about-content">

            <div class="term">
                <h3>Who We Are</h3>
                <p>Phira is a dating platform designed to help people connect authentically, share experiences, and find
                    lasting relationships. Our goal is to create a space where love knows no boundaries, fostering
                    connections that go beyond the surface.</p>
            </div>

            <div class="about-values">
                <h2>Our Values</h2>
                <div class="values-grid">
                    <div class="value-item">
                        <h3>Authenticity</h3>
                        <p>We believe in genuine connections and encourage honesty and transparency among our users.</p>
                    </div>
                    <div class="value-item">
                        <h3>Safety</h3>
                        <p>User safety is our top priority. Our platform includes safety features to ensure a secure
                            experience for everyone.</p>
                    </div>
                    <div class="value-item">
                        <h3>Inclusivity</h3>
                        <p>Phira welcomes individuals from all backgrounds, promoting diversity and respect within our
                            community.</p>
                    </div>
                </div>
            </div>

            <section class="term">
                <h3>Our Journey</h3>
                <p>Founded by a passionate team of developers and designers, Phira started as a university project with
                    a vision to make online dating more personal and meaningful. We've grown from a small idea to a
                    global platform, dedicated to transforming how people meet and connect.</p>
            </section>

            <section class="about-team">
                <h2>Meet the Team</h2>
                <p>Behind Phira is a team of innovative thinkers, problem-solvers, and relationship enthusiasts. Each
                    member plays a unique role, contributing their expertise to bring Phira to life.</p>
                <div class="team-grid">
                    <div class="team-member">
                        <img src="../public/images/team/sandakan.jpg" alt="Sandakan Nipunajith">
                        <h3>Sandakan Nipunajith</h3>
                        <p>Project Manager & Backend Developer</p>
                    </div>
                    <div class="team-member">
                        <img src="../public/images/team/sanuja.jpg" alt="Sanuja Menath">
                        <h3>Sanuja Menath</h3>
                        <p>Database Developer & Backend Developer</p>
                    </div>
                    <div class="team-member">
                        <img src="../public/images/team/vimukthi.jpg" alt="Vimukthi Pramudantha">
                        <h3>Vimukthi Pramudantha</h3>
                        <p>UI/UX Designer & Frontend Developer</p>
                    </div>
                    <div class="team-member">
                        <img src="../public/images/team/chamod.jpg" alt="Gihan Chamod">
                        <h3>Gihan Chamod</h3>
                        <p>Quality Assurance</p>
                    </div>
                    <div class="team-member">
                        <img src="../public/images/team/sasara.jpg" alt="Sasara Kavishan">
                        <h3>Sasara Kavishan</h3>
                        <p>Quality Assurance</p>
                    </div>
                </div>
            </section>

            <section class="team-culture">
                <h2>Our Culture: More Than Just Code</h2>
                <p>At Phira, we're not just a team—we're a family with a mission to create meaningful connections. Each
                    member brings unique skills and personality to the table:</p>
                <div class="culture-grid">
                    <div class="culture-item">
                        <img src="../public/images/team/sandakan.jpg" alt="Sandakan Nipunajith">
                        <h3>🧩 Sandakan Nipunajith</h3>
                        <p>The mastermind behind our backend, always three steps ahead. If it’s complex, Sandakan’s got
                            it covered!</p>
                    </div>
                    <div class="culture-item">
                        <img src="../public/images/team/sanuja.jpg" alt="Sanuja Menath">
                        <h3>⚙️ Sanuja Menath</h3>
                        <p>Database wizard. He keeps everything organized and flowing smoothly—no data challenge is too
                            big.</p>
                    </div>
                    <div class="culture-item">
                        <img src="../public/images/team/vimukthi.jpg" alt="Vimukthi Pramudantha">
                        <h3>🎨 Vimukthi Pramudantha</h3>
                        <p>Our frontend artist. Designs come to life with his magic touch, blending creativity with
                            functionality.</p>
                    </div>
                    <div class="culture-item">
                        <img src="../public/images/team/chamod.jpg" alt="Gihan Chamod">
                        <h3>🔍 Gihan Chamod</h3>
                        <p>QA detective. He ensures Phira runs flawlessly, one bug at a time. His attention to detail is
                            unmatched!</p>
                    </div>
                    <div class="culture-item">
                        <img src="../public/images/team/sasara.jpg" alt="Sasara Kavishan">
                        <h3>🔍 Sasara Kavishan</h3>
                        <p>Our second QA expert. Sasara works hand-in-hand with Gihan, finding those last bugs and
                            making sure everything is smooth.</p>
                    </div>
                </div>
                <p class="culture-footer">Together, we build, innovate, and laugh. Sometimes, we even predict what each
                    other will say. 🤔😂</p>
            </section>

        </div>
    </main>
</body>

</html>