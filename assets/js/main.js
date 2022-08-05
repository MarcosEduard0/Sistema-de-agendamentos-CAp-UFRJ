// up.motion.config.duration = 150;
up.motion.config.enabled = false;
// up.history.config.enabled = false;


/**
 * Settings: Initialise sortable tables
 *
 */
up.compiler('.sort-table', function(element, cols) {
	new SortableTable(element, cols);
});


/**
 * Bookings: Automatically submit form when picking a date.
 *
 */
up.compiler('#bookings_date', function(element) {
	var input = document.getElementById("chosen_date"),
		form = document.getElementById("bookings_date");
	input.addEventListener("change", function(event) {
		form.submit();
	});
});


/**
 * Settings: LDAP: Form for testing the settings
 *
 */
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


/**
 * Session calendars: Config mode: Click on dates to change Timetable Week assignments.
 *
 */
up.compiler('.session-calendars.mode-config', function(sessionEl, data) {

	var weekIds = [];
	var weekClassNames = [];
	var numWeeks = data && data.weeks ? data.weeks.length : 0;

	// Process list of available weeks
	for (var i = 0; i < numWeeks; i++) {
		var weekId = parseInt(data.weeks[i], 10);
		className = 'week-' + weekId;
		weekIds.push(weekId);
		weekClassNames.push(className);
	}
	// Add blank entry for cycling through items
	weekIds.push(null);

	// Click event for changing week assignment of a given date
	up.on(sessionEl, 'click', '.date-btn', function(event, el) {

		var cell = el.closest('.date-cell');

		var weekstart = cell.getAttribute('data-weekstart');
		var weekid = cell.getAttribute('data-weekid');

		// Current Week ID
		var curWeekId = weekid ? '' + weekid : null;
		// Array index of the current selected week
		var curWeekIdx = weekIds.indexOf(parseInt(curWeekId, 10));
		// Array index of next week to select
		var nextWeekIdx = (curWeekIdx + 1) % weekIds.length;

		// Next Week ID from the list
		var newWeekId = weekIds[ (curWeekIdx + 1) % weekIds.length ];

		// All cells (potentially on other months) whose week starts on `weekstart`
		var cells = up.element.all(sessionEl, '.date-cell[data-weekstart="' + weekstart + '"]');

		// Process all cells that match start of week
		up.util.each(cells, function(cell) {

			// Remove existing week classes
			for (var i = 0; i < weekClassNames.length; i++) {
				cell.classList.remove(weekClassNames[i]);
			}

			// An actual Week ID to add
			if (newWeekId !== null) {
				cell.classList.add('week-' + newWeekId);
			}

			// Update value of hidden input
			var input = up.element.get(cell, 'input[type=hidden]');
			input.value = newWeekId;

			// Update the data- attr with the new Week ID
			cell.setAttribute('data-weekid', newWeekId);

		});

	});

});


up.compiler('.up-datepicker', function(el) {
	up.on(el, 'click', function(evt, el, data) {
		if ( ! data.input) return;
		return displayDatePicker(data.input, false);
	});
});


/**
 * Bookings page: controls forms
 *
 */
up.compiler('#bookings_controls_day', function(form) {

	// Date picker and form submission

	// up.on(form, 'click', '.up-datepicker', function(evt, el, data) {
	// 	if ( ! data.input) return;
	// 	return displayDatePicker(data.input, false);
	// });

	up.on(form, 'change', '.up-datepicker-input', function(evt, el, data) {
		form.submit();
		up.emit(form, 'submit');
	});

});

up.compiler('#bookings_controls_room', function(form) {

	// Room list

	up.on(form, 'change', 'select[name=room]', function(evt, el, data) {
		form.submit();
	});

});


up.compiler('#bookings_controls_session', function(form) {

	// Session list

	up.on(form, 'change', 'select[name=session_id]', function(evt, el, data) {
		form.submit();
	});

});


up.compiler('[up-copy-to]', function(copyBtn) {

	up.on(copyBtn, 'click', function(evt, el, data) {

		var group = el.getAttribute('up-copy-to');

		var srcEl = up.element.get('[up-copy-group="' + group + '"]');
		var value = srcEl.value;

		var allItems = up.element.all('[up-copy-group="' + group + '"]');
		up.util.each(allItems, function(item) {
			item.value = value;
		});

	});
});


up.compiler('select[up-autocomplete]', function(selectEl) {
	accessibleAutocomplete.enhanceSelectElement({
		selectElement: selectEl,
		displayMenu: 'overlay',
		dropdownArrow: function(obj) {
			return '<svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="autocomplete__dropdown-arrow-down h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />';
		}
	});
});



/**
 * Unavailable slots: popup content: change position of popup based on X pos of element.
 *
 * This is used for unavailable slots - like holidays or period unavailability.
 *
 */
up.macro('.bookings-grid-button[up-content]', function(el) {
	el.setAttribute('up-position', getPopupAlignment(el));
});


/**
 * Determine where to place the popup (attached via data-up-popup).
 *
 */
function getPopupAlignment(el) {

	var rect = el.getBoundingClientRect();
	var posX = Math.ceil(rect.x);
	var docWidth = document.documentElement.clientWidth;
	var docHalf = Math.floor(docWidth / 2);

	if (posX < docHalf) {
		return 'right';
	} else {
		return 'left';
	}
}



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