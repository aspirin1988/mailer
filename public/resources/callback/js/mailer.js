function BMModule() {}

BMModule.prototype.submitForm = function(ea, t) {
    var o = this;
    for (var n = document.getElementsByClassName("blink-mailer"), r = 0; r < n.length; r++) {

        n[r].addEventListener("submit", function(e) {
            e.preventDefault();
            var r = e.target;
            o.post(r, "SendForm", function(n) {
                if (n) {
                    var l = JSON.parse(n);
                    "1" === l[0].code ? (o.clearForm(r), ea(l[0].text)) : (t(l[0].text))
                }
            });
        });
    }
};

BMModule.prototype.clearForm = function(e) {
    for (var t = 0; t < e.length - 1; t++) e[t].value = ""
};

BMModule.prototype.post = function(e, t, o) {
    for (var n = "", r = 0; r < e.length - 1; r++) {
        var l = e[r].name,
            a = e[r].value;
        n += l + "=" + a + "&"
    }
    n = n.slice(0, -1);
    var c = new XMLHttpRequest;
    c.open("POST", "https://callback.blink.kz/client/callback/" + t, !0);
    c.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    c.send(n);
    c.onreadystatechange = function() {
        if(4 == this.readyState) { o(this.responseText); }
    };
};


//function BMModule(){}BMModule.prototype.submitForm=function(e,t){for(var o=this,n=document.getElementsByClassName("blink-mailer"),r=0;r<n.length;r++)n[r].addEventListener("submit",function(n){n.preventDefault();var r=event.target;o.blockForm(r),o.post(r,"SendForm",function(n){if(n){var l=JSON.parse(n);"1"===l[0].code?(o.unBlockForm(r),o.clearForm(r),e(l[0].text)):(o.unBlockForm(r),t(l[0].text))}})})},BMModule.prototype.clearForm=function(e){for(var t=0;t<e.length-1;t++)e[t].value=""},BMModule.prototype.blockForm=function(e){for(var t=0;t<e.length-1;t++)e[t].disabled=!0},BMModule.prototype.unBlockForm=function(e){for(var t=0;t<e.length-1;t++)e[t].disabled=!1},BMModule.prototype.post=function(e,t,o){for(var n="",r=0;r<e.length-1;r++){var l=e[r].name,a=e[r].value;n+=l+"="+a+"&"}n=n.slice(0,-1);var c=new XMLHttpRequest;c.open("POST","https://callback.blink.kz/client/callback/"+t,!0),c.setRequestHeader("Content-type","application/x-www-form-urlencoded"),c.send(n),c.onreadystatechange=function(){4==this.readyState&&o(this.responseText)}};