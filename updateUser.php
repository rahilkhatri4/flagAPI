<?php
    require_once "dbcon.php";

    $response["success"] = true;
    try
    {
        $update = $db->prepare("UPDATE users SET name = ? , birthdate = ? , gender = ? , bio = ? , campus = ? , preferred_gender = ? , fromage = ? , toage = ? WHERE id = ?");
        if($update == false)
        {
            $response["success"] = false;
            $response["error"] = "Error Occurred - " . mysqli_error($db);
            goto end;
        }
        else
        {
            $update->bind_param("ssssssiii" , $_POST["name"] , $_POST["birthdate"] , $_POST["gender"] , $_POST["bio"] , $_POST["campus"] , $_POST["preferred_gender"] , $_POST["fromage"] , $_POST["toage"] , $_POST["id"]);
            if($update->execute() == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                goto end;
            }

            end:;
        }
    }
    catch(Exception $e)
    {
        $response["success"] = false;
        $response["error"] = "Error Occurred - " . $e->getMessage();
    }

    echo json_encode($response);
?>