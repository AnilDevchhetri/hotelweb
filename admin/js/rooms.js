let add_room_form = document.getElementById('add_room_form');
        add_room_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_room();
        })

        function add_room() {


            let data = new FormData(); //create a object of formdata
            data.append('add_room', '');
            data.append('name', add_room_form.elements['name'].value);
            data.append('area', add_room_form.elements['area'].value);
            data.append('price', add_room_form.elements['price'].value);
            data.append('quantity', add_room_form.elements['quantity'].value);
            data.append('adult', add_room_form.elements['adult'].value);
            data.append('children', add_room_form.elements['children'].value);
            data.append('desc', add_room_form.elements['desc'].value);

            let features = [];
            let facilities = [];
            add_room_form.elements['features'].forEach(el => {
                if (el.checked) {
                    features.push(el.value);
                }
            });
            add_room_form.elements['facilities'].forEach(el => {
                if (el.checked) {
                    facilities.push(el.value);
                }
            });

            data.append('features', JSON.stringify(features));
            data.append('facilities', JSON.stringify(facilities));


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');//(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
            xhr.onload = function() {
                console.log("test", this.responseText);
                var myModal = document.getElementById('add-room');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 1) {
                    get_all_rooms();
                    alert('success', 'New Room Added');
                    add_room_form.reset();

                } else {
                    alert('error', 'Server Down');
                }

            }
            xhr.send(data);
        }

        function get_all_rooms() {


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load) 
            xhr.onload = function() {
                document.getElementById('room-data').innerHTML = this.responseText;

            }
            xhr.send('get_all_rooms');
        }


        let edit_room_form = document.getElementById('edit_room_form');

        function edit_details(id) {

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
            xhr.onload = function() {
                let data = JSON.parse(this.responseText);
                //jason.parse alwayse return value in form of text. forexampel if it retrun 1,2 it is text not inter
                edit_room_form.elements['name'].value = data.roomdata.name;
                edit_room_form.elements['area'].value = data.roomdata.area;
                edit_room_form.elements['price'].value = data.roomdata.price;
                edit_room_form.elements['quantity'].value = data.roomdata.quantity;
                edit_room_form.elements['adult'].value = data.roomdata.adult;
                edit_room_form.elements['children'].value = data.roomdata.children;
                edit_room_form.elements['desc'].value = data.roomdata.description;
                edit_room_form.elements['room_id'].value = data.roomdata.id;

                edit_room_form.elements['facilities'].forEach(el => {
                    if (data.facilities.includes(Number(el.value))) {
                        el.checked = true;
                    }
                });

                edit_room_form.elements['features'].forEach(el => {
                    if (data.features.includes(Number(el.value))) {
                        el.checked = true;
                    }
                });

            }
            xhr.send("get_room=" + id);
        }
        edit_room_form.addEventListener('submit', function(e) {
            e.preventDefault();
            submit_edit_room();
        });

        function submit_edit_room() {


            let data = new FormData(); //create a object of formdata
            data.append('edit_room', '');
            data.append('room_id', edit_room_form.elements['room_id'].value);
            data.append('name', edit_room_form.elements['name'].value);
            data.append('area', edit_room_form.elements['area'].value);
            data.append('price', edit_room_form.elements['price'].value);
            data.append('quantity', edit_room_form.elements['quantity'].value);
            data.append('adult', edit_room_form.elements['adult'].value);
            data.append('children', edit_room_form.elements['children'].value);
            data.append('desc', edit_room_form.elements['desc'].value);

            let features = [];
            let facilities = [];
            edit_room_form.elements['features'].forEach(el => {
                if (el.checked) {
                    features.push(el.value);
                }
            });
            edit_room_form.elements['facilities'].forEach(el => {
                if (el.checked) {
                    facilities.push(el.value);
                }
            });
            data.append('features', JSON.stringify(features));
            data.append('facilities', JSON.stringify(facilities));


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');//(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
            xhr.onload = function() {
                console.log("test", this.responseText);
                var myModal = document.getElementById('edit-room');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 1) {
                    get_all_rooms();
                    alert('success', 'Room edit successully');
                    edit_room_form.reset();

                } else {
                    alert('error', 'Server Down');
                }

            }
            xhr.send(data);
        }

        function toggle_status(id, value) {

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
            xhr.onload = function() {
                // document.getElementById('room-data').innerHTML = this.responseText;
                if (this.responseText == 1) {
                    alert('success', 'Status Toggled Success');
                    get_all_rooms();
                } else {
                    alert('error', 'Status Toggled error');
                }

            }

            xhr.send('toggle_status=' + id + '&value=' + value);
        }

        let add_image_form = document.getElementById('add_image_form');
        add_image_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_image();
        });

        function add_image() {
            let data = new FormData(); //create a object of formdata
            data.append('image', add_image_form.elements['image'].files[0]);
            data.append('room_id', add_image_form.elements['room_id'].value);
            data.append('add_image', '');


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
            xhr.onload = function() {
                console.log(this.responseText);


                if (this.responseText == 'inv_img') {
                    alert('error', 'Invalid extension,Only jpg, WEBP OR PNG are allowed', 'image-alert');
                } else if (this.responseText == 'inv_size') {
                    alert('error', 'Image sizeless than 2 mb');
                } else if (this.responseText == 'upd_faild') {
                    alert('error', 'Image upload Failded');
                } else {
                    alert('success', 'New Image Added', 'image-alert');
                    room_images(add_image_form.elements['room_id'].value, document.querySelector('#room-images .modal-title').innerText);
                    add_image_form.reset();

                }

            }
            xhr.send(data);

        }

        function room_images(id, name) {
            document.querySelector('#room-images .modal-title').innerText = name;
            add_image_form.elements['room_id'].value = id;
            add_image_form.elements['image'].value = '';

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
            xhr.onload = function() {
                // document.getElementById('room-data').innerHTML = this.responseText;
                document.getElementById('room-image-data').innerHTML = this.responseText;

            }

            xhr.send('get_room_images=' + id);
        }

        function rem_image(img_id, room_id) {

            let data = new FormData(); //create a object of formdata
            data.append('image_id', img_id);
            data.append('room_id', room_id);
            data.append('rem_image', '');


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
            xhr.onload = function() {
                console.log(this.responseText);


                if (this.responseText == 1) {
                    alert('success', 'Image remove', 'image-alert');
                    room_images(room_id, document.querySelector('#room-images .modal-title').innerText);
                } else {
                    alert('error', 'Image remove failed', 'image-alert');


                }

            }
            xhr.send(data);

        }

        function thumb_image(img_id, room_id) {

            let data = new FormData(); //create a object of formdata
            data.append('image_id', img_id);
            data.append('room_id', room_id);
            data.append('thumb_image', '');


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php", true);
            // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
            xhr.onload = function() {
                console.log(this.responseText);


                if (this.responseText == 1) {
                    alert('success', 'Image ThumbNail Change', 'image-alert');
                    room_images(room_id, document.querySelector('#room-images .modal-title').innerText);
                } else {
                    alert('error', 'Image thumbnail change failed', 'image-alert');


                }

            }
            xhr.send(data);

        }

        function remove_room(room_id) {

            if (confirm("Are You Sure You want to remove this room")) {
                let data = new FormData(); //create a object of formdata
                data.append('room_id', room_id);
                data.append('remove_room','');


                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/rooms.php", true);
                // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');(for uploadng using Header is not used because we use formData because formDAta hedar request is already load)
                xhr.onload = function() {
                    console.log("test "+this.responseText);


                    if (this.responseText == 1) {
                        alert('success', 'Room Removed');
                        
                      get_all_rooms()
                    } else {
                        alert('error','server error delete room');


                    }

                }
                xhr.send(data);
            }


        }

        window.onload = get_all_rooms();