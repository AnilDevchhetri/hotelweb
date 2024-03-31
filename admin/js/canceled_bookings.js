


function get_bookings(search='') {
 

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/canceled_bookings.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load) 
    xhr.onload = function () {
        document.getElementById('table-data').innerHTML = this.responseText;

    }
    xhr.send('get_bookings&search='+search);
}


function delete_booking(id){
    if (confirm("Are You Sure You want to delete this data? ")) {
        let data = new FormData(); //create a object of formdata
        data.append('booking_id', id);
        data.append('delete_booking','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/canceled_bookings.php", true);
        // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
        xhr.onload = function() {
            console.log("test "+ this.responseText);


            if (this.responseText == 1) {
                alert('success', 'Booking Deleted');
                
              get_bookings()
            } else {
                alert('error','server error');


            }

        }
        xhr.send(data);
    }

}



window.onload = function(){
    get_bookings();
}