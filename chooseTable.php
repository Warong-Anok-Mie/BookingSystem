<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <title>Warong Anok Mie Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" integrity="sha512-DJLNx+VLY4aEiEQFjiawXaiceujj5GA7lIY8CHCIGQCBPfsEG0nGz1edb4Jvw1LR7q031zS5PpPqFuPA8ihlRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

<h1 style="color: #FEA116; text-align: center; margin-top: 50px">Select Your Table Position</h1>
<section class="table-selection">
   
    <div class="table-options">
        <div class="table table-1">
            <h3>Table 1</h3>
            <p>1 Chair</p>
            <button class="select-btn">Select</button>
        </div>

        <div class="table table-2">
            <h3>Table 2</h3>
            <p>2 Chairs</p>
            <button class="select-btn">Select</button>
        </div>

        <div class="table table-3">
            <h3>Table 3</h3>
            <p>3 Chairs</p>
            <button class="select-btn">Select</button>
        </div>

        <div class="table table-4">
            <h3>Table 4</h3>
            <p>1 Chair</p>
            <button class="select-btn">Select</button>
        </div>

        <div class="table table-5">
            <h3>Table 5</h3>
            <p>2 Chairs</p>
            <button class="select-btn">Select</button>
        </div>

        <div class="table table-6">
            <h3>Table 6</h3>
            <p>3 Chairs</p>
            <button class="select-btn">Select</button>
        </div>

        <div class="table table-7">
            <h3>Table 7</h3>
            <p>3 Chairs</p>
            <button class="select-btn">Select</button>
        </div>

        <div class="table table-8">
            <h3>Table </h3>
            <p>4 Chairs</p>
            <button class="select-btn">Select</button>
        </div>

        <div class="table table-9">
            <h3>Table 9</h3>
            <p>4 Chairs</p>
            <button class="select-btn">Select</button>
        </div>

        <div class="table table-10">
            <h3>Table 10</h3>
            <p>5 Chairs</p>
            <button class="select-btn">Select</button>
        </div>
    </div>
</section>

<style>
    .table-selection {
        margin-top: 50px;
        padding: 30px;
        background-color: #f2f2f2;
        border-radius: 5px;
        text-align: center;
        animation: fade-in 1s ease-in;
    }

    .table.selected {
        animation: selected-animation 1s ease-in-out;
    }

    .bottom-button {
        display: none;
        margin-top: 20px;
        padding: 15px 30px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
    }

    @keyframes selected-animation {
        0% { background-color: #f4f6dc; }
        50% { background-color: #e0ebeb; }
        100% { background-color: #f4f6dc; }
    }

    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .table-options {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-gap: 50px;
        justify-content: center;
    }
    

    .table {
        padding: 30px;
        background-color: #f4f6dc;
        border-radius: 10px;
        text-align: center;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }

    .table:hover {
        transform: scale(1.1);
    }
    .select-btn {
        margin-top: 10px;
        padding: 15px 30px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
    }
</style>

    </section>
</body>