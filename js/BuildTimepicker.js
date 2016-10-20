function buildTimePicker() {
    var result = document.createElement('span');
    var hours = document.createElement('select');
    hours.setAttribute('id', 'hour');
    for (var h = 1; h < 24; h++) {
        var option = document.createElement('option');
        option.setAttribute('value', h);
        option.appendChild(document.createTextNode(h + 'h'));
        hours.appendChild(option);
    }
    var minutes = document.createElement('select');
    minutes.setAttribute('id', 'minute');
    for (var m = 0; m < 60; m++) {
        var option = document.createElement('option');
        option.setAttribute('value', m);
        option.appendChild(document.createTextNode(m + 'm'));
        minutes.appendChild(option);
    }
    result.appendChild(hours);
    result.appendChild(document.createTextNode(" : "));
    result.appendChild(minutes);

    return result;
}

document.body.appendChild(buildTimePicker());