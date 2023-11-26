<?php
    require_once "dbcon.php";

    $response["success"] = true;
    $response["matches"] = [];
    try
    {
        $select = $db->prepare("SELECT id , name , profilepic FROM users WHERE id IN (SELECT user1id FROM matches WHERE user2id = ? UNION SELECT user2id FROM matches WHERE user1id = ?)");
        if($select == false)
        {
            $response["success"] = false;
            $response["error"] = "Error Occurred - " . mysqli_error($db);
            goto end;
        }
        else
        {
            $select->bind_param("ii" , $_GET["id"] , $_GET["id"]);
            if($select->execute() == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                goto end;
            }
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["matches"] , $row);
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