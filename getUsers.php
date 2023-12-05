<?php
    require_once "dbcon.php";

    $response["success"] = true;
    $response["users"] = [];
    try
    {
        $select = $db->prepare("SELECT * FROM users WHERE id <> ? AND id NOT IN (SELECT user1id FROM matches WHERE user2id = ? UNION SELECT user2id FROM matches WHERE user1id = ?) ORDER BY boost DESC");
        if($select == false)
        {
            $response["success"] = false;
            $response["error"] = "Error Occurred - " . mysqli_error($db);
            goto end;
        }
        else
        {
            $select->bind_param("iii" , $_GET["id"], $_GET["id"], $_GET["id"]);
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