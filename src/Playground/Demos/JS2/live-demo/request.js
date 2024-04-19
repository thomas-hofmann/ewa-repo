// request als globale Variable anlegen (haesslich, aber bequem)
var request = new XMLHttpRequest(); 

function requestData() { // fordert die Daten asynchron an
	request.open("GET", "response.php?Land=Deutschland"); // URL für HTTP-GET
	request.onreadystatechange = processData; //Callback-Handler zuordnen
	request.send(null); // Request abschicken
}

function processData() {
	if(request.readyState == 4) { // Uebertragung = DONE
		if (request.status == 200) {   // HTTP-Status = OK
			if(request.responseText != null) 
			process(request.responseText);// Daten verarbeiten
			else console.error ("Dokument ist leer");        
		} 
		else console.error ("Uebertragung fehlgeschlagen");
	} else ;          // Uebertragung laeuft noch
}

function process($data) {
	console.log('--------');
	console.log('Response String:');
	console.log($data);
	var obj = JSON.parse($data);

	console.log('JSON.parse Objekte:');
	console.log(obj);

	var output = document.getElementById('output');

	while (output.firstChild) {
		output.removeChild(output.lastChild);
	}

	var list = document.createElement('ol');
	output.appendChild(list);

	for (item of obj) {
		var listItem = document.createElement('li');
		listItem.innerText = item.Zielflughafen + ' - ' + item.Land;
		list.appendChild(listItem);
	}
	console.log('HTML Liste:');
	console.log(list);
}
// Wird alle 3 Sekunden aktualisiert
window.setInterval(requestData, 3000);