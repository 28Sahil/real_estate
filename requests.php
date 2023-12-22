<?php  

include 'components/connect.php';


session_start();
if(!isset($_SESSION['id']) || !isset($_SESSION['name']) || !isset($_SESSION['email'])){
   header('Location:login.php');

  

}
 
$user_id=$_SESSION['id'];
// echo $user_id;



// if(isset($_POST['delete'])){

//    $delete_id = $_POST['request_id'];
//    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

//    $verify_delete = $conn->prepare("SELECT * FROM `requests` WHERE id = ?");
//    $verify_delete->execute([$delete_id]);

//    if($verify_delete->rowCount() > 0){
//       $delete_request = $conn->prepare("DELETE FROM `requests` WHERE id = ?");
//       $delete_request->execute([$delete_id]);
//       $success_msg[] = 'request deleted successfully!';
//    }else{
//       $warning_msg[] = 'request deleted already!';
//    }

// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>requests</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="requests">

   <h1 class="heading">all requests</h1>

   <div class="box-container">

   <?php
      $select_requests_query ="SELECT * FROM `requests` WHERE receiver = '$user_id'";
      $select_requests_res=$conn->query($select_requests_query);
      if($select_requests_res->num_rows > 0){
         while($fetch_request = $select_requests_res->fetch_assoc()){
          
          
            $fetch_request_sender= $fetch_request['sender'];

       $select_sender_query ="SELECT * FROM `users` WHERE id = '$fetch_request_sender'";
        $select_sender_res=$conn->query($select_sender_query);
        while( $fetch_sender_res = $select_sender->fetch_assoc){

         $fetch_request_property_id= $fetch_request['property_id'];
       

        $select_property_query ="SELECT * FROM `property` WHERE id = ' $fetch_request_property_id'";
        $select_property_res=$conn->query($select_property_query);
        while( $fetch_property = $select_property->fetch_assoc){
       
   ?>
   <div class="box">
      <p>name : <span><?= $fetch_sender['name']; ?></span></p>
      <p>number : <a href="tel:<?= $fetch_sender['number']; ?>"><?= $fetch_sender['number']; ?></a></p>
      <p>email : <a href="mailto:<?= $fetch_sender['email']; ?>"><?= $fetch_sender['email']; ?></a></p>
      <p>enquiry for : <span><?= $fetch_property['property_name']; ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="request_id" value="<?= $fetch_request['id']; ?>">
         <input type="submit" value="delete request" class="btn" onclick="return confirm('remove this request?');" name="delete">
         <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">view property</a>
      </form>
   </div>
   <?php
    }
   }
   }
   }
   else{
      echo '<p class="empty">you have no requests!</p>';
   }
   ?>

   </div>

   



</section>


















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>