function cargarGrados() {
    let nivelEducativoId = document.getElementById("nivel-educativo").value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/obtener_grados.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("grado").innerHTML = xhr.responseText;
        }
    };

    xhr.send("nivelEducativoId=" + nivelEducativoId);
}