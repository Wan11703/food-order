<!-- social Section Starts Here -->
<section class="social">
        <div class="container text-center">
            <ul>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/50/000000/facebook-new.png"/></a>
                </li>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png"/></a>
                </li>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/twitter.png"/></a>
                </li>
            </ul>
        </div>
    </section>


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
    <!-- social Section Ends Here -->

        





    <!-- footer Section Starts Here -->
    <section class="footer">
        <div class="container text-center">
            <p>All rights reserved.</p>
        </div>
    </section>
    <!-- footer Section Ends Here -->

</body>
</html>