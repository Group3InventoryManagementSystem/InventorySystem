<?php

    require_once "php/Utility.php";
    $utility->check("FOREMAN");
    require_once "php/Foreman.php";
    $foreman = new Foreman();
?>
<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" type="text/css" href="css/style.css"> 
</head>
<script type="text/javascript">
    var material_id = 0;
    var materials = [];
    var selected_id = "selected";
    var selector_id = "material";
    var form_id = "materials_request_form";
    var submit_id = "submit_section";
    var count = 0;
    var err;
    function getForm(){
        
        var material1 = (document.getElementById(selector_id).value).split("-");
        
        var material = material1[1];
        
        err = document.getElementById('err');
        document.getElementById('err').innerHTML = "";
        
        if(checkUnique(material)){
            return false;
        }
        
        var  material_form = document.getElementById(form_id);
        if(material_id == 0){
            document.getElementById(submit_id).innerHTML+="<input type='submit' value='Submit Request' name='request'>";
        }
        material_form.innerHTML+="<tr id='"+material_id+"' class='materials'><td><form><button onclick=\"return remove('"+material_id+"')\">Remove</button></form><label class='name'>"+material+"</label></td><td><input type='number' placeholder='how many units' name='"+material+"' id='"+material+"_name' required min='1'></td><td id='"+material+"_err' class='error'></td></tr>";
        material_id+=1;
        
        
        materials.push(material);
        count++;
        setValue();
        return false;
    }
    
    function remove(id){
        var el = document.getElementById(id);
        el.innerHTML = "";
        el.style.display = 'none';
        materials[id] = "none";
        setValue();
        count--;
        return false;
    }
    
    function setValue(){
        var selected = document.getElementById(selected_id);
        selected.value = "";
        for(var i = 0; i < materials.length; i++){
            if(materials[i] == "none"){
                continue;
            }
            if(selected.value.length == 0){
                selected.value = materials[i];
            }else{
                selected.value+=","+materials[i];
            }
        }
    }
    
    function checkUnique(check){
        for(var i = 0; i < materials.length; i++){
            if(materials[i] == check){
                return true;
            }
        }
        return false;
    }
    
    function validateRequestMaterials(){
        if(count == 0){
            err.innerHTML = "* Select at least one material to request";
            return false;
        }
        for(var i = 0; i < materials.length; i++){
            if(materials[i] == "none"){
                continue;
            }
            var amt = parseInt(((document.getElementById(materials[i]).value).split("-"))[0]);
            var set = parseInt(document.getElementById(materials[i]+'_name').value);
            document.getElementById(materials[i]+'_err').innerHTML = "";
            if(amt < set){
                document.getElementById(materials[i]+'_err').innerHTML = "* Maximum amount available is "+amt;
                return false;
            }
        }
        
        return true;
    }
</script>
    <header>
        <h1>Egerton Estates Department</h1>
        <nav class="navbar">
        <?php require_once "includes/headerLinks.php";?>
    </nav>
    </header>
    <body>
        <?php $foreman->displayJob($_GET['id']);?>
        
        <div class='materials'>
        <form onsubmit="return getForm()">
        <label>Select Materials Required</label>
        <select id='material'>
            <?php $foreman->getAvailableMaterials(); ?>
            </select><input type="submit" value='add' class='button'>
        </form>
        <form action="php/Foreman.php" method="post" onsubmit="return validateRequestMaterials()">
            <input type="hidden" name='selected' value='' id='selected'>
            <input type="hidden" name='w_id' value='<?php echo $_GET['id'] ?>'>
            <table id='materials_request_form'></table>
            <p id='err'></p>
            <div id='submit_section'></div>
        </form>
             
        </div>
    </body>
</html>