
const $radioSi = document.getElementById("si_factura");
const $radioNo = document.getElementById("no_factura");
const $contRadioButton = document.querySelector(".cont_radio_imput");

const $inputFacturaElectronica = document.createElement("input");
$inputFacturaElectronica.type = "text";
$inputFacturaElectronica.name = "num_factura_electronica";
$inputFacturaElectronica.classList.add("input_factura_electronica");
$inputFacturaElectronica.setAttribute("required", "true");

document.addEventListener("click", e=> {
    if(e.target === $radioSi){
        $contRadioButton.insertAdjacentElement("afterend",$inputFacturaElectronica);
    }

    if(e.target === $radioNo){
        document.querySelector(".form_aggFactura").removeChild($inputFacturaElectronica);
    }
})