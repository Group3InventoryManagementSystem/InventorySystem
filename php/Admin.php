<?php
    require_once "Utility.php";

    class Admin extends Utility{
        
        function getRequests(){
            $rank = $_SESSION['rank'];
            echo "<center><h2>Work Requests</h2></center><br>";
            $result = $this->query("SELECT * FROM ","work_request","WHERE status = ?",[$rank]);
            
            if($result->rowCount() == 0){
                echo "<center>No pending work requests</center>";
            }else{
                echo "<table><tr>
                    <th>Date Requested</th>
                    <th>Type of Facility</th>
                    <th>Building</th>
                    <th>Room</th>
                    <th>Type of Repair</th>
                    <th>Description</th></tr>";
                while($row = $result->fetch()){
                    echo "<tr>
                        <td>".$row['dateRequested']."</td>
                        <td>".$row['section']."</td>
                        <td>".$row['buildingName']."</td>
                        <td>".$row['roomName']."</td>
                        <td>".$row['repairClass']."</td>
                        <td>".$row['description']."</td>
                        <td>
                            <form action='php/Admin.php' method='post'>
                                <input type='hidden' value='".$row['id']."' name='id'>
                                <input type='submit' value='Approve' name='approve' class='approve'>
                            </form>
                        </td>
                        <td>
                            <form action='php/Admin.php' method='post'>
                                <input type='hidden' value='".$row['id']."' name='id'>
                                <input type='submit' value='Decline' name='decline' class='decline'>
                            </form>
                        </td>
                        </tr>";
                }
                echo "</table>";
            }
        }
        
        function approve(){
            $id = $_POST['id'];
            $rank = $_SESSION['rank'];
            if($rank == "MANAGER"){
                $result = $this->query("UPDATE ","work_request","SET status=? WHERE id = ?",["MAINTENANCE SUPERVISOR", $id]);
            }else if($rank == "MAINTENANCE SUPERVISOR"){
                $result = $this->query("UPDATE ","work_request","SET status=? WHERE id = ?",["MAINTENANCE OFFICER", $id]);
            }else if($rank == "MAINTENANCE OFFICER"){
                $result = $this->query("UPDATE ","work_request","SET status=? WHERE id = ?",["UNASSIGNED", $id]);
            }
            
            header("Location:../AdminWorkRequests.php");
        }
        
        function decline(){
            $id = $_POST['id'];
            $rank = $_SESSION['rank'];
            if($rank == "MANAGER"){
                $result = $this->query("UPDATE ","work_request","SET status=? WHERE id = ?",["DENIED M", $id]);
            }else if($rank == "MAINTENANCE SUPERVISOR"){
                $result = $this->query("UPDATE ","work_request","SET status=? WHERE id = ?",["DENIED M.S", $id]);
            }else if($rank == "MAINTENANCE OFFICER"){
                $result = $this->query("UPDATE ","work_request","SET status=? WHERE id = ?",["DENIED M.O", $id]);
            }
            
           header("Location:../AdminWorkRequests.php");
            
        }
        
        function getMaterialsRequested(){
            $rank = $_SESSION['rank'];
            if($rank == "MANAGER"){
                $result = $this->query("SELECT * FROM","materials_required","WHERE status = ?",['MANAGER']);
                
                echo "<center><h2>Materials Requested</h2></center><br>";
                
                if($result->rowCount() == 0){
                    echo "<center>No pending materials requested</center>";
                }else{
                    echo "<table><tr>
                        <th>Date Requested</th>
                        <th>Building Name</th>
                        <th>Room Name</th>
                        <th>Repair Class</th>
                        <th>Description</th>
                        <th></th>
                        </tr>";
                    while($row=$result->fetch()){
                        $w_id = $row['work_id'];
                        
                        $mat_info = explode(",",$row['request']);
                        
                        $materials = "";
                        foreach($mat_info as $material){
                            $materials = $materials.$material."<br>";
                        }
                        $result2 = $this->query("SELECT * FROM","work_request","WHERE id = ?",[$w_id]);
                        $row2 = $result2->fetch();
                        $string =  "<tr>
                        <td>".$row2['dateRequested']."</td>
                        <td>".$row2['buildingName']."</td>
                        <td>".$row2['roomName']."</td>
                        <td>".$row2['repairClass']."</td>
                        <td>".$row2['description']."</td>
                        <td>".$materials."</td>
                        <td><form method='post' action='php/Admin.php'>
                        <input type='hidden' value='".$row['id']."' name='id'>
                        <input type='submit' value='Approve' name='approve_mat' class='approve'>
                        </form></td>
                        <td><form method='post' action='php/Admin.php'>
                        <input type='hidden' value='".$row['id']."' name='id'>
                        <input type='submit' value='Decline' name='decline_mat' class='decline'>
                        </form></td>
                        </tr>";
                        
                        echo $string;
                            
                    }
                    echo "</table>";
                }
            }
        }
                
        function approveMaterials(){
            $id = $_POST['id'];
            
            $request = $this->query("UPDATE ","materials_required","SET status = ? WHERE id = ?",["STOREMAN",$id]);
            
            header("Location:../MaterialsRequested.php");
        }
        
        function declineMaterials(){
            $id = $_POST['id'];
            
            $request = $this->query("UPDATE ","materials_required","SET status = ? WHERE id = ?",["DECLINED",$id]);
            
            header("Location:../MaterialsRequested.php");
        }
    
        function approveRegistered(){
            $id = $_POST['id'];
            $rank = strtoupper($_POST['rank']);
            $res = $this->query("UPDATE","users","SET rank = ?, status = ? WHERE ID = ?",[$rank, "FREE",$id]);
            header("Location:../ViewPendingReg.php");

        }
        
        function declineRegistered(){
            $id = $_POST['id'];
            $res = $this->query("DELETE FROM","users","WHERE ID = ?",[$id]);
            
            header("Location:../ViewPendingReg.php");
        }
        
        function getRegisterPending(){
            $res = $this->query("SELECT * FROM","users","WHERE status = ?",["PENDING"]);
            
            echo "<center><h2>Registration Requests</h2></center><br>";
            
            if($res->rowCount() == 0){
                echo "<center>No pending requests</center>";
            }else{
                
                $select = "<select id='rankVis' onchange='set()'>
                    <option>Artisan</option>
                    <option>Secretary</option>
                    <option>Storeman</option>
                    <option>Foreman</option>
                    <option>Maintenance Officer</option>
                    <option>Maintenance Supervisor</option>
                    <option>Manager</option>
                </select>";
                
                echo "<table>
                        <tr>
                        <th>ID Number</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Rank</th>
                        <th></th>
                        </tr>";
                
                while($row=$res->fetch()){
                    echo "<tr>
                        <td>".$row['ID']."</td>
                        <td>".$row['f_name']."</td>
                        <td>".$row['lname']."</td>
                        <td>$select</td>
                        <td>
                            <form method='post' action='php/Admin.php' style='display: inline-block'>
                                <input type='hidden' name='rank' value='artisan' id='rank'>
                                <input type='hidden' name='id' value=".$row['ID'].">
                                <input type='submit' value='Approve' name='approveReg' class='approve'>
                            </form>
                        </td>
                        <td>
                            <form method='post' action='php/Admin.php' style='display: inline-block'>
                                <input type='hidden' name='rank' value='artisan' id='rank'>
                                <input type='hidden' name='id' value=".$row['ID'].">
                                <input type='submit' value='Decline' name='declineReg' class='decline'>
                            </form>
                        </td>
                        </tr>";
                }
            }
        }
    
        function getReport(){
            $res = $this->query("SELECT * FROM","materials_required","WHERE status = ?",["APPROVED"]);
            $from = 0;
            $to = 0;
            echo "<h2><center>Material Usage</center></h2>";
            if(isset($_POST['from'])){
                $from = str_replace("/","-",$_POST['from']);
            }
            
            if(isset($_POST['to'])){
                $to = str_replace("/","-",$_POST['to']);
            }
            
            if($from == 0 && $to == 0){
                $to = date('d-m-Y');
                $from = date('d-m-Y', strtotime('-1 months', strtotime($to)));
            }else if($from == 0){
                $from = $from = date('d-m-y', strtotime('-1 months', strtotime($to)));;
            }else if($to == 0){
                $to = $from = date('d-m-y', strtotime('+1 months', strtotime($to)));;
            }
            
            $materials = array();
            $count = array();
             echo "<center><label class='label'>Showing usage from ".$from." to ".$to."</label><center>";
            while($row = $res->fetch()){
                $date = $row['date'];
                
                
                if(strtotime($date) > (strtotime($to))){
                    break;
                }
                if(strtotime($date) < strtotime($from)){
                    continue;
                }
                
                $used = explode(",",$row['request']);
                foreach($used as $mat){
                    $mat_info = explode("-",$mat);
                    $found = 0;
                    for($i = 0; $i < count($materials); $i++){
                        if($materials[$i] == $mat_info[0]){
                            $found = 1;
                            $count[$i]+=$mat_info[1];
                        }
                    }
                    if($found == 0){
                        array_push($materials, $mat_info[0]);
                        array_push($count, $mat_info[1]);
                    }
                }
                                
            }
            
            $total = 0;
            $cost = array();
            
            for($i = 0; $i < count($materials); $i++){
                $res = $this->query("SELECT * FROM","materials","WHERE name=?",[$materials[$i]]);
                $row = $res->fetch();
                $one = $row['price'];
                $t = $one * $count[$i];
                array_push($cost, $t);
            }
            
            
            echo "<table>
                    <tr>
                        <th>Material</th>
                        <th>Number of Units used</th>
                        <th>Total Cost</th>
                    </tr>";
            for($i = 0; $i < count($materials); $i++){
                echo "<tr>
                        <td>".$materials[$i]."</td>
                        <td>".$count[$i]."</td>
                        <td>".$cost[$i]."</td>
                    </tr>";
                $total+=$cost[$i];
            }
            echo "<tr><td>Total Expenditure</td><td></td><td>".$total."</td></tr>";
            echo "</table>";
            
        }
    }

    $admin = new Admin();

    if(isset($_POST['approve'])){
        $admin->approve();
    }

    if(isset($_POST['decline'])){
        $admin->decline();
    }

    if(isset($_POST['approve_mat'])){
        $admin->approveMaterials();
    }

    if(isset($_POST['decline_mat'])){
        $admin->declineMaterials();
    }

    if(isset($_POST['approveReg'])){
        echo "here2";
        $admin->approveRegistered();
    }

    if(isset($_POST['declineReg'])){
        $admin->declineRegistered();
    }
?>