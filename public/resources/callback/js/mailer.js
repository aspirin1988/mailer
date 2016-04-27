

function BMModule(success, error) {
    var forms = document.getElementsByClassName('blink-mailer');

    for(var i=0; i<forms.length; i++) {
        forms[i].addEventListener('submit', function(e) {
            e.preventDefault();
            var values = e.target;

            BlinkMailerPost(values, 'SendForm', function(response) {
                if(response) {
                    var responseFromSite = JSON.parse(response);
                    if(responseFromSite[0].code === '1') success(responseFromSite[0].text);
                    else error(responseFromSite[0].text);
                }
            });
        });
    }
}


BlinkMailerPost = function (object, url, callback) {
    var data = "";

    for(var i=0; i < object.length -1; i++) {
        var inputName = object[i].name,
            inputValue = object[i].value;

        data += inputName + "=" + inputValue + "&";
    }

    data = data.slice(0, -1);

    var XHR = ("onload" in new XMLHttpRequest()) ? XMLHttpRequest : XDomainRequest;

    var xhr = new XHR();

    xhr.open('POST', 'http://callback.blink.kz/client/callback/'+ url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(data);

    xhr.onreadystatechange = function() {
        if (this.readyState!= 4) return;

        callback(this.responseText);
    };
};