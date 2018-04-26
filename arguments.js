function alpha(bluff) {
    bluff = bluff+bluff;
    return bluff;
}
function beta(triff) {
    triff.val = triff.val+triff.val;
    return triff;
}

let test1 = 25;
let test2 = {val:25,val2:26};
let test3 = test2;
console.log('starting value of test1:',test1);
console.log('starting value of test2:',test2);
console.log('starting value of test3:',test3);

test1 = 26;
test3.val = 26;
test2 = 27;
console.log('current value of test1:',test1);
console.log('current value of test2:',test2);
console.log('current value of test3:',test3);

console.log('return value of alpha(test1):',alpha(test1));
console.log('return value of beta(test2):',beta(test2));
console.log('return value of beta(test3):',beta(test3));

console.log('current value of test1:',test1);
console.log('current value of test2:',test2);
console.log('current value of test3:',test3);
