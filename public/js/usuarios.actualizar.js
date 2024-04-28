document.addEventListener('DOMContentLoaded', e=> {
    const $form = d.querySelector('.form_crear_usuario')

    $form.addEventListener('submit', e=> {
        if(e.target.contrasena1.value !== e.target.contrasena2.value){
            e.preventDefault();
            const $small = document.createElement('small');
            $small.textContent = 'La contraseña no coincide';
            e.target.contrasena2.insertAdjacentElement('afterend', $small);
        }
    });
})