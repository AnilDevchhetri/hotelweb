


function get_bookings(search='') {
 

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load) 
    xhr.onload = function () {
        document.getElementById('table-data').innerHTML = this.responseText;

    }
    xhr.send('get_bookings&search='+search);
}

let assign_room_form = document.getElementById('assign_room_form');
function assign_room(id){
  assign_room_form.elements['booking_id'].value = id;
}
assign_room_form.addEventListener('submit',function(e){
    e.preventDefault();

    let data = new FormData(); //create a object of formdata
    data.append('room_no', assign_room_form.elements['room_number'].value);
    data.append('booking_id', assign_room_form.elements['booking_id'].value);
    data.append('assign_room', '');


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings.php", true);
    // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
    xhr.onload = function () {
        console.log(this.responseText);
        var myModal = document.getElementById('assign-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.response==1){
           alert('success','Room Number Allowted! Booking Finalized');
           assign_room_form.reset();
           get_bookings();
        }else{
           alert('error','Server Down');
        }

        
    }
    xhr.send(data);

})

function cancel_booking(id){
    if (confirm("Are You Sure You want to Cancel the room? ")) {
        let data = new FormData(); //create a object of formdata
        data.append('booking_id', id);
        data.append('cancel_booking','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_bookings.php", true);
        // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
        xhr.onload = function() {
            console.log("test "+ this.responseText);


            if (this.responseText == 1) {
                alert('success', 'Booking Cancel');
                
              get_bookings()
            } else {
                alert('error','server error');


            }

        }
        xhr.send(data);
    }

}

window.onload = get_bookings();