<?php
    require_once "php/Utility.php";
    $utility->check("FOREMAN");
    require_once "php/Foreman.php";
    $foreman = new Foreman();
?>
<html>
<head>
        <link rel="stylesheet" type="text/css" href="css/style.css"> 
</head>
    <header>
        <h1>Egerton Estates Department</h1>
        <nav class="navbar">
        <?php require_once "includes/headerLinks.php";?>
    </nav>
    </header>
   <script>
    
    var artisan_id = 0;
    var artisans = [];
    var selected_id = "artisans";
    var selector_id = "artisan";
    var form_id = "selected";
    var submit_id = "submit_section";
    var count = 0; 
    function add(){
        document.getElementById('err').innerHTML="";
        var artisan = document.getElementById(selector_id).value;
        if(checkUnique(artisan)){
            return false;
        }
        if(artisan == "No Available Artisans"){
            return false;
        }
        var  form = document.getElementById(form_id);
        if(artisan_id == 0){
            document.getElementById(submit_id).innerHTML+="<input type='submit' name='assign' value='Assign'>";
        }
        form.innerHTML+="<div id='"+artisan_id+"' class='materials'><form><button onclick=\"return remove('"+artisan_id+"')\" class='rbutton'>Remove</button></form><label>"+artisan+"</label></div>";
        artisan_id+=1;
        
        
        artisans.push(artisan);
        count++;
        setValue();
        return false;
    }
    
    function remove(id){
        var el = document.getElementById(id);
        el.innerHTML = "";
        artisans[id] = null;
        setValue();
        count--;
        return false;
    }
    
    function setValue(){
        var selected = document.getElementById(selected_id);
        selected.value = "";
        for(var i = 0; i < artisans.length; i++){
            if(artisans[i] == null){
                continue;
            }
            if(selected.value.length == 0){
                selected.value = artisans[i];
            }else{
                selected.value+=","+artisans[i];
            }
        }
    }
    
    function checkUnique(check){
        for(var i = 0; i < artisans.length; i++){
            if(artisans[i] == check){
                return true;
            }
        }
        return false;
    }
    
    function validateAssignWork(){
        if(count == 0){
            document.getElementById('err').innerHTML="Select at least one artisan to do the job";
            return false;
        }
        return true;
    }
    </script>
<body class='foreman_work'>
    <?php
    
        if(isset($_GET['type']) && $_GET['type'] == "view" && isset($_GET['id'])){
            $foreman->view($_GET['id']);
        }else if(isset($_GET['type']) && $_GET['type'] == "assign" && isset($_GET['id'])){
            $foreman->Assign($_GET['id']);
        }
        
    ?>
</body>

</html>