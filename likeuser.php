<?php
    require_once "dbcon.php";

    $response["success"] = true;
    try
    {
        $select = $db->prepare("SELECT * FROM likes WHERE likeid = ? AND likedbyid = ?");
        if($select == false)
        {
            $response["success"] = false;
            $response["error"] = "Error Occurred - " . mysqli_error($db);
            goto end;
        }
        else
        {
            $select->bind_param("ii" , $_POST["likeid"] , $_POST["likedbyid"]);
            if($select->execute() == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                goto end;
            }
            $result = $select->get_result();
            if(mysqli_num_rows($result) == 0)
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