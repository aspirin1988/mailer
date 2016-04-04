function BlinkCBModule() {
    var that = this;
    var xhr = new XMLHttpRequest();
    //var currentUrl = md5(document.location.origin);

    xhr.open('GET', '{host}/client/Template/Get/', true);
    xhr.send();

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

BlinkCBModule.prototype.loadJS = function() {
    var doc = document,
        that = this,
        allBtnContainer = doc.getElementsByClassName('blink-cb-module-btns-container')[0],
        mainOpenBtn = doc.getElementsByClassName('blink-cb-module-main-btns')[0],
        mainBody = doc.getElementsByClassName('blink-cb-module-main-body')[0],
        mainCloseBtn = doc.getElementsByClassName('blink-cb-module-exit-body-btn'),
        allBtns = doc.getElementsByClassName('blink-cb-open-popup'),
        mainBtnContainer = doc.getElementsByClassName('blink-cb-module-main-btn-container')[0],
        otherBtnsContainer = doc.getElementsByClassName('blink-cb-module-other-btn-container')[0],
        otherBtns = otherBtnsContainer.children;

    for (var i = 0; i < mainCloseBtn.length; i++) {
        mainCloseBtn[i].addEventListener('click', function(event) {
            event.preventDefault();

            mainOpenBtn.classList.add('active');
            mainBody.style.animationDuration = '0.3s';
            mainBody.classList.remove('fadeInRight');
            mainBody.classList.add('fadeOutRight');

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
                    parentDiv = doc.getElementById(parentId),
                    errMessAll = doc.getElementsByClassName('blink-cb-module-error-messange'),
                    succMessAll = doc.getElementsByClassName('blink-cb-module-success-messange'),
                    errorMessange = parentDiv.getElementsByClassName('blink-cb-module-error-messange')[0],
                    successMessange = parentDiv.getElementsByClassName('blink-cb-module-success-messange')[0];

                for(var i=0; i < errMessAll.length; i++) {
                    errMessAll[i].style.display = 'none';
                    succMessAll[i].style.display = 'none';
                }

                that.post(event.target, query, function(response) {
                    console.log(response);

                    successMessange.style.display = 'block';
                    parentDiv.classList.add('active-flip');
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

    /*
     var that = this,
     swticherAnchor = document.getElementsByClassName('blink-cb-switcher-btn'),
     swticherBlocks = document.getElementsByClassName('blink-cb-block'),
     openBlockBtn = document.getElementById('blink-cb-main-btn'),
     openBlock = document.getElementsByClassName('blink-cb-container')[0],
     exitBtn = document.getElementsByClassName('blink-cb-exit-btn')[0],
     icons = document.getElementsByClassName('blink-cb-icon-wrapper'),
     iconsContainer = document.getElementsByClassName('blink-cb-small-icons-cont')[0],
     recallFormSubmit = document.getElementsByClassName('blink-cb-recall-form')[0],
     messangeFormSubmit = document.getElementsByClassName('blink-cb-messange-form')[0],
     successDiv = document.getElementsByClassName('blink-cb-response-success'),
     errorDiv =  document.getElementsByClassName('blink-cb-response-error');

     VMasker(document.getElementById("blink-cb-phone-recall")).maskPattern('(999) 999-9999');
     VMasker(document.getElementById("blink-cb-phone-messange")).maskPattern('(999) 999-9999');

     for (var i = 0; i < swticherAnchor.length; i++) {
     swticherAnchor[i].addEventListener('click', function(event) {
     event.preventDefault();
     event.stopPropagation();
     if(openBlockBtn.style.display !== 'none') {
     openBlockBtn.style.display = 'none';

     openBlock.classList.remove('blink-cb-fadeOutRight');
     openBlock.classList.add('blink-cb-visible');
     openBlock.classList.add('blink-cb-fadeInRight');
     }

     var data = this.getAttribute('data'),
     buttonId = this.getAttribute('data-id'),
     switcherOpenBlock = document.getElementById(data),
     headerText = switcherOpenBlock.getElementsByClassName('blink-cb-header-text')[0],
     contentText = switcherOpenBlock.getElementsByClassName('blink-cb-header-content')[0],
     switcherActiveButon = document.getElementById(buttonId);

     for (var i = 0; i < swticherAnchor.length; i++) {
     swticherAnchor[i].classList.remove('active');
     }

     for (var y = 0; y < swticherBlocks.length; y++) {
     var element = swticherBlocks[y];

     element.classList.remove('blink-cb-visible');
     element.classList.add('blink-cb-hidden');
     }

     headerText.classList.remove('blink-cb-fadeInDown');
     contentText.classList.remove('blink-cb-fadeInUp');

     switcherOpenBlock.classList.remove('blink-cb-hidden');

     setTimeout(function() {
     switcherOpenBlock.classList.add('blink-cb-visible');
     headerText.classList.add('blink-cb-fadeInDown');
     contentText.classList.add('blink-cb-fadeInUp');
     }, 1);
     switcherActiveButon.classList.add('active');
     }, false);
     }

     iconsContainer.addEventListener('mouseover', function(event) {
     var iconsPos = 0;

     for (var i = 0; i < icons.length; i++) {
     that.showIconsInterval(icons[i], iconsPos, i, 'blink-cb-fadeOutRight', 'blink-cb-fadeInRight');
     iconsPos -= 37;
     }

     var width  = 80 - iconsPos;

     iconsContainer.style.width = width + 'px';
     });

     iconsContainer.addEventListener('mouseleave', function(event) {
     for (var i = 0; i < icons.length; i++) {
     that.hideIconsInterval(icons[i], 0, i, 'blink-cb-fadeInRight', 'blink-cb-fadeOutRight');
     }

     iconsContainer.style.width = 80 + 'px';
     });

     exitBtn.addEventListener('click', function() {
     for(var i=0; i < errorDiv.length; i++) {
     errorDiv[i].style.display = 'none';
     }

     for(var i=0; i < successDiv.length; i++) {
     successDiv[i].style.display = 'none';
     }

     openBlock.classList.remove('blink-cb-fadeInRight');
     openBlock.classList.add('blink-cb-fadeOutRight');
     setTimeout(function() {
     openBlock.classList.remove('blink-cb-visible');

     }, 500);

     setTimeout(function() {
     openBlockBtn.style.display = 'block';
     }, 300);
     });

     recallFormSubmit.addEventListener('submit', function (event) {
     event.preventDefault();
     var formElements = event.target, data = "";

     that.post(formElements, 'Recall', function(response) {
     that.blockInputs(formElements);
     if(response !== false) {
     that.clearForm(formElements);
     errorDiv[0].style.display = 'none';
     successDiv[0].style.display = 'block';
     } else {
     successDiv[0].style.display = 'none';
     errorDiv[0].style.display = 'block';
     }
     });
     });

     messangeFormSubmit.addEventListener('submit', function (event) {
     event.preventDefault();
     var formElements = event.target, data = "";

     that.post(formElements, 'Query', function(response) {
     that.blockInputs(formElements);

     if(response !== false) {
     that.clearForm(formElements);
     errorDiv[1].style.display = 'none';
     successDiv[1].style.display = 'block';
     } else {
     successDiv[1].style.display = 'none';
     errorDiv[1].style.display = 'block';
     }
     });
     });

     */
};


new BlinkCBModule();

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

