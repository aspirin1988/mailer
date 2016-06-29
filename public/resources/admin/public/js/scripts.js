document.addEventListener("DOMContentLoaded", function () {

  //массив с триггерами вызова модального окна с видео:
  var videoModalCallers =
    document.getElementsByClassName("video-modal-caller");

  //здесь будет храниться ссылка data-video-src
  // из вызванного триггера:
  var link;

  if (videoModalCallers.length > 0) {

    for (var i = 0; i < videoModalCallers.length; i++) {
      videoModalCallers[i].addEventListener("click", function () {
        link = this.getAttribute("data-video-src");
      });
    }

    $("#reviews-modal").on({

      "show.uk.modal": function(){
        document.getElementById("iFrameVideoReviews")
          .setAttribute("src", link);
      },

      "hide.uk.modal": function(){
        document.getElementById("iFrameVideoReviews")
          .removeAttribute("src");
      }
    });
  }
});