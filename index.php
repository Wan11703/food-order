
<?php include('partials-front/menu.php'); 
if (!isset($_SESSION['user_id'])) {
    header('location:'.SITEURL.'login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_COOKIE['username'])) {
            
    header("Location: LOGIN.php");
    exit();
}


$username = $_COOKIE['username'];


?>



<!-- Main content -->
<div class="container">
    <!-- Button to Open Modal -->
    <button id="open-modal" class="btn btn-primary">Open To-Do List & Calendar</button>
    
    <!-- Modal Window -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span id="close-modal" class="close-btn">&times;</span>

            <!-- To-Do List Widget -->
            <div class="todo-widget">
                <h3>To-Do List</h3>
                <ul id="todo-list">
                    
                </ul>
                <input type="text" id="new-task" placeholder="New task..." />
                <button onclick="addTask()">Add Task</button>
                <button onclick="removeCompletedTasks()">Remove Completed Tasks</button>
            </div>

            <!-- Calendar Widget -->
            <div class="calendar-widget">
                <h3>Calendar</h3>
                <div id="calendar"></div>
                <div id="selected-date"></div>
            </div>

            <!-- Top 5 Most Bought Products -->
            <div class="row g-5 mt-4">
                <div class="col-lg-12">
                    <div class="card bg-white pb-2 w-100 h-100">
                        <div class="card-body text-dark">
                            <h3 class="text-center">Top 5 Most Bought Products</h3>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Rank</th>
                                    <th>Product Name</th>
                                    <th>Order Count</th>
                                </tr>

                                <?php
                                // Query to get the top 5 most bought products
                                $sql_top_bought_products = "
                                    SELECT food, COUNT(food) AS order_count
                                    FROM tbl_orders
                                    WHERE status = 'Delivered' -- Only consider delivered orders
                                    GROUP BY food
                                    ORDER BY order_count DESC
                                    LIMIT 5
                                ";
                                $res_top_bought_products = mysqli_query($conn, $sql_top_bought_products);

                                if ($res_top_bought_products && mysqli_num_rows($res_top_bought_products) > 0) {
                                    $rank = 1;
                                    while ($row = mysqli_fetch_assoc($res_top_bought_products)) {
                                        $product_name = $row['food'];
                                        $order_count = $row['order_count'];

                                        echo "<tr>
                                                <td>$rank</td>
                                                <td>$product_name</td>
                                                <td>$order_count</td>
                                              </tr>";
                                        $rank++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='error'>No products found</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Main content ends -->

<script>
// Modal JavaScript
const openModalButton = document.getElementById("open-modal");
const modal = document.getElementById("modal");
const closeModalButton = document.getElementById("close-modal");

openModalButton.onclick = function() {
    modal.style.display = "block"; // Show the modal when the button is clicked
}

closeModalButton.onclick = function() {
    modal.style.display = "none"; // Hide the modal when the close button is clicked
}

// To close modal if clicked outside the modal content
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// To-Do List JavaScript
function addTask() {
    var newTask = document.getElementById("new-task").value;
    if (newTask.trim() === "") {
        alert("Please enter a task.");
        return;
    }

    var ul = document.getElementById("todo-list");
    var li = document.createElement("li");
    li.innerHTML = `<input type="checkbox" onclick="completeTask(this)"> ${newTask}`;
    ul.appendChild(li);

    // Clear input after adding
    document.getElementById("new-task").value = "";
}

// Mark task as complete and remove it
function completeTask(checkbox) {
    var taskText = checkbox.parentElement;
    if (checkbox.checked) {
        taskText.style.textDecoration = "line-through"; // Strike-through
        taskText.style.color = "gray"; // Change text color to gray
        setTimeout(function() {
            taskText.remove(); // Remove task after it's marked as complete
        }, 500); // Add a delay before removal
    } else {
        taskText.style.textDecoration = "none"; // Remove strike-through
        taskText.style.color = "black"; // Reset text color
    }
}

// Remove all completed tasks
function removeCompletedTasks() {
    const tasks = document.querySelectorAll("#todo-list li");
    tasks.forEach(task => {
        if (task.querySelector("input[type='checkbox']").checked) {
            task.remove();
        }
    });
}

// Calendar JavaScript
const calendar = document.getElementById("calendar");

function generateCalendar(month, year) {
    calendar.innerHTML = "";
    const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const firstDayOfMonth = new Date(year, month, 1).getDay();
    
    // Add the header row (Days of the week)
    const headerRow = document.createElement("tr");
    daysOfWeek.forEach(day => {
        const th = document.createElement("th");
        th.innerText = day;
        headerRow.appendChild(th);
    });
    calendar.appendChild(headerRow);

    // Add the calendar days
    let row = document.createElement("tr");
    let dayCounter = 1;

    // Empty spaces for the first row (before the first day of the month)
    for (let i = 0; i < firstDayOfMonth; i++) {
        row.appendChild(document.createElement("td"));
    }

    // Fill in the days of the month
    for (let i = firstDayOfMonth; i < 7; i++) {
        const td = document.createElement("td");
        td.innerText = dayCounter++;
        td.onclick = function() { showSelectedDate(td.innerText); };
        row.appendChild(td);
    }
    calendar.appendChild(row);

    // Fill in the remaining weeks
    while (dayCounter <= daysInMonth) {
        row = document.createElement("tr");
        for (let i = 0; i < 7 && dayCounter <= daysInMonth; i++) {
            const td = document.createElement("td");
            td.innerText = dayCounter++;
            td.onclick = function() { showSelectedDate(td.innerText); };
            row.appendChild(td);
        }
        calendar.appendChild(row);
    }

    // Display current date and year
    const currentDate = new Date();
    document.getElementById("selected-date").innerHTML = `Date: ${currentDate.toLocaleDateString()}`;
}

// Show selected date from the calendar
function showSelectedDate(day) {
    const currentMonth = new Date().getMonth() + 1;
    const currentYear = new Date().getFullYear();
    const selectedDate = `${currentMonth}/${day}/${currentYear}`;
    document.getElementById("selected-date").innerHTML = `Selected Date: ${selectedDate}`;
}

// Navigate between months
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

function goToPreviousMonth() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    generateCalendar(currentMonth, currentYear);
}

function goToNextMonth() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    generateCalendar(currentMonth, currentYear);
}

// Initialize the calendar on page load
generateCalendar(currentMonth, currentYear);
</script>

<!-- CSS Styles for the Modal -->
<style>
.container {
    margin-top: 20px;
}

#open-modal {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

#open-modal:hover {
    background-color: #0056b3;
}

.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
    overflow: auto; /* Enable scroll if needed */
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 10px;
}

.close-btn {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close-btn:hover,
.close-btn:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.todo-widget, .calendar-widget {
    width: 100%;
    padding: 20px;
    border-radius: 5px;
}

h3 {
    text-align: center;
}

ul {
    list-style-type: none;
    padding-left: 0;
}

ul li {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

ul li input[type="checkbox"] {
    margin-right: 10px;
}

input[type="text"] {
    width: 70%;
    padding: 5px;
    margin-right: 10px;
}

button {
    padding: 5px 10px;
}

.calendar-widget {
    display: inline-block;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 8px;
    text-align: center;
    border: 1px solid #ccc;
}

table th {
    background-color: #f1f1f1;
}

td {
    cursor: pointer;
}

#selected-date {
    margin-top: 10px;
    text-align: center;
    font-size: 16px;
    font-weight: bold;
}
</style>

<!-- fOOD sEARCH Section Starts Here -->
<br>
<section class="food-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="What's Our Cravings For Today.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php
if(isset($_SESSION['order'])){
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}

// Add to Cart functionality
if(isset($_POST['add_to_cart'])){
    $food_id = $_POST['food_id'];
    $qty = $_POST['qty'];

    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    $title = $row['title'];
    $price = $row['price'];
    $image_name = $row['image_name'];

    $total = $price * $qty;

    $item_exists = false;

    // Check if the item already exists in the cart
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $key => $item){
            if($item['food_id'] == $food_id && $item['qty'] + $qty <= 99){
                $_SESSION['cart'][$key]['qty'] += $qty;
                $_SESSION['cart'][$key]['total'] += $total;
                $item_exists = true;
                break;
            }
        }
    }

    if(!$item_exists){
        // Store cart items in session
        $cart_item = array(
            'food_id' => $food_id,
            'title' => $title,
            'price' => $price,
            'qty' => $qty,
            'total' => $total,
            'image_name' => $image_name,
            'status' => 'Pending' // Set status to Pending
        );

        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = array();
        }

        $_SESSION['cart'][] = $cart_item;
    }

    $_SESSION['cart_msg'] = "<div class='success text-center'>Food Added to Cart</div>";
    header('location:'.SITEURL.'index.php');
    exit();
}

if(isset($_SESSION['cart_msg'])){
    echo $_SESSION['cart_msg'];
    unset($_SESSION['cart_msg']);
}
?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Our Categories</h2>

        <?php
        $sql = "SELECT * FROM tbl_category WHERE active='YES' AND featured='Yes' LIMIT 3";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if($count > 0){
            while($row = mysqli_fetch_assoc($res)){
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
                ?>
                <a href="<?php echo SITEURL?>category-food.php?category_id=<?php echo $id?>">
                    <div class="box-3 float-container">
                        <?php 
                        if($image_name == ""){
                            echo "<div class='error'>Image not Available</div>";
                        } else {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name?>" alt="Pizza" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>
                <?php
            }
        } else {
            echo "<div class='error'>No Categories Found</div>";
        }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Our Menu</h2>

        <?php
        $sql2 = "SELECT * FROM tbl_food WHERE active = 'Yes' AND featured = 'Yes' LIMIT 6";
        $res2 = mysqli_query($conn, $sql2);
        $count2 = mysqli_num_rows($res2);

        if($count2 > 0){
            while($row = mysqli_fetch_assoc($res2)){
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];
                ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        if($image_name == ""){
                            echo "<div class='error'>Unavailable at the moment</div>";
                        } else {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">₱<?php echo $price; ?></p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>

                        
                        
                        <!-- Add to Cart Form -->
                        <form action="" method="POST" class="add-to-cart-form">
                            <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                            <input type="number" name="qty" value="1" min="1" max="99" class="input-responsive" style="width: 60px;">
                            <input type="submit" name="add_to_cart" value="Add to Cart" class="btn btn-secondary">
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='error'>Unavailable at the moment</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>

    <p class="text-center">
        <a href="<?php echo SITEURL; ?>foods.php">See All Foods</a>
    </p>
</section>



<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>