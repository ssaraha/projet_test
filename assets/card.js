const $ = require('jquery');

require('bootstrap');

$('.txt_article_quantity').each( function(){
	$(this).dblclick(function(){
		let currentElmt = $(this);
		let quantityTxt = $(currentElmt).find('input:first');
		let idTxt = $(currentElmt).find('input:first').next();
		$(currentElmt).find('input:first').css('display', 'block').focus();
		$(currentElmt).find('p').css('display', 'none');


		$(currentElmt).find('input').on('keypress', function(e){
			if ( e.which == 13 ) {
				$(currentElmt).find('input:first').css('display', 'none');
				//console.log($(quantityTxt).val());
				//console.log($(idTxt).val());

				$.ajax({
					type: 'POST',
					data: {'id': $(idTxt).val(), 'quantity': $(quantityTxt).val()},
					url: "/panier/change_quantity",
					beforeSend: function(){

					},
					success: function(response){
						let total = 0;					
						//$(currentElmt).html(response.quantity);
						$(currentElmt).find('p').text(response.quantity);
						$(currentElmt).find('p').css('display', 'block');
						$('#txt_price_article_'+response.id).val(response.priceArticle);
						$(currentElmt).find('input:first').val(response.quantity);
						$('#p_price_'+response.id).text(response.priceArticle);
						$('.txt_price_article').each(function(index, el) {
							total += parseInt($(this).val());
						});
						$('.p_total').text(total);
						$('#txt_total').val(total);
						//$(currentElmt).prepend('<input style="display: none;" type="text" value="'+response.id+'" id="txt_article_'+response.quantity+'"/>');
						//$('currentElmt').prepend('<input style="display: none;" type="text" value="'+response.quantity+'" id="txt_article_quantity_'+response.quantity+'"/>');
					}
				})
			}
		});
	});
});

$("#chk_delete_all").change(function() {
	$('.btn_delete_all').toggle();
    if(this.checked) {
        $('.delete_row').each(function(){
        	if ( !this.checked ) {
        		$(this).prop('checked', true);
        	}	
        });
    }else{
        $('.delete_row').each(function(){
        	if ( this.checked ) {
        		$(this).prop('checked', false);
        	}
        });
    }
})


$('.btn_delete_all').on('click', function(e){
	$('.delete_row').each(function(){
		let id = $(this).closest('td').next().find('input').val();
		if( $(this).prop('checked') ){
			$.ajax({
				type: 'POST',
				url: 'panier/remove/'+id,
				data: {id: id},
				success: function(){

				}
			});
		}
	});	
})
