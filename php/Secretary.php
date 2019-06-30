<?php
    require_once "Utility.php";
    
    class Secretary extends Utility{
        
        function submitRequest(){
            try{
                $requestedBy = $_POST['requestedBy'];
                $section = $_POST['section'];
                $buildingName = $_POST['buildingName'];
                $roomName = $_POST['roomName'];
                $repairClass = $_POST['repairClass'];
                $description = $_POST['description'];
                $date = date("d-m-Y");
                
                $result = $this->query("INSERT INTO","work_request","(requestedBy, section, buildingName, roomName, repairClass, description, dateRequested, status) VALUES(?,?,?,?,?,?,?,?)",[$requestedBy, $section, $buildingName, $roomName, $repairClass, $description, $date, "MANAGER"]);
                
                if($result){
                    header("Location:../WorkRequestPage.php?suc=Request submitted succesfully");
                }else{
                    header("Location:../WorkRequestPage.php?err=Failed to submit request");
                }
            }catch(Exception $e){
                header("Location:../WorkRequestPage.php?err=Failed to submit request");
            }
        }
        
    }

    $secretary = new Secretary();
    $secretary->submitRequest();

?>