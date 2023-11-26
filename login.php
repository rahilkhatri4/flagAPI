<?php
    require_once "dbcon.php";

    $response["success"] = true;
    try
    {
        if(
            (isset($_POST["id"]) && $_POST["id"] != "")
            && (isset($_POST["password"]) && $_POST["password"] != "")
        )
        {
            $select = $db->prepare("SELECT id , password FROM users WHERE id = ?");
            if($select == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                goto end;
            }
            else
            {
                $select->bind_param("s" , $_POST["id"]);
                if($select->execute() == false)
                {
                    $response["success"] = false;
                    $response["error"] = "Error Occurred - " . mysqli_error($db);
                    goto end;
                }
                $result = $select->get_result();
                $row;
                if(mysqli_num_rows($result) != 0)
                {
                    $row = $result->fetch_assoc();
                    if($row["password"] != $_POST["password"])
                    {
                        $response["success"] = false;
                        $response["error"] = "Authentication error";
                        goto end;
                    }
                }
                else
                {
                    $response["success"] = false;
                    $response["error"] = "Authentication error";
                    goto end;
                }
                $response["id"] = $row["id"];
            }
        }
        else
        {
            $response["success"] = false;
            $response["error"] = "Enter email and password to login";
            goto end;
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