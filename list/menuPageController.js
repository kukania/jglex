
Array.prototype.remove = function() {
	var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L].value;
        var i;
        for(i=0; i<a.length; i++){
        	if(a[i].value==what){
        		this.splice(i,1);
        		break;
        		}
        	}
        }
    return this;
}


   	function doOrder(path){
   	    tableNum = prompt("테이블 번호를 입력하세요:");
   	    if(isNaN(tableNum)==true){
   	    	console.log(tableNum);
   	    	return;
   	    }
   	    document.cookie = "tableNum=" + tableNum;
   	    var method = "post";
   	    var form = document.createElement("form");
   	    form.setAttribute("method", method);
   	    var url = path + "?length=" + order.length + "&tableNum=" + tableNum;
   	    form.setAttribute("action", url);

   	    for (var key = 0; key < order.length; key++) {
   	        var hiddenField1 = document.createElement("input");
   	        hiddenField1.setAttribute("type", "hidden");
   	        var manu = "manu" + key;
   	       
   	        hiddenField1.setAttribute("name", manu);
   	        hiddenField1.setAttribute("value", order[key].value);

   	        form.appendChild(hiddenField1);

   	        var hiddenField2 = document.createElement("input");
   	        hiddenField2.setAttribute("type", "hidden");
   	        var manuMany = "many" + key;
   	        hiddenField2.setAttribute("name", manuMany);
   	        hiddenField2.setAttribute("value", order[key].many);
   	        form.appendChild(hiddenField2);
   	    }
   	    document.body.appendChild(form);
   	    form.submit();
   	}
   function orderSet(chkbox,input){
   	if(chkbox.checked==true){
   			var temp="#mc"+input;
   			console.log(temp);
   			$(temp).attr("style","display");
   		}
   }
   	function test(btn, type){
   		var temp={};
   		var btnId=btn.id;
   		temp.value=btn.value;
   		temp.many=$("#"+btnId).parent().children().eq(2).html();
   		if(type==true){
   			alert(temp.value+" "+temp.many+"개 장바구니에 넣었습니다!");
   			order.push(temp);
   			$("#"+btnId).attr("onclick","test(this,false)");
   			$("#"+btnId).html("주문빼기");
   		}
   		else{
   			alert(temp.value+"를 장바구니에 뺐습니다!");
   			order.remove(temp);
   			$("#checkbox"+btnId).attr("checked",false);
   			$("#"+btnId).attr("onclick","test(this,true)");
   			$("#"+btnId).html("주문넣기");
   			$("#"+btnId).parent().attr("style","display:none");
   		}
   		$('#checkBagDiv').contents().remove();
   		for(var i in order){
   			if(i!="remove"){
   			$('#checkBagDiv').append('<p style="color:white">'+order[i].value+" "+order[i].many+' 개</p>');
   			}
   		}	
  }