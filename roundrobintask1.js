/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


let anArray = [];
let item = 3;
anArray.push(item);
anArray.unshift("whatever");
for(let i=1;i<11;i++) {
    anArray.push(i);
}
for(let i=1;i<11;i++) {
//for(let i=10;i>0;i--) {
    anArray.unshift(i);
}
for(let i = 0; i<anArray.length; i++) {
    if (anArray[i] === 'whatever') {
	let acc = anArray[i];
	anArray[i] = anArray[i+1];
	anArray[i+1] = acc;
	break;
    }
}
let whateverPosition = anArray.indexOf("whatevers");
console.log(whateverPosition);

console.log(anArray);
