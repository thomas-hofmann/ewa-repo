var priceTotal = 0;

function addPizza(name, price, pizzaId) {
	var cart = document.getElementById('cart');
	let option = document.createElement('option');

	option.text = "+ " + name + " - " + price + "€";
	option.value = pizzaId;
	option.setAttribute('data-price', price);

	cart.appendChild(option);
	
	var priceElement = document.getElementById('price');
	var priceTmp = parseFloat(priceTotal) + parseFloat(price);
	priceElement.value = "Gesamtpreis: " + priceTmp.toFixed(2) + "€";
	priceTotal = parseFloat(priceTmp);
}

function deleteAll() {
	var cart = document.getElementById('cart');
	var priceElement = document.getElementById('price');

	while (cart.options.length > 0) {
        cart.remove(0);
    }

	priceElement.value = "Gesamtpreis: 0€";
	priceTotal = 0;
}

function updatePriceTotal(amount) {
    priceTotal += amount;
    var priceElement = document.getElementById('price');
    priceElement.value = "Gesamtpreis: " + priceTotal.toFixed(2) + "€";
}

function deleteSelected() {
	var cart = document.getElementById('cart');
	var options = cart.options;
    for (var i = options.length - 1; i >= 0; i--) {
        if (options[i].selected) {
			var price = parseFloat(options[i].getAttribute('data-price'));
            updatePriceTotal(-price);
            cart.remove(i);
        }
    }
}

function formCheck() {
	var cart = document.getElementById('cart');
	var addressElement = document.getElementById('address');
	var button = document.getElementById('orderButton');
	var buttonClasses = button.classList;
	if(!cart.options.length || addressElement.value == "") {
		button.disabled = true; 
		buttonClasses.add('disabled');
	} else {
		button.disabled = false;
		buttonClasses.remove('disabled');
	}
}

function orderCheck() {
	var options = cart.options;
	for (var i = 0; i < options.length; i++) {
		options[i].selected = true;
	}
}