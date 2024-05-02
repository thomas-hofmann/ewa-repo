   // request als globale Variable anlegen (haesslich, aber bequem)
   console.log('Skript erfolgreich eingebunden');
   console.log('-----');
   var request = new XMLHttpRequest(); 

   function requestData() { // fordert die Daten asynchron an
        request.open("GET", "response.php"); // URL für HTTP-GET
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
    let obj = JSON.parse($data);
    console.log('Response:')
    console.log(obj);
    console.log('-----');

    var para = document.createElement('p');
    para.innerText = obj.name + ' - ' + obj.age;
    document.getElementById('output').innerText = '';
    document.getElementById('output').appendChild(para);
   }

   window.setInterval(requestData, 3000);