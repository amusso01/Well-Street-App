$(function(){
    var startTime = document.getElementById("startTime");
    var finishTime = document.getElementById("finishTime");
    var startSpan = document.getElementById("start");
    var finishSpan = document.getElementById("finish");

    startTime.addEventListener("input", function() {
        startSpan.innerText = startTime.value;
    }, false);
    finishTime.addEventListener("input", function() {
        finishSpan.innerText = finishTime.value;
    }, false);
})
