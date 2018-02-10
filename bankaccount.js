/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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

var BandisAccount = new bankAccount("Bandi");
BandisAccount.changeBalance(10000,"bank branch","yoda01");
BandisAccount.changeBalance(-2500,"SUPERGSMPOS","728732837283");
console.log(BandisAccount);

/* PLEASE WRITE YOUR CODE ONLY AFTER YOUR NAMED SECTION */

/* Attila's account */

/* Balazs's account */

/* Filip's account */

/* Marci's account */

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