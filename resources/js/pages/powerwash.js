document.querySelectorAll('.button-controls .btn').forEach(item => {
    item.addEventListener('click', switchView);
});

const career = document.getElementById('career');
const bonusdlc = document.getElementById('bonusdlc');
const careerBtn = document.getElementById('careerButton');
const bonusdlcBtn = document.getElementById('bonusdlcButton');
const firstSwitch = true;

function switchView(e) {
    var id = e.target.id;
    if (firstSwitch) {
        document.querySelectorAll('.section-container').forEach(item => {
            item.classList.add('disable-stagger');
        });
    }
    if (id === 'careerButton') {
        career.classList.remove('d-none');
        bonusdlc.classList.add('d-none');
        careerBtn.classList.add('active');
        bonusdlcBtn.classList.remove('active');
    } else {
        career.classList.add('d-none');
        bonusdlc.classList.remove('d-none');
        careerBtn.classList.remove('active');
        bonusdlcBtn.classList.add('active');
    }
    
}