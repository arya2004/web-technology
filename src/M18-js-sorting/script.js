$(function () {

    let intArr = [];

    let nameArr = [];


    function updateDisplay(arr, displayId) {
        $(displayId).text(JSON.stringify(arr));
    }

    
    $('#parse-int').click(() => {
        const raw = $('#int-input').val().trim();
        if (!raw) return alert('Enter some numbers first.');
        intArr = raw.split(',')
            .map(s => parseInt(s, 10))
            .filter(n => !isNaN(n));
        updateDisplay(intArr, '#int-array-display');
        $('#sort-int-asc, #sort-int-desc, #search-int, #search-int-btn').prop('disabled', false);
        $('#int-result').text('');
    });


    $('#sort-int-asc').click(() => {
        intArr.sort((a, b) => a - b);
        updateDisplay(intArr, '#int-array-display');
    });
    $('#sort-int-desc').click(() => {
        intArr.sort((a, b) => b - a);
        updateDisplay(intArr, '#int-array-display');
    });


    $('#search-int-btn').click(() => {
        const target = parseInt($('#search-int').val(), 10);
        if (isNaN(target)) return alert('Enter a valid number to search.');
        const indices = [];
        intArr.forEach((v, i) => {
            if (v === target) indices.push(i);
        });
        if (indices.length)
            $('#int-result').text(`Found at index(es): ${indices.join(', ')}`);
        else
            $('#int-result').text('Value not found.');
    });

   
    $('#parse-name').click(() => {
        const raw = $('#name-input').val().trim();
        if (!raw) return alert('Enter some names first.');
        nameArr = raw.split(',')
            .map(s => s.trim())
            .filter(s => s.length > 0);
        updateDisplay(nameArr, '#name-array-display');
        $('#sort-name-asc, #sort-name-desc, #search-name, #search-name-btn').prop('disabled', false);
        $('#name-result').text('');
    });


    $('#sort-name-asc').click(() => {
        nameArr.sort((a, b) => a.localeCompare(b));
        updateDisplay(nameArr, '#name-array-display');
    });
    $('#sort-name-desc').click(() => {
        nameArr.sort((a, b) => b.localeCompare(a));
        updateDisplay(nameArr, '#name-array-display');
    });

    $('#search-name-btn').click(() => {
        const q = $('#search-name').val().trim().toLowerCase();
        if (!q) return alert('Enter a name to search.');
        const matches = nameArr
            .map((v, i) => ({ v, i }))
            .filter(o => o.v.toLowerCase() === q)
            .map(o => o.i);
        if (matches.length)
            $('#name-result').text(`Found at index(es): ${matches.join(', ')}`);
        else
            $('#name-result').text('Name not found.');
    });
});
