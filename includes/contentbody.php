<?php
include 'config.php';
?>
<div class="content">
<div class="row">
<?php
  if (isset($_SESSION['sfname']) && isset($_SESSION['sid'])){ ?>
  <h4 class="latest">Latest Assignment:</h4>
  <?php
  } ?>

    <?php
      if (isset($_SESSION['sfname']) && isset($_SESSION['sid'])){
        $sem = $_SESSION['semester'];
        $batch = $_SESSION['batch'];
        $fac = $_SESSION['faculty'];
        $selectquery = "SELECT * FROM `assignment` WHERE semester='$sem' AND faculty='$fac' ORDER BY ID DESC limit 4";
    $query = mysqli_query($conn,$selectquery);
    $num = mysqli_num_rows($query);

    if($num ==0){
      echo '<p class="alert-msg">No any Assignment Found !</p>';
  }else{

    while($result = mysqli_fetch_array($query)){
      $batch = $result['batch'];                
      $id = $result['id'];
      $title = $result['title'];
      $faculty=$result['faculty'];
     $teacherid = $result['teacher_id'];
      $comment = $result['comment'];
      $initialDate = strtotime($result['registeredate']);
      $finalDate = strtotime($result['deadline']);
      // Get the current date
$currentDate = time();
$remainingTime = $finalDate - $currentDate;
// Calculate the remaining days by comparing the final date with the current date
$remainingDays = ceil($remainingTime / (60 * 60 * 24));
      ?>
        
      <div class="col s12 m6 l6 car">
        
      <h5 class="header">#<?php echo $id;?>Assignment: <?php echo $title; ?> </h5> 
    

    <div class="card horizontal">
     
      <div class="card-stacked">
      <p><span class="highlight"> <?php echo "$batch | $sem | $faculty" ?></span>
      <?php 
         
        $sql = "select * from teacher where id='$teacherid'";
        $query1 = mysqli_query($conn,$sql);
        while($res = mysqli_fetch_array($query1)){
          $fname = $res['tfname'];
          $lname = $res['tlname'];
          $name = $fname .' '.$lname;
         
        }
        ?>
      <span class="right">
      <b><?php echo $name;?></b> 
      </span> </p>
      
                
                      
                                        <div class="card-content">
                                      <p> <b>Subject:</b> <?php echo $result['sub']; ?></p>
                   
                                         <p><b>Deadline:</b> <?php echo $result['deadline'];?> </p>
                                         <?php if ($remainingDays >0){ ?> 
                                            <span class=" remain deadline"> <b><?php echo $remainingDays ?> days more</b>  </span></p>
                                             
                               
                                         <?php if ($result['pdf']){ ?>
                                        <a class="box "href="pdf/<?php echo $result['pdf']; ?>" download ><b>Download</b></a>         
                                            <?php } ?>
                                                 
                                         <?php if ($result['comment']){  ?>                   
                                          <a  href="#modal<?php echo $result['id']; ?>" class=" modal-trigger box"><b>Read More</b></a> 
                                       
                                            <?php } ?>
                                          
                                            <?php
                                                 
                                                 } else{
                                              ?>
                        
                                                 <span class="warn"><b>No more deadline</b> </span>
                          <?php
                                    }
                                        ?>
                                         <?php 
                    if ($result['remarks']){ ?>
                    <p class="remarks"><b>Remarks:</b> <?php echo $result['remarks']; ?></p>
                  <?php } else{?>
                        <p class="remarks"><b>Remarks:</b> Null</p>
                    <?php }?>


                   
        </div>
        <div id="modal<?php echo $result['id']; ?>" class="modal">
    <div class="modal-content text">
<center>
        <h4><b>Assignment No:<?php echo $id; ?></b></h4>
                      </center>
                      <p style="float:right"><b>Date:</b> <?php echo $result['registeredate'];?> </p>
                      <h5> <?php echo $title;?> <br>
                      <?php echo $result['sub'];?><br>
                       <b><?php echo $name;?></b>
                     
                    </h5>
                    
                    
                    <hr> 
                    <p><?php echo $comment;?></p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-orange btn-flat">Done</a>
    </div>
</div>
        
      </div>
    </div>
  </div>  
    
<?php
    }
  }
}
?>

 
</div>
</div>








<style>

  .card-content {
    transform: rotate(360deg);
    
    background-image: linear-gradient(-1deg, rgb(255 193 7 / 15%) 0px, rgb(53 144 131 / 0%) 100%);
    
  }
    .card .card-action:last-child {

    border-top: none;
    }
    span.warn{
            color : red;
        
          }
          span.remain{
            
            color:green;
          }
    .text{
  
  
    background-image: linear-gradient(180deg, #804c00b3 0px, rgb(53 144 131 / 2%) 60%);
    
}
</style>