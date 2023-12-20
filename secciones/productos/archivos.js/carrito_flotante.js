const addToCart=document.getElementById('abrir_modal_flotante');
const closeModal=document.querySelector('.jsModalClose');
const modal=document.getElementById('jsModalCarrito');

addToCart.addEventListener('click', function(event){
    modal.classList.toggle('active');
})

//CERRAR EL MODAL
closeModal.addEventListener('click',(event)=>{
    event.target.parentNode.parentNode.classList.remove('active');
})

//CERRAMOS MODAL CUANDO HACEMOS CLICK FUERA DEL CONTENDINO DEL MODAL
window.onclick = (event)=>{
    if(event.target == modal){
        modal.classList.remove('active');
    }
}
