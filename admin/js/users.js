


function get_users() {
 

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load) 
    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;

    }
    xhr.send('get_users');
}



function toggle_status(id, value) {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
    xhr.onload = function () {
        // document.getElementById('room-data').innerHTML = this.responseText;
        if (this.responseText == 1) {
            alert('success', 'Status Toggled Success');
            get_users();
        } else {
            alert('error', 'Status Toggled error');
        }

    }

    xhr.send('toggle_status=' + id + '&value=' + value);
}

function remove_user(user_id) {
   
    if (confirm("Are You Sure You want to remove this User? ")) {
        let data = new FormData(); //create a object of formdata
        data.append('user_id', user_id);

        data.append('remove_user','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users.php", true);
        // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
        xhr.onload = function() {
            console.log("test "+ this.responseText);


            if (this.responseText == 1) {
                alert('success', 'user Removed');
                
              get_users()
            } else {
                alert('error','server error delete user');


            }

        }
        xhr.send(data);
    }


}

function search_user(username){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load) 
    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;

    }
    xhr.send('search_user&name='+ username);
}

window.onload = function(){
    get_users();
}