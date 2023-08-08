<?php
   require_once "dbcon.php";
   require_once "Model/user.php";

   $response["success"] = true;
   try
   {
      if(isset($_GET["id"]) && $_GET["id"] != "")
      {
         $select = $db->prepare("SELECT * FROM Users WHERE id = ?");
         if($select == false)
         {
            $response["success"] = false;
            $response["error"] = "Error occurred - " . mysqli_error($db);
            goto end;
         }
         else
         {
            $select->bind_param("i" , $_GET["id"]);
            if($select->execute() == false)
            {
               $response["success"] = false;
               $response["error"] = "Error occurred - " . mysqli_error($db);
               goto end;
            }
            $result = $select->get_result();
            if(mysqli_num_rows($result) != 0)
            {
               $row = $result->fetch_assoc();
               $response["user"] = $row;
            }
            else
            {
               $response["success"] = false;
               $response["error"] = "User not found";
               goto end;
            }
         }
      }
      else
      {
         $response["success"] = false;
         $response["error"] = "Did not received ID";
         goto end;
      }
      end:;
   }
   catch(Exception $e)
   {
      $response["success"] = false;
      $response["error"] = "Error Occurred - " . mysqli_error($db);
   }

   echo json_encode($response);
?>