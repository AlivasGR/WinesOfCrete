function carttoggler() { 
    var cartpop = document.getElementById('cartpop'); 
    if (cartpop.style.visibility === "visible") { 
        cartpop.style.visibility = "hidden"; 
        return 0; 
    } else { 
        cartpop.style.visibility = "visible"; 
        return 1; 
    } 
} 

function toggler(eid) {
    var elem = document.getElementById(eid);
    if (elem.style.display === "block") {
        elem.style.display = "none";
    } else {
        elem.style.display = "block";
    }
}

function ordermanip(i) {
    var btn = document.getElementById("ob" + i);
    var con = document.getElementById("id" + i);
    if (con.style.height === "15em") {
        btn.value = "Show Less";
        con.style.height = "auto";
    } else {
        btn.value = "Show More";
        con.style.height = "15em";
    }
}

function transmanip(i) {
    var btn = document.getElementById("ot" + i);
    var con = document.getElementById("tb" + i);
    if (con.style.display === "none") {
        btn.value = "Hide Transactions";
        con.style.display = "block";
    } else {
        btn.value = "Show Transactions";
        con.style.display = "none";
    }
}