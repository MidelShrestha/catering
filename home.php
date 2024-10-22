<?php
    include("connection.php");
?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Catering Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="main">
        <div class="navbar">
            <div class="icon">
                <img src="photos/logo.png" class="logo">
            </div>

            <div class="menu">
                <ul>
                    <li><a href="home.php">HOME</a></li>
                    <li><a href="#aboutus">ABOUT US</a></li>
                    <li><a href="#contact">CONTACT</a></li>
                    <li><a href="login.php">LOGIN</a></li>
                </ul>
            </div>
            

        </div> 
        <div class="content">
            <h1>Welcome To <br> Shrestha Catering Service</h1>
            
                
                    </div>
                </div>
        </div>
    </div>

    <!--about us-->
    <section class="aboutus">
        <div class="container">
            <h1>About Shrestha Catering</h1>
            <p>At Shrestha Catering, we bring passion and expertise to every meal we serve. With a commitment to excellence, our team specializes in creating memorable culinary experiences for events of all sizes. From intimate gatherings to large corporate events, we craft menus that are both innovative and tailored to your specific needs. Our dedication to fresh ingredients and authentic flavors ensures that every dish reflects the quality and care that Shrestha Catering is known for.</p>
            <p>Our diverse menu, blending traditional recipes with modern cuisine, ensures there's something for every palate. Whether you are hosting a wedding, private party, or corporate event, we take pride in delivering top-tier service and exceptional food that will leave a lasting impression.</p>
        </div>
    </section>

    <section class="contactus">
        <div class="contain">
            <h1>Contact Us</h1>
            <p>Feel free to reach out to us</p>

            <div class="contact-info">
                <p><strong>Email:</strong> contact@shresthacatering.com</p>
                <p><strong>Phone:</strong> 9818696998</p>
                <p><strong>Address:</strong> Kirtipur, Kathmandu</p>
            </div>

            <form class="contact-form" action="#" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>

</body>
</html>