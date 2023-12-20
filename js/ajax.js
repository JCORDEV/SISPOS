const formularios_ajax = document.querySelectorAll(".FormularioAjax");
const formulario = document.getElementById('FormularioAjax');
const toastTrigger = document.getElementById('liveToastBtn');
const toastLiveExample = document.getElementById('liveToast');

function enviar_formulario_ajax(e) {
    e.preventDefault();
    let enviar = confirm("Quieres enviar el formulario");

    if (enviar == true) {
        let data = new FormData(this);
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");

        let encabezados = new Headers();

        let config = {
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };

        fetch(action, config)
        .then(respuesta => respuesta.text())
        .then(respuesta => {
            let contenedor = document.querySelector(".form-rest");
            contenedor.innerHTML = respuesta;

            
        
    
        });
        formulario.reset();
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
        toastBootstrap.show();
    }
    
}

formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit", enviar_formulario_ajax);
});



var exampleElement = document.getElementById("example");
    if (exampleElement) {
        new MultiSelect(exampleElement);
    }