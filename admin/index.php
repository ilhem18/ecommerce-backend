<?php

session_start();
// Check if user is not logged in
if (isset($_SESSION['userID']) == "") {
    // Redirect to the login page
    header("Location: ../controllers/login.php");
}
if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['userID']);
    header("Location: ../controllers/login.php");
  }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="../pics/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Admin Dashbord</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Lobster+Two:wght@400;700&family=Roboto:wght@300;400;500;700&display=swap');
    :root{
    --clr-bg: #fff;
    --clt-txt: #111111;
    --clr-main: #c8815f;
    --clr-grey: #999999;
    --clr-darkgrey: #D7DCE2;
    --clr-lightergrey: #F7F7F7;
    --font-big: 4.5rem;
    --font-h3: 2rem;
    --font-body: 1rem;
}
    *{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    list-style-type: none;
    text-decoration: none;
}
    .sidebar{
        width:345px;
        position: fixed;
        left:0;
        top:0;
        height:100%;
        background: var(--clr-main);
        z-index: 100;
}
    .main-content{
        transition : margin-left 300ms;
        margin-left: 345px;
}
    .logo{
    font-family: 'Lobster Two', cursive;
    font-weight: 700;
    color: var(--clt-txt);
    font-size: var(--font-h3);
    text-transform: capitalize;
}
a{
    text-decoration:none;
    color: #000;
}
    .sidebar-brand{
    height: 90px;
    padding: 20px;
}
    .sidebar-menu{
        margin-top: 1rem;
    }
    .sidebar-menu li{
        width: 100%;
        margin-bottom: 2.5rem;
        padding-left: 1rem;
}
    .sidebar-menu a{
        padding-left: 1rem;
        display: block;
        color: #fff;
        font-size: 1.3rem;
    }
    .sidebar-menu a.active{
        background: #fff;
        padding-top: 1rem;
        padding-bottom: 1rem;
        color: #c8815f;
        border-radius: 30px 0px 0px 30px;
    }
    .sidebar-menu a i:first-child{
        font-size: 1.5rem;
        padding-right: 1rem;
    }
    header{
        display: flex;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        position: fixed;
        left: 345px;
        width: calc(100% - 345px);
        top: 0;
        z-index: 100;
    }
    header h2{
        color: #555;
    }
    header label i{
        font-size: 1.7rem;
        padding-right: 1rem;
    }
    .search-wrapper{
        border: 1px solid #ccc;
        border-radius: 30px;
        height: 50px;
        display: flex;
        align-items: center;
    }
    .search-wrapper i{
        display: inline-block;
        padding: 0rem 1rem;
        font-size: 1.2rem;
    }
    .search-wrapper input{
        height: 100%;
        padding: .5rem;
        border: none;
        outline: none;
    }
    .user-wrapper{
        display: flex;
        align-items: center;
    }
    .user-wrapper i{
        border-radius: 50%;
        margin-right: 1rem; 
    }
    .user-wrapper button{
        padding: 10px;
        display: flex;
        position: relative;
        background: #fff;
        border: none;
        outline: none;
        font-size: 15px;
    }
    .user-wrapper button:hover{
        font-size: 20px;
        color: #fff;
        background: red;
        border-radius: 4px;
    }
    main{
        margin-top: 85px;
        padding: 2rem 1.5rem;
        background: #F7F7F7;
        min-height: calc(100vh - 90px);
    } 
    .cards{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 2rem;
        margin-top: 1rem;
    }
    .card-single{
        display: flex;
        justify-content: space-between;
        background: #fff; 
        padding: 2rem;
        border-radius: 2px;
    }
    .card-single div:first-child span{
        color: #555;
    }
    .card-single div:last-child i{
        font-size: 2rem;
        color: #c8815f;
    }
    .card-single:last-child{
        background: #c8815f;
    }
    .card-single:last-child h1,
    .card-single:last-child div:first-child span,
    .card-single:last-child div:last-child i{
        color: #fff;
    }
    .orders{
        position: relative;
        padding: 2rem;
    }
    .card-header h2{
        font-size: 40px;
        margin-bottom: 20px;
        text-transform: uppercase;
    }
    #nav-toggle{
        display: none;
    }
    #nav-toggle:checked + .sidebar{
        width: 100px;
    }
    .main-content.adjusted-margin {
        margin-left: 98px; /* Adjusted margin */
}
    #nav-toggle:checked + .sidebar .sidebar-brand h2 span:last-child,
    #nav-toggle:checked + .sidebar li a span:last-child{
        display:none;
    }
    #nav-toggle:checked + .sidebar li a{
        padding-left: 0rem;
    }
    #nav-toggle:checked + .sidebar li a span{
        padding-right: 1rem;
        text-align: center;
    }
    @media only screen and (max-width: 1200px){
        .sidebar{
        width: 100px;
    }
    .main-content {
        margin-left: 98px; /* Adjusted margin */
}
    header{
        width: calc(100% - 98px);
        left: 98px;
    }
    .sidebar .sidebar-brand h2 span:last-child,
    .sidebar li a span:last-child{
        display:none;
    }
    .sidebar li a{
        padding-left: 0rem;
    }
    .sidebar li a span{
        padding-right: 1rem;
        text-align: center;
    }
    }

    @media only screen and (max-width: 960px){
        .cards{
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media only screen and (max-width: 768px){
        .cards{
            grid-template-columns:100%;
        }
        .search-wrapper{
            display: none;
        }
    }
    </style>
</head>
<body>
    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2 class="logo">el<span>enganza</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul id="myLinks">
                <li><a href="#main" class="active"><i class="fa-solid fa-house"></i><span>Dashboard</span></a></li>
                <li><a href="#customers"><i class="fa-solid fa-users"></i><span>Customers</span></a></li>
                <li><a href="#orders"><i class="fa-solid fa-basket-shopping"></i><span>Orders</span></a></li>
                <li><a href="#products"><i class="fa-solid fa-tag"></i><span>Products</span></a></li>
                <li><a href="#accounts"><i class="fa-solid fa-user"></i><span>Accounts</span></a></li>
            </ul>
        </div>
    </div>
    <section id="containers">
    <div id="main" class="section main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                <i class="fa-solid fa-bars"></i>
                </label>
                Dashboard
            </h2>
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Search here" />
            </div>
            <div class="user-wrapper">
                <a href="#"><i class="fa-solid fa-user"></i></a>
                    <h4>Admin</h4>
                    <form method="post">
                        <button type="submit" name="logout"><i class="fa-sharp fa-solid fa-right-from-bracket">Log Out</i></button>
                    </form>
            </div>
        </header>




        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1>54</h1>
                        <span>Customers</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1>223</h1>
                        <span>Orders</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-basket-shopping"></i>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1>54.000 DZD</h1>
                        <span>Incomes</span>
                    </div>
                    <div>
                    <i class="fa-solid fa-coins"></i>
                    </div>
                </div>
            </div>
            
                <div class="orders">
                        <div class="card-header">
                        <h2>Orders</h2>
                                <ul id="myTabs" class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#all">All orders</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#completed">Completed</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#panding">Panding</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#canceled">Canceled</a>
                                </li>
                                </ul>
                        </div>
                        <div id="tableContainer" class="card-body">
                            <!--all orders table-->
                        <table id="all" class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">OrderID</th>
                                <th scope="col">ProductName</th>
                                <th scope="col">Address</th>
                                <th scope="col">Date</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <!--completed orders table-->
                        <table id="completed" class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">OrderID</th>
                                <th scope="col">ProductName</th>
                                <th scope="col">Address</th>
                                <th scope="col">Date</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">2</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <!--panding orders table-->
                        <table id="panding" class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">OrderID</th>
                                <th scope="col">ProductName</th>
                                <th scope="col">Address</th>
                                <th scope="col">Date</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">3</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <!--canceled orders table-->
                        <table id="canceled" class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">OrderID</th>
                                <th scope="col">ProductName</th>
                                <th scope="col">Address</th>
                                <th scope="col">Date</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">4</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                </div>
        </main>
    </div>
    <div id="customers" class="section">Customers section</div>
    <div id="orders" class="section">Orders section</div>
    <div id="products" class="section">Products section</div>
    <div id="accounts" class="section">Accounts section</div>
    </section>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
            $(document).ready(function() {
        $('#nav-toggle').change(function() {
            if ($(this).is(':checked')) {
            $('.main-content').addClass('adjusted-margin');
            $('header').css('width', 'calc(100% - 98px)').css('left', '98px');
            } else {
            $('.main-content').removeClass('adjusted-margin');
            $('header').css('width', '').css('left', '');
            }
        });
        });
    </script>
<script>
    $(document).ready(function() {
        // Hide all tables except the first one initially
        $('#tableContainer table:not(:first)').hide();

        // Add click event handler to the tab links
        $('#myTabs a').click(function(e) {
            e.preventDefault(); // Prevent the default link behavior


            // Remove "active" class from all tab links
            $('#myTabs a').removeClass('active');

            // Add "active" class to the clicked tab link
            $(this).addClass('active');


            // Get the ID of the selected tab
            const selectedTab = $(this).attr('href');

            // Hide all tables
            $('#tableContainer table').hide();

            // Display the selected table
            $(selectedTab).show();
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Hide all sections except the first one initially
        $('.section:not(:first)').hide();

        // Add click event handler to the tab links
        $('#myLinks a').click(function(e) {
            e.preventDefault(); // Prevent the default link behavior

            // Remove "active" class from all tab links
            $('#myLinks a').removeClass('active');

            // Add "active" class to the clicked tab link
            $(this).addClass('active');

            // Get the ID of the selected section
            const selectedSection = $(this).attr('href');

            // Hide all sections
            $('.section').hide();

            // Display the selected section
            $(selectedSection).show();
        });
    });
</script>
</body>
</html>