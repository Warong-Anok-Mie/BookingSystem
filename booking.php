<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <title>Warong Anok Mie Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" integrity="sha512-DJLNx+VLY4aEiEQFjiawXaiceujj5GA7lIY8CHCIGQCBPfsEG0nGz1edb4Jvw1LR7q031zS5PpPqFuPA8ihlRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        .booking-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 100px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            max-width: 3000px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <section class="header">
        <nav class="navbar">
            <div class="brand-title">
                <img src="img/WARONG.jpg" alt="Logo" class="logo">
                Warong Anok Mie
            </div>
            <a href="#" class="toggle-button">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </a>
            <div class="navbar-links">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="anokmielogin.php" class="hero-btn book">Book a Table</a></li>


                </ul>
            </div>
        </nav>

<div class="booking-form">          
    <h1 style="font-color: white;">Warong Anok Mie Booking Form</h1>
    <form action="process_booking.php" method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div>
            <label for="time">Time:</label>
            <select type="time" name="reservation_time" class="form-control" placeholder="Heure" id="time" required="">
                    <option value=""> -Select- </option>
                    <option value="10:00 h">08:00</option>
                    <option value="10:00 h">08:30</option>
                    <option value="10:00 h">09:00</option>
                    <option value="10:00 h">09:30</option>
                    <option value="10:00 h">10:00</option>
                    <option value="10:30 h">10:30</option>
                    <option value="11:00 h">11:00</option>
                    <option value="11:30 h">11:30</option>
                    <option value="12:00 h">12:00</option>
                    <option value="12:30 h">12:30</option>
                    <option value="13:00 h">13:00</option>
                    <option value="13:30 h">13:30</option>
                    <option value="14:00 h">14:00</option>
                    <option value="14:30 h">14:30</option>
                    <option value="15:00 h">15:00</option>
                    <option value="15:30 h">15:30</option>
                    <option value="16:00 h">16:00</option>
                    <option value="16:30 h">16:30</option>
                    <option value="17:00 h">17:00</option>
                    <option value="17:30 h">17:30</option>
                    <option value="18:00 h">18:00</option>
                    <option value="18:30 h">18:30</option>
                    <option value="19:00 h">19:00</option>
                    <option value="19:30 h">19:30</option>
                    <option value="20:00 h">20:00</option>
                    <option value="20:30 h">20:30</option>
                    <option value="21:00 h">21:00</option>
                    <option value="21:30 h">21:30</option>
                    <option value="22:00 h">22:00</option>
                    <option value="22:30 h">22:30</option>
                    <option value="23:00 h">23:00</option>
                    <option value="23:30 h">23:30</option>
                    <option value="00:00 h">00:00</option>
                    <option value="00:30 h">00:30</option>
                    <option value="01:00 h">01:00</option>
                    <option value="01:30 h">01:30</option>
                  </select>
        </div>
        <div>
            <input type="submit" value="Book Table">
        </div>
    </form>
</div>


</body>       
       