<?php
require_once "Utility.php";

class Storeman extends Utility{
    
        function AddMaterials(){
            $name = $_POST['name'];
            $amt = $_POST['units'];
            $price = $_POST['price'];
            $ref = $_POST['ref'];
            
            $res = $this->query("SELECT * FROM ","materials","WHERE name=?",[$name]);
            
            if($res->rowCount() > 0){
                $row = $res->fetch();
                $amt+=$row['amt'];
                $res = $this->query("UPDATE","materials","SET amt = ?, price = ?, last_added = ?, ref = ? WHERE name = ?",[$amt, $price, date('d-m-Y'), $ref, $name]);
            }else{
                $res = $this->query("INSERT INTO","materials","(name, amt, price, ref, last_added) VALUES(?,?,?,?,?)",[$name, $amt, $price, $ref, date('d-m-Y')]);
            }
            
            header("Location:../AddMaterials.php?suc=Materials added Successfully");
        }
    
        function getMaterialsRequested(){
            $rank = $_SESSION['rank'];
            if($rank == "STOREMAN"){
                $result = $this->query("SELECT * FROM","materials_required","WHERE status = ?",['STOREMAN']);
                
                echo "<h2><center>Materials Requested</center></h2>";
                
                if($result->rowCount() == 0){
                    echo "<center>No materials requested</center>";
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
                        $res2 = $this->query("SELECT * FROM","work_request","WHERE id = ?",[$w_id]);
                        $row2 = $res2->fetch();
                        $string =  "<tr>
                        <td>".$row2['dateRequested']."</td>
                        <td>".$row2['buildingName']."</td>
                        <td>".$row2['roomName']."</td>
                        <td>".$row2['repairClass']."</td>
                        <td>".$row2['description']."</td>
                        <td>".$materials."</td>
                        <td><form method='post' action='php/StoreKeeper.php'>
                        <input type='hidden' value='".$row['id']."' name='id'>
                        <input type='submit' value='Approve' name='approve_mat' class='approve'>
                        </form></td>
                        <td><form method='post' action='php/StoreKeeper.php'>
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
            
            $request = $this->query("UPDATE ","materials_required","SET status = ? WHERE id = ?",["APPROVED",$id]);
            
            $request = $this->query("UPDATE ","materials_required","SET date = ? WHERE id = ?",[date('d-m-Y'),$id]);
            
           $request = $this->query("SELECT * FROM","materials_required","WHERE id = ?",[$id]);
            $row = $request->fetch();
            $materials = explode(",",$row['request']);
           
            foreach($materials as $material){
                $info = explode("-",$material);
                $run = $this->query("SELECT * FROM",'materials',"WHERE name = ?", [$info[0]]);
                $row = $run->fetch();
                $amt = $row['amt'];
                $amt-=$info[1];
                $run = $this->query("UPDATE","materials","SET amt = ? WHERE name = ?",[$amt, $info[0]]);
            }
            header("Location:../MaterialsRequested.php");
        }
        
        function declineMaterials(){
            $id = $_POST['id'];
            
            $request = $this->query("UPDATE ","materials_required","SET status = ? WHERE id = ?",["DECLINED",$id]);
            
            header("Location:../MaterialsRequested.php");
        }
}

$storeMan = new StoreMan();

if(isset($_POST['add'])){
    $storeMan->AddMaterials();
}

if(isset($_POST['approve_mat'])){
    $storeMan->approveMaterials();
}

if(isset($_POST['decline_mat'])){
    $storeMan->declineMaterials();
}

?>