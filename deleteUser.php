<?php
    require_once "dbcon.php";

    $response["success"] = true;
    try
    {
        if(isset($_GET["id"]) && $_GET["id"] != "")
        {
            $db->begin_transaction();
            $delete = $db->prepare("DELETE FROM users WHERE id = ?");
            if($delete == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                $db->rollback();
                goto end;
            }
            else
            {
                $delete->bind_param("i" , $_GET["id"]);
                if($delete->execute() == false)
                {
                    $response["success"] = false;
                    $response["error"] = "Error Occurred - " . mysqli_error($db);
                    $db->rollback();
                    goto end;
                }
            }

            $delete = $db->prepare("DELETE FROM matches WHERE user1id = ? OR user2id = ?");
            if($delete == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                $db->rollback();
                goto end;
            }
            else
            {
                $delete->bind_param("ii" , $_GET["id"] , $_GET["id"]);
                if($delete->execute() == false)
                {
                    $response["success"] = false;
                    $response["error"] = "Error Occurred - " . mysqli_error($db);
                    $db->rollback();
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
        if($response["success"] == true)
        {
            $db->commit();
        }
    }
    catch(Exception $e)
    {
        $response["success"] = false;
        $response["error"] = "Error Occurred - " . $e->getMessage();
    }

    echo json_encode($response);
?>