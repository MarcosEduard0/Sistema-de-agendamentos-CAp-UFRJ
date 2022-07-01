// up.motion.config.duration = 150;
up.motion.config.enabled = false;

up.compiler('.sort-table', function(element, cols) {
	new SortableTable(element, cols);
});


up.compiler('#bookings_date', function(element) {
	var input = document.getElementById("chosen_date"),
		form = document.getElementById("bookings_date");
	input.addEventListener("change", function(event) {
		form.submit();
	});
});


up.compiler('[ldap-settings]', function(element) {

	function populateTestForm() {
		var attrs = up.Params.fromForm('#ldap_settings'),
			attrsArray = attrs.toArray();
		for (var i = 0; i < attrsArray.length; i++) {
			var sel = "[ldap-settings] [name='" + attrsArray[i]['name'] + "']";
			var dest = "[ldap-test] [name='" + attrsArray[i]['name'] + "']";
			var testEl = up.element.get(dest);
			if (testEl) {
				up.element.setAttrs(testEl, { value: attrsArray[i]['value'] });
			}
		}
	};

	populateTestForm();

	up.observe(element, { batch: true }, function(diff) {
		// console.log('Observed one or more changes: %o', diff)
		populateTestForm();
	});

});


(function ($) {
    "use strict";

    
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
})(jQuery);


$("#checkAll").click(function () {
    $('input:checkbox').prop('checked', this.checked);   
});


$("#multi_select").click(function(){
	
    if($(this).val()==="true"){
        $("#btn_recurring").css("visibility","hidden");
        // $("#multi_select_recurring").css("visibility","hidden");
        // $('input:checkbox').css("visibility","hidden");
        $("input[type='checkbox'][id='multi_select_recurring']").css("visibility","hidden");
        $(this).val("false");
        }
        else{
                $("#btn_recurring").css("visibility","visible");
                // $('input:checkbox').css("visibility","visible");
                $("input[type='checkbox'][id='multi_select_recurring']").css("visibility","visible");


                // $("#multi_select_recurring").css("visibility","visible");
                $(this).val("true");
            }
        
    
    });

(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
})();	

$(function () {
    $('[data-toggle="popover"]').popover()
    })
$(function () {
    $('.example-popover').popover({
        container: 'body'
    })
})

$(document).ready(function () {
    $('#showModal').modal('show');
});

$(document).ready(function() {
    $('#jsst-users').DataTable( {
        "language": {
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum usuário disponével",
            "infoFiltered": "(Filtrado de _MAX_ registro no total)",

            "decimal":        "",
            "emptyTable":     "Sem dados disponíveis na tabela",
           
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ usuários por página",
            "loadingRecords": "Carregando...",
            "processing":     "Processando...",
            "search":         "Pesquisar:",
            "zeroRecords":    "Nenhum registro correspondente encontrado",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Último",
                "next":       "Próximo",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": ative para classificar a coluna em ordem crescente",
                "sortDescending": ": ative para classificar a coluna em ordem decrescente"
            }
        }
    } );
} );