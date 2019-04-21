$.fn.editable.defaults.mode = 'inline';

let editor_el = document.querySelector('#editor');

ClassicEditor
    .create(editor_el, {
        ckfinder: {
            uploadUrl: '/ckfinder/connector?command=QuickUpload&type=Files&responseType=json'
        },
        toolbar: {
            items: [
                'undo',
                'redo',
                '|',
                'heading',
                '|',
                'bold',
                'italic',
                'link',
                '|',
                'imageUpload',
                'insertTable',
                '|',
                'alignment',
                'bulletedList',
                'numberedList',
                'blockQuote',
            ]
        }
    })
    .catch( error => {
        console.error( error );
    });
    
$('#published').change(() => {
    let published = $('[name=published]').val();
    
    if (published == 1) {
        $('[name=published]').val(0);
        $('.published_label').html('Draft')
        $('[type=submit]').html('Save')
    } else {
        $('[name=published]').val(1);
        $('.published_label').html('Published')
        $('[type=submit]').html('Publish')
    }
});

let categoriesInput =  new Choices(document.getElementById('categories'), {
    silent: false,
    choices: choices,
    addItems: true,
    removeItemButton: true,
    editItems: true,
    duplicateItemsAllowed: false,
    delimiter: ',',
    searchResultLimit: 3,
    paste: true,
    searchEnabled: true,
    searchChoices: true,
    searchFields: ['label'],
    placeholder: true,
    placeholderValue: "Click here to search...",
});

let _newCategoryInput = $('#newCategory'),
    newCategoryInput = new Choices(document.getElementById('newCategory'), {
    placeholder: true,
    placeholderValue: "Type something..."
});

$('[for=newCategory]').click(e => {
    e.target.nextElementSibling.className = 'd-block';
})