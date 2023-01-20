//Dibujar respuesta
const synth = window.speechSynthesis;
function decir(texto){
    const utterThis = new SpeechSynthesisUtterance(texto);
    utterThis.lang = 'es-ES';
    synth.speak(utterThis);
    //speechSynthesis.speak(new SpeechSynthesisUtterance(texto));
}
answer(document.getElementById("fig-to-select").innerHTML);

function answer(text) {

	let draw;
	switch(text){
	case "Cuadrado":
		draw="square";
	break;
	case "Circulo":
		draw="circle";
	break;
	case "Triangulo":
		draw="trian";
	break;
	}
	console.log(draw);
	try{
		if (draw!="trian") {
			let answer = document.getElementById('answer');
	        answer.className = draw;
		}
		else{
			let answer = document.getElementById('answer');
	        answer.className = draw;
	        let answer2 = document.getElementById('answer2');
	        answer2.className = "triangle-border";
	        let answer3 = document.getElementById('answer3');
	        answer3.className = "triangle-inner";
		}
	}
	catch(exception){
	}
    
}



