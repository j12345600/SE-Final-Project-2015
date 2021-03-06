var Clock = {
	totalSeconds:-1,
	
  start: function () {
  	var self = this;
    this.interval = setInterval(function () {
     if($.cookie("login")==null){
     	self.totalSeconds=-1;
			alert("時間到了請重新登入!");
			Clock.pause();
			location.href='../bank';
			}else if(self.totalSeconds<0){
				var URLs="cookieTime.php";
				$.ajax({
              url: URLs,
              type:"POST",
              dataType:'text',

              success: function(msg){
              		self.totalSeconds=parseInt(msg);
                  $("#timelf").text("Time left: "+self.totalSeconds+" Sec(s)");
              },

               error:function(xhr, ajaxOptions, thrownError){ 
                  alert(xhr.status); 
                  alert(thrownError); 
               }
          });
			}
			else{
				self.totalSeconds-=1;
				$("#timelf").text("Time left: "+self.totalSeconds+" Sec(s)");
			}
    }, 1000);
  },
	
	pause: function () {
	  clearInterval(this.interval);
	  delete this.interval;
	},
	
	resume: function () {
	  if (!this.interval) this.start();
	}
};
Date.prototype.yyyymmdd = function() {
  var yyyy = this.getFullYear().toString();
  var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
  var dd  = this.getDate().toString();
  return yyyy + "/" + (mm[1]?mm:"0"+mm[0]) + "/" + (dd[1]?dd:"0"+dd[0]); // padding
};
var Submit=function(){
    var URLs="test.php";
    $.ajax({
        url: URLs,
        data: $('#myForm').serialize()+"&test=Huang",
        type:"POST",
        dataType:'html',

        success: function(msg){
        		
            $('#reply').html(msg);
        },

         error:function(xhr, ajaxOptions, thrownError){ 
            alert(xhr.status); 
            alert(thrownError); 
         }
    });
 };
var login=function(){
  var URLs="login.php";
 
  $.ajax({
      url: URLs,
      data: $('#myForm').serialize(),
      type:"POST",
      dataType:'html',

      success: function(msg){
      		if($.cookie("login")!=null)Clock.start();
      	  $('#ajaxDiv').html(msg);

          
      },

      error:function(xhr, ajaxOptions, thrownError){ 
         alert(xhr.status); 
         alert(thrownError); 
      }
  });
};

 var transfer=function(transMode){
	if(transMode=='single'||transMode=='rsvd'){
		window.localStorage["step"]=0;
		window.localStorage['transMode']=transMode;
		var content="<P> 選擇銀行代碼並輸入金額</p>"
					+"<a href='../bank/bankCodeList.html' target='_blank'>銀行代碼一覽表</a><br>"
					+"<table id='transferTable'>"
				+"<tr><td>銀行代號(非跨行轉帳請輸入000):</td><td><input type='text' name='bankCode' value='000' id='BC'></td></tr>"
				+"<tr><td>銀行帳號:</td><td><input type='text' name='bankAccount' id='BAC'></td></tr>"
				+"<tr><td>金額:</td><td><input type='text' name='amount' id='Amount'></td></tr>"
				+"<tr><td><input type='button' onclick='transfer()' value='下一步'class='button'/></td></tr>"
				+"</table>";
		$('#interact').html(content);
		if(window.localStorage['transMode']=='single') window.localStorage["step"]=2;
		else window.localStorage["step"]+=1;
	}
	//input transfer date
	else if(window.localStorage["step"]==1){
		if($('#BC').val().length!=3||$('#BAC').val().length!=16||$('#Amount').val()<=0){
			if($('#BC').val().length!=3){
				if(!($('#errMsgBC').length>0)) $('#transferTable').append("<h2 style='color:red;' id='errMsgBC'>銀行代碼輸入有誤!</h2>");
			}
			else if($('#errMsgBC').length>0) {$('#errMsgBC').empty();$('#errMsgBC').remove();}
			
			if($('#BAC').val().length!=16){
				if(!($('#errMsgBAC').length>0)) $('#transferTable').append("<h2 style='color:red;' id='errMsgBAC'>銀行帳戶輸入有誤!</h2>");
			}
			else if($('#errMsgBAC').length>0) {$('#errMsgBAC').empty();$('#errMsgBAC').remove();}
			
			if($('#Amount').val()<=0){
				if(!($('#errMsgAMT').length>0)) $('#transferTable').append("<h2 style='color:red;' id='errMsgAMT'>金額輸入有誤!</h2>");
			}
			else if($('#errMsgAMT').length>0) {$('#errMsgAMT').empty();$('#errMsgAMT').remove();}
			
			return;
		}
		window.localStorage['bankCode']=$('#BC').val();
		window.localStorage['bankAccount']=$('#BAC').val();
		window.localStorage['amount']=$('#Amount').val();
		
		d = new Date();
		d.setDate(d.getDate() + 1);
		var content="<p>選擇日期: <input type='text' id='datepicker' value="+d.yyyymmdd()+"></p>"		+"<input type='button' onclick='transfer()' value='下一步'class='button'/>"
		+" <script>$( \"#datepicker\" ).datepicker({inline: true, minDate: 1,dateFormat:'yy/mm/dd'}); </script>"
		$('#interact').html(content);
		window.localStorage["step"]=2;
	}
	//verify information
	else if(window.localStorage["step"]==2){
		if(window.localStorage['transMode']=='single'&&($('#BC').val().length!=3||$('#BAC').val().length!=16||$('#Amount').val()<=0)){
			if($('#BC').val().length!=3){
				if(!($('#errMsgBC').length>0)) $('#transferTable').append("<h2 style='color:red;' id='errMsgBC'>銀行代碼輸入有誤!</h2>");
			}
			else if($('#errMsgBC').length>0) {$('#errMsgBC').empty();$('#errMsgBC').remove();}
			
			if($('#BAC').val().length!=16){
				if(!($('#errMsgBAC').length>0)) $('#transferTable').append("<h2 style='color:red;' id='errMsgBAC'>銀行帳戶輸入有誤!</h2>");
			}
			else if($('#errMsgBAC').length>0) {$('#errMsgBAC').empty();$('#errMsgBAC').remove();}
			
			if($('#Amount').val()<=0){
				if(!($('#errMsgAMT').length>0)) $('#transferTable').append("<h2 style='color:red;' id='errMsgAMT'>金額輸入有誤!</h2>");
			}
			else if($('#errMsgAMT').length>0) {$('#errMsgAMT').empty();$('#errMsgAMT').remove();}
			
			return;
		}
		if(window.localStorage['transMode']=='single'){
			window.localStorage['bankCode']=$('#BC').val();
			window.localStorage['bankAccount']=$('#BAC').val();
			window.localStorage['amount']=$('#Amount').val();
		}
		else window.localStorage['date']=$('#datepicker').val();
		var content="<p>請確認資料</p>"
		+"<table>"
		+"<tr><td>銀行代號:"+window.localStorage['bankCode']+"</td></tr>"
		+"<tr><td>銀行帳號:"+window.localStorage['bankAccount']+"</td></tr>"
		+"<tr><td>金額:"+window.localStorage['amount']+"</td></tr>";
		if(window.localStorage['transMode']=='rsvd')
			content+="<tr><td>日期(月/日/年):"+window.localStorage['date']+"</td></tr>";
		content+="</table>"
		+"<input type='button' onclick='transfer()' value='確認轉帳'class='button'/>"
		+"<button type=\"reset\" onclick=\"location.href='../bank'\" class='button'>取消轉帳</button>";
		$('#interact').html(content);
		window.localStorage["step"]=3;
	}
   else if(window.localStorage["step"]==3){
			var mode=window.localStorage['transMode'];
			var BC=window.localStorage['bankCode'];
			var BAC=window.localStorage['bankAccount'];
			var amount=window.localStorage['amount'];
			if(window.localStorage['transMode']=='rsvd')
					var date=window.localStorage['date'];
			$.ajax({
				url: "performFuncs.php",
				data: {"mode": mode,"BC": BC,"BAC": BAC,"amount": amount,"date":date},
				type:"POST",
				dataType:'text',
				success: function(msg){
						alert("轉帳成功!");
						location.href='../bank';
				},
				 error:function(xhr, ajaxOptions, thrownError){ 
					alert(xhr.status); 
					alert(thrownError); 
				 }
			});
   }
 };
 
 var debt=function(debtMode){
	if(debtMode=='chkStatus'||debtMode=='pay'){
		window.localStorage["step"]=0;
		window.localStorage['debtMode']=debtMode;
		var debt;
		
		$.ajax({
		url: "performFuncs.php",
		async: false,
		data: {"mode": 'chkStatus'},
		type:"POST",
		dataType:'text',
		success: function(msg){
			debt=msg;
			
		},
		 error:function(xhr, ajaxOptions, thrownError){ 
			alert(xhr.status); 
			alert(thrownError); 
		 }
	});
	
		var content;
		if(debtMode=='chkStatus')content="<P>借貸狀況</p>"
		else content="<P> 應繳金額</p>"
		if (debt==0) {
			content+="<table> <tr><td>並無債務需要繳</td></tr>"
			+"<tr><td><button type=\"reset\" onclick=\"location.href='../bank'\" class='button'>返回選單</button></td></tr></table>";
			
		}
		else{
			content+="<table><tr><td>積欠金額: "+debt+"</td></tr>"	
			if(debtMode=='chkStatus') content+="<tr><td><button type=\"reset\" onclick=\"location.href='../bank'\" class='button'>返回選單</button></td></tr></table>";
			else {
				content+="<tr><td><input type='button' onclick='debt()' value='下一步' class='button'/></td></tr></table>";
				window.localStorage["step"]=1;
				window.localStorage["debt"]=debt;
			}
		}
		
		$('#interact').html(content);
	}
	//verify information
	else if(window.localStorage["step"]==1){
		
		var content="<p>請確認是否繳款</p>"
		+"<table>"
		+"<tr><td>金額:"+window.localStorage['debt']+"</td></tr>";
		content+="</table>"
		+"<input type='button' onclick='debt()' value='確認繳款' class='button'/>"
		+"<button type=\"reset\" onclick='debt(\"pay\")' class='button'>取消繳款</button>";
		$('#interact').html(content);
		window.localStorage["step"]=2;
	}
   else if(window.localStorage["step"]==2){
	$.ajax({
		url: "performFuncs.php",
		data: {"mode": window.localStorage['debtMode']},
		type:"POST",
		dataType:'text',
		success: function(msg){
			$("#interact").html(msg);
		},
		 error:function(xhr, ajaxOptions, thrownError){ 
			alert(xhr.status); 
			alert(thrownError); 
		 }
	});
	
   }
 };
 
  var chkHistory=function(historyMode){
	if(historyMode=='balance'){
		var balance;
		
		$.ajax({
		url: "performFuncs.php",
		async: false,
		data: {"mode": historyMode},
		type:"POST",
		dataType:'text',
		success: function(msg){
			balance=msg;
			
		},
		 error:function(xhr, ajaxOptions, thrownError){ 
			alert(xhr.status); 
			alert(thrownError); 
		 }
	});
	
		var content;
		content="<P>查詢餘額</p>"
		content+="<table><tr><td>帳戶餘額額: "+balance+"元</td></tr>"	
		content+="<tr><td><button type=\"reset\" onclick=\"location.href='../bank'\"class='button'>返回選單</button></td></tr></table>";
		$('#interact').html(content);
	}
	//verify information
	else if(historyMode=='log'){
		d = new Date();
		var content="<p>選擇日期: <input type='text' id='datepicker' value="+d.yyyymmdd()+"></p>"
		+"<input type='button' onclick='chkHistory()' value='下一步' class='button'/>"
		+" <script>$( \"#datepicker\" ).datepicker({inline: true, maxDate: 0,dateFormat:'yy/mm/dd'}); </script>"
		$('#interact').html(content);
		window.localStorage["step"]=1;
	}
	else if(window.localStorage["step"]==1){
		var balance;
		var date=$('#datepicker').val();

		$.ajax({
		url: "performFuncs.php",
		async: false,
		data: {"mode": 'log',"date": date},
		type:"POST",
		dataType:'text',
		success: function(msg){
			balance=msg;
			
		},
		 error:function(xhr, ajaxOptions, thrownError){ 
			alert(xhr.status); 
			alert(thrownError); 
		 }
	});
		var content;
		content="<P>查詢歷史紀錄</p>"
		content+="<table BORDER=2><th>帳戶帳號</th><th>日期</th><th>匯入金額</th><th>匯出金額</th><th>餘額</th>"	
		content+=""+balance+"</table>"	
		content+="<tr><td><button type=\"reset\" onclick=\"location.href='../bank'\" class='button'>返回選單</button></td></tr>";
		content+="<tr><td><button type=\"reset\" onclick=chkHistory() class='button'>聯絡客服人員</button></td></tr>";
		$('#interact').html(content);
		window.localStorage["step"]=2;
		
	}
	else if(window.localStorage["step"]==2){
		
		var content;
		content="<P>客服資訊:</p>"
		content+="<table>";
		content+="<tr><td><h2>電話: 0800-000-000</h3></td></tr>";
		content+="<tr><td><h2>Email:abc@gmail.com</h3></td></tr>";
		content+="</table>";
		content+="<tr><td><button type=\"reset\" onclick=\"location.href='../bank'\" class='button'>返回選單</button></td></tr>";
		$('#interact').html(content);
	}
  
 };
  var logout=function(){
  if($.cookie("login")!=null){
	  Clock.pause();
	  $.cookie("login", null,{ expires: -1 });
	  location.href='../bank';
	  
  }
};
 