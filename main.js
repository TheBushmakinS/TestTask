$( document ).ready(function() {
    $("#bsave").click(
		function(){
			$.ajax({
                url:     "/save.php",
                type:     "POST",
                dataType: "html",
                data: $("#form").serialize(),
                success: function(response) {
                    $('#result_form').html(response);
                },
                error: function(response) {
                    $('#result_form').html('<div class="alert alert-danger " role="alert">Ошибка отправки!</div>');
                }
            });
			return false; 
		}
    );
    $("#bload").click(
		function(){
			$.ajax({
                url:     "/load.php",
                type:     "GET",
                dataType: "html",
                success: function(response) {
                    $('#result_form').html(response);
                },
                error: function(response) {
                    $('#result_form').html('<div class="alert alert-danger " role="alert">Ошибка отправки!</div>');
                }
             });
		}
	);
});