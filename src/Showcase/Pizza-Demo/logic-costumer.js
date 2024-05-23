// request als globale Variable anlegen (haesslich, aber bequem)
var request = new XMLHttpRequest();
var orderPast = false;

function requestData() { // fordert die Daten asynchron an
	request.open("GET", "api.php"); // URL für HTTP-GET
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
	var obj = JSON.parse($data);

	console.log('JSON.parse Objekte:');
	console.log(obj);

    obj.forEach(element => {
        orderPast = true;
        if (element.status == 0) {
            document.getElementById(element.ordered_article_id).className = 'text-info font-weight-bold';
            document.getElementById(element.ordered_article_id).textContent = 'Bestellt';
        } else if (element.status == 1) {
            document.getElementById(element.ordered_article_id).className = 'text-warning font-weight-bold';
            document.getElementById(element.ordered_article_id).textContent = 'Im Ofen';
        } else if (element.status == 2) {
            document.getElementById(element.ordered_article_id).className = 'text-success font-weight-bold';
            document.getElementById(element.ordered_article_id).textContent = 'Fertig';
        } else if (element.status == 3) {
            document.getElementById(element.ordered_article_id).className = 'text-primary font-weight-bold';
            document.getElementById(element.ordered_article_id).textContent = 'Unterwegs';
        }
    });

    if (!obj.length && orderPast) {
        document.getElementById('order-wrapper').innerHTML = '<p class="text-success mt-3 mb-3">Ihre Bestellung ist angekommen. Guten Appetit!</p>';
        document.getElementById('order-price-total').innerHTML = '<p>Bis zum nächsten Mal.</p>';
        
    }
}
// Wird alle 3 Sekunden aktualisiert
window.setInterval(requestData, 2000);