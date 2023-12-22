<?php

include 'components/connect.php';

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name']) || !isset($_SESSION['email'])) {
   header('Location:login.php');
}

$user_id = $_SESSION['id'];


if (isset($_GET['get_id'])) {
   $get_id = $_GET['get_id'];
} else {
   $get_id = '';
   header('location:home.php');
}

include 'components/save_send.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Property</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php
   include 'components/user_header.php';
   ?>

   <!-- view property section starts  -->

   <section class="view-property">

      <h1 class="heading">property details</h1>

      <?php
      $select_properties_query = "SELECT * FROM `property` WHERE id = '$get_id' ORDER BY date DESC LIMIT 1" or die($conn->error);
      $select_properties_res = $conn->query($select_properties_query);
      if ($select_properties_res) {


         while ($fetch_property = $select_properties_res->fetch_assoc()) {
            // echo "<pre>";
            // print_r($fetch_property);

            $fetch_property_user_id = $fetch_property['user_id'];

            $property_id = $fetch_property['id'];


            $select_user_query = "SELECT * FROM `users1` WHERE id ='$fetch_property_user_id'" or die($conn->error);
            $select_user_res = $conn->query($select_user_query) or die($conn->error);


            if ($select_user_res) {

               while ($fetch_user = $select_user_res->fetch_assoc()) {




                  $select_saved_query = "SELECT * FROM `saved` WHERE property_id ='$property_id'  and user_id = '$user_id'" or die($conn->error);
                  $select_saved_res = $conn->query($select_saved_query);

      ?>
                  <div class="details">
                     <div class="swiper images-container">
                        <div class="swiper-wrapper">
                           <img src="uploaded_files/<?php echo $fetch_property['image_01']; ?>" alt="" class="swiper-slide">
                           <?php if (!empty($fetch_property['image_02'])) { ?>
                              <img src="uploaded_files/<?php echo $fetch_property['image_02']; ?>" alt="" class="swiper-slide">
                           <?php } ?>
                           <?php if (!empty($fetch_property['image_03'])) { ?>
                              <img src="uploaded_files/<?php echo $fetch_property['image_03']; ?>" alt="" class="swiper-slide">
                           <?php } ?>
                           <?php if (!empty($fetch_property['image_04'])) { ?>
                              <img src="uploaded_files/<?php echo $fetch_property['image_04']; ?>" alt="" class="swiper-slide">
                           <?php } ?>
                           <?php if (!empty($fetch_property['image_05'])) { ?>
                              <img src="uploaded_files/<?php echo $fetch_property['image_05']; ?>" alt="" class="swiper-slide">
                           <?php } ?>
                        </div>
                        <div class="swiper-pagination"></div>
                     </div>
                     <h3 class="name"><?php $fetch_property['property_name']; ?></h3>
                     <p class="location"><i class="fas fa-map-marker-alt"></i><span><?php echo $fetch_property['address']; ?></span></p>
                     <div class="info">
                        <p><i class="fas fa-indian-rupee-sign"></i><span><?php echo $fetch_property['price']; ?></span></p>
                        <p><i class="fas fa-user"></i><span><?php echo $fetch_user['name']; ?></span></p>
                        <p><i class="fas fa-phone"></i><a href="tel:1234567890"><?php echo $fetch_user['number']; ?></a></p>
                        <p><i class="fas fa-building"></i><span><?php echo $fetch_property['type']; ?></span></p>
                        <p><i class="fas fa-house"></i><span><?php echo $fetch_property['offer']; ?></span></p>
                        <p><i class="fas fa-calendar"></i><span><?php echo $fetch_property['date']; ?></span></p>

                  <?php
               }
            } ?>
                     </div>
                     <h3 class="title">details</h3>
                     <div class="flex">
                        <div class="box">
                           <p><i>rooms :</i><span><?php echo $fetch_property['bhk']; ?> BHK</span></p>
                           <p><i>deposit amount : </i><span><span class="fas fa-indian-rupee-sign" style="margin-right: .5rem;"></span><?= $fetch_property['deposite']; ?></span></p>
                           <p><i>status :</i><span><?php echo $fetch_property['status']; ?></span></p>
                           <p><i>bedroom :</i><span><?php echo $fetch_property['bedroom']; ?></span></p>
                           <p><i>bathroom :</i><span><?php echo $fetch_property['bathroom']; ?></span></p>
                           <p><i>balcony :</i><span><?php echo $fetch_property['balcony']; ?></span></p>
                        </div>
                        <div class="box">
                           <p><i>carpet area :</i><span><?php echo $fetch_property['carpet']; ?>sqft</span></p>
                           <p><i>age :</i><span><?php echo $fetch_property['age']; ?> years</span></p>
                           <p><i>total floors :</i><span><?php echo $fetch_property['total_floors']; ?></span></p>
                           <p><i>room floor :</i><span><?php echo $fetch_property['room_floor']; ?></span></p>
                           <p><i>furnished :</i><span><?php echo $fetch_property['furnished']; ?></span></p>
                           <p><i>loan :</i><span><?php echo $fetch_property['loan']; ?></span></p>
                        </div>
                     </div>
                     <h3 class="title">amenities</h3>
                     <div class="flex">
                        <div class="box">
                           <p><i class="fas fa-<?php if ($fetch_property['lift'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>lifts</span></p>
                           <p><i class="fas fa-<?php if ($fetch_property['security_guard'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>security guards</span></p>
                           <p><i class="fas fa-<?php if ($fetch_property['play_ground'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>play ground</span></p>
                           <p><i class="fas fa-<?php if ($fetch_property['garden'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>gardens</span></p>
                           <p><i class="fas fa-<?php if ($fetch_property['water_supply'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>water supply</span></p>
                           <p><i class="fas fa-<?php if ($fetch_property['power_backup'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>power backup</span></p>
                        </div>
                        <div class="box">
                           <p><i class="fas fa-<?php if ($fetch_property['parking_area'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>parking area</span></p>
                           <p><i class="fas fa-<?php if ($fetch_property['gym'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>gym</span></p>
                           <p><i class="fas fa-<?php if ($fetch_property['shopping_mall'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>shopping mall</span></p>
                           <p><i class="fas fa-<?php if ($fetch_property['hospital'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>hospital</span></p>
                           <p><i class="fas fa-<?php if ($fetch_property['school'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>schools</span></p>
                           <p><i class="fas fa-<?php if ($fetch_property['market_area'] == 'yes') {
                                                   echo 'check';
                                                } else {
                                                   echo 'times';
                                                } ?>"></i><span>market area</span></p>
                        </div>
                     </div>
                     <h3 class="title">description</h3>
                     <p class="description"><?php echo $fetch_property['description']; ?></p>
                     <form action="" method="post" class="flex-btn">
                        <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
                        <?php
                        if ($select_saved_res) {
                        ?>
                           <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>saved</span></button>
                        <?php
                        } else {
                        ?>
                           <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
                        <?php
                        }
                        ?>
                        <input type="submit" value="send enquiry" name="send" class="btn">
                     </form>
                  </div>
            <?php
         }
      } else {
         echo '<p class="empty">property not found! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">add new</a></p>';
      }
            ?>

   </section>

   <!-- view property section ends -->










   <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <?php include 'components/footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <?php
   include 'components/message.php';
   ?>

   <script>
      var swiper = new Swiper(".images-container", {
         effect: "coverflow",
         grabCursor: true,
         centeredSlides: true,
         slidesPerView: "auto",
         loop: true,
         coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 200,
            modifier: 3,
            slideShadows: true,
         },
         pagination: {
            el: ".swiper-pagination",
         },
      });
   </script>

</body>

</html>