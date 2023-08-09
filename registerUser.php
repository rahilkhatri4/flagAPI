<?php
    require_once "dbcon.php";
    require_once "Model/user.php";

    $response["success"] = true;
    try
    {
        if(isset($_POST["register"]) && $_POST["register"] != "")
        {
            if($_POST["password"] != $_POST["confirmpassword"])
            {
                $response["success"] = false;
                $response["error"] = "Passwords do not match";
                goto end;
            }
            $select = $db->prepare("SELECT COUNT(*) AS num FROM users WHERE email = ?");
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
                $row = $result->fetch_assoc();
                if($row["num"] != 0)
                {
                    $response["success"] = false;
                    $response["error"] = "You are already registered";
                    goto end;
                }
            }

            $insert = $db->prepare("INSERT INTO users (name, gender, birthdate, email, password, bio, profilepic, campus, preferred_gender, fromage, toage)
            VALUES (? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?);
            ");
            if($insert == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                goto end;
            }
            else
            {
                $insert->bind_param("sssssssssii" , $_POST["name"] , $_POST["gender"] , $_POST["birthdate"] , $_POST["email"] , $_POST["password"] , $_POST["bio"] , $_POST["profilepic"] , $_POST["campus"] , $_POST["preferred_gender"] , $_POST["fromage"] , $_POST["toage"]);
                if($insert->execute() == false)
                {
                    $response["success"] = false;
                    $response["error"] = "Error Occurred - " . mysqli_error($db);
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
    }
    catch(Exception $e)
    {
        $response["success"] = false;
        $response["error"] = "Error Occurred - " . $e->getMessage();
    }

    echo json_encode($response);
?>