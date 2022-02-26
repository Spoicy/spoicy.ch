var calcString = '';
const regex = /^[^0-9+×÷\-]+$/

const calcWrapper = document.getElementById('cButtonGrid');

calcWrapper.addEventListener('click', calcButtonClick);

function calcButtonClick(e) {
    const isButton = e.target.nodeName === 'BUTTON';
    if (!isButton) {
        return;
    }
    const buttonType = e.target.className;
    if (buttonType.includes('equal') === true) {
        if (!regex.exec(calcString)) {
            calcString = calcString.replaceAll('×', '*');
            calcString = calcString.replaceAll('^', '**');
            calcString = calcString.replaceAll('÷', '/');
            try {
                calcString = eval(calcString);
            } catch {
                calcString = 'ERROR';
            }
        }
    } else if (e.target.innerHTML == 'AC') {
        calcString = '';
    } else {
        calcString = calcString + e.target.value;
    }
    document.getElementById('cDisplay').value = calcString;
}