

document.addEventListener('DOMContentLoaded', e=> {
    const $form = d.querySelector('.form_contrasena')

    $form.addEventListener('submit', e=> {
        if(e.target.contrasena_nueva1.value !== e.target.contrasena_nueva2.value){
            e.preventDefault();
            const $small = document.createElement('small');
            $small.textContent = 'La contraseña no coincide';
            e.target.contrasena_nueva2.insertAdjacentElement('afterend', $small);
        }
    });
})