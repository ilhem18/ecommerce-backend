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
    font-family: 'cinzel', serif;
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
        background: #fff;
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
        font-size: 17px;
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
    .customers{
        position: relative;
        padding: 9rem 4rem;
    }
    .customer-header p{
        font-family: 'cinzel', serif;
        font-size: 28px;
        font-weight: 600;
        text-transform: uppercase;
        color: #c8815f;
    }
    .customer-body{
        border-top: 3px solid #333;
        padding-top: 1.5rem;
    }
    #orders .orders{
        position: relative;
        padding: 8rem 4rem;
    }
    .card-header h2{
        font-family: 'cinzel', serif;
        font-size: 40px;
        margin-bottom: 20px;
        text-transform: uppercase;
    }
    .product-body{
        position: relative;
        padding: 7rem;
    }
    .product-body .title h2{
        font-family: 'cinzel', serif;
        text-transform: uppercase;
        font-size: 30px;
        font-weight: 500;
        color: var(--clr-main);
        padding: 20px;
    }
    .addproducts{
        padding: 20px;
    }
    .addproducts button{
        padding: 20px;
        background: var(--clr-main);
        color: #fff;
        font-size: 18px;
        font-weight: 600;
        border: none;
        border-radius: 5px;
        border-bottom: 2px solid #000;
    }
    .categories-container{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px 25px;
    }
    .category:last-child {
    grid-column: 1 / span 2;
    justify-self: center;
    }
    .category{
    position: relative;
    display: flex;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    background-color: var(--clr-main);  
    }
    .category:before{
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: opacity 0.3s ease;
    }
    .category:hover::before{
    opacity: 1;
    }
    .category h2,
    .category button {
    position: relative;
    z-index: 1;
    text-align: center;
    color: var(--clr-bg);
    }
    .btn-category {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    padding: 10px 20px;
    font-size: 18px;
    }
    .category i {
    transition: transform 0.2s;
    }
    .category:hover i{
    transform: translateX(5px);
    }
    .new-product{
        position: relative;
        padding: 2rem;
        margin-top: 2rem;
        background: var(--clr-lightergrey);
        border: 3px solid var(--clr-main);
        box-shadow: 1px 0px 0px 1px rgba(0, 0, 0, .7);
    }
    .new-product p{
        padding:0 5px 20px 0px;
        font-size: 20px;
        font-weight: 500;
        color: #000;
    }
    .col{
        margin-bottom: 1rem;
    }
    .accounts{
        position: relative;
        padding: 7rem;
    }
    .account-header p {
        font-family: 'cinzel', serif;
        text-transform: uppercase;
        font-size: 25px;
        font-weight: 500;
        color: var(--clr-main);
        padding: 20px;
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
                <li><a href="#products"><i class="fa-solid fa-tag"></i><span>Products</span></a></li>
                <li><a href="#accounts"><i class="fa-solid fa-user"></i><span>Accounts</span></a></li>
            </ul>
        </div>
    </div>
    <section id="containers">
        <!--main dashboard-->
    <div id="main" class="section main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                <i class="fa-solid fa-bars"></i>
                </label>
                Dashboard
            </h2>
        
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
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
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
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
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
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
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
                    <th scope="row"></th>
                    <td></td>
                    <td></td>
                    <td></td>
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



    <!--customers dashboard-->
    <div id="customers" class="section main-content">
    <header>
            <h2>
                <label for="nav-toggle">
                <i class="fa-solid fa-bars"></i>
                </label>
                Dashboard
            </h2>
            
            <div class="user-wrapper">
                <a href="#"><i class="fa-solid fa-user"></i></a>
                    <h4>Admin</h4>
                    <form method="post">
                        <button type="submit" name="logout"><i class="fa-sharp fa-solid fa-right-from-bracket">Log Out</i></button>
                    </form>
            </div>
        </header>

        <div class="customers">
            <div class="customer-header">
                <p>List of customers</p>
            </div>
        <div class="customer-body">
        <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
        </tbody>
        </table>
        </div>
        </div>
    </div>

    <!--products dashboard-->
    <div id="products" class="section main-content">
    <header>
            <h2>
                <label for="nav-toggle">
                <i class="fa-solid fa-bars"></i>
                </label>
                Dashboard
            </h2>

            <div class="user-wrapper">
                <a href="#"><i class="fa-solid fa-user"></i></a>
                    <h4>Admin</h4>
                    <form method="post">
                        <button type="submit" name="logout"><i class="fa-sharp fa-solid fa-right-from-bracket">Log Out</i></button>
                    </form>
            </div>
        </header>
        <div class="product-body">
            <div class="addproducts">
                <button type="button"><a href="#new">Add new product</a></button>
            </div>
            <div class="title">
                <h2>all products</h2>
            </div>
            <div class="categories-container">
            <div class="category" onclick="window.location.href='./clothing.html#sets'">
              
              <div>
                <h2>Sets</h2>
                <button class="btn-category">
                  <span>view products<i class="fa-solid fa-arrow-right"></i></span>
                </button>
              </div>
            </div> <!-- end item 1 -->

            <div class="category" onclick="window.location.href='./clothing.html#shirts'">
              
              <div>
                <h2>Shirts</h2>
                <button class="btn-category">
                  <span>view products<i class="fa-solid fa-arrow-right"></i></span>
                </button>
              </div>
            </div> <!-- end item 2 -->

            <div class="category" onclick="window.location.href='./clothing.html#dresses'">
              
              <div>
                <h2>dresses</h2>
                <button class="btn-category">
                  <span>view products<i class="fa-solid fa-arrow-right"></i></span>
                </button>
              </div>
            </div> <!-- end item 3 -->

            <div class="category" onclick="window.location.href='./clothing.html#tops'">
              <img src="./pics/category4.jpg" alt="">
              <div>
                <h2>tops</h2>
                <button class="btn-category">
                  <span>view products<i class="fa-solid fa-arrow-right"></i></span>
                </button>
              </div>
            </div> <!-- end item 4 -->

            <div class="category" onclick="window.location.href='./clothing.html#pants'">
              
              <div>
                <h2>pants</h2>
                <button class="btn-category">
                  <span>view products<i class="fa-solid fa-arrow-right"></i></span>
                </button>
              </div>
            </div> <!-- end item 5 -->

            <div class="category" onclick="window.location.href='./clothing.html#coats'">
              
              <div>
                <h2>coats</h2>
                <button class="btn-category">
                  <span>view products<i class="fa-solid fa-arrow-right"></i></span>
                </button>
              </div>
            </div> <!-- end item 6 -->

            <div class="category" onclick="window.location.href='./clothing.html#jackets'">
              
              <div>
                <h2>jackets</h2>
                <button class="btn-category">
                  <span>view products<i class="fa-solid fa-arrow-right"></i></span>
                </button>
              </div>
            </div> <!-- end item 7 -->

            <div class="category" onclick="window.location.href='./bags.html#bags'">
              
              <div>
                <h2>bags</h2>
                <button class="btn-category">
                  <span>view products<i class="fa-solid fa-arrow-right"></i></span>
                </button>
              </div>
            </div> <!-- end item 8 -->

            <div class="category" onclick="window.location.href='./bags.html#backpacks'">
              
              <div>
                <h2>Backpacks</h2>
                <button class="btn-category">
                  <span>view products<br/><i class="fa-solid fa-arrow-right"></i></span>
                </button>
              </div>
            </div> <!-- end item 9 -->
          </div>


          <div id="new" class="new-product">
            <p>ajouter un nouveau produit:</p>
            <form action="functions.php" method="post">
            <div class="row">
                <div class="col">
                <input type="text" class="form-control" id="pname" name="pname" placeholder="Product's name">
                </div>
                <div class="col">
                <input type="text" class="form-control" id="pprice" name="pprice" placeholder="Product's price">
                </div>
            </div>
            <div class="row">
                <div class="col">
                <input type="number" class="form-control" id="pstock" name="pstock" placeholder="Number in stock">
                </div>
                <div class="col">
                    
                    <label>Product's image</label>
                    <input type="file" class="form-control-file" id="pimg" name="pimg" multiple>
                    
                </div>
            </div>
            <div class="row">
            <div class="col">
                <label for="sizeS">S:</label>
                <input type="number" id="sizeS" class="form-control" name="sizeS" min="0">
            </div>
            <div class="col">
                <label for="sizeM">M:</label>
                <input type="number" id="sizeM" class="form-control" name="sizeM" min="0">
            </div>
            <div class="col">
                <label for="sizeL">L:</label>
                <input type="number" id="sizeL" class="form-control" name="sizeL" min="0">
            </div>
            <div class="col">
                <label for="sizeXL">XL:</label>
                <input type="number" id="sizeXL" class="form-control" name="sizeXL" min="0">
            </div>
            </div>
            <div class="row">
                <div class="col">
                <label>categories:</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="sets" name="sets">
                        <label class="form-check-label" for="sets">SETS</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="jackets" name="jackets">
                        <label class="form-check-label" for="jackets">JACKETS</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="coats" name="coats">
                        <label class="form-check-label" for="coats">COATS</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="pants" name="pants">
                        <label class="form-check-label" for="pants">PANTS</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tops" name="tops">
                        <label class="form-check-label" for="tops">TOPS</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="dresses" name="dresses">
                        <label class="form-check-label" for="dresses">DRESSES</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="shirts" name="shirts">
                        <label class="form-check-label" for="shirts">SHIRTS</label>
                    </div> 
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="bags" name="bags">
                        <label class="form-check-label" for="bags">BAGS</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="backpacks" name="backpacks">
                        <label class="form-check-label" for="backpacks">BACKPACKS</label>
                    </div>           
                </div>
                <div class="col">
                    <div class="form-group">
                    <label for="productDescription">Product description</label>
                    <textarea class="form-control" id="productDescription" name="productDescription" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="col">
                <button type="submit" name="addproduct" class="btn btn-secondary">Add product</button>
            </div>
            </form>
          </div>
        </div>
    </div>



    <!--accounts dashboard-->
    <div id="accounts" class="section main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                <i class="fa-solid fa-bars"></i>
                </label>
                Dashboard
            </h2>
            
            <div class="user-wrapper">
                <a href="#"><i class="fa-solid fa-user"></i></a>
                    <h4>Admin</h4>
                    <form method="post">
                        <button type="submit" name="logout"><i class="fa-sharp fa-solid fa-right-from-bracket">Log Out</i></button>
                    </form>
            </div>
        </header>
        <div class="accounts">
            <div class="account-header">
                <p>List of accounts</p>
            </div>
            <div class="account-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>
                            <th scope="col">date inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
  // Hide all tables except the initially active one
  const activeTab = $('.nav-link.active').attr('href');
  $('#tableContainer table').not(activeTab).hide();

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