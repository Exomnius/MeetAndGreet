//validation functions
function isEmpty(field) {
    if (field == null || field == "") {
        return true;
    }

    return false;
}

function isAlphaNumeric(field) {
    if (field.match(/^[a-zA-Z0-9 ]+$/)) {
        return true;
    }

    return false;
}

function isBetweenBounds(field, min, max) {
    if (field.length < min || field.length > max) {
        return false;
    }

    return true;
}

function isNumber(field) {
    if (field.match(/^[0-9]+$/)) {
        return true;
    }

    return false;
}