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
            $select->bind_param("ii" , $_POST["likedbyid"] , $_POST["likeid"]);
            if($select->execute() == false)
            {
                $response["success"] = false;
                $response["error"] = "Error Occurred - " . mysqli_error($db);
                goto end;
            }
            $result = $select->get_result();
            if(mysqli_num_rows($result) != 0)
            {
                $db->begin_transaction();
                $insert = $db->prepare("INSERT INTO matches(user1id , user2id) VALUES (? , ?)");
                if($insert == false)
                {
                    $response["success"] = false;
                    $response["error"] = "Error Occurred - " . mysqli_error($db);
                    $db->rollback();
                    goto end;
                }
                else
                {
                    $insert->bind_param("ii" , $_POST["likeid"] , $_POST["likedbyid"]);
                    if($insert->execute() == false)
                    {
                        $response["success"] = false;
                        $response["error"] = "Error Occurred - " . mysqli_error($db);
                        $db->rollback();
                        goto end;
                    }
                }

                $delete = $db->prepare("DELETE FROM likes WHERE (likeid = ? AND likedbyid = ?) OR (likeid = ? AND likedbyid = ?)");
                if($delete == false)
                {
                    $response["success"] = false;
                    $response["error"] = "Error Occurred - " . mysqli_error($db);
                    $db->rollback();
                    goto end;
                }
                else
                {
                    $delete->bind_param("iiii" , $_POST["likeid"] , $_POST["likedbyid"] , $_POST["likedbyid"] , $_POST["likeid"]);
                    if($delete->execute() == false)
                    {
                        $response["success"] = false;
                        $response["error"] = "Error Occurred - " . mysqli_error($db);
                        $db->rollback();
                        goto end;
                    }
                }

                $db->commit();
            }
            else
            {
                $select3 = $db->prepare("SELECT * FROM likes WHERE likeid = ? AND likedbyid = ?");
                if($select3 == false)
                {
                    $response["success"] = false;
                    $response["error"] = "Error Occurred - " . mysqli_error($db);
                    goto end;
                }
                else
                {
                    $select3->bind_param("ii" , $_POST["likeid"] , $_POST["likedbyid"]);
                    if($select3->execute() == false)
                    {
                        $response["success"] = false;
                        $response["error"] = "Error Occurred - " . mysqli_error($db);
                        goto end;
                    }
                    $result = $select3->get_result();
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