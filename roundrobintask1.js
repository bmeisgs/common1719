/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function log10(a) {
    console.log('hey, executing log10('+a+')');
    return Math.log10(a);
}
function squareRoot(a) {
    console.log('hey, executing squareRoot('+a+')');
    return Math.sqrt(a);
}
function log10ThenSquareRoot(a) {
    return squareRoot(log10(a));
}
log10ThenSquareRoot(25);

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

var square_root = squareRoot;
//square_root = log10;

squareRoot(25);
log10(25);
log10(11);
Math.ceil(15.2);
console.log(square_root(log10(15)));
console.log(square_root(1.2837283782));
console.log(1.12232132132);

item = square_root(25);
item = 5;

item.dada.spack.whatevs[15];

console.log(log10ThenSquareRoot(25));
