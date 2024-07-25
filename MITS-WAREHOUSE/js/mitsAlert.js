MITSALERT_ERROR = 1
MITSALERT_WARNING = 2
MITSALERT_INFO = 3
MITSALERT_CONFIRM = 4

var interval = 0

function mitsAlert(level, message, callback) {
    $(".alert-popup").hide()

    const popup = $("<div>").addClass("alert-popup");

    const messageElement = $("<p>").text(message);

    popup.append(messageElement);

    $("body").append(popup);

    $(popup).click(() => {
        $(".alert-popup").hide()
    })

    popup.css({
        fontSize: "1.5em",
        position: "fixed",
        top: "0",
        left: "50%",
        width: "100%",
        textAlign: "center",
        transform: "translate(-50%, 0)",
        padding: "5px",
        borderRadius: "10px",
        boxShadow: "0 2px rgba(0, 0, 0, 0.2)",
        cursor: "pointer"
    });

    switch (level) {
        case MITSALERT_ERROR: {
            popup.css({
                background: "rgba(255, 0, 0, 0.5)"
            });

            break;
        }
        case MITSALERT_WARNING: {
            popup.css({
                background: "rgba(255, 217, 0, 0.66)"
            });
            break;
        }
        case MITSALERT_INFO: {
            popup.css({
                background: "rgba(125, 218, 233, 0.5)"
            });
            break;
        }
        case MITSALERT_CONFIRM: {
            popup.css({
                background: "rgb(2, 255, 0 , 0.43)"
            });

            interval = setInterval(hidePopup, 2000)
            break;
        }
    }

    if (callback) {
        callback();
    }
}

function hidePopup() {
    $(".alert-popup").hide()
    clearInterval(interval)
}