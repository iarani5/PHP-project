function tn(p,e,n){
	if(!isNaN(n)){
		return p.getElementsByTagName(e)[n];
	}
	return p.getElementsByTagName(e);
}
function id(e){
	return document.getElementById(e);
}
function ce(e){
	return document.createElement(e);
}
function ac(p,e){
	return p.appendChild(e);
}
function rc(p,e){
	return p.removeChild(e);
}
function txt(s){
	return document.createTextNode(s);
}
function opacidad(t){
	t.style.opacity='0.1';
	setTimeout(function () {
	t.style.opacity='1';
	}, 300);
}










