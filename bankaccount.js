/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var bankAccounts = [];

var lastAccountNumber = 0;

class bankAccount {
    constructor(ownerName) {
	/** @type {Number} */
	this.balance = 0;
	this.accountOwner = ownerName;
	++lastAccountNumber;
	this.accountNumber = lastAccountNumber;
	this.history = [];
    }
    changeBalance(amount,otherParty,transactionId) {
	this.balance += amount;
	var when = new Date().toISOString();
	//var historyEnt = [when,amount,this.balance,transactionId,otherParty];
	var historyEntry = {
	    "when":when,
	    "amount":amount,
	    "balanceAfter":this.balance,
	    "transactionId":transactionId,
	    "otherParty":otherParty
	};
	this.history.push(historyEntry);
    }
}

function findAccountByName(name) {
    
}

funciton findAccountByNumber(numb) {
    
}

var BandisAccount = new bankAccount("Bandi");
BandisAccount.changeBalance(10000,"bank branch","yoda01");
BandisAccount.changeBalance(-2500,"SUPERGSMPOS","728732837283");
console.log(BandisAccount);

/* PLEASE WRITE YOUR CODE ONLY AFTER YOUR NAMED SECTION */

/* Attila's account */
var AttilasAccount= new bankAccount("Attial");
AttilasAccount.changeBalance(10000000,"electronics branch","laptop");
AttilasAccount.changeBalance(-200000,"ASUS","23415679");
console.log(AttilasAccount);

/* Balazs's account */
var BalazssAccount = new bankAccount("Balazs");
BalazssAccount.changeBalance(12345,"legendary branch","phone");
BalazssAccount.changeBalance(-1234,"Samsung","123456789");
console.log(BalazssAccount);
/* Filip's account */
var FilipsAccount = new bankAccount("Filip");
FilipsAccount.changeBalance(1000000000,"GOD","00001000");
FilipsAccount.changeBalance(-999999999,"IBO","24362942");
console.log(FilipsAccount);
/* Marci's account */
var MarcisAccount= new bankAccount("Urdamarci");
MarcisAccount.changeBalance(15000,"bestbank branch","iknow");
MarcisAccount.changeBalance(-2500,"NIKE","125567898");
console.log(MarcisAccount);

/* Matt's account */

/* Mi's account */
var MisAccount = new bankAccount("Mi");
MisAccount.changeBalance (77773,"third party","random Number");
console.log(MisAccount);

/* Sanyi's account */
var SanyisAccount = new bankAccount ("Sanyi");
SanyisAccount.changeBalance(99999,"ITbank privatebankingbranch","Luke01");
SanyisAccount.changeBalance(-11111,"VIDEOGAMESHOPHUNGARY","938475843759834798");
console.log(SanyisAccount);