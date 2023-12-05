<?php
    require_once "dbcon.php";

    $response["success"] = true;
    try
    {
        $update = $db->prepare("UPDATE users SET boost = ? WHERE id = ?");
        if($update == false)
        {
            $response["success"] = false;
            $response["error"] = "Error Occurred - " . mysqli_error($db);
            goto end;
        }
        else
        {
            $truevalue = 1;
            $update->bind_param("ii" , $truevalue , $_GET["id"]);
            if($update->execute() == false)
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