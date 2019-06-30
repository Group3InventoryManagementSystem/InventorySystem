<?php
    require_once "Utility.php";

    class Foreman extends Utility{
        
        function assignWork(){
            $artisans = explode(",",$_POST['artisans']);
            $w_id = $_POST['work_id'];
            $artisanList = "";
            foreach($artisans as $artisan){
                $info = explode("-",$artisan);
                $run = $this->query("UPDATE ","users","SET status = ? WHERE id = ?",["ENGAGED", $info[0]]);
            }
            
            $run = $this->query("INSERT INTO ","work_assigned"," (work_id, user_id, status) VALUES(?,?,?)",[$w_id, $_POST['artisans'], "INCOMPLETE"]);
            
            $run = $this->query("UPDATE","work_request","SET status = ? WHERE id = ?",["ASSIGNED",$w_id]);
            header("Location:../ForemanWorkRequest.php");
        }
        
        function assign($id){
            $result = $this->query("SELECT * FROM","work_request","WHERE id = ?",[$id]);
            
            $artisans = $this->query("SELECT * FROM ","users","WHERE rank = ? and status = ?",["ARTISAN","FREE"]);
            
            echo "<h1><center>Assign Work<center></h1>";
            
            if($row = $result->fetch()){
                $string =  "<table>
                        <tr>
                            <th>Date Requested</th>
                            <th>Type of Facility</th>
                            <th>Building Name</th>
                            <th>Room Name</th>
                            <th>Type of Repair</th></tr>
                            <tr>
                            <td>".$row['dateRequested']."</td>
                            <td>".$row['section']."</td>
                            <td>".$row['buildingName']."</td>
                            <td>".$row['roomName']."</td>
                            <td>".$row['repairClass']."</td>
                    </tr>
                    <tr><th colspan=5>Description</th><tr>
                    <tr><td colspan=5>".$row['description']."</td></tr>
                    <tr><td colspan=5><form action='php/Foreman.php' method='post' onsubmit='return validateAssignWork()'><label>Assign to :</label><select id='artisan'>";
                if($artisans->rowCount()==0){
                    $string = $string."<option>No Available Artisans</option>";
                }else{
                    while($artisan = $artisans->fetch()){
                        $string = $string."<option>".$artisan['ID']." - ".$artisan['f_name']." </option>";
                    }
                }
                
                $string = $string."</select><button onclick='return add()'  class='button'>Add</button><input type='hidden' value='".$row['id']."' name='work_id'><input type='hidden' name='artisans' value='' id='artisans'><div id='selected'></div><p id='err'></p><div id='submit_section'></div></form></td></tr>
                    </table>";
                
                echo $string;
            }
            
            
        }
        
        function view($id){
            $result = $this->query("SELECT * FROM","work_request","WHERE id = ?",[$id]);
            
            $artisans = $this->query("SELECT * FROM","work_assigned","WHERE work_id = ? ORDER BY id DESC",[$id]);
            echo "<h2><center>Assigned Job</center></h2>";
            if($row = $result->fetch()){
                $string =  "<table>
                        <tr>
                        
                            <th>Date Requested</th>
                            <th>Type of Facility</th>
                            <th>Building Name</th>
                            <th>Room Name</th>
                            <th>Type of Repair</th></tr>
                            <tr>
                            <td>".$row['dateRequested']."</td>
                            <td>".$row['section']."</td>
                            <td>".$row['buildingName']."</td>
                            <td>".$row['roomName']."</td>
                            <td>".$row['repairClass']."</td>
                         
                    </tr>
                    <tr><th colspan=5 style='border-color: #0b1a0b'>Description</th><tr>
                    <tr><td colspan=5>".$row['description']."</td></tr>
                    <tr><td colspan=5>";
                
                $assignedInfo = $artisans->fetch();
                $assignedTo = explode(",",$assignedInfo['user_id']);
                $string = $string."<label >Assigned to :<label> <table>
                                <tr><th>ID</th>
                                <th>Name</th></tr>";
                for($i = 0; $i < sizeof($assignedTo); $i++){
                    $artisan = explode("-",$assignedTo[$i]);
                    $string = $string."<tr>
                                <td>".$artisan[0]."</td>
                                <td>".$artisan[1]."</td>
                            </tr>";
                }
                $string = $string."</table>";
                
                $string = $string."</td></tr>
                <tr><td colspan=5><form action='php/Foreman.php' method='post'><input type='hidden' value='".$assignedInfo['id']."' name='id'><input type='submit' value='Complete' name='complete'></form></td></tr>
                    </table>";
                
                echo $string;
            }
        }
        
        function getAvailableMaterials(){
            $res = $this->query("SELECT * FROM","materials","WHERE amt > ? ORDER BY name",[0]);
            
            while($row=$res->fetch()){
                echo "<option value='".$row['amt']."-".$row['name']."' id='".$row['name']."'>".$row['name']."</option>";
            }
            
        }
        
        function displayJob($id){
            $result = $this->query("SELECT * FROM","work_request","WHERE id = ?",[$id]);
            
            echo "<h2><center>Request Materials</center></h2>";
            
            if($row = $result->fetch()){
                $string =  "<table>
                        <tr>
                            <th>Date Requested</th>
                            <th>Type of Facility</th>
                            <th>Building Name</th>
                            <th>Room Name</th>
                            <th>Type of Repair</th></tr>
                            <tr>
                            <td>".$row['dateRequested']."</td>
                            <td>".$row['section']."</td>
                            <td>".$row['buildingName']."</td>
                            <td>".$row['roomName']."</td>
                            <td>".$row['repairClass']."</td>
                    </tr>
                    <tr><th colspan=5>Description</th><tr>
                    <tr><td colspan=5>".$row['description']."</td></tr>
                    </table>";
                
                echo $string;
            }
        }
        
        function request(){
            $work_id = $_POST['w_id'];
            $materials = explode(",",$_POST['selected']);
            
            $string = "";
            foreach($materials as $material){
                if(strlen($string) == 0){
                    $string = $material."-".$_POST[$material];
                }else{
                    $string = $string.",".$material."-".$_POST[$material];
                }
            }
            $res = $this->query("INSERT INTO","materials_required","(request, work_id, status) VALUES(?,?,?)",[$string, $work_id, "MANAGER"]);
            
            header("Location:../ForemanWorkRequest.php");
        }
        
        function getWork(){
            $filter = "";
            if(isset($_GET['filter'])){
                if($_GET['filter'] != "Filter" ){
                    $filter = strtoupper($_GET['filter']);
                }
            }
            
            $result = null;
            if($filter == "" || $filter == "All"){
                $result = $this->query("SELECT * FROM","work_request","WHERE status = ? or status = ?",["UNASSIGNED","ASSIGNED"]);
            }else{
                $result = $this->query("SELECT * FROM","work_request","WHERE status = ?",[$filter]);
            }
            
            echo "<h2><center>Work Requests</center></h2>";
            
            
            if($result->rowCount() == 0){
                echo "<center>No Work Requests Found</center>";
            }else{
                echo "<table><tr>
                        <th>Date Requested</th>
                        <th>Type of Facility</th>
                        <th>Building</th>
                        <th>Type of Repair</th>
                        <th>Status<th>
                    </tr>";
                while($row=$result->fetch()){
                    $string ="<tr>
                            <td>".$row['dateRequested']."</td>
                            <td>".$row['section']."</td>
                            <td>".$row['buildingName']."</td>
                            <td>".$row['repairClass']."</td>";
                      
                    $status = $row['status'];
                    
                    if($status == "ASSIGNED"){
                        $result2 = $this->query("SELECT * FROM","work_assigned","WHERE work_id = ? ORDER BY id DESC",[$row['id']]);
                        $string = $string."<td>ASSIGNED</td><td><a href='WorkPage.php?type=view&id=".$row['id']."'>View</a></td>";
                    }else if($status == "UNASSIGNED"){
                        $result2 = $this->query("SELECT * FROM","materials_required","WHERE work_id = ? ORDER BY id DESC",[$row['id']]);
                        if($result2->rowCount()==0){
                            $string = $string."<td>UNASSIGNED</td><td><a href='Materials.php?id=".$row['id']."'>Request Materials</a></td>";
                        }else{
                            $row2 = $result2->fetch();
                            if($row2['status'] == "MANAGER" || $row2['status'] == "STOREMAN"){
                                $string = $string."<td>PENDING APPROVAL</td><td></td>";
                            }else if($row2['status'] == "APPROVED"){
                                 $string = $string."<td>APPROVED</td><td><a href='WorkPage.php?type=assign&id=".$row['id']."'>Assign</a></td>";
                            }else if($row2['status'] == "DECLINED"){
                                 $string = $string."<td>DECLINED</td><td><a href='Materials.php?id=".$row['id']."'>Request Materials</a></td>";
                            }
                        }
                    }
                    
                    $string = $string."</tr>";
                    
                    echo $string;
                }
                echo "</table>";
            }
        }
        
        function completed(){
            $id = $_POST['id'];
            
            $work_info = $this->query("SELECT * FROM","work_assigned","WHERE id = ?",[$id]);
            $work_info = $work_info->fetch();
            $w_id = $work_info['work_id'];
            $artisans = explode(",",$work_info['user_id']);
            $run = $this->query("UPDATE ","work_assigned","SET status = ? WHERE id = ?",["COMPLETE",$id]);
            $run = $this->query("UPDATE ","work_request","SET status = ? WHERE id = ?",["COMPLETE",$w_id]);
            foreach($artisans as $artisan){
                $info = explode("-",$artisan);
                $run = $this->query("UPDATE ","users","SET status = ? WHERE id = ?",["FREE",$info[0]]);
            }
            
            header("Location:../ForemanWorkRequest.php");
        }
        
    }

    $foreman = new Foreman();
    
    if(isset($_POST['request'])){
        $foreman->request();
    }

    if(isset($_POST['assign'])){
        $foreman->assignWork();
    }
    
    if(isset($_POST['complete'])){
        $foreman->completed();
    }
?>