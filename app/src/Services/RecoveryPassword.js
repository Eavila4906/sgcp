document.addEventListener('DOMContentLoaded', function() {
    var formRecoveryPassword = document.querySelector("#form-recoveryPassword");
	formRecoveryPassword.onsubmit = function (e) {
		e.preventDefault();
		var password = document.querySelector('#password').value;
        var passwordC = document.querySelector('#passwordconfirmation').value;

		if (password == '' || passwordC == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
        
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = 'http://localhost:8000/sgcp/login/passwordupdate';
		var formData = new FormData(formRecoveryPassword);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
                    alert(objData.msg, window.location.href = "http://localhost:4200");
				} else {
					swal("¡Atención!", objData.msg, "warning");
				}
			}
		}

	}
}, false);
