document.getElementById('mbButton').addEventListener('click', menuState);
document.getElementById('mcButton').addEventListener('click', menuState);

function menuState() {
    const menu = document.getElementById('mPopout');
    const background = document.getElementById('bDim');
    const menuclose = document.getElementById('mcButton');
    if (menu.className.includes('menu-show')) {
        menu.classList.remove('menu-show');
        background.classList.remove('active');
        menuclose.classList.remove('menuclose-show');
    } else {
        menu.classList.add('menu-show');
        background.classList.add('active');
        menuclose.classList.add('menuclose-show');
    }
}