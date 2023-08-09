<?php
    require_once "dbcon.php";

    $response["success"] = true;
    $response["users"] = [];
    try
    {
        $select = $db->prepare("SELECT * FROM users");
        if($select == false)
        {
            $response["success"] = false;
            $response["error"] = "Error Occurred - " . mysqli_error($db);
            goto end;
        }
        else
        {
            if($select->execute() == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                goto end;
            }
            $result = $select->get_result();
            if(mysqli_num_rows($result) != 0)
            {
                while($row = $result->fetch_assoc())
                {
                    array_push($response["users"] , $row);
                }
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        $response["success"] = false;
        $response["error"] = $e->getMessage();
    }

    echo json_encode($response);
?>