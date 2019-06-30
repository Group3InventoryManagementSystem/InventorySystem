function validateRegister(){
    var id = document.getElementById('id');
    var pass = document.getElementById('pass');
    var confirm = document.getElementById('confirm');
    var err = document.getElementById('err');
    var suc = document.getElementById('suc');
    
    if(id){
        
    }
    if(pass.length < 6){
        err.innerHTML = "Password needs to be at least 6 charachters in length";
        return false;
    }
    if(pass != confirm){
        err.innerHTML = "Passwords do not match";
        return false;
    }
    
    return false;
}


