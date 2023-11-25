<?php
    require_once "dbcon.php";

    $response["success"] = true;
    try
    {
        $insert = $db->prepare("INSERT INTO likes VALUES(? , ?)");
        if($insert == false)
        {
            $response["success"] = false;
            $response["error"] = "Error Occurred - " . mysqli_error($db);
            goto end;
        }
        else
        {
            $insert->bind_param("ii" , $_POST["likeid"] , $_POST["likedbyid"]);
            if($insert->execute() == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                goto end;
            }
        }
        end:;
    }
    catch(Exception $e)
    {
        $response["success"] = false;
        $response["error"] = "Error Occurred - " . $e->getMessage();
    }

    echo json_encode($response);
?>