var calcString = '';
var bLayer = 0;
var bState = 0;
var calcEqual = 0;
var prevChar = '';
const regex = /^[^0-9+×÷.\-]+$/;
const nums = /^[0-9]+$/;
const symbols = /^[+×÷^\-]+$/;
const brac = /\(/g;
let result;

/* TODO:
   - Divide by 0 error catch
*/

const calcWrapper = document.getElementById('cButtonGrid');

calcWrapper.addEventListener('click', calcButtonClick);

function calcButtonClick(e) {
    const isButton = e.target.nodeName === 'BUTTON';
    if (!isButton) {
        return;
    }
    const buttonType = e.target.className;
    if (calcString.length > 0) {
        prevChar = calcString.slice(-1);
    } else {
        prevChar = '';
    }
    switch (e.target.value) {
        case '=':
            if (!regex.exec(calcString)) {
                calcString = calcString.replaceAll('×', '*');
                calcString = calcString.replaceAll('^', '**');
                calcString = calcString.replaceAll('÷', '/');
                while ((result = brac.exec(calcString) !== null)) {
                    if (brac.lastIndex - 1 != 0) {
                        var beforeBrac = calcString.slice(brac.lastIndex-2, brac.lastIndex-1);
                        if (nums.exec(beforeBrac) || beforeBrac == ')' || beforeBrac == '.') {
                            calcString = calcString.slice(0, brac.lastIndex-1) + "*" + calcString.slice(brac.lastIndex-1);
                        }
                    }
                }
                try {
                    var finalNum = eval(calcString);
                    calcString = parseFloat(finalNum.toFixed(10));
                } catch {
                    calcString = 'ERROR';
                }
            }
            calcEqual = 1;
            document.getElementById('bAC').innerHTML = 'AC';
            document.getElementById('bAC').value = 'AC';
            break;
        case 'AC':
            calcString = '';
            bLayer = 0;
            bState = 0;
            break;
        case 'CE':
            // Check if bracket layer needs updating
            if (prevChar == '(') {
                bLayer--;
            } else if (prevChar == ')') {
                bLayer++;
            }
            calcString = calcString.slice(0, -1);
            // Update bracket state in the new calc string if necessary
            if (calcString.slice(-1) == '(') {
                bState = 1;
            } else if (calcString.slice(-1) == ')') {
                bState = 2;
            }
            break;
        case '(':
            bState = 1;
            bLayer++;
            calcString = calcString + '(';
            break;
        case ')':
            if (bLayer > 0 && ((bState != 1 && nums.exec(prevChar)) || bState == 2)) {
                bState = 2;
                bLayer--;
                calcString = calcString + ')';
            }
            break;
        case '.':
            if (prevChar != '.') {
                calcString = calcString + '.';
            }
            break;
        default:
            if (symbols.exec(e.target.value)) {
                if (bState == 1) {
                    break;
                } else if (symbols.exec(prevChar)) {
                    calcString = calcString.slice(0, -1) + e.target.value;
                } else if (calcString == '') {
                    calcString = '0' + e.target.value;
                } else {
                    bState = 0;
                    calcString = calcString + e.target.value;
                }
            } else if (bState == 2 && nums.exec(e.target.value)) {
                bState = 0;
                calcString = calcString + '*' + e.target.value;
            } else {
                bState = 0;
                calcString = calcString + e.target.value;
            }
    }
    if (calcString.length > 0 && document.getElementById('bAC').innerHTML != 'CE' && calcEqual != 1) {
        document.getElementById('bAC').innerHTML = 'CE';
        document.getElementById('bAC').value = 'CE';
    } else if (calcString.length === 0) {
        document.getElementById('bAC').innerHTML = 'AC';
        document.getElementById('bAC').value = 'AC';
    }
    document.getElementById('cDisplay').value = calcString;
    if (calcString == 'ERROR') {
        calcString = '';
    }
    calcEqual = 0;
}