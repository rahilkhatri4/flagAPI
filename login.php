<?php
    require_once "dbcon.php";

    $response["success"] = true;
    try
    {
        if(
            (isset($_POST["email"]) && $_POST["email"] != "")
            && (isset($_POST["password"]) && $_POST["password"] != "")
        )
        {
            $select = $db->prepare("SELECT email , password FROM users WHERE email = ?");
            if($select == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                goto end;
            }
            else
            {
                $select->bind_param("s" , $_POST["email"]);
                if($select->execute() == false)
                {
                    $response["success"] = false;
                    $response["error"] = "Error Occurred - " . mysqli_error($db);
                    goto end;
                }
                $result = $select->get_result();
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