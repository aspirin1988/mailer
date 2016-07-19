
(function meta () {
    var meta = document.getElementsByTagName('meta');
    var head = document.getElementsByTagName('head');
    var viewport=false;
    for(i=0; i<Object(meta).length; i++)
    {
        if (meta[i].name==='viewport') {
            viewport = true;
            if (meta[i].content.indexOf('width=device-width')>-1) {
            }
            else
            {
                meta[i].content= meta[i].content+', width=device-width';
            }
        }
    }
    if (viewport===false)
    {
        head[0].innerHTML=head[0].innerHTML+'<meta name="viewport" content="width=device-width, initial-scale=1">';
    }
})();

function get_cookie ( cookie_name )
{
    var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );

    if ( results )
        return ( encodeURIComponent ( results[2] ) );
    else
        return null;
}

function gen_cookie() {
    var one=Math.random().toString(36),
        second=Math.random().toString(36);
    document.cookie = "blinkChat="+second+one;
    return second+one;
}

function BlinkCBModule() {
    var that = this;
    var xhr = new XMLHttpRequest();
    //var currentUrl = md5(document.location.origin);

    xhr.open('GET', '{host}/client/Template/Get/', true);
    xhr.send();

    var token = get_cookie ( "blinkChat" );
    if (!token)
    {
        token=gen_cookie();
    }



    setInterval(function () {
        if (document.getElementById('blink-cb-module-popup-comments')) {
            setTimeout(function () {
                var toSendObject = document.getElementById('Chat');
                document.getElementById('chat-token').value = token;

                that.post(toSendObject, 'GetChat', function (response) {
                    var currentResutlt = JSON.parse(response);
                    var Content = '';
                    var count_obj = Object.keys(currentResutlt).length;
                    for (i = count_obj - 1; i >= 0; i--) {
                        if (currentResutlt[i].data&&currentResutlt[i].data.message) {
                            if (currentResutlt[i].from == token) {
                                Content = Content + '<div class="site"><p class="bubble">' + currentResutlt[i].data.message.text + '</p></div>';
                            }
                            else {
                                Content = Content + '<div class="operator"><p class="bubble1" >' + currentResutlt[i].data.message.text + '</p></div>';
                            }
                        }
                    }
                    document.getElementById('Chat-text').innerHTML = Content;

                });
            }, 1);
        }
    },3000);

    xhr.onreadystatechange = function() {
        if (this.readyState!= 4) return;

        var template = this.responseText,
            body = document.getElementsByTagName('body')[0];

        if(template !== false) {
            var htmlObject = document.createElement('div');
            htmlObject.style.position = 'relative';
            htmlObject.style.zIndex = '999999999';
            htmlObject.innerHTML = template;

            document.body.appendChild(htmlObject);

            that.loadJS();
        }
    };
}


BlinkCBModule.prototype.post = function (object, url, callback) {
    var data = "";

    for(var i=0; i < object.length -1; i++) {
        var inputName = object[i].name,
            inputValue = object[i].value;

        data += inputName + "=" + inputValue + "&";
    }

    data = data.slice(0, -1);

    var xhr = new XMLHttpRequest();

    xhr.open('POST', '{host}/client/callback/'+ url +'/', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(data);

    xhr.onreadystatechange = function() {
        if (this.readyState!= 4) return;

        callback(this.responseText);
    };
};

BlinkCBModule.prototype.clearForm = function (object) {
    for(var i=0; i < object.length -1; i++) {
            object[i].value = '';
    }
};

BlinkCBModule.prototype.blockForm = function (object) {
    for(var i=0; i < object.length -1; i++) {
        object[i].disabled  = true;
    }
};

BlinkCBModule.prototype.unBlockForm = function (object) {
    for(var i=0; i < object.length -1; i++) {
        object[i].disabled = false;
    }
};

BlinkCBModule.prototype.loadJS = function() {
    var doc = document,
        that = this,
        allBtnContainer = doc.getElementsByClassName('blink-cb-module-btns-container')[0],
        mainOpenBtn = doc.getElementsByClassName('blink-cb-module-main-btns')[0],
        mainBody = doc.getElementsByClassName('blink-cb-module-main-body')[0],
        mainCloseBtn = doc.getElementsByClassName('blink-cb-module-exit-body-btn'),
        allBtns = doc.getElementsByClassName('blink-cb-open-popup'),
        overlay = doc.getElementById('overlay-blink'),
        mainBtnContainer = doc.getElementsByClassName('blink-cb-module-main-btn-container')[0],
        otherBtnsContainer = doc.getElementsByClassName('blink-cb-module-other-btn-container')[0],
        otherBtns = otherBtnsContainer.children;


    if(document.getElementsByClassName('search-blink-cb-module-btn').length >= 2 ) {
        document.getElementById('blink-cb-module-own-btn').style.display = 'none';
    }
    /*overlay.addEventListener('click', function(event) {
        event.preventDefault();
        overlay.style.display = 'none';
        mainOpenBtn.classList.add('active');
        mainBody.style.animationDuration = '0.3s';
        mainBody.classList.remove('fadeInRight');
        mainBody.classList.add('fadeOutRight');
        document.getElementsByTagName('html')[0].classList.remove('no-overflow');

        setTimeout(function() {
            mainBody.classList.remove('active');
        }, 300);
    });*/
    for (var i = 0; i < mainCloseBtn.length; i++) {
        mainCloseBtn[i].addEventListener('click', function(event) {
            event.preventDefault();
            overlay.style.display = 'none';
            mainOpenBtn.classList.add('active');
            mainBody.style.animationDuration = '0.3s';
            mainBody.classList.remove('fadeInRight');
            mainBody.classList.add('fadeOutRight');
            document.getElementsByTagName('html')[0].classList.remove('no-overflow');

            setTimeout(function() {
                mainBody.classList.remove('active');
            }, 300);
        });
    }

    (function() {
        var animations = {
            mainBtn: 'bounceInRight',
            otherBtn: {
                in: 'fadeInRight',
                out: 'fadeOutRight'
            }
        };

        mainBtnContainer.classList.add(animations.mainBtn);

        allBtnContainer.addEventListener('mouseenter', function(event) {
            var i = 0, delayTime = 0;

            otherBtnsContainer.classList.remove('hidden');
            otherBtnsContainer.style.width = (otherBtnsContainer.clientWidth * otherBtns.length) + 'px';

            for (i = 0; i < otherBtns.length; i++) {
                otherBtns[i].classList.remove(animations.otherBtn.out);
                otherBtns[i].classList.add(animations.otherBtn.in);
                otherBtns[i].style.animationDelay = '0.' + delayTime + 's';
                otherBtns[i].style.animationDuration = '0.3s';
                delayTime++;
            }

        });

        allBtnContainer.addEventListener('mouseleave', function(event) {
            var i = 0, delayTime = 0;

            for (i = otherBtns.length; i > 0; i--) {
                otherBtns[i - 1].classList.remove(animations.otherBtn.in);
                otherBtns[i - 1].classList.add(animations.otherBtn.out);
                otherBtns[i - 1].style.animationDelay = '0.' + delayTime + 's';
                otherBtns[i - 1].style.animationDuration = '0.2s';
                delayTime++;
            }

            setTimeout(function() {
                otherBtnsContainer.classList.add('hidden');
                otherBtnsContainer.style.width = 'auto';
            }, 200);
        });

    })();

    (function() {


        for (var i = 0; i < allBtns.length; i++) {
            allBtns[i].addEventListener('click', function(event) {
                event.preventDefault();

                var	popupToOpenId = this.children[0].getAttribute('href').replace("#", ''),
                    popupToOpen = doc.getElementById('blink-cb-module-popup-' + popupToOpenId),
                    allPopups = doc.getElementsByClassName('blink-cb-module-flip-container');

                if(!mainBody.classList.contains('active')) {
                    overlay.style.display = 'block';
                    mainBody.style.animationDuration = '0.5s';
                    mainBody.classList.add('active');
                    mainBody.classList.remove('fadeOutRight');
                    mainBody.classList.add('fadeInRight');

                    mainOpenBtn.classList.remove('active');
                }

                for (var y = 0; y < allBtns.length; y++) {
                    allBtns[y].classList.remove('active');
                }

                for (var i = 0; i < allPopups.length; i++) {
                    allPopups[i].classList.remove('active');
                }

                popupToOpen.classList.add('active');
                doc.getElementById('blink-cb-module-to-'  + popupToOpenId).classList.add('active');

                document.getElementsByTagName('html')[0].classList.add('no-overflow');
            });
        }
    })();

    (function() {
        var form = doc.getElementsByClassName('blink-cb-module-popup-form');

        for (var i = 0; i < form.length; i++) {
            form[i].addEventListener('submit', function(event) {
                event.preventDefault();

                var parentId = this.getAttribute('data'),
                    query = this.getAttribute('id'),
                    dataClear = this.getAttribute('data-clear'),
                    toSendObject = event.target,
                    parentDiv = doc.getElementById(parentId),
                    errMessAll = doc.getElementsByClassName('blink-cb-module-error-messange'),
                    succMessAll = doc.getElementsByClassName('blink-cb-module-success-messange'),
                    errorMessange = parentDiv.getElementsByClassName('blink-cb-module-error-messange')[0],
                    successMessange = parentDiv.getElementsByClassName('blink-cb-module-success-messange')[0];
                for(var i=0; i < errMessAll.length; i++) {
                    errMessAll[i].style.display = 'none';
                    succMessAll[i].style.display = 'none';
                }

                that.blockForm(toSendObject);

                that.post(toSendObject, query, function(response) {
                    var currentResutlt = JSON.parse(response);
                    if(dataClear==='false'){
                        var Content='';
                        var count_obj=Object.keys(currentResutlt).length;
                            for(i=count_obj-1; i>=0; i--)
                            {
                                if (currentResutlt[i].from=='123456789')
                                {
                                    Content = Content + '<div class="site"><p class="bubble">' + currentResutlt[i].data.message.text + '</p></div>';
                                }
                                else {
                                    Content = Content + '<div class="operator"><p class="bubble1" >' + currentResutlt[i].data.message.text + '</p></div>';
                                }
                            }
                        that.unBlockForm(toSendObject);
                        setTimeout(function(){document.getElementById('chat-clear-text').value='';  },1);
                            document.getElementById('Chat-text').innerHTML=Content;
                        //that.clearForm(toSendObject);
                    }
                    else {
                        if (currentResutlt[0].code === '1') {
                            successMessange.style.display = 'block';
                            //successMessange.children[0].innerHTML = currentResutlt[0].text;
                            parentDiv.classList.add('active-flip');
                            that.unBlockForm(toSendObject);
                            that.clearForm(toSendObject);
                        } else {
                            errorMessange.style.display = 'block';
                            //errorMessange.children[0].innerHTML = currentResutlt[0].text;
                            parentDiv.classList.add('active-flip');
                            that.unBlockForm(toSendObject);
                        }
                    }
                });

            });
        }
    })();

    (function() {
        var btns = doc.getElementsByClassName('blink-cb-module-popup-flip-back-btns');

        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener('click', function(event) {
                event.preventDefault();

                var parentId = this.getAttribute('data'),
                    parentDiv = doc.getElementById(parentId);

                parentDiv.classList.remove('active-flip');
            });
        }
    })();
};

var loadTemplate = function () {
    new BlinkCBModule();
};

var loadLocalFunc = function(evt) {
    window.onload(evt);
    loadTemplate(evt);
};

if(window.attachEvent) {
    window.attachEvent('onload', loadTemplate);
} else {
    if(window.onload) {
        window.onload = loadLocalFunc;
    } else {
        window.onload = loadTemplate;
    }
}

/*
 Input Masks
 */

(function(root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(factory);
    } else if (typeof exports === 'object') {
        module.exports = factory();
    } else {
        root.VMasker = factory();
    }
}(this, function() {
    var DIGIT = "9",
        ALPHA = "A",
        ALPHANUM = "S",
        BY_PASS_KEYS = [9, 16, 17, 18, 36, 37, 38, 39, 40, 91, 92, 93],
        isAllowedKeyCode = function(keyCode) {
            for (var i = 0, len = BY_PASS_KEYS.length; i < len; i++) {
                if (keyCode == BY_PASS_KEYS[i]) {
                    return false;
                }
            }
            return true;
        },
        mergeMoneyOptions = function(opts) {
            opts = opts || {};
            opts = {
                precision: opts.hasOwnProperty("precision") ? opts.precision : 2,
                separator: opts.separator || ",",
                delimiter: opts.delimiter || ".",
                unit: opts.unit && (opts.unit.replace(/[\s]/g,'') + " ") || "",
                suffixUnit: opts.suffixUnit && (" " + opts.suffixUnit.replace(/[\s]/g,'')) || "",
                zeroCents: opts.zeroCents,
                lastOutput: opts.lastOutput
            };
            opts.moneyPrecision = opts.zeroCents ? 0 : opts.precision;
            return opts;
        },
    // Fill wildcards past index in output with placeholder
        addPlaceholdersToOutput = function(output, index, placeholder) {
            for (; index < output.length; index++) {
                if(output[index] === DIGIT || output[index] === ALPHA || output[index] === ALPHANUM) {
                    output[index] = placeholder;
                }
            }
            return output;
        }
        ;

    var VanillaMasker = function(elements) {
        this.elements = elements;
    };

    VanillaMasker.prototype.unbindElementToMask = function() {
        for (var i = 0, len = this.elements.length; i < len; i++) {
            this.elements[i].lastOutput = "";
            this.elements[i].onkeyup = false;
            this.elements[i].onkeydown = false;

            if (this.elements[i].value.length) {
                this.elements[i].value = this.elements[i].value.replace(/\D/g, '');
            }
        }
    };

    VanillaMasker.prototype.bindElementToMask = function(maskFunction) {
        var that = this,
            onType = function(e) {
                e = e || window.event;
                var source = e.target || e.srcElement;

                if (isAllowedKeyCode(e.keyCode)) {
                    setTimeout(function() {
                        that.opts.lastOutput = source.lastOutput;
                        source.value = VMasker[maskFunction](source.value, that.opts);
                        source.lastOutput = source.value;
                        if (source.setSelectionRange && that.opts.suffixUnit) {
                            source.setSelectionRange(source.value.length, (source.value.length - that.opts.suffixUnit.length));
                        }
                    }, 0);
                }
            }
            ;
        for (var i = 0, len = this.elements.length; i < len; i++) {
            this.elements[i].lastOutput = "";
            this.elements[i].onkeyup = onType;
            if (this.elements[i].value.length) {
                this.elements[i].value = VMasker[maskFunction](this.elements[i].value, this.opts);
            }
        }
    };

    VanillaMasker.prototype.maskMoney = function(opts) {
        this.opts = mergeMoneyOptions(opts);
        this.bindElementToMask("toMoney");
    };

    VanillaMasker.prototype.maskNumber = function() {
        this.opts = {};
        this.bindElementToMask("toNumber");
    };

    VanillaMasker.prototype.maskAlphaNum = function() {
        this.opts = {};
        this.bindElementToMask("toAlphaNumeric");
    };

    VanillaMasker.prototype.maskPattern = function(pattern) {
        this.opts = {pattern: pattern};
        this.bindElementToMask("toPattern");
    };

    VanillaMasker.prototype.unMask = function() {
        this.unbindElementToMask();
    };

    var VMasker = function(el) {
        if (!el) {
            throw new Error("VanillaMasker: There is no element to bind.");
        }
        var elements = ("length" in el) ? (el.length ? el : []) : [el];
        return new VanillaMasker(elements);
    };

    VMasker.toMoney = function(value, opts) {
        opts = mergeMoneyOptions(opts);
        if (opts.zeroCents) {
            opts.lastOutput = opts.lastOutput || "";
            var zeroMatcher = ("("+ opts.separator +"[0]{0,"+ opts.precision +"})"),
                zeroRegExp = new RegExp(zeroMatcher, "g"),
                digitsLength = value.toString().replace(/[\D]/g, "").length || 0,
                lastDigitLength = opts.lastOutput.toString().replace(/[\D]/g, "").length || 0
                ;
            value = value.toString().replace(zeroRegExp, "");
            if (digitsLength < lastDigitLength) {
                value = value.slice(0, value.length - 1);
            }
        }
        var number = value.toString().replace(/[\D]/g, ""),
            clearDelimiter = new RegExp("^(0|\\"+ opts.delimiter +")"),
            clearSeparator = new RegExp("(\\"+ opts.separator +")$"),
            money = number.substr(0, number.length - opts.moneyPrecision),
            masked = money.substr(0, money.length % 3),
            cents = new Array(opts.precision + 1).join("0")
            ;
        money = money.substr(money.length % 3, money.length);
        for (var i = 0, len = money.length; i < len; i++) {
            if (i % 3 === 0) {
                masked += opts.delimiter;
            }
            masked += money[i];
        }
        masked = masked.replace(clearDelimiter, "");
        masked = masked.length ? masked : "0";
        if (!opts.zeroCents) {
            var beginCents = number.length - opts.precision,
                centsValue = number.substr(beginCents, opts.precision),
                centsLength = centsValue.length,
                centsSliced = (opts.precision > centsLength) ? opts.precision : centsLength
                ;
            cents = (cents + centsValue).slice(-centsSliced);
        }
        var output = opts.unit + masked + opts.separator + cents + opts.suffixUnit;
        return output.replace(clearSeparator, "");
    };

    VMasker.toPattern = function(value, opts) {
        var pattern = (typeof opts === 'object' ? opts.pattern : opts),
            patternChars = pattern.replace(/\W/g, ''),
            output = pattern.split(""),
            values = value.toString().replace(/\W/g, ""),
            charsValues = values.replace(/\W/g, ''),
            index = 0,
            i,
            outputLength = output.length,
            placeholder = (typeof opts === 'object' ? opts.placeholder : undefined)
            ;

        for (i = 0; i < outputLength; i++) {
            // Reached the end of input
            if (index >= values.length) {
                if (patternChars.length == charsValues.length) {
                    return output.join("");
                }
                else if ((placeholder !== undefined) && (patternChars.length > charsValues.length)) {
                    return addPlaceholdersToOutput(output, i, placeholder).join("");
                }
                else {
                    break;
                }
            }
            // Remaining chars in input
            else{
                if ((output[i] === DIGIT && values[index].match(/[0-9]/)) ||
                    (output[i] === ALPHA && values[index].match(/[a-zA-Z]/)) ||
                    (output[i] === ALPHANUM && values[index].match(/[0-9a-zA-Z]/))) {
                    output[i] = values[index++];
                } else if (output[i] === DIGIT || output[i] === ALPHA || output[i] === ALPHANUM) {
                    if(placeholder !== undefined){
                        return addPlaceholdersToOutput(output, i, placeholder).join("");
                    }
                    else{
                        return output.slice(0, i).join("");
                    }
                }
            }
        }
        return output.join("").substr(0, i);
    };

    VMasker.toNumber = function(value) {
        return value.toString().replace(/(?!^-)[^0-9]/g, "");
    };

    VMasker.toAlphaNumeric = function(value) {
        return value.toString().replace(/[^a-z0-9 ]+/i, "");
    };

    return VMasker;

}));

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

document.onreadystatechange = function () {
    function viseble (){
        document.getElementById('blink-main-module').style.display='block';
        var el = document.querySelector('#Recall input[name="phone"]');
        VMasker(el).maskPattern("+9(999) 999-99-99");
        var el = document.querySelector('#Query input[name="phone"]');
        VMasker(el).maskPattern("+9(999) 999-99-99");
    }
    if (document.readyState==='complete'){
        setTimeout(viseble,1000);
    }
};

