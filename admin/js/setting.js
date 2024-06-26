let general_data, contacts_data;
let general_s_form = document.getElementById('general_s_form');
let contacts_s_form = document.getElementById('contacts_s_form');
let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp = document.getElementById('site_about_inp');


let team_s_form = document.getElementById('team_s_form');
let member_name_inp = document.getElementById('member_name_inp');
let member_picture_inp = document.getElementById('member_picture_inp');

function get_general() {
    let site_title = document.getElementById('site_title');
    let site_about = document.getElementById('site_about');



    let shutdown_toggle = document.getElementById('shutdown-toggle');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        general_data = JSON.parse(this.responseText);
        site_title.innerHTML = general_data.site_title;
        site_about.innerHTML = general_data.site_about;

        site_title_inp.value = general_data.site_title;
        site_about_inp.value = general_data.site_about;

        if (general_data.shutdown == 0) {
            shutdown_toggle.checked = false;
            shutdown_toggle.value = 0;
        } else {
            shutdown_toggle.checked = true;
            shutdown_toggle.value = 1;
        }
    }   
    xhr.send('get_general');

}
general_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    upd_general(site_title_inp.value, site_about_inp.value);
})

function upd_general(site_title_val, site_about_val) {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        var myModal = document.getElementById('general-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.response == 1) {
            alert('success', 'Changes Saved!');
            get_general();

        } else {
            alert('error', 'No Changes Saved!');
            console.log('No updates');
        }
        // site_about_inp.value = general_data.site_about;
    }
    xhr.send('site_title=' + site_title_val + '&site_about=' + site_about_val + '&upd_general');

}


function upd_shutdown(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {

        if (this.responseText == 1 && general_data.shutdown == 0) {
            alert('success', 'Site has been shutdown');


        } else {
            alert('success', 'Shut downmode false');
            console.log('No updates');
        }
        get_general();

    }
    xhr.send('upd_shutdown=' + val);
}


function get_contacts() {
    let contacts_p_id = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw'];
    let iframe = document.getElementById('iframe');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        contacts_data = JSON.parse(this.responseText);

        contacts_data = Object.values(contacts_data);

        for (i = 0; i < contacts_p_id.length; i++) {
            document.getElementById(contacts_p_id[i]).innerText = contacts_data[i + 1];
        }
        iframe.src = contacts_data[9];

        contacts_inp(contacts_data);
    }
    xhr.send('get_contacts');

}

function contacts_inp(data) {
    let contact_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];

    for (i = 0; i < contact_inp_id.length; i++) {
        document.getElementById(contact_inp_id[i]).value = data[i + 1];
    }
}

contacts_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    upd_contacts();
})

function upd_contacts() {
    let index = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw', 'iframe'];
    let contacts_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];
    let data_str = "";

    for (i = 0; i < index.length; i++) {
        data_str += index[i] + "=" + document.getElementById(contacts_inp_id[i]).value + '&';

    }
    data_str += "upd_contacts";

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {

        var myModal = document.getElementById('contact-us-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        console.log(this.responseText);
        // not retrun 1 in this.responseText so usie there 
        alert('success', 'Changes change');
        get_contacts();

        //Have to fixed this     
        if (this.responseText == 1) {
            alert('success', 'Changes change');
            get_contacts();

        } else {
            alert('error', 'NO changese Made');
            console.log('No updates');
        }

    }

    xhr.send(data_str);
}

team_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_member();
})

function add_member() {
    let data = new FormData(); //create a object of formdata
    data.append('name', member_name_inp.value);
    data.append('picture', member_picture_inp.files[0]);
    data.append('add_member', '');


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
    xhr.onload = function() {
        console.log(this.responseText);
        var myModal = document.getElementById('team-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 'inv_img') {
            alert('error', 'Invalid extension');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image sizeless than 2 mb');
        } else if (this.responseText == 'upd_faild') {
            alert('error', 'Image upload Failded');
        } else {
            alert('success', 'New Member Added');
            member_name_inp.value = '';
            member_picture_inp.value = '';
            get_members();
        }

    }
    xhr.send(data);

}

function get_members() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('team-data').innerHTML = this.responseText;
    }
    xhr.send('get_members');
}

function rem_member(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if(this.responseText == 1){
        alert('success','Memeber Deleted');
        get_members();
      }else{
        alert('error','Server down');
      }
    }
    xhr.send('rem_member='+val);
}

window.onload = function() {
    get_general();
    get_contacts();
    get_members();
};