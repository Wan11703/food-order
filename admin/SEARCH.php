<?php 
   include('../config/constants.php');
  
   $name = $_POST['firstname'];
  
   $sql = "SELECT * FROM users WHERE firstname LIKE '$name%' OR lastname LIKE '$name%' OR middlename LIKE '$name%' OR  username LIKE '$name%' OR email LIKE '$name%' OR birthdate LIKE '$name%'";  
   $query = mysqli_query($conn,$sql);
   $data='';
   while ($row = mysqli_fetch_assoc($query)) {
    $data .= "<tr>
                <td>".$row['id']."</td>
                <td>".$row['firstname']."</td>
                <td>".$row['lastname']."</td>
                <td>".$row['middlename']."</td>
                <td>".$row['username']."</td>
                <td>".$row['email']."</td>
                <td>".$row['contact']."</td>
                <td>".$row['gender']."</td>
                <td>".$row['birthdate']."</td>
                <td>".$row['age']."</td>
                <td>
                    <a href='UPDATE.php?id={$row['id']}' class='btn btn-success btn-sm' onclick='return confirm(\"Are you sure you want to edit this user?\")'>Edit</a>
                    <form action='EDIT_DELETE.php' method='POST' class='d-inline' onsubmit='return confirmDelete()'>
                        <button type='submit' name='delete_user' value='{$row['id']}' class='btn btn-danger btn-sm'>Delete</button>
                    </form>
                </td>";
}
    echo $data;
 ?>