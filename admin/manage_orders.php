<?php 

include('partials/menu.php');

$limit = 10; // Number of entries to show in a page.
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};

$offset = ($page-1) * $limit;

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}


if (isset($_POST['update'])) {

    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];


    $update_sql = "UPDATE tbl_orders SET status='$new_status' WHERE id='$order_id'";

    
    if (mysqli_query($conn, $update_sql)) {

    } else {
        $_SESSION['update'] = "Failed to update order status: " . mysqli_error($conn);
    }

}


?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    
    const orderTable = document.getElementById('orderTable');



    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("orderTable");
        tr = table.getElementsByTagName("tr");
        var selectedValue;
        const selectElement = document.getElementById('inputSearch');

        var selectedValue;

        selectedValue = document.getElementById("inputSearch").value;

        inputSearch.addEventListener('change', function() {

            selectedValue = this.value;
        });
    
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[selectedValue];
            if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
            }
        }
    }


   // Function to filter orders based on the selected radio button
function filterOrders() {
    // Get the selected value from the radio buttons
    const radios = document.getElementsByName('stats');
    let selectedStatus = '';
    
    for (const radio of radios) {
        if (radio.checked) {
            selectedStatus = radio.value;
            break; // Exit the loop once the checked radio is found
        }
    }
    
    // Get the table and all rows
    const orderTable = document.getElementById('orderTable');
    const tableRows = orderTable.getElementsByTagName('tr');

    // Loop through each row to check the status
    for (let i = 1; i < tableRows.length; i++) { // Start from 1 to skip the header row
        const row = tableRows[i];
        const statusCell = row.getElementsByTagName('td')[3]; // Assuming status is in the 4th column (index 3)
        const statusText = statusCell.textContent || statusCell.innerText;

        // Show or hide the row based on the selected status
        if (selectedStatus === "All" || statusText.toUpperCase() === selectedStatus.toUpperCase()) {
            row.style.display = ""; // Show the row
        } else {
            row.style.display = "none"; // Hide the row
        }
    }
}

// Attach event listeners to radio buttons
const radios = document.getElementsByName('stats');
for (const radio of radios) {
    radio.addEventListener('change', filterOrders);
}
    
</script>




<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!--- main Section Start--->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage orders</h1>
        <br><br>

        <?php

            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

        ?>

        <br /><br>
        <!--- buttone to add admin--->
        
    <br />
    <form method="GET" action="">
        <button type="submit" class = "btn btn-primary">Search</button>
            <input type="text" name="search" id="searchInput" value="<?php echo htmlspecialchars($search); ?>">
            <select name="inputSearch" id="inputSearch">
                <option value="id" <?php if(isset($_GET['inputSearch']) && $_GET['inputSearch'] == 'id') echo 'selected'; ?>>Order ID</option>
                <option value="oder_date" <?php if(isset($_GET['inputSearch']) && $_GET['inputSearch'] == 'oder_date') echo 'selected'; ?>>Date</option>
                <option value="status" <?php if(isset($_GET['inputSearch']) && $_GET['inputSearch'] == 'status') echo 'selected'; ?>>Status</option>
            </select>
            
    </form>
    <!-- <input type="radio" id="all" name="stats" value="All" checked>
    <label for="all">All</label>
    <input type="radio" id="prep" name="stats" value="Preparing">
    <label for="prep">Preparing</label>
    <input type="radio" id="onDeli" name="stats" value="On Delivery">
    <label for="onDeli">On Delivery</label>
    <input type="radio" id="Deli" name="stats" value="Delivered">
    <label for="Deli">Delivered</label>
    <input type="radio" id="Cancel" name="stats" value="Cancelled">
    <label for="Cancel">Cancelled</label> -->



            
        
        
        <br><br>
           <table class="table table-bordered table-striped col-12" id = "orderTable" name = "orderTable">
           <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

                <?php
                
                $search_condition = "";
                if (!empty($search)) {
                    $column = isset($_GET['inputSearch']) ? $_GET['inputSearch'] : 'id';
                    $search_condition = "WHERE $column LIKE '%$search%'";
                }

                $sql = "SELECT DISTINCT id, status, oder_date, SUM(total) AS total 
                        FROM tbl_orders 
                        $search_condition 
                        GROUP BY id 
                        ORDER BY oder_date DESC 
                        LIMIT $limit OFFSET $offset";

                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);

                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $date = $row['oder_date'];
                    $total = $row['total'];
                    $status = $row['status'];


                    // $sql = "SELECT DISTINCT id, status, oder_date, SUM(total) AS total 
                    //     FROM tbl_orders 
                    //     GROUP BY id 
                    //     ORDER BY oder_date DESC 
                    //     LIMIT $limit OFFSET $offset";

                    // $res = mysqli_query($conn, $sql);
                    // $count = mysqli_num_rows($res);
                    // $res = mysqli_query($conn, $sql);
                    // $count = mysqli_num_rows($res);

                    // while ($row = mysqli_fetch_assoc($res)) {
                    //     $id = $row['id'];
                    //     $date = $row['oder_date'];
                    //     $total = $row['total'];
                    //     $status = $row['status'];
                    
                    //     ?>
                      <form name = "order" id = "order" method = "post">
                        <input type="hidden" name="order_id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_status" value="<?php echo $status; ?>">
                            <tr>
                                <td class = "col-2"> <?php echo $id ?> </td>
                                <td class = "col-4"> <?php echo $date ?> </td>
                                <td class = "col-2"> <?php echo $total ?> </td>
                                <td class = "col-3"> <?php echo $status ?> </td>
                                <td class = "col-1"> 
                                <button type="button" class="btn btn-secondary view-order-details" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $id ?>">View</button>
                                        <div class="modal fade modal-lg" id="orderModal<?php echo $id ?>" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="orderModalLabel">Order Details (ID: <?php echo $id ?>)</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <table class = "table table-bordered table-striped col-11">
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                        </tr>

                                                    <?php
                                                         $sql5 = "SELECT * FROM tbl_orders WHERE id = '$id'";
                                                         $res5 = mysqli_query($conn, $sql5);
                                                        
                                                         while ($row = mysqli_fetch_assoc($res5)) {
                                                            $food = $row['food'];
                                                            $qty = $row['qty'];
                                                            $price = $row['price'];
                                                            $cname = $row['customer_name'];
                                                            $contact = $row['customer_contact'];
                                                            $address = $row['customer_address'];
                                                            $status = $row['status'];

                                            
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $food ?></td>
                                                                    <td><?php echo $qty ?></td>
                                                                    <td><?php echo $price ?></td>
                                                                </tr>
                                                            
                                                            <?php

                                                         }

                                                    ?>
                                                    
                                                    </table>

                                                    <p><b>Customer Name: </b><?php echo $cname ?></p>
                                                    <p><b>Contact: </b> <?php echo $contact ?></p>
                                                    <p><b>Address: </b> <p>
                                                    
                                                    <textarea id = "address" rows = 5 cols = 100 disabled><?php echo $address ?></textarea> 

                                                    <p><b>Total: </b><?php echo $total ?></p>

                                                    <p><b>Status: </b>
                                                        <select name = "status" id = "status">
                                                            <option value = "<?php echo $status ?>"><?php echo $status ?></option>
                                                            <?php
                                                            if ($status == "Delivered") {
                                                                echo "<option value = 'Preparing'>Preparing</option>";
                                                                echo "<option value = 'Cancelled'>Cancelled</option>";
                                                                echo "<option value = 'On Delivery'>On Delivery</option>";
                                                            }
                                                            
                                                            elseif ($status == "Preparing") {
                                                                echo "<option value = 'Delivered'>Delivered</option>";
                                                                echo "<option value = 'Cancelled'>Cancelled</option>";
                                                                echo "<option value = 'On Delivery'>On Delivery</option>";
                                                            }

                                                            elseif ($status == "Cancelled") {
                                                                echo "<option value = 'Delivered'>Delivered</option>";
                                                                echo "<option value = 'Preparing'>Preparing</option>";
                                                                echo "<option value = 'On Delivery'>On Delivery</option>";
                                                            }

                                                            elseif ($status == "On Delivery") {
                                                                echo "<option value = 'Delivered'>Delivered</option>";
                                                                echo "<option value = 'Cancelled'>Cancelled</option>";
                                                                echo "<option value = 'Preparing'>Preparing</option>";
                                                            }
                                                            
                                                            
                                                            ?>
                                                        </select>
                                                    </p>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                    <button type="submit" name="update" id="update" class="btn btn-success">Update</button>
                        
                                                       
                                                       
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                            </tr>
                    </form>      

                    <?php

                    }      
                    
                    
                ?>
        </table>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

         <!-- Pagination -->
         <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php
                $total_sql = "SELECT COUNT(DISTINCT id) AS total FROM tbl_orders";
                $total_res = mysqli_query($conn, $total_sql);
                $total_rows = mysqli_fetch_assoc($total_res)['total'];
                $total_pages = ceil($total_rows / $limit);

                $start_page = max(1, $page - 5);
                $end_page = min($total_pages, $page + 4);
                $range = 9;

                if ($total_pages > $range) {
                    if ($page <= 5) {
                        $end_page = $range + 1;
                    } elseif ($page > $total_pages - 5) {
                        $start_page = $total_pages - $range;
                    } else {
                        $start_page = $page - 4;
                        $end_page = $page + 4;
                    }
                }
                ?>

                <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>">Previous</a>
                </li>
                <?php for($i = $start_page; $i <= $end_page; $i++ ): ?>
                    <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                        <a class="page-link" href="manage_orders.php?page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if($page >= $total_pages) { echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">Next</a>
                </li>
            </ul>
        </nav>
           
        
    </div>
</div>
<!--- main Section End--->

<?php include('partials/footer.php') ?>