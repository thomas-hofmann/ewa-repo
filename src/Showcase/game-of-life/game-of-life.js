/* global calculateNextGeneration: false */

var width = 10;
var height = 8;

var initialState = [
	[false, true, false, false, false, false, false, false, true],
	[false, false, true, false, false, false, false, false, true],
	[true, true, true, false, false, false, false, false, true],
];


var field = [];

var $field = $('.field');
var $result = $('#result');

function reset() {
	$field.empty();

	for (var y = 0; y < height; y++) {
		field[y] = [];

		var $row = $('<div>', {'class': 'row'});

		for (var x = 0; x < width; x++) {
			var $cell = $('<div>', {'class': 'cell'});
			field[y][x] = $cell;
			if (initialState && initialState[y] && initialState[y][x]) {
				$cell.addClass('alive');
			}
			$row.append($cell);
		}

		$field.append($row);
	}
}

reset();

$(document).on('click', '.cell', function() {
	var $cell = $(this);
	$cell.toggleClass('alive');
});

$(document).on('click', '.reset', function(event) {
	event.preventDefault();
	reset();
});

$(document).on('click', '.next-gen', function(event) {
	event.preventDefault();
	$result.text('');

	if (!window.calculateNextGeneration) {
		$result.text('Missing function calculateNextGeneration');
		return;
	}

	var currentState = [];
	var x, y;
	for (y = 0; y < height; y++) {
		currentState[y] = [];
		for (x = 0; x < width; x++) {
			currentState[y][x] = field[y][x].hasClass('alive');
		}
	}

	// calculate next state
	// Any live cell with two or three live neighbours survives.
	// Any dead cell with three live neighbours becomes a live cell.
	// All other live cells die in the next generation. Similarly, all other dead cells stay dead.
	var nextGeneration = calculateNextGeneration(currentState);
	for (y = 0; y < height; y++) {
		for (x = 0; x < width; x++) {
			field[y][x].toggleClass('alive', nextGeneration[y][x]);
		}
	}
});
