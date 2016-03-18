function BlinkCBModule() {
    var that = this;
    var xhr = new XMLHttpRequest();
    //var currentUrl = md5(document.location.origin);

    xhr.open('GET', '{host}/client/Template/Get/966128519f610498a7df19b1aa045b6f/style', true);
    xhr.send();

    xhr.onreadystatechange = function() {
        if (this.readyState!= 4) return;

        var template = this.responseText,
            body = document.getElementsByTagName('body')[0];

        if(template !== false) {
            var htmlObject = document.createElement('div');
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

    xhr.open('POST', '{host}/client/callback/'+ url +'/966128519f610498a7df19b1aa045b6f', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(data);

    xhr.onreadystatechange = function() {
        if (this.readyState!= 4) return;

        callback(this.responseText);
    };
};

BlinkCBModule.prototype.showIconsInterval = function(element, position, iteration, deleteClass, addClass) {
    setTimeout(function() {
        element.classList.remove('blink-cb-hidden');
        element.classList.remove(deleteClass);
        element.classList.add('blink-cb-visible');
        element.classList.add(addClass);
        element.style.left = position + "px";
    }, iteration*200);
};

BlinkCBModule.prototype.hideIconsInterval = function(element, position, iteration, deleteClass, addClass) {
    setTimeout(function() {

        element.classList.remove(deleteClass);
        element.classList.add(addClass);
        element.style.left = position + "px";
        setTimeout(function() {
            element.classList.remove('blink-cb-visible');
            element.classList.add('blink-cb-hidden');
        }, iteration*400);
    }, iteration*200);
};

BlinkCBModule.prototype.loadJS = function() {
    var that = this,
        swticherAnchor = document.getElementsByClassName('blink-cb-switcher-btn'),
        swticherBlocks = document.getElementsByClassName('blink-cb-block'),
        openBlockBtn = document.getElementById('blink-cb-main-btn'),
        openBlock = document.getElementsByClassName('blink-cb-container')[0],
        exitBtn = document.getElementsByClassName('blink-cb-exit-btn')[0],
        icons = document.getElementsByClassName('blink-cb-icon-wrapper'),
        iconsContainer = document.getElementsByClassName('blink-cb-small-icons-cont')[0],
        recallFormSubmit = document.getElementsByClassName('blink-cb-recall-form')[0],
        messangeFormSubmit = document.getElementsByClassName('blink-cb-messange-form')[0];

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
            console.log(response);
        });
    });

    messangeFormSubmit.addEventListener('submit', function (event) {
        event.preventDefault();
        var formElements = event.target, data = "";

        that.post(formElements, 'Query', function(response) {
            console.log(response);
        });
    });
};

new BlinkCBModule();
