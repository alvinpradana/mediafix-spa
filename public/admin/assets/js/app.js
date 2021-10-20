// Start-Create-Invoice-Script
$(document).ready(function(){
    var count = $(".itemRow").length ;	
    $('#add').click(function(){
    count++;
    var html_code = '';
    html_code += '<tr>';
	html_code += '<style> input[type=number]{ -moz-appearance: textfield; } input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button {-webkit-appearance: none; margin: 0;}</style>';

    html_code += '<td><input class="itemRow" type="checkbox"></td>';
    html_code += '<td><input type="number" id="unitQty_'+count+'" class="form-control" autocomplete="off"></td>';
	html_code += '<td><select id="unitType_'+count+'" class="text-white form-control"><option class="mb-2" value="Camera">Camera</option><option class="mb-2" value="Phone">Phone</option><option class="mb-2" value="Laptop-PC">Laptop/PC</option><option class="mb-2" value="Other">Other</option></select></td>';
    html_code += '<td><input type="text" id="unitName_'+count+'" class="form-control" autocomplete="off"></td>';
    html_code += '<td><input type="text" id="unitDescription_'+count+'" class="form-control" autocomplete="off"></td>';
    html_code += '<td><input type="text" id="unitCompleteness_'+count+'" class="form-control" autocomplete="off"></td>';
    html_code += '<td><input type="number" id="unitCost_'+count+'" class="form-control" autocomplete="off"></td>';
    html_code += '<td><input type="number" id="totalCost_'+count+'" class="form-control" autocomplete="off"></td>';
    html_code += '</tr>';
    $('#invoiceItem').append(html_code);
    });

    $(document).on('click', '#checkAll', function() {          	
        $(".itemRow").prop("checked", this.checked);
    });	
    
    $(document).on('click', '.itemRow', function() {  	
        if ($('.itemRow:checked').length == $('.itemRow').length) {
            $('#checkAll').prop('checked', true);
        } else {
            $('#checkAll').prop('checked', false);
        }
    });  
    
    $(document).on('click', '#delete', function(){
        $(".itemRow:checked").each(function() {
            $(this).closest('tr').remove();
        });
        $('#checkAll').prop('checked', false);
        calculateTotal();
    });	

    $(document).on('blur', "[id^=unitQty_]", function(){
		calculateTotal();
	});	
    
	$(document).on('blur', "[id^=unitCost_]", function(){
		calculateTotal();
	});	

	$(document).on('blur', "#discount", function(){		
		calculateTotal();
	});	

	$(document).on('blur', "#downPayment", function(){
		var downPayment = $(this).val();
		var totalPay = $('#totalPay').val();	
		if(downPayment && totalPay) {
			totalPay = totalPay-downPayment;			
			$('#dependents').val(totalPay);
		} else {
			$('#dependents').val(totalPay);
		}	
	});
});

function calculateTotal(){
	var totalAmount = 0; 
	$("[id^='unitCost_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("unitCost_",'');
		var unitCost = $('#unitCost_'+id).val();
		var unitQty  = $('#unitQty_'+id).val();
		if(!unitQty) {
			unitQty = 1;
		}
		var total = unitCost*unitQty;
		$('#totalCost_'+id).val(parseFloat(total));
		totalAmount += total;			
	});
	
	$('#subtotal').val(parseFloat(totalAmount));	
	var discount = $("#discount").val();
	var subtotal = $('#subtotal').val();	
	if(subtotal) {
		var discAmount = subtotal*discount/100;
		$('#discAmount').val(discAmount);
		subtotal = parseFloat(subtotal)-parseFloat(discAmount);
		$('#totalPay').val(subtotal);		
		var downPayment = $('#downPayment').val();
		var totalPay = $('#totalPay').val();	
		if(downPayment && totalPay) {
			totalPay = totalPay-downPayment;			
			$('#dependents').val(totalPay);
		} else {		
			$('#dependents').val(subtotal);
		}
	}
}
// End-Create-Invoice-Script