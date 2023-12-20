const profile = document.getElementById("profile-details");
const contaniner = document.getElementById("container-profile");
const cerrar = document.querySelector(".cerrar_profile");

profile.addEventListener("click", (e)=>{
    e.stopPropagation()
    contaniner.classList.toggle("ocultar_profile")
})

window.addEventListener("click", (e)=>{
    if(!contaniner.contains(e.target)&&!e.target.classList.contains("profile-details")){
        contaniner.classList.add("ocultar_profile")
    }
})

document.addEventListener("DOMContentLoaded", function(){
    cerrar.onclick = function(){
        contaniner.classList.add("ocultar_profile")
    }
})