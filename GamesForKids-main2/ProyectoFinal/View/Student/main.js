Webcam.set({
    width: 250,
    height: 200,
    margin: 5,
    image_format: 'jpeg',
    jpeg_quality: 100
});
const synth = window.speechSynthesis;
Webcam.attach('#web_cam');





// show random initial images on cards
randomLoadImages(document.getElementById("fig-to-select").innerHTML);

function take_snapshot() {
    Webcam.snap(function (web_cam_data) {
        $(".image-tag").val(web_cam_data);
        document.getElementById('copyVideo').innerHTML = '<img style="border-radius: 20px;" src="' + web_cam_data + '"/>';
    });

    document.getElementById('btn-empezar').style.visibility = 'visible';
}

function randomLoadImages(text) {
    console.log(text);
    let clases = ['square', 'Triangle', 'circle'];
    const shuffledArray = clases.sort((a, b) => 0.5 - Math.random());
    let cards = document.getElementsByClassName('card');
    let index = 0;
    Array.from(cards).forEach(function (element) {
        element.removeChild(document.getElementById(`c${index}`));
            let newDiv = document.createElement("div");
            newDiv.classList.add(clases[index]);
            element.appendChild(newDiv);
        if (clases[index] == 'Triangle') {
            let secondDiv = document.createElement("div");
            secondDiv.classList.add("triangle-border");
            newDiv.appendChild(secondDiv);
            let thirdDiv =  document.createElement("div");
            thirdDiv.classList.add("triangle-inner");
            secondDiv.appendChild(thirdDiv);
        } 
        index++;

    });


}

function decir(texto){
    const utterThis = new SpeechSynthesisUtterance(texto);
    utterThis.lang = 'es-ES';
    synth.speak(utterThis);
    //speechSynthesis.speak(new SpeechSynthesisUtterance(texto));
}




