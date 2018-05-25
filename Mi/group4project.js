/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

let XLSX = require('xlsx');
let workbook = XLSX.readFile('./Group4project/summary.xlsx');
let sheet = workbook.Sheets[workbook.SheetNames[0]];
let jason = XLSX.utils.sheet_to_json(sheet);

console.log(jason);

var Soaps= [
   {type:"greensoap",average:jason[3].Greensoap},
   {type:"olivesoap",average:jason[3].Olivesoap},
   {type:"whitesoap",average:jason[3].Whitesoap}
   //...
];
//console.log(Soaps);
for(i=0;i<Soaps.length;i++) {
   Soaps[i].startnumber = i+1;
}
console.log(Soaps);
Soaps.sort(function(a,b) {
   if (b.average>a.average) return -1;
   else if (b.average<a.average) return 1;
   return 0;
});
for(i=0;i<3;i++) {
   console.log("In place "+(i+1).toString()+" is "+Soaps[i].type);
}
