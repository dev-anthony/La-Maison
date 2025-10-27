<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/Authentication/frontend/css/user-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
        <h3 class="logo">La Maison<i class="fa-solid fa-house"></i></h3>
        <nav>
            <a href="">Dashboard</a>
            <a href="/Authentication/frontend/php/admin-inbox.php">Messages</a>
            <a href="/Authentication/frontend/html/notifications.html">Notifications</a>
            <a href="/Authentication/frontend/html/review.html">Review / Feedback</a>
            <a href="">About</a>
        </nav>
        <div class="other-links">
            <a href="">Help & Support</a>
            <a href="/Authentication/backend/logout.php">Logout</a>
        </div>
        </aside>

        <div class="main">
            <header>
               <div class="text"> <h2 id="user"></h2>
                <div class="search-container">
                <input type="text" id="searchInput">
                <button id="search-btn">Find Your <i class="fa-solid fa-house"></i></button>
                </div> 
                </div>
                <button id="menubutton">
                  <i class="fa fa-bars" ></i>
                </button>
            </header>

            <div class="house-section" id="house-section">
            <div class="house-list" id="house-list"></div>
            </div>
        </div>
    </div>
    <script src="/Authentication/frontend/js/user-dashboard.js"></script>
    <script>
        
        const menubtn = document.getElementById("menubutton")
const sidebar = document.querySelector('.sidebar');
menubtn.addEventListener('click', ()=>{
  const icon = menubtn.querySelector("i");
  sidebar.classList.toggle('active');

  if(sidebar.classList.contains('active')){
    icon.classList.remove('fa-bars');
    icon.classList.add('fa-times');
  }else{
    icon.classList.remove('fa-times');
    icon.classList.add('fa-bars');
  }
})
    </script>
</body>
</html> -->
<?php
require_once '../../config/config.php'; // <-- fixed path
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= $BASE_URL ?>/frontend/css/user-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h3 class="logo">La Maison<i class="fa-solid fa-house"></i></h3>
            <nav>
                <a href="#">Dashboard</a>
                <a href="<?= $BASE_URL ?>/frontend/php/admin-inbox.php">Messages</a>
                <a href="<?= $BASE_URL ?>/frontend/html/notifications.html">Notifications</a>
                <a href="<?= $BASE_URL ?>/frontend/html/review.html">Review / Feedback</a>
                <a href="#">About</a>
            </nav>
            <div class="other-links">
                <a href="#">Help & Support</a>
                <a href="<?= $BASE_URL ?>/backend/logout.php">Logout</a>
            </div>
        </aside>

        <div class="main">
            <header>
                <div class="text">
                    <h2 id="user"></h2>
                    <div class="search-container">
                        <input type="text" id="searchInput">
                        <button id="search-btn">Find Your <i class="fa-solid fa-house"></i></button>
                    </div>
                </div>
                <button id="menubutton">
                    <i class="fa fa-bars"></i>
                </button>
            </header>

            <div class="house-section" id="house-section">
                <div class="house-list" id="house-list"></div>
            </div>
        </div>
    </div>

    <script src="<?= $BASE_URL ?>/frontend/js/user-dashboard.js"></script>
    <script>
        const menubtn = document.getElementById("menubutton")
        const sidebar = document.querySelector('.sidebar');
        menubtn.addEventListener('click', () => {
            const icon = menubtn.querySelector("i");
            sidebar.classList.toggle('active');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });
    </script>
</body>
</html>
