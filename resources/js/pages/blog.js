document.querySelectorAll('.button-blog-edit').forEach(item => {
    item.addEventListener('click', blogEntryEdit);
})

function blogEntryEdit(e) {
    var splitId = e.target.id.split('blogEditButton')[1];
    console.log(splitId);
    document.getElementById('blogEntryText' + splitId).classList.toggle('d-none');
    document.getElementById('blogEditText' + splitId).classList.toggle('d-none');
    document.getElementById('blogSaveEntry' + splitId).classList.toggle('d-none');
}