// Функции
// Одобрить заявку
function allow_request(number) {
    swal({
        title: "Одобрить заявку?",
        text: "Номер заявки: " + number,
        icon: "info",
        buttons: true
    }).then((response) => {
        if (response){
            if (Number.isInteger(number)){
                var url = "request.php";
                $.post(
                    url,
                    {
                        id: number,
                        type: 'allow'
                    },
                    allowRequest
                );

                function allowRequest(data) {
                    var response = jQuery.parseJSON(data);
                    if (response.response === true){
                        swal("Одобрено!", "Заявка под номером " + number + " была одобрена!", "success");

                    } else {
                        swal("Ошибка!", "Произошла ошибка при одобрении заявки!", "error");
                    }
                }
            }
        }
    });
}

// Отклонить заявку
function deny_request(number) {
    swal({
        title: "Отклонить заявку?",
        text: "Номер заявки: " + number,
        icon: "info",
        buttons: true
    }).then((response) => {
        if (response){
            if (Number.isInteger(number)){
                var url = "request.php";
                $.post(
                    url,
                    {
                        id: number,
                        type: 'deny'
                    },
                    denyRequest
                );

                function denyRequest(data) {
                    var response = jQuery.parseJSON(data);
                    if (response.response === true){
                        swal("Успех!", "Заявка под номером " + number + " была отклонена!", "success");
                    } else {
                        swal("Ошибка!", "Произошла ошибка при отклонении заявки!", "error");
                    }
                }
            }
        }
    });
}

// Пересмотреть заявку
function wait_request(number) {
    swal({
        title: "Пересмотреть заявку?",
        text: "Номер заявки: " + number,
        icon: "info",
        buttons: true
    }).then((response) => {
        if (response){
            if (Number.isInteger(number)){
                var url = "request.php";
                $.post(
                    url,
                    {
                        id: number,
                        type: 'wait'
                    },
                    waitRequest
                );

                function waitRequest(data) {
                    var response = jQuery.parseJSON(data);
                    if (response.response === true){
                        swal("Успех!", "Заявка под номером " + number + " была отправлена на пересмотрение!", "success");
                    } else {
                        swal("Ошибка!", "Произошла ошибка при пересмотрении заявки!", "error");
                    }
                }
            }
        }
    });
}