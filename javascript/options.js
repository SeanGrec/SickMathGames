const checkbox1 = document.getElementById("checkbox1");
const checkbox2 = document.getElementById("checkbox2");
const checkbox3 = document.getElementById("checkbox3");

checkbox1.addEventListener("click", () => {
    if(checkbox1.checked){
        document.cookie = "cookieName1=active1";
    }else{  
        document.cookie = "cookieName1=; Max-Age=0";
    }
});
checkbox2.addEventListener("click", () => {
    if(checkbox2.checked){
        document.cookie = "cookieName2=active2";
    }else{  
        document.cookie = "cookieName2=; Max-Age=0";
    }
});
checkbox3.addEventListener("click", () => {
    if(checkbox3.checked){
        document.cookie = "cookieName3=active3";
    }else{  
        document.cookie = "cookieName3=; Max-Age=0";
    }
});