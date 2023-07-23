document.querySelectorAll('.button-blog-edit').forEach(item => {
    item.addEventListener('click', blogEntryEdit);
})

function blogEntryEdit(e) {
    var splitId = e.target.id.split('blogEditButton')[1];
    document.getElementById('blogEditForm' + splitId).classList.toggle('d-none');
    document.getElementById('blogEntryText' + splitId).classList.toggle('d-none');
}