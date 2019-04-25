$.fn.editable.defaults.mode = 'inline';

var makeEditable = () => {
    $('#permalink').editable({
        type: "text",
        pk: "1",
        url: makePermalinkUrl,
        value: postSlug,
        ajaxOptions: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        success: function(response, newValue) {
            $('#permalink').editable('destroy');
            $('#permalink').html(response);
            if (response.length) {
                $('[name=slug]').val(response);
            }
            makeEditable();
        }
    }).on('save', function(e, params) {
        $('[name=slug]').val(params.newValue);
    });
}

makeEditable();

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
    } else {
        $('[name=published]').val(1);
        $('.published_label').html('Published')
    }
});

let categoriesInput =  new Choices(document.getElementById('categories'), {
    silent: false,
    items: items,
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

if ($(".alert-dismissible").length) {
    setTimeout(() => {
        $(".alert-dismissible").slideUp();
    }, 1500);
}
