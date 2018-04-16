(function(){
	var that			= this;
	this.matrixOptions	= [];
	$('#answer').hide();

	Object.keys(fullMatrix).forEach(function(value){
		var name	= value.split('_');
		that.matrixOptions.push($('<option value="'+value+'">' + name[0] + ' fila de ' + name[1] + ' letras</option>'));
	});

	$('#inputGroupSelect01').append(this.matrixOptions);

	this.printAnswer	= function(res){
		if(typeof res.countWordAppers !== 'number')
			return;
		$('#answer_number').html(res.countWordAppers);

		var matrixToText	= [];
		fullMatrix[res.selectedMatrix].forEach(function(row,i){
			matrixToText.push($('<p>' + row.toString() + '</p>'))
		});
		$('#matrix_content').html('');
		$('#matrix_content').append(matrixToText);
		$('#answer').show();
	}
	this.callApi			= function(){
		$.ajax({
			url: './api.php',
			data: {
				selectedMatrix: $('#inputGroupSelect01').val(),
			},
			dataType: 'json',
			success: function(data, status){
				that.printAnswer(data);
			}
		});
		return false;
	}

	$('#calculate').click(this.callApi);
})();