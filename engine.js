/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

const CYCLE_INTAKE = 1;
const CYCLE_COMPRESSION = 2;
const CYCLE_IGNITION = 3;
const CYCLE_EXHAUST = 4;
const PISTON_BOTTOM = 0;
const PISTON_TOP = 19;
const FIRE_SPARKPLUG = PISTON_TOP-1;

class cylinder {
    constructor(which,initPos,initCycle) {
	this.ID = which;
	this.position = initPos;
	this.cycle = initCycle;
	this.isIntakeValveOpen = false;
	this.isExhaustValveOpen = false;
	this.isSparkPlugIgnited = false;
	this.decideNext();
    }
    decideNext() {
	//these are all the same
	let a = this.isSparkPlugIgnited = 
	 (this.position===FIRE_SPARKPLUG && this.cycle===CYCLE_COMPRESSION) ? true : false;
	/*
	this.isSparkPlugIgnited = (this.position===FIRE_SPARKPLUG);
	if (this.position===FIRE_SPARKPLUG) {
	    this.isSparkPlugIgnited = true;
	} else {
	    this.isSparkPlugIgnited = false;
	}
	
	a = (b===15) ? ( (c===19) ? 1 : 2 ) : 3;
	b = 16;
	c = 19;
	a = 3
	
	b = 15;
	c = 16;
	a = 2
	
	b = 15;
	c = 19;
	a = 1
	*/
	//
	//in a duty cycle, this runs:
	//80 times (PISTON_TOP-PISTON_BOTTOM x 4)
	if (this.position===PISTON_BOTTOM) {
	    if (this.cycle===CYCLE_INTAKE) {
		this.cycle = CYCLE_COMPRESSION;
		this.isExhaustValveOpen = false;
	    }
	    else {
		this.cycle = CYCLE_EXHAUST;
		this.isExhaustValveOpen = true;
	    }
	    this.isIntakeValveOpen = false;
	    //this.isSparkPlugIgnited = false;
	    this.position = PISTON_BOTTOM+1;
	}
	//78 times (PISTON_TOP-PISTON_BOTTOM x 4 - 2 times the above will be true)
	else if (this.position===PISTON_TOP) {
	    if (this.cycle===CYCLE_COMPRESSION) {
		this.cycle = CYCLE_IGNITION;
		this.isIntakeValveOpen = false;
		//this.isSparkPlugIgnited = true;
	    }
	    else {
		this.cycle = CYCLE_INTAKE;
		this.isIntakeValveOpen = true;
		//this.isSparkPlugIgnited = false;
	    }
	    this.isExhaustValveOpen = false;
	    this.position = PISTON_TOP-1;
	}
	//76 times
	else {
	    if (this.cycle===CYCLE_INTAKE || this.cycle===CYCLE_IGNITION) {
		--this.position;
	    } else {
		++this.position;
	    }
	    //this.isSparkPlugIgnited = false;
	}
    }
    visualize() {
	let out = '';
	if (this.isExhaustValveOpen===true) {
	    out += "\\";
	}
	else if (this.isIntakeValveOpen===true) {
	    out += '/';
	}
	else {
	    out += '|';
	}
	if (this.isSparkPlugIgnited===true) {
	    out += '=*';
	}
	else {
	    out += '==';
	}
	for(let i=PISTON_TOP;i>=PISTON_BOTTOM;--i) {
	    if (this.position===i) {
		out += 'O';
	    }
	    else {
		out += '_';
	    }
	}
	return out;
    }
}

class engine {
    constructor(numOfCyls) {
	this.running = false;
	this.cylinders = [];
	let phases = [CYCLE_INTAKE,CYCLE_COMPRESSION,CYCLE_IGNITION,CYCLE_EXHAUST];
	let cylPos = PISTON_BOTTOM+1;
	let cylPhase = 0;
	for(let i=1;i<=numOfCyls;i++) {
	    this.cylinders.push(new cylinder(i,cylPos,phases[cylPhase]));
	    ++cylPhase;
	    if (cylPhase===phases.length) {
		cylPhase = 0;
	    }
	    cylPos = (cylPos===(PISTON_BOTTOM+1)) ? PISTON_TOP-1 : PISTON_BOTTOM+1;
	}
	this._timer = null;
    }
    ignite() {
	this._timer = setInterval(function() {
	    let out = '';
	    for(let i=0;i<this.cylinders.length;i++) {
		this.cylinders[i].decideNext();
		out += this.cylinders[i].visualize()+' ';
	    }
	    console.log(out);
	}.bind(this),30);
    }
}

let en = new engine(3);
en.ignite();
