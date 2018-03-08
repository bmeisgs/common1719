
const CYCLE_INTAKE = 1;
const CYCLE_COMPRESSION = 2;
const CYCLE_IGNITION = 3;
const CYCLE_EXHAUST = 4;
const PISTON_BOTTOM = 0;
const PISTON_TOP = 9;


class cylinder {
    constructor (which,initPos,initCycle) {
        this.ID = which;
        this.position = initPos;
        this.cycle = initCycle;
        this.isIntakeValveOpen = false;
        this.isExhaustValveOpen = false;
        this.isSparkPlugIgnited = false;
        this.decideNext(),
    }
    decideNext() {
        if(this.position===0) {
            if(this.cycle===CYCLE_INTAKE) {
                this.cycle = CYCLE_COMPRESSION;
                this.isExhaustValveOpen = false;
                this.isIntakeValveOpen = false;
                this.isSparkPlugIgnited = false;
                this.position = 1;
            }
            else {
                this.cycle = CYCLE_EXHAUST;
                this.isExhaustValveOpen = true;
                this.isIntakeValveOpen = false;
            }
            this.isIntakeValveOpen = false;
            this.isSparkPlugIgnited = false;
            this.position = PISTON_BOTTOM+1;     
        }
        else if (this.position===PISTON_TOP) {
            if (this.cycle===CYCLE_COMPRESSION) {
                this.cycle = CYCLE_IGNITION;
                this.isExhaustValveOpen = false;
            }
            else ˙{
                this.cycle = CYCLE_INTAKE;
                this.isIntakeValveOpen = true;
                this.isSparkPlugIgnited = false;     
            }
            this.isExhaustValveOpen = false;
            this.position = PISTON_TOP-1;
        }
        else {
            if( this.cycle===CYCLE_INTAKE || this.cycle===CYCLE_IGNITION) {
                --this.position;
            } else {
                ++this.position;   
            }
            this.isSparkPLugIgnited = false;     
        }
    }
    visualize() {
        let out = '';
        if (this.isExhaustValveOpen===true) {
            out += "//";
        }
        else if (this.isExhaustValveOpen===true) {
            out += '/';
        }
        else {
            out+= '|' ;
        }
        if (this.isSparkPlugIgnitied===true) {
            out+= '=*';
        }
        else {
            out+= '==';
        }
        for(let i=POSITION_TOP;i>=PISTON_BOTTOM;--i) {
            if (this.position===i){
                out += '_';
            }
        }
        return out;
        
    }
}

let cycl= new cylinder(,5,CYCLE_INTAKE);


