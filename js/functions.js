///////////////////////////////////////// Регистрация //////////////////////////////
function ResetCaptcha(vitem){
	
	
	vitem.innerHTML = '<img src="/captcha.php?rnd='+ Math.random() +'" border="0"/>';
	
}

function GetSumPer(){
	
	var sum = parseInt(document.getElementById("sum").value);
	var percent = parseInt(document.getElementById("percent").value);
	var add_sum = 0;
	
	if(sum > 0){
		
		if(percent > 0){
			add_sum = (percent / 100) * sum;
		}
		
		document.getElementById("res_sum").innerHTML = Math.round(sum+add_sum);
	}
	
}

var valuta = 'RUB';

function SetVal(){
	
	valuta = document.getElementById("val_type").value;
	document.getElementById("res_val").innerHTML = valuta;
	PaymentSum();
}

function PaymentSum(){
	
	var sum = parseInt(document.getElementById("sum").value);
	var ser = parseInt(document.getElementById(valuta).value);
	
	xt = (valuta == 'RUB') ? 'min_sum_RUB' : xt;
	xt = (valuta == 'USD') ? 'min_sum_USD' : xt;
	xt = (valuta == 'EUR') ? 'min_sum_EUR' : xt;
	
	var min_pay = parseFloat(document.getElementById(xt).value);
	
		document.getElementById("res_sum").innerHTML = (sum/ser).toFixed(2);
		document.getElementById("res_min").innerHTML = (min_pay*ser).toFixed(2);
	
}

$(document).ready(function(){

	$(".admin_pay_action_refuse").submit(function(e){
		e.preventDefault();
		var pay_id = $(".admin_pay_action_refuse_return").val();
		$(".admin_pay_action_buttons").html("");
		$(".admin_pay_action_buttons").text("Отказано");

		$.ajax({
			method: "post",
			url: "?menu=helpmyadmin&sel=payments",
			data: {"return": pay_id},
			success: function(msg){
				location.reload();
			}
		});

	});
	$(".admin_pay_action_pay").submit(function(e){
		e.preventDefault();
		var pay_id = $(".admin_pay_action_pay_payment").val();
		$(".admin_pay_action_buttons").html("");
		$(".admin_pay_action_buttons").text("Выплачено");

		$.ajax({
			method: "post",
			url: "?menu=helpmyadmin&sel=payments",
			data: {"payment": pay_id},
			success: function(msg){
				location.reload();
			}
			});

	});
});