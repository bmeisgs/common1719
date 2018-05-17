/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

let XLSX = require('xlsx');
let workbook = XLSX.readFile('./group4example/jelenleti_sablon.xlsx');
let sheet = workbook.Sheets[workbook.SheetNames[0]];
let jason = XLSX.utils.sheet_to_json(sheet);

console.log(jason);
