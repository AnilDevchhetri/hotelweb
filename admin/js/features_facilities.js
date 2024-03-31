let feature_s_form = document.getElementById('feature_s_form');
let facility_s_form = document.getElementById('facility_s_form');

feature_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_feature();
});


function add_feature() {
    let data = new FormData(); //create a object of formdata
    data.append('name', feature_s_form.elements['feature_name'].value);
    data.append('add_feature', '');


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
    xhr.onload = function () {
        console.log(this.responseText);
        var myModal = document.getElementById('features-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'New Feature Added');
            feature_s_form.elements['feature_name'].value = '';
            get_features();
            // get_members();
        } else {
            alert('error', 'New feature Failded');
        }

    }
    xhr.send(data);
}



function get_features() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('features-data').innerHTML = this.responseText;
    }
    xhr.send('get_features');
}

function rem_feature(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Feature Deleted');
            get_features();
        } else if (this.responseText == 'room_added') {
            alert('error', 'Feature is added in room!');
        } else {
            alert('error', 'Server down');
        }
    }
    xhr.send('rem_feature=' + val);
}



facility_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_facility();
});


function add_facility() {
    let data = new FormData(); //create a object of formdata
    data.append('name', facility_s_form.elements['facility_name'].value);
    data.append('icon', facility_s_form.elements['facility_icon'].files[0]);
    data.append('desc', facility_s_form.elements['facility_desc'].value);
    data.append('add_facility', '');


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
    xhr.onload = function () {
        console.log(this.responseText);
        var myModal = document.getElementById('faciltiy-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 'inv_img') {
            alert('error', 'Only svg is accept');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image sizeless than 2 mb');
        } else if (this.responseText == 'upd_faild') {
            alert('error', 'Image upload Failded');
        } else {
            alert('success', 'New Member Added');
            facility_s_form.reset();
            get_facilities();
        }

    }
    xhr.send(data);
}

function get_facilities() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('facilities-data').innerHTML = this.responseText;
    }
    xhr.send('get_facilities');
}

function rem_facility(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'facility Deleted');
            get_facilities();
        } else if (this.responseText == 'room_added') {
            alert('error', 'facility is added in room!');
        } else {
            alert('error', 'Server down');
        }
    }
    xhr.send('rem_facility=' + val);
}


window.onload = function () {
    get_features();
    get_facilities();
};