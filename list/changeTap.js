function showContainer(tabNumber){
	for (i = 0; i < 4; i++){
		var tabName = "tab"+(i+1);
		if(i+1 == tabNumber){
			document.getElementById(tabName).style.visibility="visible";
			document.getElementById(tabName).style.display='-webkit-flex';
			document.getElementById(tabName).style.display='flex';
		}
		else{
			document.getElementById(tabName).style.visibility="hidden";
			document.getElementById(tabName).style.display='none';
		}
		//document.getElementById(tabName).innerHTML="success";
	}
}
function showUnderbar(tabNumber){
	for (i = 0; i < 4; i++){
		var tabName = "underbar"+(i+1);
		if(i+1 == tabNumber){
			document.getElementById(tabName).style.visibility="visible";
			document.getElementById(tabName).style.display='-webkit-flex';
			document.getElementById(tabName).style.display='flex';
		}
		else{
			document.getElementById(tabName).style.visibility="hidden";
			document.getElementById(tabName).style.display='none';
		}
		//document.getElementById(tabName).innerHTML="success";
	}
}

function showTap(tabNumber){
	showUnderbar(tabNumber);
	showContainer(tabNumber);
}
	